<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/9
 * Time: 11:16
 */

namespace app\api\controller\v1;
use app\api\validate\Count;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ProductException;
use think\Controller;
use app\api\model\Product as ProductModel;

class Product extends Controller
{

    /*
     *  @url   /api/v1/product/recent?count=$count
     *  @http  GET
     *  @count 最近新品数量（1到15）
     */
    public function  getRecent($count = 15){

        (new Count())->goCheck();
        $recentProducts = ProductModel::getMostRecent($count);
        if ($recentProducts->isEmpty()){
            throw new ProductException("wrong");
        }
        $recentProducts = $recentProducts->hidden(["summary"]);
        return  $recentProducts;
    }


    /*
     *  @url   /api/v1/category_id/id
     *  @http  GET
     *  @id    货号ID
     */
    public function  getAllInCategory($id){
        (new IDMustBePositiveInt())->goCheck();
        $result = ProductModel::getProductsByCategoryID($id);
        if ($result->isEmpty()){
            throw  new ProductException();
        }
        return $result;
    }

    /*
     *  @url   /api/v1/product/id
     *  @http  GET
     *  @id  货号ID
     */
    public function  getOne($id){
        (new IDMustBePositiveInt())->goCheck();
       // $product  = ProductModel::getProductsByCategoryID($id);
        $detail   = ProductModel::getProductDetail($id);

        if (!$detail){
            throw  new ProductException();
        }
        return $detail;
    }

    /*
      *  @url   /api/v1/product/id
      *  @http  DELETE
      *  @c
      */
    public function  deleteOne($id){
        (new IDMustBePositiveInt())->goCheck();
        // $product  = ProductModel::getProductsByCategoryID($id);
        $detail   = ProductModel::getProductDetail($id);

        if (!$detail){
            throw  new ProductException();
        }
        return $detail;
    }




}