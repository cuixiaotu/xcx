<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/10
 * Time: 17:34
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $code = 401;
    public $errorCode = 10001;
    public $msg   = "Token无效或过期";


}