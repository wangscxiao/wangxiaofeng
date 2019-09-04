<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;


class UploadModel extends \yii\db\ActiveRecord
{
    /**
     * @var UploadedFile|Null file attribute
     */
    public $file;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [["file"], "file",],
        ];
    }

    /**公共上传 上传信息(数组) 文件名称 大小 后缀名限制 上传后保存的名字 update时为更新图片 删除原有图片*/
    public function upload($img, $name = '/vessel', $siez = '', $arr_type = '', $text_name = '', $act = 'update', $url = '/vessel/20180831/153571385083726.jpg')
    {
        $path = '../..';
        $dirname = $path . $name;
        $fill = $this->file->extension;//图片的名字只取后缀名
        if (empty($text_name)) {
            $ran = time() . rand(10000, 99999);//随机名字
        } else {
            $ran = $text_name;
        }
        $arr = $arr_type;
        if (!empty($arr)) {
            if (!in_array($fill, $arr)) {
                return json_encode('格式不正确');
            }
        }
//定义上传大小和类型
        if (!empty($siez)) {
            if ($img['size'] > $siez) {
                return json_encode('文件大小超过限制');
            }
        }
//文件上传存放的目录
        $dir = $dirname . '/' . date("Ymd");
        $dir_sev = $name . '/' . date("Ymd");/*数据库存储路径*/
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }
        if ($this->validate()) {
//文件名
            $fileName = $ran . '.' . $fill;
            $dir = $dir . "/" . $fileName;
            if ($act == 'update') {
                if ($this->file->saveAs($dir)) {
                    @unlink($path . $url);
                }
            }/*删除图片*/
            $uploadSuccessPath = $dir_sev . "/" . $fileName;/*最后路径*/
            return $uploadSuccessPath;
        }
    }
}