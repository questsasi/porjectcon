<?php

namespace app\modules\contact\controllers;


use Yii;
//use frontend\modules\contact\Account;

use frontend\models\AccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index'=>['get'],
                    'create' =>['POST'],
                    'update' =>['POST'],
                    'delete' =>['POST'],
                ],
            ],
        ];
    }
    public function beforeAction($event) {
        $action = $event->id; 
        if (isset($this->actions[$action])) {
            $verbs = $this->actions[$action];
        } 
        elseif (isset($this->actions['*'])) {
            $verbs = $this->actions['*'];
        } 
        else {
            return $event->isValid;
        }
        $verb = Yii::$app->getRequest()->getMethod(); 
        $allowed = array_map('strtoupper', $verbs);    
        if (!in_array($verb, $allowed)) {   
            echo json_encode(array('status'=>failed,'error_code'=>400,'message'=>'Method not allowed'),JSON_PRETTY_PRINT);
            exit;          
        }         
        return true;  
    } 

    /**
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex() {         
    $query= new Query;      
    $query->from('account')      
    ->select("`account_id`, `first_name`, `middile_name`, `last_name`, `mobile_no`, `alternate_no`, `address`, `created_on`, `updated_on`, `is_active`, `designation`, `designation_type`");           
    $command = $query->createCommand();
    $models = $command->queryAll();  
    echo json_encode(array('status'=>"success",'data'=>array_filter($models)),JSON_PRETTY_PRINT);   
    }

    /**
     * Displays a single Account model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $params = Yii::$app->getRequest()->getBodyParams(); 
        $model = new Account();
        $model->attributes=$params;       
        if ($model->save()) {
            echo json_encode(array('status'=>"success",'data'=>array('message'=>'record saved successfully')),JSON_PRETTY_PRINT);         
        } 
        else {    
            echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
        }
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {    
        $params = Yii::$app->getRequest()->getBodyParams(); 
        $model = new Account();
        $model->attributes = $params;     
        $model = $this->findModel($id);
        if ($model->save()) {
            echo json_encode(array('status'=>"success",'data'=>array('message'=>'record updated successfully')),JSON_PRETTY_PRINT);        
        } 
        else {    
            echo json_encode(array('status'=>"error",'data'=>array('message'=>'record not updated')),JSON_PRETTY_PRINT);
        }     
    }

    /**
     * Deletes an existing Account model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $model=$this->findModel($id);      
        if($model->delete()) {        
          echo json_encode(array('status'=>"success",'data'=>array('message'=>'record deleted successfully')),JSON_PRETTY_PRINT);    
        }
        else {          
          echo json_encode(array('status'=>"error",'data'=>array('message'=>'record not deleted')),JSON_PRETTY_PRINT);
        }
    }

    /**
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}


