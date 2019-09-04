<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/8/29
 * Time: 8:17
 */

namespace backend\models;


use yii\db\ActiveRecord;

class NsLogin extends ActiveRecord
{
    public static function tableName()
    {
        return 'ns_login';
    }

    public function getLogin()
    {
        return $this->hasOne(Login::className(), ['id' => 'cart_id']);
    }
}