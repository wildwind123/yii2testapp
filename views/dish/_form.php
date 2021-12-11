<?php

use app\models\custom\DishIngredients;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Dish */
/* @var $form yii\widgets\ActiveForm */
/* @var $dishIngredients DishIngredients */
?>

<div class="dish-form">

    <?= Html::beginForm() ?>

    <?= Html::label('Название') ?>
    <br>
    <?= Html::textInput("dishName", $dishIngredients->dishName) ?>
    <br><br>
    <?php
    echo \dosamigos\multiselect\MultiSelectListBox::widget([
//        'id'=>"multiselect",
        "options" => ['multiple'=>"multiple"], // for the actual multiselect
        'data' => $dishIngredients->ingredients, // data as array
        'value' => $dishIngredients->existIngredientsDishIds, // if preselected
        'name' => 'multiselect', // name for the form
        "clientOptions" =>
            [
                "includeSelectAllOption" => true,
                'numberDisplayed' => 2
            ],
    ]);
    ?>


    <br>
    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?= Html::endForm() ?>
</div>
