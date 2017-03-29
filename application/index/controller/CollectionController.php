<?php
/**
 * Created by PhpStorm.
 * User: weiyang
 * Date: 2017/3/29
 * Time: 16:42
 */

namespace app\index\controller;

use app\index\model\Collection;
use think\Session;

class CollectionController extends BaseController
{
    public function nodes()
    {
        $collections = Collection::all(['user' => Session::get('user')['id']], ['category']);
        $this->assign('collections', $collections);
        $this->assign('collectionCount', count($collections));
        return $this->fetch();
    }
}