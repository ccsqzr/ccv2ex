<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/3/1
 * Time: 20:48
 */

namespace app\index\controller;

use app\index\model\Article;
use app\index\model\Category;
use app\index\model\Collection;
use think\Session;

class CategoryController extends BaseController
{
    //通过分类名，获得该分类下的全部文章
    public function detail($categoryId)
    {
        $articles = Article::all(['category' => $categoryId], ['author', 'category']);
        $user = Session::get('user');
        $userId = $user['id'];
        $collections = Collection::all(['user' => $userId, 'node' => $categoryId]);
        $this->assign("isCollection", count($collections) > 0);
        $this->assign("articles", $articles);
        $this->assign('count', count($articles));
        $this->assign("category", Category::get($categoryId));
        //$this->assign("collections", $collections);
        return $this->fetch();
    }
}