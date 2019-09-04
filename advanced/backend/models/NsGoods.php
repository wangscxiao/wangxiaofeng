<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/2
 * Time: 19:23
 */

namespace backend\models;


use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
class NsGoods extends ActiveRecord
{
    public static function tableName()
    {
        return 'ns_goods';
    }


  public function getCartGoods(){
      return $this->hasMany(NsCartGoods::className(), ['cart_id' => 'goods_id']);
  }




    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'attributes' => [
                    # 创建之前
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time', 'update_time'],
                    # 修改之前
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['update_time']
                ],
                #设置默认值
                'value' => time()
            ]
        ];
    }

}