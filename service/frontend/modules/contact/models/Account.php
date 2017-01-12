<?php

namespace frontend\modules\contact\models;

use Yii;

/**
 * This is the model class for table "account".
 *
 * @property integer $account_id
 * @property string $first_name
 * @property string $middile_name
 * @property string $last_name
 * @property integer $mobile_no
 * @property integer $alternate_no
 * @property string $address
 * @property string $created_on
 * @property string $updated_on
 * @property string $is_active
 * @property string $designation
 * @property string $designation_type
 *
 * @property MaterialPurchased[] $materialPurchaseds
 * @property PettyCash[] $pettyCashes
 * @property PettyCash[] $pettyCashes0
 * @property PettyCash[] $pettyCashes1
 */
class Account extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'account';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['first_name', 'mobile_no'], 'required'],
            [['mobile_no', 'alternate_no'], 'integer'],
            [['created_on', 'updated_on'], 'safe'],
            [['is_active'], 'string'],
            [['first_name', 'middile_name', 'last_name', 'designation', 'designation_type'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 255],
            [['mobile_no'], 'unique'],
            [['alternate_no'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'account_id' => 'Account ID',
            'first_name' => 'First Name',
            'middile_name' => 'Middile Name',
            'last_name' => 'Last Name',
            'mobile_no' => 'Mobile No',
            'alternate_no' => 'Alternate No',
            'address' => 'Address',
            'created_on' => 'Created On',
            'updated_on' => 'Updated On',
            'is_active' => 'Is Active',
            'designation' => 'Designation',
            'designation_type' => 'Designation Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialPurchaseds()
    {
        return $this->hasMany(MaterialPurchased::className(), ['purchased_by' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPettyCashes()
    {
        return $this->hasMany(PettyCash::className(), ['account_id' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPettyCashes0()
    {
        return $this->hasMany(PettyCash::className(), ['given_by' => 'account_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPettyCashes1()
    {
        return $this->hasMany(PettyCash::className(), ['approved_by' => 'account_id']);
    }
}
