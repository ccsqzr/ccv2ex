<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/3/5
 * Time: 12:29
 */

namespace app\index\model;


use think\Model;

class ArticleVisit extends Model
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