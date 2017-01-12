<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "project".
 *
 * @property integer $project_id
 * @property string $name
 * @property string $Address
 * @property string $city
 * @property string $state
 * @property integer $pincode
 *
 * @property MaterialPurchased[] $materialPurchaseds
 * @property PettyCash[] $pettyCashes
 * @property VehicleAttendance[] $vehicleAttendances
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'project';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           
            [['project_id', 'pincode'], 'integer'],
            [['name', 'city', 'state'], 'string', 'max' => 100],
            [['Address'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'name' => 'Name',
            'Address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'pincode' => 'Pincode',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterialPurchaseds()
    {
        return $this->hasMany(MaterialPurchased::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPettyCashes()
    {
        return $this->hasMany(PettyCash::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleAttendances()
    {
        return $this->hasMany(VehicleAttendance::className(), ['project_id' => 'project_id']);
    }
}
