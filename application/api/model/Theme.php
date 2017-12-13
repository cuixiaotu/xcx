<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/8
 * Time: 18:37
 */

namespace app\api\model;


class Theme extends BaseModel
{
    protected $hidden = ["update_time","delete_time","topic_img_id","head_img_id"];
    public function TopicImg(){
        return $this->belongsTo("Image","topic_img_id",'id');
    }

    public function HeadImg(){
        return $this->belongsTo("Image","head_img_id",'id');
    }

    public function products(){
        return $this->belongsToMany("Product","theme_product","product_id","theme_id");
    }

    public  static function  getThemeWithProducts($id){
        $theme= self::with("products,TopicImg,HeadImg")->find($id);
        return $theme;
    }


}