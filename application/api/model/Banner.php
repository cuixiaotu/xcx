<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/10/31
 * Time: 16:09
 */

namespace app\api\model;

class Banner extends BaseModel
{
    protected $hidden=["update_time","delete_time"];


    public function items(){
      return  $this->hasMany("BannerItem","banner_id","id");
    }
    /*
     * 通过指定Id获取banner信息
     * @url banner/:id
     * @http get
     * @id banner的id号
     */
    public static function  getBannerById($id){
    /*   $res = Db::query("select * from banner_item where banner_id ={$id}");
         $res = Db::table("banner_item")->where("banner_id","eq",$id)->select();
         $res = Db::table("banner_item")->where(function ($query) use ($id){ $query->where("banner_id","=",$id);})->select();
         return json($res);
    */
         return self::with(['items','items.img'])->find($id);
    }



}