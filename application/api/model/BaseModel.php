<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/8
 * Time: 17:18
 */

namespace app\api\model;
use think\Model;

class BaseModel extends  Model
{

    protected function  prefixImgUrl($value,$data){
        $finalUrl = $value;
        if($data['from'] == 1) {
            $finalUrl = config("setting.img_prefix") . $value;
        }
        return $finalUrl;
    }



}