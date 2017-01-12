<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "material_purchased".
 *
 * @property integer $id
 * @property integer $material_id
 * @property integer $supplier_id
 * @property integer $invoice_no
 * @property integer $project_id
 * @property double $quantity
 * @property integer $vehicle_no
 * @property string $delivered_by
 * @property string $recieved_by
 * @property integer $bill_no
 * @property string $date_time
 * @property string $remarks
 * @property integer $purchased_by
 *
 * @property Account $purchasedBy
 * @property Material $material
 * @property Project $project
 * @property Supplier $supplier
 */
class MaterialPurchased extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'material_purchased';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
            [['material_id', 'supplier_id', 'invoice_no', 'project_id', 'vehicle_no', 'bill_no', 'purchased_by'], 'integer'],
            [['quantity'], 'number'],
            [['date_time'], 'safe'],
            [['delivered_by', 'recieved_by'], 'string', 'max' => 50],
            [['remarks'], 'string', 'max' => 255],
            [['purchased_by'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['purchased_by' => 'account_id']],
            [['material_id'], 'exist', 'skipOnError' => true, 'targetClass' => Material::className(), 'targetAttribute' => ['material_id' => 'id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
            [['supplier_id'], 'exist', 'skipOnError' => true, 'targetClass' => Supplier::className(), 'targetAttribute' => ['supplier_id' => 'supplier_id']],
        ];
    }

    public function validatePassword($attribute)
    {
           
        return $this->addError($attribute, 'Incorrect username or password.');
        
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'material_id' => 'Material ID',
            'supplier_id' => 'Supplier ID',
            'invoice_no' => 'Invoice No',
            'project_id' => 'Project ID',
            'quantity' => 'Quantity',
            'vehicle_no' => 'Vehicle No',
            'delivered_by' => 'Delivered By',
            'recieved_by' => 'Recieved By',
            'bill_no' => 'Bill No',
            'date_time' => 'Date Time',
            'remarks' => 'Remarks',
            'purchased_by' => 'Purchased By',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPurchasedBy()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'purchased_by']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaterial()
    {
        return $this->hasOne(Material::className(), ['id' => 'material_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['project_id' => 'project_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSupplier()
    {
        return $this->hasOne(Supplier::className(), ['supplier_id' => 'supplier_id']);
    }
}
