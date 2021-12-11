<?php

namespace app\controllers;

use app\models\custom\DishIngredients;
use app\models\Dish;
use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DishController implements the CRUD actions for Dish model.
 */
class DishController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }
    public function beforeAction($action)
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['/site/login']);
        }
        return parent::beforeAction($action);
    }

    /**
     * Lists all Dish models.
     * @return mixed
     */
    public function actionIndex()
    {
        $hiddenDishIds = DishIngredients::getHiddenDishIds();
        if ( empty($hiddenDishIds) ) {
            $query = Dish::find();
        } else {
            $query = Dish::find()->where(['not in', 'id', $hiddenDishIds]);
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Dish model.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Dish model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $dishIngredients = new DishIngredients();

        if ($this->request->isPost) {
            $dishName = $this->request->post('dishName', 'unknown');
            $ingredientIds = $this->request->post('multiselect', []);
            $dishIngredients->dishName = $dishName;
            $dishIngredients->setSelectedIngredientsByIds($ingredientIds);

            if ( $dishIngredients->createDishIngredients() ) {
                return $this->redirect(['view', 'id' => $dishIngredients->dishId]);
            } else {
                foreach ( $dishIngredients->errors as $error ) {
                    Yii::$app->session->setFlash('error', $error);
                }
            }
        }

        return $this->render('create', [
            'dishIngredients' => $dishIngredients,
        ]);
    }

    /**
     * Updates an existing Dish model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $dishIngredients = new DishIngredients();
        $dishIngredients->set($id);
        if ($this->request->isPost) {
            $dishName = $this->request->post('dishName', 'unknown');
            $ingredientIds = $this->request->post('multiselect', []);
            $dishIngredients->dishName = $dishName;
            $dishIngredients->setSelectedIngredientsByIds($ingredientIds);

            if ( $dishIngredients->updateDishIngredients() ) {
                return $this->redirect(['view', 'id' => $dishIngredients->dishId]);
            } else {
                foreach ( $dishIngredients->errors as $error ) {
                    Yii::$app->session->setFlash('error', $error);
                }
            }
        }

        return $this->render('update', [
            'dishIngredients' => $dishIngredients,
        ]);
    }

    /**
     * Deletes an existing Dish model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Dish model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Dish the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Dish::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
