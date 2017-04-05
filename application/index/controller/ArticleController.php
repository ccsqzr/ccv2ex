<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/3/1
 * Time: 20:48
 */

namespace app\index\controller;

use app\index\model\Article;
use app\index\model\ArticleVisit;
use app\index\model\Category;
use app\index\model\Collection;
use app\index\model\Comment;
use Redis;
use think\Session;

class ArticleController extends BaseController
{
    //通过文章ID，获取该ID下的文章详情
    public function detail($articleId)
    {
        $article = Article::get($articleId, ['category', 'author']);
        if (Session::has("user")) {
            $visitCount = ArticleVisit::where(["user" => Session::get("user")->id, "article" => $articleId])->count();
            if ($visitCount < 1) {
                // 此人没访问过
                Article::update(['visit' => $article->visit + 1], ["id" => $articleId]);
                $articleVisit = new ArticleVisit();
                $articleVisit->user = Session::get("user")->id;
                $articleVisit->article = $articleId;
                $articleVisit->date = date('Y-m-d H:i:s', time());
                $articleVisit->save();
            }
        }
        $comments = Comment::all(['article' => $articleId], ['user']);
        $user = Session::get('user');
        $userId = $user['id'];
        $collection = Collection::all(['user' => $userId, 'article' => $articleId]);
        $collections = Collection::all(['article' => $articleId]);
        $this->assign("collectionCount", count($collections));
        $this->assign("isCollection", count($collection) > 0);
        $this->assign("article", $article);
        $this->assign("comments", $comments);


        return $this->fetch();
    }

    /**
     * @return mixed
     * 新增文章界面
     */
    public function addNew()
    {
        $categories = Category::all();
        $this->assign('categories', $categories);
        return $this->fetch();
    }

    /**
     * 执行新增文章操作
     */
    public function doAdd()
    {
        $title = $this->request->param("title");
        $content = $this->request->param("content");
        $category = $this->request->param("category");
        $authorId = session::get("user")->id;
        if ($title == null) {
            $this->error("请输标题", "/addNew");
        }
        if ($content == null) {
            $this->error("请输入内容", "/addNew");
        }
        if ($category == null) {
            $this->error("请选择分类", "/addNew");
        }
        $article = new Article();
        $article->create_date = date('Y-m-d H:i:s', time());
        $article->visit = 0;
        $article->comment = 0;
        $article->title = $title;
        $article->content = $content;
        $article->category = $category;
        $article->author = $authorId;
        $article->save();
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->hDel("statistics","articleCount");
        $this->success("新增成功", "/");
    }
}