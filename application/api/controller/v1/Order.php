<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/15
 * Time: 15:42
 */

namespace app\api\controller\v1;



use app\api\validate\IDMustBePositiveInt;
use app\api\validate\OrderPlace;
use app\api\service\Order as OrderService;
use app\api\validate\PagingParamter;
use app\api\model\Order as OrderModel;
use app\api\service\Token;
use app\lib\exception\OrderException;

class Order extends BaseController
{
    //用户提交商品后  向Api提供包含他所选择的商品的相关信息
    //API在接受信息后 检查订单相关商品的库存量
    //客户端的信息和服务器的信息不一定是同步的
    //有库存 则订单数据存入数据库中（下单成功）  返回客户端 可以支付
    //调用支付接口 可以支付了
    //还需要再次检查库存量
    //服务器这边调用支付接口进行微信支付
    //小程序根据服务器结果拉起微信支付
    //微信返回一个支付结果
    //成功 也进行库存量检查  支付有延迟
    //成功 进行库存量的减少   失败 返回一个支付失败的结果
    protected $beforeActionList = [
        "checkExclusiveScope" =>["only"=>"placeOrder"],
        "checkPrimaryScope"   =>["only"=>"getDetail,getSummaryByUser"]
    ];

    public function placeOrder(){
        (new OrderPlace())->goCheck();

        $product = input("post.products/a");
        $uid = \app\api\service\Token::getCurrentUid();
        $order =  new OrderService();
        $status = $order->place($uid,$product);
        return $status;
    }


    /*
     *    @url    api/v1/order/by_user?page=1&size=2
     *    @param  $page   当前页码
     *    @param  $size   页面数据
     *    @http   post
     *
     */


    public function  getSummaryByUser($page=1,$size=15){
         (new PagingParamter())->goCheck();
         $uid = Token::getCurrentUid();
         $pagingData =  OrderModel::getSummaryByUser($uid,$page,$size);
         if ($pagingData->isEmpty()){
            return ['data'=>[],'current_page'=>$pagingData->getCurrentPage(), ];
         }
         $data = $pagingData->hidden(['snap_items','snap_address','prepay_id'])->toArray();
        return ['data'=>$data,'current_page'=>$pagingData->getCurrentPage(), ];
    }

    public function getDetail($id){
        (new IDMustBePositiveInt())->goCheck();
        $orderDetail = OrderModel::get($id);
        if (!$orderDetail){
            throw  new OrderException();
        }
        return $orderDetail->hidden(['prepay_id']);
    }


}