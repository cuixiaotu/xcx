<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/13
 * Time: 14:07
 */

namespace app\api\model;


class ProductImage extends BaseModel
{
    protected $hidden = ["product_id","image_id","delete_time"];

    public function  imageUrl(){
        return $this->belongsTo("Image","img_id","id");
    }


}