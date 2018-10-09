<?php
namespace Home\Controller;
use Think\Controller;
class ArticleController extends Controller {
    public function index(){
        $id = I("get.id");
        if($id == NULL){
            $id = 1;
        }
        if($id < 1){
            $id = 1;
        }

        $db_art = M("book_list");
        $data_art = $db_art->where("`id`=".$id." AND `status`=0")->find();

        $this->assign("article_data",$data_art);
        $this->display();
    }
}
