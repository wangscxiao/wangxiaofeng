<?php
/**
 * Created by PhpStorm.
 * User: wang
 * Date: 2019/8/29
 * Time: 8:20
 */

namespace backend\controllers;

use Yii;
use backend\models\Pics;
use yii\web\Controller;
use app\models\Post;
use yii\helpers\Json;
use backend\models\UploadModel;
use backend\models\UploadForm;
use yii\web\UploadedFile;

class PicController extends Controller
{
    public $enableCsrfValidation = false;

    //展示轮播图表
    public function actionList()
    {

        return $this->renderPartial('list');
    }

    //展示轮播图数据
    public function actionList_do()
    {
        $data = Pics::find()->asArray()->all();

        $data = array(
            "code" => 0,
            "message" => "",
            "data" => $data
        );
        exit(json_encode($data));
    }

    //添加轮播图展示页
    public function actionAdd_list()
    {
        return $this->renderPartial('addlist');
    }

    //添加轮播图操作
    public function actionAdd_do()
    {
        $data = Yii::$app->request->post();

        unset($data['file'], $data["UploadForm"]);
        $pic = new Pics();

        $pic->title = $data['title'];
        $pic->url = $data['url'];
        $pic->pic = $data["pic"];
        if ($pic->save() > 0) {

            return json_encode(array("code" => 1, "message" => "", "data" => array()));
        } else {
            return json_encode(array("code" => -1, "message" => "上传失败", "data" => array()));
        }

    }


    //上传轮播图片
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

    //删除轮播图
    public function actionDelete()
    {
        $data = Yii::$app->request->post();
        //var_dump($data);die;
        $res = Pics::findOne($data)->delete();

        if ($res) {
            return 200;
        } else {
            return 301;
        }
    }

    //修改页
    public function actionUpdate()
    {
        $data = Yii::$app->request->get();
        unset($data['r']);
        $res=Pics::find()->where($data)->asArray()->one();
        return $this->renderPartial('update',['date'=>$res]);
    }
    //修改操作
    public function actionUpdate_do(){
        $data = Yii::$app->request->post();
        unset($data['file'],$data['UploadForm']);
        //var_dump($data);die;
        $db=\Yii::$app->db->createCommand()->update('pics',['title'=>$data['title'],'url'=>$data['url'],'pic'=>$data['pic']],['id'=>$data['id']])->execute();
        //var_dump($db);die;
        if($db){
            return 1;
        }else{
            return 0;
        }

    }
}