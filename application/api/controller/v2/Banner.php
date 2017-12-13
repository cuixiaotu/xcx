<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/10/30
 * Time: 11:36
 */
namespace app\api\controller\v2;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\BannerMissException;
use think\Controller;
use app\api\model\Banner as BannerModel;

class Banner extends  Controller
{
    /*
     * 获取指定id下的banner图
     * @url  /banner/:id
     * @http GET
     * @id   banner的id号
     */
    public  function  getBanner($id){
     return "This is v2 version";
    }





}