<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/20
 * Time: 18:45
 */

namespace app\api\controller\v1;



use app\api\service\WxNotify;
use app\api\validate\IDMustBePositiveInt;
use app\api\service\Pay as PayService;

class Pay extends BaseController
{

    protected $beforeActionList = [
        "checkExclusiveScope" =>["only"=>"getPreOrder"]
    ];


    public function getPreOrder($id=''){
        (new IDMustBePositiveInt())->goCheck();
        $pay = new PayService($id);
        return $pay->pay();
    }

    public function receiveNotify(){
        //通知频率 15/15/30/180/1800/1800/1800/1800/3600,单位：秒
        //1.检查库存量  商品超卖
        //2.更新订单状态status
        //3.减去库存量
        //4.如果成功处理 返回微信成功处理的消息 否则 则返回没有成功处理

        //特点  POST  参数为XML格式   不能携带 问号后的参数
        $notify = new WxNotify();
        $notify->Handle();

    }

}