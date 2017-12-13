<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/10
 * Time: 16:10
 */

namespace app\api\service;


use app\lib\enum\ScopeEnum;
use app\lib\exception\ForbiddenException;
use app\lib\exception\TokenException;
use think\Cache;
use think\Exception;
use think\Request;

class Token
{
    //生成32位的Token
    /**
     * @return string
     */
    public static function generateToken(){
        $randChars = getRandChars(32);
        //用三组字符串  随机字符串 时间戳 盐  MD5加密
        $timestamp = $_SERVER["REQUEST_TIME_FLOAT"];
        $salt = config("secure.token_salt");
        return Md5($randChars.$timestamp.$salt);
    }

    /**
     * @param $key
     * @return mixed
     * @throws Exception
     * @throws TokenException
     */
    public static function getCurrentTokenVar($key){
        $token = Request::instance()->header("token");
        $vars  = Cache::get($token);
        if (!$vars){
            throw  new TokenException();
        }else{
            if (!is_array($vars)) {
                $vars = json_decode($vars, true);
            }
            if (array_key_exists($key,$vars)){
                return $vars[$key];

            }else{
                throw new Exception("尝试获取的Token变量不存在");
            }
        }
    }


    /**
     * @return mixed
     */
    public static function getCurrentUid(){
       // $uid = self::getCurrentUid('uid');
        $uid = self::getCurrentTokenVar('uid');
        return $uid;
    }

    /**
     *  用户和管理员都可以访问的权限
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static  function  needPrimaryScope(){
        $scope = self::getCurrentTokenVar("scope");
        if ($scope){
            if ($scope>=ScopeEnum::User){
                return true;
            }else{
                throw  new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }
    }

    /**
     *  只有用户才能访问的接口权限
     * @return bool
     * @throws ForbiddenException
     * @throws TokenException
     */
    public static function needExclusiveScope(){
        $scope = self::getCurrentTokenVar("scope");
        if ($scope){
            if ($scope==ScopeEnum::User){
                return true;
            }else{
                throw  new ForbiddenException();
            }
        }else{
            throw new TokenException();
        }

    }


    public static function isValidOperate($checkUID){
        if (!$checkUID){
            throw new Exception('检查用户的UID必须存在');
        }
        $currentOperateUID = self::getCurrentUid();
        if ($currentOperateUID == $checkUID){
            return true;
        }
        return false;
    }


}