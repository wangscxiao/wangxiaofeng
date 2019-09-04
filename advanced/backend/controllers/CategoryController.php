<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/2
 * Time: 13:48
 */

namespace backend\controllers;

use Yii;
use backend\models\NsCategory;
use yii\web\Controller;
use app\models\Post;
use yii\helpers\Json;
use backend\models\UploadModel;
use backend\models\UploadForm;
use yii\web\UploadedFile;

class CategoryController extends Controller
{
    public $enableCsrfValidation = false;

    //分类列表
    public function actionList()
    {

        return $this->renderPartial('list');
    }

    //展示分类数据
    public function actionList_do()
    {
        $data = NsCategory::find()->asArray()->all();

        $data = array(
            "code" => 0,
            "message" => "",
            "data" => $data
        );
        exit(json_encode($data));
    }


    //添加分类页
    public function actionAdd_list()
    {
        $data = new NsCategory();
        $res = $data->getCategories();

        return $this->renderPartial('addlist', ["data" => $res]);
    }


    //添加分类操作
    public function actionAdd_do()
    {
        $data = Yii::$app->request->post();
        $Category = new NsCategory();
        $Category->category_name = $data['category_name'];
        $Category->level = $data['city'];
        $Category->pid = $data['pid'];
        if ($Category->save() > 0) {

            return json_encode(array("code" => 1, "message" => "", "data" => array()));
        } else {
            return json_encode(array("code" => -1, "message" => "添加失败", "data" => array()));
        }

    }


    //分类修改页

    public function actionUpdate()
    {
        $data1 = new NsCategory();

        $res2 = $data1->getCategories();
        $data = Yii::$app->request->get();
        unset($data['r']);
        $res = NsCategory::find()->where($data)->asArray()->one();//获取的是单条的
        // var_dump($data);die;
        return $this->renderPartial('update', ['date' => $res, 'dd' => $res2,'id'=>$data['id']]);
    }
    //修改操作
    public function actionUpdate_do()
    {
        $data = Yii::$app->request->post();
        $db=\Yii::$app->db->createCommand()->update('ns_category',['category_name'=>$data['category_name'],'level'=>$data['level'],'pid'=>$data['pid'],'sort'=>$data['sort']],['id'=>$data['id']])->execute();
        //var_dump($db);die;
        if($db){
            return 1;
        }else{
            return 0;
        }
    }
    //删除分类
    public function actionDelete()
    {
        $data = Yii::$app->request->post();
        //var_dump($data);die;
        $res = NsCategory::findOne($data)->delete();

        if ($res) {
            return 200;
        } else {
            return 301;
        }
    }
}