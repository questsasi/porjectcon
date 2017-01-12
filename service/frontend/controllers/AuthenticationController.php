<?php
namespace frontend\controllers;
use Yii;
use yii\web\Response; 
use yii\filters\Cors;  
use yii\helpers\ArrayHelper;  
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\User;
class AuthenticationController extends Controller
{ 
  public $response; 
  public function actionLogin() {
   // $user = Yii::$app->request->post('username');
   
    $user = Yii::$app->getRequest()->getQueryParam('username');   
    $pass = Yii::$app->getRequest()->getQueryParam('password');  
    $model = new User();
    $data = $model->login($user,$pass);

    /*foreach($data as $email) {
      $emailID = $email->email;
    }*/
     //print_r($model->findByUsername($user));
    exit;
    /*if($model->findByUsername($user) == true && $model->findByPassword($pass) == true) {  
      $this->error = array('status' => "Success","data"=>array( "Name" => $user, "Email" => $emailID ));    
    }
    else {         
      $this->error = array('status' => "Error", "data"=>"Login Failed"); 
    }*/

    $userObj = $model->findByUsername($user);
    
   
    if($userObj->username == $user && $userObj->password == $pass) {
      $this->response = array('status' => "success"," data"=>array("name" => $user, "email" => $userObj->email));
    }
    else{
      $this->response = array('status' => "error", "data"=>"Login failed");
    }

    print_r( json_encode($this->response)); 
  } 

    public function behaviors()
    {
    return ArrayHelper::merge(parent::behaviors(), [    
          [
              'class' => 'yii\filters\ContentNegotiator',
              'only' => ['view', 'index'],  // in a controller
              // if in a module, use the following IDs for user actions
              // 'only' => ['user/view', 'user/index']
              'formats' => [
                  'application/json' => Response::FORMAT_JSON,
              ],
              'languages' => [
                  'en',
                  'de',
              ],
          ],

          'cors' => [
            'class' => Cors::className(),
            #special rules for particular action
            'actions' => [
                'your-action-name' => [
                    #web-servers which you alllow cross-domain access
                    'Origin' => ['*'],
                    'Access-Control-Allow-Origin'=> ['*'],
                    'Access-Control-Request-Method' => ['GET'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
                ]
            ],
            #common rules
            'cors' => [
               'Origin' => ['*'],
                    'Access-Control-Allow-Origin'=> ['*'],
                    'Access-Control-Request-Method' => ['GET'],
                    'Access-Control-Request-Headers' => ['*'],
                    'Access-Control-Allow-Credentials' => null,
                    'Access-Control-Max-Age' => 86400,
                    'Access-Control-Expose-Headers' => [],
            ]
        ],
         

      ]); 
  }
}
