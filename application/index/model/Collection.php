<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/2/27
 * Time: 21:57
 */

namespace app\index\model;


use think\Model;

class Collection extends Model
{
    public function category()
    {
        return $this->belongsTo('Category', 'node');
    }

    public function article()
    {
        return $this->belongsTo('Article', 'article');
    }

    public function user()
    {
        return $this->belongsTo('User', 'userId');
    }

}