<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/14
 * Time: 11:25
 */

namespace app\lib\exception;


class UserException
{
    public $code = 401;
    public $errorCode = 60000;
    public $msg   = "用户不存在";


}