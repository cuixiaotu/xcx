<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/14
 * Time: 10:16
 */

namespace app\api\controller\v1;


use app\api\model\User;
use app\api\validate\AddressNew;
use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use app\api\service\Token;
use app\lib\exception\SuccessMessage;
use think\Exception;

class Address extends BaseController
{
    protected $beforeActionList = [
        "checkPrimaryScope" =>["only" =>"createOrUpdateAddress"]
    ];

    public function createOrUpdateAddress(){

        $validate = new AddressNew();
        $validate->goCheck();
        //根据token获取用户的Uid
        //查找用户信息 未找到则抛出异常
        //获取用户从客户端的地址信息
        //根据用户地址是否存在来判断 增加地址或修改地址
        $uid = Token::getCurrentUid();
        $user = User::get($uid);

        if (!$user){
            throw new Exception("wrong");
        }

        $dataArray = $validate->getDataByRule(input("post."));


        $userAddress = $user->address;

        if (!$userAddress){
            //新增地址
            $user->address()->save($dataArray);
        }else{
            $user->address->save($dataArray);
        }
        //return $user;
        throw new SuccessMessage();
    }


}