<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "supplier".
 *
 * @property integer $supplier_id
 * @property string $name
 * @property integer $mobile_no
 * @property integer $alternate_no
 * @property string $address
 * @property string $created_on
 * @property string $updated_on
 * @property string $bank_id
 * @property string $is_active
 *
 * @property MaterialPurchased[] $materialPurchaseds
 * @property Payment[] $payments
 */
class Supplier extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'supplier';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['supplier_id', 'name', 'mobile_no', 'alternate_no', 'address', 'is_active'], 'required'],
            [['supplier_id', 'mobile_no', 'alternate_no'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_active'], 'string'],
            [['name', 'bank_id'], 'string', 'max' => 100],
            [['address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'supplier_id' => 'Supplier ID',
            'name' => 'Name',
            'mobile_no' => 'Mobile No',
            'alternate_no' => 'Alternate No',
            'address' => 'Address',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'bank_id' => 'Bank ID',
            'is_active' => 'Is Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialPurchaseds()
    {
        return $this->hasMany(MaterialPurchased::className(), ['supplier_id' => 'supplier_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPayments()
    {
        return $this->hasMany(Payment::className(), ['supplier_id' => 'supplier_id']);
    }
}
