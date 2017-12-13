<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/8
 * Time: 18:34
 */

namespace app\api\controller\v1;
use app\api\validate\IDCollection;
use app\api\validate\IDMustBePositiveInt;
use app\lib\exception\ThemeException;
use think\Controller;
use app\api\model\Theme as ThemeModel;
use think\Collection;

class Theme extends  Controller
{
    /*
     * @url /theme?ids=id1,id2,id3
     *
     */
    public function getSimpleList($ids=''){
        (new IDCollection())->goCheck();
        $ids = explode(',',$ids);
        $result = ThemeModel::with("TopicImg","HeadImg")->select($ids);
        if ($result->isEmpty()){
            throw  new  ThemeException(["msg"=>"找不到主题"]);
        }

        return $result;
    }

    /*
     *  @url /api/v1/theme/id
     *  @http GET
     *  @id   theme的id号
     * */
    public  function  getComplexOne($id){
        (new IDMustBePositiveInt())->goCheck();

        $result =  ThemeModel::getThemeWithProducts($id);
        if (!$result){
            throw  new ThemeException("未找到该主题ID下的商品，请检查ID");
        }
        return $result;
    }






}