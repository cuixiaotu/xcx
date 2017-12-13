<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/10/30
 * Time: 11:36
 */
namespace app\api\controller\v1;
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
        //开闭原则  对于拓展是开发的  对于修改是封闭的
        /*AOP面对切面编程*/
        $validate = new IDMustBePositiveInt();
        $validate->goCheck();
        $banner = BannerModel::getBannerById($id);

        if (!$banner){
            throw new  BannerMissException(["msg"=>"找不到banner信息"]);
        }
        return $banner;
    }





}