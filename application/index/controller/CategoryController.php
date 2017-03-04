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
use think\Controller;

class CategoryController extends Controller
{
    //通过分类名，获得该分类下的全部文章
    public function detail($categoryId)
    {
        $articles = Article::all(['category'=>$categoryId],['author', 'category']);
        $this->assign("articles", $articles);

        $this->assign('count', count($articles));
        $this->assign("category", Category::get($categoryId));

      return $this->fetch();
    }
}