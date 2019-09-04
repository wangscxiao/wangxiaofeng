<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/3
 * Time: 19:24
 */

namespace frontend\models;


use yii\db\ActiveRecord;

class  NsCategory extends ActiveRecord
{
    public static function tableName()
    {
        return 'ns_category';
    }

}