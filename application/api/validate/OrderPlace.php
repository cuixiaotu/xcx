<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/15
 * Time: 19:36
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;

class OrderPlace extends BaseValidate
{
    protected $product = [
        ['product_id' =>1,'count'=>3],
        ['product_id' =>2,'count'=>3],
        ['product_id' =>3,'count'=>3],
    ];
    protected $rule = [
        "product" => "checkProducts"
    ] ;
    protected $singleRule = [
        "product" => "require|isPositiveInteger",
        "count"   => "require|isPositiveInteger",
    ];
    protected function checkProducts($values){
        if (!is_array($values)){
            throw new ParameterException(["msg"=>"商品不为数组"]);
        }
        if (empty($values)){
            throw new ParameterException(["msg"=>"商品列表不能为空"]);
        }

        foreach ($values as $value){
            $this->checkProduct($value);
        }
        return true;
    }


    protected function checkProduct($value){
         $validate = new BaseValidate($this->singleRule);
         $result   = $validate->check($value);
         if (!$result){
             throw  new ParameterException(["msg"=>"商品信息错误"]);
         }
    }




}