<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/4
 * Time: 10:25
 */

namespace backend\models;


use yii\db\ActiveRecord;

class NsCart extends ActiveRecord
{
    public static function tableName()
    {
        return 'ns_cart';
    }

    public function getNsGoods(){
        return $this->hasMany(NsLogin::className(), ['id' => 'cart_id']);
    }
}