<?php
use yii\web\Response; 
use yii\filters\Cors;  
use yii\helpers\ArrayHelper; 
class CorsOrgin
{
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
                'Access-Control-Request-Method' => ['PUT','POST'],
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
                'Access-Control-Request-Method' => ['PUT','POST'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Credentials' => null,
                'Access-Control-Max-Age' => 86400,
                'Access-Control-Expose-Headers' => [],
        ]
    ],    

  ]); 
 } 
}