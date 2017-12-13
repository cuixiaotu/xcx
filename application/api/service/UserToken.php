<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/10
 * Time: 11:33
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\TokenException;
use app\lib\exception\WeChatException;
use think\Exception;
use app\api\model\User as UserModel;

class UserToken extends Token
{
    protected $code;
    protected $wxAppID;
    protected $wxAppSecret;
    protected $loginUrl;

    public function __construct($code) {
        $this->code = $code;
        $this->wxAppID = config("wx.app_id");
        $this->wxAppSecret = config("wx.app_secert");
        $this->loginUrl = sprintf(config("wx.login_url"),$this->wxAppID,$this->wxAppSecret,$this->code);
    }

    public function get(){
        $result = curl_get($this->loginUrl);
        $wxResult = json_decode($result,true);
        if (empty($wxResult)){
            throw new  Exception("获取session_key和openid失败，微信内部错误");
        }
        else{
            $loginFail = array_key_exists("errcode",$wxResult);
            if ($loginFail){
                $this->processLoginFail($wxResult);
            }else{
              return  $this->grantToken($wxResult);
            }
        }

    }


    private  function  processLoginFail($wxResult){
        throw new WeChatException([
            "msg"=>$wxResult['errmsg'],
            "errorCode"=>$wxResult['errcode'],
            "code"=>400,
            ]);

    }

    private  function  grantToken($wxResult){
        //拿到openid
        //检查数据库是否存在
        //1.如果存在则不处理
        //2.如果存在则新增一条记录
        //生成令牌 准备缓存数据 写入缓存
        //将令牌返回到客户端去
        //key 令牌  value wxResult,uid,scope
        $openid = $wxResult["openid"];

        $user = UserModel::getByOpenID($openid);
        if ($user){
            $uid = $user->id;
        }else{
            $uid = $this->newUser($openid);
        }
        $cacheValue = $this->prepareCacheValue($wxResult,$uid);
        $value = $this->saveToCache($cacheValue);
        return $value;
    }

    private function saveToCache($cacheValue){
        $key = self::generateToken();
        $value = json_encode($cacheValue);
        $expire_in = config("setting.token_expire_in");
        $request = cache($key,$value,$expire_in);
        if (!$request){
            throw  new TokenException([
                "msg" => "服务器缓存出错",
                "errCode" => "10005"
            ]);
        }
        return $key;

    }

    private function prepareCacheValue($wxResult,$uid){
        $cacheValue = $wxResult;
        $cacheValue['uid'] = $uid;
        //scope 值
        $cacheValue['scope'] = ScopeEnum::User;
        //$cacheValue['scope'] = 12;
        return $cacheValue;
    }

    private function newUser($openid){
        $user = UserModel::create([
            "openid" => $openid,
        ]);
        return $user->id;
    }



}