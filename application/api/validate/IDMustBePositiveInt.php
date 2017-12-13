<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/10/31
 * Time: 10:12
 */

namespace app\api\validate;

class IDMustBePositiveInt extends  BaseValidate
{
    protected $rule =[
        'id' => 'require|isPositiveInteger',
    ];

    protected  $message= ["id"=>"id必须是正整数"];



}