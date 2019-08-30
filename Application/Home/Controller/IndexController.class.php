<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
		$model = M('paper');
		$count = $model -> where($where) -> count();
		$page = new \Think\Page($count, 9);

		$list = $model -> where('store_cate=2') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id desc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		
		//公司新闻分类24
		$data2 = $model -> where('store_cate=24') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id desc') -> select();
		foreach($data2 as $k=>$v){
			$data2[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//行业新闻分类 23
		$news = $model -> where('store_cate=23') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id desc') -> select();
		foreach($data2 as $k=>$v){
			$data2[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		
		
		
		$wher['store_cate'] = array(array('EGT',"5"),array('ELT',"9"),"AND");
		$lis = $model -> where($wher) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id desc') -> select();

		foreach($lis as $k=>$v){
			$lis[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		$this -> assign('page',$page->show());
		$this->assign('news',$news);
		$this->assign('list',$list);
		$this->assign('data2',$data2);
		$this->assign('lis',$lis);
		$this->display();
	}
}