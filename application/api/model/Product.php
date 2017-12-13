<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/8
 * Time: 18:35
 */

namespace app\api\model;


class Product extends BaseModel
{
    protected $hidden=["delete_time","create_time","update_time","pivot","from","img_id","category_id"];

    public function imgs(){
       return $this->hasMany("ProductImage","product_id","id");
    }

    public function properties(){
       return $this->hasMany("ProductProperty","product_id","id");
    }

    public function getMainImgUrlAttr($value,$data) {
        return $this->prefixImgUrl($value,$data);
    }

    public static function  getMostRecent($count){
        $products = self::limit($count)->order('create_time',"desc")->select();
        return $products;

    }

    public static function getProductsByCategoryID($id){
        $products = self::where('category_id',"=",$id)->select();
        return $products;
    }

    public static function getProductDetail($id){
        $detail = self::with( ["imgs" => function($query){$query->with("imageUrl")->order("order"," asc");}])->with(["properties"])->find($id);
        return $detail;
    }




}