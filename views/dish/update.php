<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $dishIngredients \app\models\custom\DishIngredients */

$this->title = 'Update Dish: ' . $dishIngredients->dishName;
$this->params['breadcrumbs'][] = ['label' => 'Dishes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $dishIngredients->dishName, 'url' => ['view', 'id' => $dishIngredients->dishId]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="dish-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'dishIngredients' => $dishIngredients,
    ]) ?>

</div>
