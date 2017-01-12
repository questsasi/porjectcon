<?php

namespace app\modules\pettycash\models;

use Yii;

/**
 * This is the model class for table "petty_cash".
 *
 * @property integer $id
 * @property integer $project_id
 * @property integer $account_id
 * @property integer $amt
 * @property string $date_time
 * @property string $purpose
 * @property integer $given_by
 * @property integer $approved_by
 *
 * @property Account $account
 * @property Account $givenBy
 * @property Account $approvedBy
 * @property Project $project
 */
class PettyCash extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'petty_cash';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'project_id', 'account_id', 'amt', 'given_by', 'approved_by'], 'integer'],
            [['date_time'], 'safe'],
            [['purpose'], 'string', 'max' => 255],
            [['account_id'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['account_id' => 'account_id']],
            [['given_by'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['given_by' => 'account_id']],
            [['approved_by'], 'exist', 'skipOnError' => true, 'targetClass' => Account::className(), 'targetAttribute' => ['approved_by' => 'account_id']],
            [['project_id'], 'exist', 'skipOnError' => true, 'targetClass' => Project::className(), 'targetAttribute' => ['project_id' => 'project_id']],
        ];
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'project_id' => 'Project ID',
            'account_id' => 'Account ID',
            'amt' => 'Amt',
            'date_time' => 'Date Time',
            'purpose' => 'Purpose',
            'given_by' => 'Given By',
            'approved_by' => 'Approved By',
        ];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccount()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'account_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGivenBy()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'given_by']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApprovedBy()
    {
        return $this->hasOne(Account::className(), ['account_id' => 'approved_by']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProject()
    {
        return $this->hasOne(Project::className(), ['project_id' => 'project_id']);
    }
}
