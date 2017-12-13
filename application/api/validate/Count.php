<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/9
 * Time: 14:48
 */

namespace app\api\validate;


class Count extends BaseValidate
{
    protected $rule = ["count"=>"isPositiveInteger|between:1,15"];
    protected $message = [
        "count" =>"数量必须是在1到15之间的正整数"
    ];


}