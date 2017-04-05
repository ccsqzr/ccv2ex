<?php
/**
 * Created by PhpStorm.
 * User: weiyang
 * Date: 2017/3/29
 * Time: 16:42
 */

namespace app\index\controller;

use app\index\model\Collection;
use think\Db;
use think\Session;

class CollectionController extends BaseController
{
    public function nodes()
    {
        $user = Session::get('user')['id'];
        $categories = Db::table('cc_collection')->alias("c")
            ->field("c.node,ct.id as categoryId,ct.name")
            ->join("cc_category ct", "c.node=ct.id")
            ->where('c.user', '=', $user)
            ->select();
        $this->assign('categories', $categories);
        $this->assign('categoryCount', count($categories));
        return $this->fetch();
    }

    public function topics()
    {
        $user = Session::get('user')['id'];
        $articles = Db::table('cc_collection')->alias("c")
            ->field("c.node,c.article as articleId,c.userId,a.username,a.avatar,ct.name as categoryName,ct.id as categoryId,at.title as articleTitle,at.comment,cu.username as lastReplyUsername")
            ->join("cc_article at", "at.id = c.article")
            ->join("cc_user a", "a.id = at.author")
            ->join("cc_user cu", "cu.id = at.last_reply")
            ->join("cc_category ct", "ct.id = at.category")
            ->where('c.user', '=', $user)
            ->select();
        $this->assign('articles', $articles);
        $this->assign('articleCount', count($articles));
        // echo "<pre>";
        //print_r($articles)
        //echo "</pre>";
        return $this->fetch();

    }

    public function following()
    {
        $user = Session::get('user')['id'];
        $articles = Db::table('cc_collection')->alias("c")
            ->field("c.userId,a.username,a.avatar,ct.name as categoryName,ct.id as categoryId,at.title as articleTitle,at.comment,at.id as articleId,at.create_date,cu.username as lastReplyUsername")
            ->join("cc_article at", "at.author = c.userId")
            ->join("cc_user a", "a.id = at.author")
            ->join("cc_user cu", "cu.id = at.last_reply")
            ->join("cc_category ct", "ct.id = at.category")
            ->where('c.user', '=', $user)
            ->order("at.create_date desc")
            ->select();
        $this->assign('articles', $articles);
        $this->assign('articleCount', count($articles));
        return $this->fetch();

    }

    public function addSpecial()
    {
        $userId = $this->request->param("superId");
        $user = session::get("user")->id;
        $collection = new Collection();
        $collection->user = $user;
        $collection->userid = $userId;
        $collection->save();
        return ["status" => "success", "message" => "收藏成功"];

    }

    public function cancelSpecial()
    {
        $userId = $this->request->param("superId");
        $user = session::get("user")->id;
        $collection = Collection::get(["userid" => $userId, "user" => $user]);
        if (empty($collection)) {
            // 返回错误
            return ["status" => "error", "message" => "取消收藏失败,原因:未查询到收藏的内容"];
        }
        $collection->delete();
        // 返回成功
        return ["status" => "success", "message" => "取消收藏成功"];

    }

    public function addNode()
    {
        $node = $this->request->param("categoryId");
        $user = session::get("user")->id;
        $collection = new Collection();
        $collection->user = $user;
        $collection->node = $node;
        $collection->save();
        return ["status" => "success", "message" => "收藏成功"];

    }

    public function deleteNode()
    {
        $node = $this->request->param("categoryId");
        $user = session::get("user")->id;
        $collection = Collection::get(["node" => $node, "user" => $user]);
        if (empty($collection)) {
            // 返回错误
            return ["status" => "error", "message" => "取消收藏失败,原因:未查询到收藏的内容"];
        }
        $collection->delete();
        // 返回成功
        return ["status" => "success", "message" => "取消收藏成功"];
    }

    public function addArticle()
    {
        $article = $this->request->param("articleId");
        $user = session::get("user")->id;
        $collection = new Collection();
        $collection->user = $user;
        $collection->article = $article;
        $collection->save();
        return ["status" => "success", "message" => "收藏成功"];

    }

    public function deleteArticle()
    {
        $article = $this->request->param("articleId");
        $user = session::get("user")->id;
        $collection = Collection::get(["article" => $article, "user" => $user]);
        if (empty($collection)) {
            // 返回错误
            return ["status" => "error", "message" => "取消收藏失败,原因:未查询到收藏的内容"];
        }
        $collection->delete();
        // 返回成功
        return ["status" => "success", "message" => "取消收藏成功"];
    }


}