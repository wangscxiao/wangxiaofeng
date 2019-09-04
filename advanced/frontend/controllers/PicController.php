<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/8/29
 * Time: 19:33
 */

namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use frontend\models\Pic;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class PicController extends Controller
{
    public function actionList(){

        $list = Pic::find()->asArray()->all();
        $data =array(
            "code"=>0,
            "message"=>"",
            "data"=>$list
        );
        exit(json_encode($data));
    }
    public function actionAdd($a, $b){
        echo $a;
        echo $b;
    }
}