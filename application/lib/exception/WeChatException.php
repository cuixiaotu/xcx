<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/10
 * Time: 14:27
 */

namespace app\lib\exception;


class WeChatException extends BaseException
{
    public $code = 400;
    public $errorCode = 9999;
    public $msg   = "微信服务器接口调用异常";


}