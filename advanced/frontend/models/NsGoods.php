<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/2
 * Time: 15:46
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class NsGoods extends ActiveRecord
{
    public static function tableName()
    {
        return 'ns_goods';
    }


}