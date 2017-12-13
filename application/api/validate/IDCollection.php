<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/8
 * Time: 19:05
 */

namespace app\api\validate;


class IDCollection extends BaseValidate
{

    protected $rule = ['ids'=>"require|checkIDs"];
    protected $message = [
        "ids" =>"IDs必须是以逗号分隔的正整数"
    ];

    public function checkIDs($value,$rule='',$data='',$field=''){
        $values = explode(",",$value);
        if (empty($values)){
            return false;
        }

        foreach ($values as $id){
            if (!$this->isPositiveInteger($id)){
                return false;
            }
        }
        return true;
    }


}