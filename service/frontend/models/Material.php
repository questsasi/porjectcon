<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "material".
 *
 * @property integer $id
 * @property string $name
 * @property string $unit
 *
 * @property MaterialPurchased[] $materialPurchaseds
 * @property PettyCashPurchase[] $pettyCashPurchases
 */
class Material extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'unit'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['unit'], 'string', 'max' => 20],
            ['name', 'unique', 'targetClass' => '\frontend\models\Material', 'message' => 'This material name is already exist.'], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'unit' => 'Unit',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialPurchaseds()
    {
        return $this->hasMany(MaterialPurchased::className(), ['material_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPettyCashPurchases()
    {
        return $this->hasMany(PettyCashPurchase::className(), ['material_id' => 'id']);
    }
}
