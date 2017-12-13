<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/16
 * Time: 15:09
 */

namespace app\lib\exception;


class OrderException extends BaseException
{
    //HTTP 状态码
    public $code = 403;
    //错误具体信息
    public $msg = '订单错误';
    public $errorCode = 80000;


}