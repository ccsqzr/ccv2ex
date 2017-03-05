<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/3/5
 * Time: 23:32
 */

namespace app\index\controller;


use app\index\model\Article;
use app\index\model\Comment;
use app\index\model\User;
use Redis;
use think\Controller;

class BaseController extends Controller
{
    public function _initialize()
    {
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);

        if ($redis->hExists("statistics", "userCount")) {
            $this->assign("userCount", $redis->hGet("statistics", "userCount"));
        } else {
            $userCount = User::count();
            $this->assign("userCount", $userCount);
            $redis->hSet("statistics", "userCount", $userCount);
        }

        if ($redis->hExists("statistics", "commentCount")) {
            $this->assign("commentCount", $redis->hGet("statistics", "commentCount"));
        } else {
            $commentCount = Comment::count();
            $this->assign("commentCount", $commentCount);
            $redis->hSet("statistics", "commentCount", $commentCount);
        }

        if ($redis->hExists("statistics", "articleCount")) {
            $this->assign("articleCount", $redis->hGet("statistics", "articleCount"));
        } else {
            $articleCount = Article::count();
            $this->assign("articleCount", $articleCount);
            $redis->hSet("statistics", "articleCount", $articleCount);
        }
    }
}