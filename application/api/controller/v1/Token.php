<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/10
 * Time: 11:21
 */

namespace app\api\controller\v1;

use app\api\validate\TokenGet;
use think\Controller;
use app\api\service\UserToken;

class Token extends Controller
{
    public function getToken($code = ''){

        (new TokenGet())->goCheck();
        $ut =new UserToken($code);
        $token = $ut->get();
        return ["token" => $token ];
    }



}