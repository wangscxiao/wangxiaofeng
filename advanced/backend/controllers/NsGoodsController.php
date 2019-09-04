<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/9/2
 * Time: 20:40
 */

namespace backend\controllers;

use app\models\Post;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;
use backend\models\NsGoods;
use yii\web\Controller;
use backend\models\NsCategory;
use backend\models\UploadForm;
use yii\web\UploadedFile;
use Yii;

class NsGoodsController extends Controller
{
    public $enableCsrfValidation = false;

    //商品列表
    public function actionList()
    {

        return $this->renderPartial('list');
    }

    //展示商品数据
    public function actionList_do()
    {
        $data = NsGoods::find()->asArray()->all();

        $data = array(
            "code" => 0,
            "message" => "",
            "data" => $data
        );
        exit(json_encode($data));
    }

    //上传图片
    public function actionUpload()
    {

        $model = new UploadForm();
        $uploadSuccessPath = "";
        if (Yii::$app->request->isPost) {
            $image = UploadedFile::getInstanceByName('file');
            $imageName = $image->getBaseName();
            $ext = $image->getExtension();
            $rootPath = 'assets/images/';
            $path = $rootPath . date('Y/m/d/');
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
            $fullName = $path . $imageName . "." . $ext;
            if ($image->saveAs($fullName)) {
                return json_encode(['code' => 1, 'message' => '保存图片成功', 'data' => $fullName]);
            } else {
                return json_encode(['code' => -1, 'message' => '保存图片失败', 'data' => $image->error]);
            }

        }
    }

    //添加商品页
    public function actionAdd_list()
    {
        $data = new NsCategory();
        $res = $data->getCategories();
        return $this->renderPartial('addlist', ['data' => $res]);
    }

    //添加商品操作
    public function actionAdd_do()
    {
        $data = Yii::$app->request->post();
        unset($data['file'], $data["UploadForm"]);
        $goods = new NsGoods();
        $goods->goods_name = $data['goods_name'];
        $goods->shop_id = $data['shop_id'];
        $goods->goods_pic = $data['pic'];
        $goods->goods_spec = $data['goods_spec'];
        $goods->sort = $data['sort'];
        $goods->original_price = $data['original_price'];
        $goods->present_price = $data['present_price'];
        $goods->category = $data['category'];
        $goods->number = $data['number'];
        $goods->description = $data['desc'];
        if ($goods->save() > 0) {
            return json_encode(array("code" => 1, "message" => "", "data" => array()));
        } else {
            return json_encode(array("code" => -1, "message" => "添加失败", "data" => array()));
        }

    }

    //推荐状态//
    public function actionRecommend()
    {
        $data = Yii::$app->request->post();
        $status = 0;
        if ($data['status'] == "true") {
            $status = 1;
        }
        $res = \Yii::$app->db->createCommand()->update('ns_goods',
            ['is_recommend' => $status], ['goods_id' => $data['id']])->execute();

        if ($res) {
            $data = array(
                "code" => 1,
                "message" => "",
                "data" => array()
            );

        } else {
            $data = array(
                "code" => -1,
                "message" => "失败",
                "data" => array()
            );
        }
        exit(json_encode($data));

    }


    //商品删除
    public function actionDelete()
    {
        $data = Yii::$app->request->post();
        $res = NsGoods::findOne($data)->delete();
        if ($res) {
            return json_encode(array("code" => 1, "message" => "", "data" => array()));
        } else {
            return json_encode(array("code" => -1, "message" => "删除失败", "data" => array()));
        }
    }

    //商品修改页
    public function actionUpdate()
    {
        $data1 = new NsCategory();

        $res2 = $data1->getCategories();

        $data = Yii::$app->request->get();
        unset($data['r']);
        $res = NsGoods::find()->where($data)->asArray()->one();//获取的是单条的

        return $this->renderPartial('update', ['date' => $res, 'data' => $res2, 'id' => $data['goods_id']]);
    }

    //商品修改操作
    //修改操作
    public function actionUpdate_do()
    {
        $data = Yii::$app->request->post();
        unset($data['r'],$data['file'],$data['UploadForm']);
       //var_dump($data);die;
        $db=\Yii::$app->db->createCommand()
            ->update('ns_goods',[
                'goods_name'=>$data['goods_name'],
                'shop_id'=>$data['shop_id'],
                'goods_pic'=>$data['goods_pic'],
                'goods_spec'=>$data['goods_spec'],
                'original_price'=>$data['original_price'],
                'category'=>$data['pid'],
                'number'=>$data['number'],
                'description'=>$data['desc'],
                ],['goods_id'=>$data['goods_id']])->execute();

        if($db){
            return json_encode(array("code" => 1, "message" => "", "data" => array()));
        }else{
            return json_encode(array("code" => -1, "message" => "失败", "data" => array()));
        }
    }
}