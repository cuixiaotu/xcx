<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/10
 * Time: 11:23
 */

namespace app\api\validate;


class TokenGet extends BaseValidate
{
    protected $rule = ['code'=>"require|isNotEmpty"];

    protected $message = [
        "code" =>"没有code还想获取code,活在梦里吧"
    ];


}