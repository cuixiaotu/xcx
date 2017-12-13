<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/15
 * Time: 15:23
 */

namespace app\lib\exception;


class ForbiddenException extends  BaseException
{
    //HTTP 状态码
    public $code = 403;
    //错误具体信息
    public $msg = '权限不够';
    public $errorCode = 10001;

}