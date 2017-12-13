<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/9
 * Time: 16:42
 */

namespace app\api\controller\v1;


use app\lib\exception\CategoryException;
use think\Controller;
use app\api\model\Category as CategoryModel;

class Category extends Controller
{

    public function  getAllCategories(){

        $categories = CategoryModel::all([],"topicImg");
        if ($categories->isEmpty()){
            throw new CategoryException();
        }
        return $categories;
    }




}