<?php

namespace frontend\controllers;
use Yii;
//use app\models\Material;
use yii\rest\ActiveController;
use yii\rest\Controller;
use yii\data\ActiveDataProvider; 
//use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response; 
use yii\filters\Cors;  
use yii\helpers\ArrayHelper; 
/**
 * MaterialController implements the CRUD actions for Material model.
 */
class MaterialController extends ActiveController {
public $modelClass = 'frontend\models\Material'; 


}
