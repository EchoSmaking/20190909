<?php
namespace Home\Controller;
use Think\Controller;
class AboutController extends Controller {
    public function index(){
		$this->display();
}
	public function about(){

		$this->display();
}
	public function contact(){

		$this->display();
}
	public function news(){
		
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count, 9);
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id desc') -> select();
		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		
		
		$news = $model -> where('store_cate=23 or store_cate=24') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id desc') -> select();
		$this -> assign('page',$page->show());
		$this->assign('news',$news);
		$this->assign('list',$list);
		$this->display();
		
	}
	
	public function advantage(){
		$this->display();
	}
	

}