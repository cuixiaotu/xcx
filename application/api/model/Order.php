<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/16
 * Time: 18:48
 */

namespace app\api\model;



class Order extends BaseModel
{
    protected $hidden=["user_id","update_time","delete_time"];
    protected $autoWriteTimestamp=true;

    public static function getSummaryByUser($uid,$page=1,$size=15){
        $pageDate = self::where('user_id','=',$uid)->order('create_time desc')->paginate($size,true,['page' => $page]);
        return $pageDate;
    }

    public function getSnapItemsAttr($value){
        if (empty($value)){
            return null;
        }
        return json_decode($value);
    }

    public function  getSnapAddressAttr($value){
        if (empty($value)){
            return null;
        }
        return json_decode($value);
    }


}