<?php
/**
 * Created by PhpStorm.
 * User: cuixiaotu
 * Date: 2017/10/31
 * Time: 11:35
 */

namespace app\api\validate;
use app\lib\exception\BaseException;
use app\lib\exception\ParameterException;
use think\Validate;
use think\Request;

class BaseValidate extends  Validate
{
    public function  goCheck(){
        //获取http传入的参数
        //对这些参数做校验
        $request = Request::instance();
        $params  = $request ->param();

        $result  = $this->batch()->check($params);
        if (!$result){
            $e= new ParameterException([
                'msg' => $this->error,
                'code'=> 400,
                'errorCode' => 10002
            ]);
            throw $e;
        }else{
            return true;
        }
    }

    protected function isPositiveInteger($value,$rule='',$data='',$field=''){
        if ( is_numeric($value) && is_int($value+0) && ($value+0)>0){
            return true;
        }else{  //返回错误信息
            //return $field.'必须是正整数';
            return false;
        }
    }

    public function isNotEmpty($value,$rule='',$data='',$field=''){
        if (empty($value)){
            return false;
        }else{  //返回错误信息
            return true;
        }
    }


    protected function isMobile($value){
        $rule = "/^1(3|5|7|8|9)[0-9]\d{8}$/";
        if (preg_match($rule,$value)){
            return true;
        }else{
            return false;
        }

    }


    public function getDataByRule($arrays){
        if (array_key_exists("user_id",$arrays)|array_key_exists("uid",$arrays)){
            //不容许用户传入user_id 或uid
            throw new ParameterException(['msg'=>"参数中含有非法参数user_id或uid"]);
        }
        $newArray = [];
        foreach ($this->rule as $k=>$v){
            $newArray[$k] = $arrays[$k];
        }
        return $newArray;
    }


}