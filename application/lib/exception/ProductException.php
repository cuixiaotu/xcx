<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/9
 * Time: 15:02
 */

namespace app\lib\exception;


class ProductException extends BaseException
{
    public $code = 404;
    public $errorCode = 20000;
    public $msg   = "指定的商品不存在";

}