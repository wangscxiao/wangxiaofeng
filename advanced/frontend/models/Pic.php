<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/8/29
 * Time: 19:54
 */

namespace frontend\models;

use yii\db\ActiveRecord;

class Pic extends ActiveRecord
{

    public static function tableName()
    {
        return 'pics';
    }
}