<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/9
 * Time: 11:00
 */

namespace app\lib\exception;


class ThemeException extends BaseException
{
    public $code = 404;
    public $errorCode = 30000;
    public $msg   = "未找到对应的主题,请检查主题ID";

}