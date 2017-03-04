<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/3/1
 * Time: 21:13
 */

namespace app\index\model;


use think\Model;

class Comment extends Model
{
    public function user()
    {
        return $this->belongsTo("User", "user");
    }

    public function article()
    {
        return $this->belongsTo("Article", "article");
    }
}