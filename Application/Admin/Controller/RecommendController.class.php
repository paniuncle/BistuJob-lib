<?php
namespace Admin\Controller;
use Think\Controller;
class RecommendController extends Controller {
    public function index(){
        $username = session('username');
        if($username == NULL){
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index">';
            die();
        }
        $page = I("get.page"); //获取page
        // 对page合法性进行判断
        if($page == 0){
            $page = 1; //如果page=0 -》 令page = 1
        }
        if($page < 1){
            $page = 1;
        }
        $db_index_booklist = M('book_list');

        //先计算出一共有多少页
        $data_index_allnum = $db_index_booklist->where("`status` = 0")->order("time desc")->count();
        $data_index_allpage = ceil($data_index_allnum / 8 );

        if($data_index_allpage == 0 || $data_index_allpage == 1){
            //如果数据不满足1页
            $data_index_allpage = 1;
        }

        //对翻页按钮进行控制
        if($page == 1) {
            $ctrl_up_button = 'disabled';
        }
        if($page == $data_index_allpage){
            $ctrl_down_button = 'disabled';
        }

        //计算上一页数和下一页数
        $data_index_up_num = $page - 1;
        $data_index_down_num = $page + 1;

        //对上下页数据进行合法性判断
        if($data_index_up_num < 1){
            $data_index_up_num = 1;
        }

        if($data_index_down_num > $data_index_allpage){
            $data_index_down_num = $data_index_allpage;
        }





        $data_index_booklist = $db_index_booklist->where("`status` = 0")->page($page,8)->order("time DESC")->select();
        $this->assign("book_list",$data_index_booklist); //将列表数据输出
        $this->assign("page_all",$data_index_allpage); //将总页数输出
        $this->assign("page_now",$page); //将当前页数输出
        $this->assign("index_up_page",$data_index_up_num); //将上页页数输出
        $this->assign("index_down_page",$data_index_down_num); //将下页页数输出
        $this->assign("ctrl_up_button",$ctrl_up_button); //按钮状态输出
        $this->assign("ctrl_down_button",$ctrl_down_button);


        //Recommend设置
        $db_recommend = M("recommend");
        $data_recommend = $db_recommend->where("`status` = 0")->order("time desc")->select();
        $this->assign("data_rec",$data_recommend);


        $this->display();
    }
    public function recommend(){
        $username = session('username');
        if($username == NULL){
            echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=index">';
            die();
        }
        $id = I("get.id");
        $this->assign("id",$id);
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


        $db_admin_delete = M("recommend");
        $data['book_id'] = I("post.bookid");
        $data['status'] = 0;
        $data['time'] = time();
        $data['img'] = $file_main_info;

        $db_admin_delete->data($data)->add();
        echo '<meta http-equiv="refresh" content="0;url=./admin.php?c=recommend">';
    }
 /*   public function recommend(){

    }*/
}
