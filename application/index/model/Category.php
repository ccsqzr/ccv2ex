<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/2/27
 * Time: 21:57
 */

namespace app\index\model;


use think\Model;

class Category extends Model
{
    public function articles()
    {
        return $this->hasMany("Article", "category", "id");
    }
}