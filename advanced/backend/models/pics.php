<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/8/30
 * Time: 10:37
 */

namespace backend\models;


use yii\db\ActiveRecord;

class pics extends ActiveRecord
{
    public static function tableName()
    {
        return 'pics';
    }
}