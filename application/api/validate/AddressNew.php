<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/14
 * Time: 10:30
 */

namespace app\api\validate;


class AddressNew extends  BaseValidate
{
    protected $rule = [
        "name"   => "require|max:25|isNotEmpty",
        "mobile" => "require|isMobile",
        "province" => "require|isNotEmpty",
        "city"     => "require|isNotEmpty",
        "country"  => "require|isNotEmpty",
        "detail"   => "require|isNotEmpty"
    ];




}