<?php

namespace app\modules\pettycash\models;

use Yii;

/**
 * This is the model class for table "petty_cash_purchase".
 *
 * @property integer $id
 * @property integer $material_id
 * @property integer $amt
 * @property string $date_time
 * @property string $desc
 *
 * @property Material $material
 */
class PettyCashPurchase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'petty_cash_purchase';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'material_id', 'amt', 'desc'], 'required'],
            [['id', 'material_id', 'amt'], 'integer'],
            [['date_time'], 'safe'],
            [['desc'], 'string', 'max' => 255],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::className(), 'targetAttribute' => ['material_id' => 'id']],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_id' => 'Material ID',
            'amt' => 'Amt',
            'date_time' => 'Date Time',
            'desc' => 'Desc',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }
}
