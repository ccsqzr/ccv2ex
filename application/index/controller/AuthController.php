<?php
/**
 * Created by PhpStorm.
 * User: sqzr
 * Date: 2017/3/2
 * Time: 21:51
 */

namespace app\index\controller;


use app\index\model\User;
use Redis;
use think\Session;

class AuthController extends BaseController
{
    /**
     * 解析登录界面
     */
    public function signin()
    {
        return $this->fetch();
    }

    /**
     * 请求尝试登录
     */
    public function doSignin()
    {
        $email = $this->request->param("email");
        $password = $this->request->param("password");
        $user = User::get(["email" => $email]);
        if ($user == null) {
            $this->error("邮箱不存在", "/signin");
        }
        $userPassword = $user->password;
        if ($userPassword != $password) {
            $this->error("密码错误", "/signin");
        }
        Session::set("user", $user);
        $this->success("登录成功", "/");
    }

    /**
     * 退出登录
     */
    public function dropOut()
    {

        Session::delete('user');
        $this->success("已退出", "/");
    }

    /**
     * 用户注册页面
     */
    public function signUp()
    {
        return $this->fetch();
    }

    /**
     * 注册提交
     */
    public function doSignUp()
    {
        $username = $this->request->param("username");
        $email = $this->request->param("email");
        $password = $this->request->param("password");

        if ($username == null) {
            $this->error("请输入用户名", "/signUp");
        } elseif (User::where('username', '=', $username)->count() > 0) {
            $this->error("用户名已被注册", "/signUp");
        }
        if ($password == null) {
            $this->error("请输入密码", "/signUp");
        }
        if ($email == null) {
            $this->error("请输入邮箱地址", "/signUp");
        } elseif (User::where('email', '=', $email)->count() > 0) {
            $this->error("邮箱已被注册", "/signUp");
        }

        $user = new User();
        $user->reg_date = date('Y-m-d H:i:s', time());
        $user->avatar = "//v2ex.assets.uxengine.net/gravatar/c4dbc6d6d23b7fa2874387d14a65a4f0?s=48&d=retro";
        $user->username = $username;
        $user->email = $email;
        $user->password = $password;
        $user->save();
        Session::set("user", $user);
        $redis = new Redis();
        $redis->connect('127.0.0.1', 6379);
        $redis->hDel("statistics", "userCount");
        $this->success("注册成功", "/");
    }
}