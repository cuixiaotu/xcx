<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/27
 * Time: 11:25
 */

namespace app\api\validate;


class PagingParamter extends BaseValidate
{
    protected $rule = [
        'page'  => 'isPositiveInteger',
        'size'  => 'isPositiveInteger'
    ];

    protected $message = [
        'page'  => '分页参数必须为正整数',
        'size'  => '分页参数必须为正整数'
    ];


}