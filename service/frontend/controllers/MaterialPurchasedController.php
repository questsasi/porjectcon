<?php
namespace frontend\controllers;

use Yii;
use frontend\models\MaterialPurchased;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

class MaterialPurchasedController extends Controller 
{ 
  public function behaviors()
  {
    return [
      'verbs' => [
        'class' => VerbFilter::className(),
        'actions' => [
          'index'=>['get'],                   
          'create-material-purchased'=>['post'],
          'update-material-purchased'=>['post'],
          'delete-material-purchased' => ['post'],         
        ],        
      ]
    ];
  }    
  public function beforeAction($event)
  {
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
      $this->setHeader(400);
      echo json_encode(array('status'=>"error",'data'=>array('message'=>'method not allowed')),JSON_PRETTY_PRINT);
      exit;          
    }         
   return true;  
  }   
 //get the all material purchased record     
  public function actionIndex() {      
  /*  $query= new Query;      
    $query ->from('material_purchased')      
    ->select("`id`, `material_id`, `supplier_id`, `invoice_no`, `project_id`, `quantity`, `vehicle_no`, `delivered_by`, `recieved_by`, `bill_no`, `date_time`, `remarks`, `purchased_by`");           
    $command = $query->createCommand();
    $models = $command->queryAll(); */
    $query = new Query;
    $query  ->select(['material.name','material_purchased.vehicle_no','supplier.name as supplier_name','project.name as project_name'])  
    ->from('material_purchased')
    ->innerjoin('material','material.id =material_purchased.material_id')
    ->innerjoin('project','project.project_id=material_purchased.project_id')
    ->innerjoin('supplier','material_purchased.supplier_id = supplier.supplier_id');
    $command = $query->createCommand();
    $models = $command->queryAll();       
      
    $this->setHeader(200);     
    echo json_encode(array('status'=>"success",'data'=>array_filter($models)),JSON_PRETTY_PRINT);   
  }  
//get particular material purchased record 
//using id
  public function actionGetMaterialPurchased($id){  
    $model=$this->findModel($id);      
    $this->setHeader(200);
    echo json_encode(array('status'=>"success",'data'=>array_filter($model->attributes)),JSON_PRETTY_PRINT);  
  } 
  //add the materil purchased in db
  public function actionCreateMaterialPurchased() {       
    $params = Yii::$app->getRequest()->getBodyParams();    
    $model = new MaterialPurchased();
    $model->attributes=$params;       
    if ($model->save()) {      
      $this->setHeader(200);
      echo json_encode(array('status'=>"success",'data'=>array('message'=>'record saved successfully')),JSON_PRETTY_PRINT);        
    } 
    else {
      $this->setHeader(400);    
      echo json_encode(array('status'=>"error",'data'=>array_filter($model->errors)),JSON_PRETTY_PRINT);
    }     
  } 
//update the record in db using id
  public function actionUpdateMaterialPurchased($id) {
    $params = Yii::$app->getRequest()->getBodyParams();  
    $model = $this->findModel($id);  
    $model->attributes=$params;
    if($model->save()) {      
      $this->setHeader(200);
      echo json_encode(array('status'=>"success",'data'=>array('message'=>'record updated successfully')),JSON_PRETTY_PRINT);       
    } 
    else {
      $this->setHeader(400);
       echo json_encode(array('status'=>"error",'data'=>array('message'=>'record not updated')),JSON_PRETTY_PRINT);
    }        
  }  
//delete thr record in db uding id
  public function actionDeleteMaterialPurchased($id) {
    $model=$this->findModel($id);      
    if($model->delete()) { 
      $this->setHeader(200);
       echo json_encode(array('status'=>"success",'data'=>array('message'=>'record deleted successfully')),JSON_PRETTY_PRINT);       
    }
    else {         
      $this->setHeader(400);
       echo json_encode(array('status'=>"error",'data'=>array('message'=>'record not deleted')),JSON_PRETTY_PRINT);
    }
  }
  //getting the value from Material purchased model    
  protected function findModel($id) { 
    if (($model = MaterialPurchased::findOne($id)) !== null) {
      return $model;
    }
    else {
      $this->setHeader(400);
      echo json_encode(array('status'=>"error",'data'=>array('message'=>'Bad request')),JSON_PRETTY_PRINT);
      exit;
    }
  }
  //setting the header 
    private function setHeader($status) {    
      $status_header = 'HTTP/1.1 ' . $status . ' ' . $this->_getStatusCodeMessage($status);
      $content_type = "application/json";  
      header($status_header);
      header('Content-type: ' . $content_type);
      header('X-Powered-By: ' . "ProZ Solutions");
    }
    //get the status code with error msg
    private function _getStatusCodeMessage($status)
    {
      $codes = Array(
        200 => 'OK.',
        201 =>'A resource was successfully created in response to a POST request. The Location header contains the URL pointing to the newly created resource.',
        204 =>  'The request was handled successfully and the response contains no content.', 
        304 =>  'The resource was not modified.',
        400 =>  'Bad request.',
        401 =>  'Authentication failed.',
        403 =>  'The authenticated user is not allowed to access the specified API endpoint.',
        404 =>  'The resource does not exist.',
        405 =>  'Method not allowed.',
        415 =>  'Unsupported media type.',
        422 =>  'Data validation failed.',
        429 =>  'Too many requests.',
        500 =>  'Internal server error.',     
      );
    return (isset($codes[$status])) ? $codes[$status] : '';
    }
}
