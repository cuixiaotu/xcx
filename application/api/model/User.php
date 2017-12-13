<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/10
 * Time: 11:31
 */

namespace app\api\model;


class User extends BaseModel
{


    public static function  getByOpenID($openid){
        $user = self::where("openid","=",$openid)->find();
        return $user;
    }

    public function address(){
        return $this->hasOne("UserAddress","user_id","id");
    }



}