<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    't/:articleId' => 'index/article/detail',
    'go/:categoryId' => 'index/category/detail',
    'comment/add' => 'index/comment/add',
    'signin' => 'index/auth/signin',
    'doSignin' => 'index/auth/doSignin',
    'dropOut' => 'index/auth/dropOut',
    'signUp' => 'index/auth/signUp',
    'doSignUp' => 'index/auth/doSignUp',
    'addNew' => 'index/article/addNew',
    'doAdd' => 'index/article/doAdd',
    'member/:userName' => 'index/index/member'
];
