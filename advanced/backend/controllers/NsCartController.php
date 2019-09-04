<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/4
 * Time: 10:24
 */

namespace backend\controllers;


use yii\web\Controller;
use backend\models\NsCart as Cart;
use backend\models\NsCartGoods;
use backend\models\NsLogin;
class NsCartController extends Controller
{
    public function actionList()
    {

        return $this->renderPartial('list');
    }

    public function actionList_do()
    {
        $CartGoods=NsCartGoods::find()->all();

        $carts = Cart::find()->asArray()->all();

        $uid=NsLogin::find()->asArray()->all();
        var_dump($uid);die;
        foreach($carts as $cart ){
            $uid=NsLogin::find()->where(['id'=>$cart['user_id']])->all();

        }
        var_dump($uid);die;

        $data = array(
            "code" => 0,
            "message" => "",
            "data" => $cart,
        );
        exit(json_encode($data));
    }

}