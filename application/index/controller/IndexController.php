<?php
namespace app\index\controller;


use app\index\model\Article;
use app\index\model\Category_category;
use app\index\model\Comment;
use app\index\model\User;
use think\Session;

class IndexController extends BaseController
{
    //社区首页
    public function index()
    {
        $articles = Article::with('category,author')->paginate(10);
        $categories = Category_category::all(null, ['category']);
        $pageRender = $articles->render();
        $isLogin = Session::has("user");
        $this->assign("articles", $articles);
        $this->assign("categories", $categories);
        $this->assign('count', count($articles));
        $this->assign('pageRender', $pageRender);
        $this->assign("isLogin", $isLogin);
        return $this->fetch();
    }

    //用户详情页
    public function member($userName)
    {
        $user = User::get(['username' => $userName]);
        $author = $user{'id'};
        $articles = Article::all(['author' => $author], ['category', 'lastReply', 'author']);
        $comments = Comment::all(['user' => $author], 'article');
        //echo '<pre>';
        //print_r($comments);
        //echo '</pre>';
        $this->assign("user", $user);
        $this->assign("articles", $articles);
        $this->assign("comments", $comments);
        return $this->fetch();
    }

}

