<?php
/**
 * Created by PhpStorm.
 * User: cuixiaotu
 * Date: 2017/11/2
 * Time: 14:39
 */

namespace app\lib\exception;



class ParameterException extends BaseException
{
    //HTTP 状态码
    public $code = 400;
    //错误具体信息
    public $msg = '通用参数错误';

    public $errorCode = 10000;

}