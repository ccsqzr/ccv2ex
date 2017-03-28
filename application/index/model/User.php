<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/2/27
 * Time: 21:31
 */

namespace app\index\model;


use think\Model;

class User extends Model
{
    public function articles()
    {
        return $this->hasMany("Article", "author", "id");
    }

    public function comments()
    {
        return $this->hasMany("Comment", "user", "id");
    }
}