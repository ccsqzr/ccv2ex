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

}