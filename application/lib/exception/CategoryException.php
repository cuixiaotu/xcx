<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/9
 * Time: 17:17
 */

namespace app\lib\exception;


class CategoryException extends BaseException
{
    //HTTP 状态码
    public $code = 404;
    //错误具体信息
    public $msg = '指定类别不存在，请检查参数';
    public $errorCode = 50000;

}