<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/15
 * Time: 20:12
 */

namespace app\api\service;


use app\api\model\OrderProduct;
use app\api\model\Product;
use app\api\model\UserAddress;
use app\lib\exception\OrderException;
use think\Db;
use think\Exception;

class Order
{
    //客户端传递过来的product参数
    protected $oProducts ;
    //真实的商品信息
    protected $products ;
    //获取uid
    protected $uid;

    public function place($uid,$oProducts){
    //oProduct 和 product
    //product 从商品中获取
    $this->uid = $uid;
    $this->products = $this->getProductsByOrder($oProducts);
    $this->oProducts = $oProducts;
    $status = $this->getOrderStatus();
    if ($status['pass'] == false){
        $status['order_id'] = -1;
        return $status;
    }
    //开始创建订单
    $orderSnap = $this->snapOrder($status);
    $order     = $this->creatOrder($orderSnap);
    $order['pass'] = true;
    return $order;

    }

    //生成订单快照
    protected function snapOrder($status){
       $snap = [
           "orderPrice" => 0,
           "totalCount" => 0,
           "pStatus"    => [],
           "snapAddress"=> "",
           "snapName"   => "",
           "snapImg"    => "",
       ];

       $snap["orderPrice"] = $status["orderPrice"];
       $snap["totalCount"] = $status["totalCount"];
       $snap["pStatus"]    = $status["pStatusArray"];
       $snap["snapAddress"]= json_encode($this->getUserAddress());
       $snap["snapName"]   = $this->products[0]['name'];
       $snap["snapImg"]    = $this->products[0]['main_img_url'];
       if (count($this->products)>1){
            $snap["snapName"] .= "等";
       }
       return $snap;
    }

    private function creatOrder($snap){
        Db::startTrans();
        try {
            $orderNo = $this->makeOrderNo();
            $order = new \app\api\model\Order();
            $order->user_id = $this->uid;
            $order->order_no = $orderNo;
            $order->total_price = $snap['orderPrice'];
            $order->total_count = $snap['totalCount'];
            $order->snap_img = $snap['snapImg'];
            $order->snap_address = $snap['snapAddress'];
            $order->snap_name = $snap['snapName'];
            $order->snap_items = json_encode($snap['pStatus']);
            $order->save();

            $orderID = $order->id;
            $create_time = $order->create_time;
            foreach ($this->oProducts as &$p) {
                $p['order_id'] = $orderID;
            }
            $orderProduct = new OrderProduct();
            $orderProduct->saveAll($this->oProducts);
            Db::commit();
            return [
                "order_no" => $orderNo,
                "order_id" => $orderID,
                "create_time" => $create_time,
            ];
        }catch (Exception $ex){
            Db::rollback();
            throw  $ex;
        }

    }

    public static function makeOrderNo(){
        $yCode = array("A","B","C","D","E","F","G","H","I","J");
        $orderSn = $yCode[intval(date("Y"))-2017].strtoupper(dechex(date("m"))).date("d").substr(time(),-5).substr(microtime(),2,5).sprintf('%02d',rand(0,99));
        return $orderSn;
    }


    private function getUserAddress(){
        $userAddress = UserAddress::where('user_id',"=",$this->uid)->find();
        if (!$userAddress){
            throw new UserException([
                "msg"       => "用户信息不存在",
                "errorCode" => 60001
            ]);
        }
        return $userAddress->toArray();
    }


    /*根据订单查找真实的订单信息*/
    private function getProductsByOrder($oProducts){
        $oPIDs = [];
        foreach ($oProducts as $item){
            array_push($oPIDs,$item["product_id"]);
        }
        $products = Product::all($oPIDs)->visible(["id","price","stock","name","main_img_url"])->toArray();
        return $products;
    }

    /*检查库存*/
    public function checkOrderStatus($orderID){
        $oProduct = OrderProduct::where("order_id","=",$orderID)->select();
        $this->oProducts = $oProduct;
        $this->products = $this->getProductsByOrder($oProduct);
        $status = $this->getOrderStatus();
        return $status;
    }

    private function getProductStatus($oPID,$oCount,$products){
        $pIndex = -1;
        $pStatus = [
            "id"         => null,
            "haveStock"  => false,
            "count"      => 0,
            "name"       => '',
            "totalPrice" => 0
        ];

        for ($i=0;$i<count($products);$i++){
            if($oPID == $products[$i]['id']){
                $pIndex = $i;
            }
        }
        if ($pIndex == -1){
            //客户端传来的商品product_id有可能不存在
            throw  new  OrderException(['msg'=>'id为'.$oPID.'商品不存在']);
        }else{
            $product = $products[$pIndex];
            $pStatus['id'] = $product['id'];
            $pStatus['name'] = $product['name'];
            $pStatus['count'] = $oCount;
            $pStatus['totalPrice'] = $product['price']*$oCount;

            if ($product['stock']-$oCount >0){
                $pStatus['haveStock']  = true;
            }
            return $pStatus;
        }

    }

    private function  getOrderStatus(){
        $status = [
            "pass" => true,
            "orderPrice" => 0,
            "pStatusArray" => [],
            "totalCount"   => 0,
            ];
        foreach ($this->oProducts as $oProduct){
            $pStatus = $this->getProductStatus($oProduct['product_id'],$oProduct['count'],$this->products);
            if (!$pStatus['haveStock']){
                $status['pass'] = false;
            }
            $status['orderPrice'] += $pStatus['totalPrice'];
            $status['totalCount'] += $pStatus['count'];
            array_push($status['pStatusArray'],$pStatus);
        }
        return $status;

    }

}