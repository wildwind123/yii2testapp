<?php
namespace app\models\custom;

use app\models\Dish;
use app\models\DishIngredient;
use app\models\Ingredient;
use Codeception\Lib\Di;
use yii\db\Connection;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use Yii;

class DishIngredients extends \yii\base\BaseObject
{
    public $dishName = '';
    public $dishId = 0;
    public $ingredients = [];
    public $existIngredientsDish = [];
    public $existIngredientsDishIds = [];
    public $errors = [];
    private $selectedIngredients = [];

    public function __construct($config = [])
    {
        $this->ingredients = $this->getIngredients();
        parent::__construct($config);
    }

    public function set($dishId) : bool
    {
        $this->dishId = $dishId;
        $dish = Dish::findOne(['id' => $this->dishId]);
        if ( empty($dish) ) {
            Yii::warning(sprintf("dish not exist"));
            return false;
        }
        $this->dishName = $dish->name;
        $this->existIngredientsDish = $this->getIngredients($this->dishId);
        $this->existIngredientsDishIds = array_keys($this->existIngredientsDish);
        return true;
    }

    public function setSelectedIngredientsByIds(array $selectedIngredientIds) : bool
    {
        $selectedIngredients = Ingredient::find()->
        where(['in', 'id', $selectedIngredientIds])->
        all();
        $this->selectedIngredients = ArrayHelper::map($selectedIngredients, 'id', 'name');
        return true;
    }

    public function createDishIngredients() : bool
    {
        $dish = new Dish();
        $dish->name = $this->dishName;
        if ( !$dish->validate() ) {
            \Yii::warning($dish->getErrors());
            $this->errors = array_column($dish->getErrors(), 0);
            return false;
        }
        try {
            $dish->insert();
        } catch (\Exception $e) {
            $this->errors[] = $e->getMessage();
            \Yii::warning($e->getMessage());
            return 0;
        }
        $this->dishId = $dish->id;
        try {
            self::saveMultipleIngredient($dish->id, $this->selectedIngredients, $this->existIngredientsDish);
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
            Yii::warning($e->getMessage());
            return 0;
        }

        return $dish->id;
    }

    public function updateDishIngredients() : bool
    {
        if ( empty($this->dishId) ) {
            $this->errors[] = "empty dish id";
            Yii::warning("dish id is empty");
            return false;
        }
        $dish = Dish::findOne(['id' => $this->dishId]);
        if ( empty($dish) ) {
            $this->errors[] = "dish does not found id=".$this->dishId;
            Yii::warning(sprintf("dish_id is not exist %d", $this->dishId));
            return false;
        }
        $dish->name = $this->dishName;
        try {
            $dish->update();
        } catch (\Throwable $e) {
            $this->errors[] = $e->getMessage();
            \Yii::warning($e->getMessage());
            return false;
        }

        try {
            self::saveMultipleIngredient($dish->id, $this->selectedIngredients, $this->existIngredientsDish);
        } catch (Exception $e) {
            $this->errors[] = $e->getMessage();
            Yii::warning($e->getMessage());
            return false;
        }

        return true;
    }

    public  function getIngredients($dishId = 0): array
    {
        if ( empty($dishId) ) {
            $res = Ingredient::find()->where('hidden != 1')->all();
        } else {
            try {
                $res= Yii::$app->db->createCommand(
                    "select i.id as id, i.name as name from dish_ingredient di 
                        join ingredient i on di.ingredient_id = i.id where dish_id = :dish_id;"
                )->
                bindParam(":dish_id", $dishId)->queryAll();
            } catch (Exception $e) {
                Yii::warning($e->getMessage());
                return [];
            }
        }


        return ArrayHelper::map($res, 'id', 'name');
    }

    /**
     * @throws \yii\db\Exception
     */
    public static function saveMultipleIngredient(
        int $dishId,
        array $selectedIngredients,
        array $existIngredients
    ) : bool
    {
        $selectedIngredientIds = array_keys($selectedIngredients);
        $existIngredientIds = array_keys($existIngredients);
        // Новые данные
        $newIds = [];
        foreach ( $selectedIngredientIds as $selectedId) {
            if ( !in_array($selectedId, $existIngredientIds) ) {
               $newIds[] = $selectedId;
            }
        }
        $newIds = array_unique($newIds);
        $valuesForInsert = [];
        foreach ( $newIds as $newId) {
            $valuesForInsert[] = [$dishId,$newId];
        }

        if ( !empty($valuesForInsert) ) {
            Yii::$app->db->createCommand()->batchInsert(
                DishIngredient::tableName(),
                ['dish_id', 'ingredient_id'],
                $valuesForInsert)->execute();
        }

        // данные которые надо удалить
        $delIds = [];
        foreach ( $existIngredientIds as $existId ) {
            if ( !in_array($existId, $selectedIngredientIds) ) {
                $delIds[] = $existId;
            }
        }

        if ( !empty($delIds) ) {
            $delIdsStr = implode(",", $delIds);
            Yii::$app->db->createCommand(
                'delete from dish_ingredient where dish_id = :dish_id and ingredient_id in(:ingredient_ids);'
            )->bindParam(':dish_id', $dishId)
                ->bindParam(':ingredient_ids', $delIdsStr)
                ->execute();
        }


        return true;
    }

    public static function getHiddenDishIds() : array
    {
       static $staticHiddenDishIds = null;

       if ( $staticHiddenDishIds !== null ) {
           return $staticHiddenDishIds;
       }

        try {
            $res = Yii::$app->db->
            createCommand('select di.dish_id from dish_ingredient di left join ingredient i on di.ingredient_id = i.id where hidden = 1;')->
            queryAll();
            if ( empty($res) ) {
                $staticHiddenDishIds = [];
                return $staticHiddenDishIds;
            }
        } catch (Exception $e) {
            Yii::warning($e->getMessage());
            return [];
        }
        $staticHiddenDishIds = array_column($res, 'dish_id');
        return $staticHiddenDishIds;
    }

}