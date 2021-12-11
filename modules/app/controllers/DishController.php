<?php

namespace app\modules\app\controllers;

use app\models\custom\DishIngredients;
use Yii;
use yii\data\SqlDataProvider;
use yii\db\Exception;
use yii\db\PdoValue;
use yii\web\Controller;

/**
 * Default controller for the `app` module
 */
class DishController extends Controller
{
    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $maxIngredient = 5;
        $minIngredient = 2;
        $this->layout = 'main';
        $dishIngredients = new DishIngredients();
        $dishIngredients->existIngredientsDishIds = $this->request->post('multiselect', []);


        $idsSql = "'" . implode("','", $dishIngredients->existIngredientsDishIds) . "'";
        $hiddenIngredientsIds = DishIngredients::getHiddenDishIds();
        if ( empty($hiddenIngredientsIds) ) {
            $hiddenIngredientsIds = [0];
        }
        $hiddenIngredientsIdsSql = "'" . implode("','", $hiddenIngredientsIds) . "'";

        $sql = "
        select d.id as id,d.name as name,
       (
           select count(*) from dish_ingredient di2
           where di2.ingredient_id in ( $idsSql ) and d.id = di2.dish_id
           group by dish_id
       ) as countFoundedIngredient,
       (select group_concat(i.name)
        from dish_ingredient di
                 left join ingredient i
                           on di.ingredient_id = i.id where di.dish_id = d.id) as ingredients
        from dish d
         join (
            select di3.dish_id from dish_ingredient di3 where di3.ingredient_id in ( $idsSql ) and di3.dish_id not in ($hiddenIngredientsIdsSql)
             ) t
              on d.id = t.dish_id  group by d.id having countFoundedIngredient > :countFoundedIngredient order by countFoundedIngredient desc;
        ";

        $countFoundedIngredient = 1;
        try {
            $exist = Yii::$app->db->createCommand($sql,
                [':countFoundedIngredient' => $maxIngredient - 1]
            )->query()->count();
            if ( $exist ) {
                $countFoundedIngredient = $maxIngredient - 1;
            }
        } catch (Exception $e) {
            Yii::warning($e->getMessage());
        }


        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'params' => [':countFoundedIngredient' => $countFoundedIngredient],
            'pagination' => false,
            'sort' => false
        ]);


        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'dishIngredients' => $dishIngredients,
            'minIngredient' => $minIngredient,
            'maxIngredient' => $maxIngredient,
        ]);
    }
}
