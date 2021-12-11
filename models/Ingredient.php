<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ingredient".
 *
 * @property int $id
 * @property string|null $name
 * @property int $hidden
 * @property string|null $updated
 * @property string|null $created
 */
class Ingredient extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ingredient';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'string'],
            [['hidden'], 'required'],
            [['hidden'], 'integer'],
            [['updated', 'created'], 'safe'],
            ['name', 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'hidden' => 'Hidden',
            'updated' => 'Updated',
            'created' => 'Created',
        ];
    }
}
