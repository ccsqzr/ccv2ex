<?php
namespace app\index\controller;

use app\index\model\Article;
use app\index\model\Category_category;
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

}

