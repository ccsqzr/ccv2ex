<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/2/27
 * Time: 21:57
 */

namespace app\index\model;


use think\Model;

class Article extends Model
{
    public function category()
    {
        return $this->belongsTo('Category','category');
    }
    public function author()
    {
        return $this->belongsTo('User','author');
    }
}