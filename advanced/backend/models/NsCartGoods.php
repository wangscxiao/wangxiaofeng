<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/4
 * Time: 10:39
 */

namespace backend\models;


use yii\db\ActiveRecord;

class NsCartGoods extends ActiveRecord
{
    public static function tableName()
    {
        return 'ns_cart_goods';
    }
}