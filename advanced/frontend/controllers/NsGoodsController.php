<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/2
 * Time: 15:24
 */

namespace frontend\controllers;

use frontend\models\NsGoods;
use yii\web\Controller;

class NsGoodsController extends Controller
{
    public function actionList(){
        $list = NsGoods::find()->where(['is_recommend'=>1])->asArray()->all();
        $data =array(
            "code"=>0,
            "message"=>"",
            "data"=>$list
        );
        exit(json_encode($data));
    }
}