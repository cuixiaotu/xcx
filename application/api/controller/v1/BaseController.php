<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/15
 * Time: 19:10
 */

namespace app\api\controller\v1;


use think\Controller;
use app\api\service\Token;

class BaseController extends Controller
{

    protected function checkPrimaryScope(){
       Token::needPrimaryScope();
    }

    protected function checkExclusiveScope(){
        Token::needExclusiveScope();
    }

}