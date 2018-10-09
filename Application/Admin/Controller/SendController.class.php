<?php
namespace Admin\Controller;
use Think\Controller;
class SendController extends Controller {
    public function index(){
        $username = session('username');
        if($username == NULL){
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index">';
            die();
        }
        $this->display();
    }
    public function submit(){
        $username = session('username');
        if($username == NULL){
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index">';
            die();
        }
        $file_main_info;
        $date = date("Y-m-z");
        $upload = new \Think\Upload();// 实例化上传类
        $upload->maxSize   =     1024*1024*1024 ;// 设置附件上传大小
        $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg', 'ydk');// 设置附件上传类型
        $upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
        $upload->savePath  =     ''; // 设置附件上传（子）目录
        // 上传文件
        $info   =   $upload->upload();
        if(!$info) {// 上传错误提示错误信息

        }else{
            foreach($info as $file){
                $file_main_info = $file['savepath'].$file['savename'];
            }
        }

        if(I("post.bookname")==NULL || I("post.dec")==NULL){
            die();
        }else{
            $db_admin_delete = M("book_list");
            $data['title'] = I("post.bookname");
            $data['dec'] = I("post.dec");
            $data['url'] = I("post.url");
            $data['time'] = time();
            $data['img'] = $file_main_info;
            $db_admin_delete->data($data)->add();
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=manage">';
        }
    }
}