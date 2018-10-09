<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        $username_a = session('username');
        if($username_a != NULL){
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index&a=speed">';
            die();
        }
        $this->display();
    }
    public function speed(){
        $username = session('username');
        if($username == NULL){
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index">';
            die();
        }
        $this->display();
    }
    public function dologin(){
        $username_a = session('username');
        if($username_a != NULL){
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index&a=speed">';
            die();
        }

        $username = I("post.username");
        $pwd = I("post.pwd");

        if($username == NULL || $pwd == NULL){
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index">';
            die();
        }

        $pwd = md5($pwd);
        $db_admin_list = M("admin_list");
        $data_list = $db_admin_list->where("`username` = '".$username."' AND `pwd` = '".$pwd."' AND `status`=0")->find();
        if($data_list['username'] == $username){
            session('username',$username);
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index&a=speed">';
        }else{
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index">';
            die();
        }
    }
}