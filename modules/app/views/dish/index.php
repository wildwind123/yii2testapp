<?php

use app\models\custom\DishIngredients;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\web\JsExpression;

/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $dishIngredients DishIngredients */
/* @var $minIngredient int */
/* @var $maxIngredient int */

echo Html::beginForm();
echo \dosamigos\multiselect\MultiSelectListBox::widget([
//        'id'=>"multiselect",
    "options" => ['multiple'=>"multiple"], // for the actual multiselect
    'data' => $dishIngredients->ingredients, // data as array
    'value' => $dishIngredients->existIngredientsDishIds, // if preselected
    'name' => 'multiselect', // name for the form

    "clientOptions" =>
        [
            "includeSelectAllOption" => true,
            'numberDisplayed' => 2,
            'maximumInputLength' => 1,
            'afterSelect' => new JsExpression('function(ms){ 
                    selectEvent(ms)
            }', ),
            'afterDeselect' => new JsExpression('function(ms){ 
                     selectEvent(ms)
            }', )
        ],
]);
?>
    <br>
    <div class="form-group">
        <div type="submit" onclick="checkAndSubmit()" class="btn btn-success">Save</div>
    </div>
    <br>
<?php
echo Html::endForm();

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
            'id',
            'name',
            'ingredients',
            'countFoundedIngredient'
    ],
]); ?>

<script>

    let minIngredient = <?= $minIngredient ?>;
    let maxIngredient = <?= $maxIngredient ?>;
   let checkAndSubmit = () => {
           if (  getSelectedItemCount() < minIngredient ) {
               alert('Выберите больше ингредиентов')
               return;
           }
       let s = document.querySelector('form[action="/app"]')
       s.submit()
   }

   let multiselect;
   let selectEvent = (data) => {
       if ( getSelectedItemCount() > maxIngredient - 1 ) {
           selectableColumnDisable(true)
       } else {
           selectableColumnDisable(false)
       }

   }

   let getSelectedItemCount = () => {
       let selectedItemsEl = document.querySelectorAll('.ms-selection>.ms-list>.ms-selected')
       if (selectedItemsEl == null) {
           return 0
       }
       return selectedItemsEl.length
   }

   let selectableColumnDisable = (disabled) => {
       let selectableElements = document.querySelectorAll('.ms-elem-selectable:not(.ms-selected)')
       for ( let elem in selectableElements ) {
           let e = selectableElements[elem]
           if (e instanceof Node) {
               if (disabled) {
                   e.classList.add('disabled')
               } else {
                   e.classList.remove('disabled')
               }

           }
       }
   }

</script>
