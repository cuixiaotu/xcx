<?php
/**
 * Created by cuixiaotu.
 * User: cuixiaotu
 * Date: 2017/11/9
 * Time: 16:42
 */

namespace app\api\model;


class Category extends BaseModel
{
        protected $hidden = ['delete_time',"update_time"];
        public  function topicImg(){
             return  $this->belongsTo("Image","topic_img_id","id");
        }



}