<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/3/1
 * Time: 20:48
 */

namespace app\index\controller;

use app\index\model\Article;
use app\index\model\Comment;
use think\Controller;
use think\Request;

class CommentController extends Controller
{
    //新增评论
    public function add(Request $request)
    {
        $articleId = $request->param('articleId');
        $content = $request->param('content');
        $currentNumber = Comment::where("article", $articleId)->max('number');
        $comment = new Comment();
        $comment->article = $articleId;
        $comment->content = $content;
        $comment->create_date = date('Y-m-d H:i:s',time());
        $comment->user = 1;
        $comment->number = $currentNumber + 1;
        $articleCommentNumber = Article::where("id", $articleId)->find()->comment;
        //新的评论存入到comment表中
        $comment->save();
        $newCommentNumber=$articleCommentNumber+1;
        Article::where("id",$articleId)
            ->update(['comment'=>"$newCommentNumber"]);
        $this->redirect('/t/'.$articleId);
    }

}