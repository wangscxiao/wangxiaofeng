<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/2
 * Time: 13:53
 */

namespace backend\models;


use yii\db\ActiveRecord;

class NsCategory extends ActiveRecord
{
    public static function tableName()
    {
        return 'ns_category';
    }




    public function rules()
    {
        return [
            [['pid'], 'integer'],
            [['category_name'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_name' => '分类名称',
            'pid' => '父级分类',
        ];
    }

    /**
     * 获取所有的分类
     */
    public function getCategories()
    {
        $data = self::find()->where(['pid'=>0])->asArray()->all();
        foreach($data as $k=>$v){
            $res = self::find()->where(['pid'=>$v['id']])->asArray()->all();
            $data[$k]['childs']=$res;

        }
        return $data;
    }

    /**
     *遍历出各个子类 获得树状结构的数组
     */
    public static function getTree($data,$pid = 0,$lev = 1)
    {
        $tree = [];
        foreach($data as $value){
            if($value['pid'] == $pid){
                $value['category_name'] = str_repeat('|___',$lev).$value['category_name'];
                $tree[] = $value;
                $tree = array_merge($tree,self::getTree($data,$value['id'],$lev+1));
            }
        }
        return $tree;
    }


    /**
     * 得到相应  id  对应的  分类名  数组
     */
    public function getOptions()
    {
        $data = $this->getCategories();
        $tree = $this->getTree($data);
        $list = ['添加顶级分类'];
        foreach($tree as $value){
            $list[$value['id']] = $value['category_name'];
        }
        return $list;
    }
}