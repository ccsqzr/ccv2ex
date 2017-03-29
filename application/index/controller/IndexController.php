<?php
namespace app\index\controller;


use app\index\model\Article;
use app\index\model\Category_category;
use app\index\model\User;
use think\Db;
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
        $articles = Article::all(['author' => $author], ['category', 'author']);
        $comments = Db::table('cc_comment')->alias("c")
            ->field("c.content,c.id,c.create_date,a.username,ct.name as categoryName,ct.id as categoryId,at.title as articleTitle")
            ->join("cc_article at", "at.id = c.article")
            ->join("cc_user a", "a.id = at.author")
            ->join("cc_category ct", "ct.id = at.category")
            ->where('c.user', '=', $author)
            ->select();
        $this->assign("user", $user);
        $this->assign("articles", $articles);
        $this->assign("comments", $comments);
        return $this->fetch();
    }

}

