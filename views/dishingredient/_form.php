<?php

use dosamigos\multiselect\MultiSelect;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\DishIngredient */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="dish-ingredient-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'customAttDishName')->textInput() ?>

    <?= $form->field($model, 'dish_id')->hiddenInput() ?>

    <?= $form->field($model, 'ingredient_id')->textInput() ?>

    <?php
    echo \dosamigos\multiselect\MultiSelectListBox::widget([
        'id'=>"multiXX",
        "options" => ['multiple'=>"multiple"], // for the actual multiselect
        'data' => [ 0 => 'super', 2 => 'natural'], // data as array
//        'value' => [ 0, 2], // if preselected
        'name' => 'multti', // name for the form
        "clientOptions" =>
            [
                "includeSelectAllOption" => true,
                'numberDisplayed' => 2
            ],
    ]);
     ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
