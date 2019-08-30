<?php
namespace Admin\Controller;
use Think\Controller;
class PaperController extends AdminController {
    // 文章列表
	public function index(){
		$model = M('paper');
		$count = $model -> where($where) -> count();
		$page = new \Think\Page($count, 25);

		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id desc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}
	

	// 编辑、添加文章
	public function edit(){
		if(IS_POST){
			// 判断分类是否可用
			if(!empty($_POST['cate_id'])){
				$find = M('product_cate') -> where(array('id' => intval($_POST['cate_id']))) -> find();
				if(!$find){
					$this -> error('请选择正确的分类');
				}
			}
			// 判断商城分类是否可用
			// 修改
			if(isset($_GET['id'])){
				$rs = M('paper') -> where('id='.intval($_GET['id'])) -> save($_POST);
				$product_id = intval($_GET['id']);
			}
			// 添加
			else{
				$_POST['create_time'] = NOW_TIME;
				$rs = M('paper') -> add($_POST);
				$product_id = $rs;
			}
		}
		
		if(!empty($_GET['id'])){
			$where = array();
			$info = M('paper') -> find($_GET['id']);
			if(!$info){
				$this -> error('没有这个商品');
			}
		}
		// 查询商城的分类
		$store_cates = M('product_cate') -> where(array('admin_id' => 0)) -> select();
		$this -> assign('store_cates',$store_cates);

		$this -> assign('info', $info);
		$this -> display();
	} 
	
	
	// 根据分类获得子分类
	public function get_child_cates(){
		$pid = intval($_REQUEST['id']);
		$cates = M('product_cate') -> where(array('pid' => $pid)) -> select();
		$data = array();
		foreach($cates as $cate){
			$data[$cate['id']] = array('name' => $cate['name']);
		}
		$this -> ajaxReturn($data);
	}
	
	public function set_value(){
		$where = array('id' => intval($_GET['id']));
		M('product') -> where($where) -> setField($_GET['field'],$_GET['value']);
		$this -> success('操作成功!',$_SERVER['HTTP_REFERER']);
	}
	
	// 根据attr_table格式化数据
	private function format($attr_table){
		if(!is_array($attr_table)){
			$attr_table = unserialize($attr_table);
		}
		// 属性种类数
		$attr_count = count($attr_table['attr']) / count($attr_table['stock']);
		// 最后的结果
		$rows = array();
		foreach($attr_table['stock'] as $key => $val){
			$attr_tmp = array();
			for($i=0; $i<$attr_count;$i++){
				$attr_tmp[] = $attr_table['attr'][$key*$attr_count+$i];
			}
			$rows[] = array(
				'attr' => implode(',', $attr_tmp),
				'stock' => $attr_table['stock'][$key],
				'code' => $attr_table['code'][$key]
			);
		}
		return $rows;
	}
	// 删除商品
	public function del(){
		$where['id'] = intval($_GET['id']);
		M('paper')->where($where)->delete();
		$this -> success('操作成功！', $_SERVER['HTTP_REFERER']);
	}
	
	
	/***以下是分类管理***/
	
	// 列表
	public function cate(){
		if($_GET['pid']){
			$where['pid'] = intval($_GET['pid']);
		}
		else{
			$where['pid'] = 0;
		}
		$list = M('product_cate') -> order('sort desc') -> where($where) -> select();
		$this -> assign('list', $list);
		$this -> display();
	}
	
	// 编辑
	public function cate_edit(){
		if($_GET['pid']){
			// 检查pid是否有效
			$where = array('id' => intval($_GET['pid']));
			$find = M('product_cate') -> where($where) -> find();
			if(!$find){
				$this -> error('访问错误');
			}
		}
		if(IS_POST){
			// id,mch_id不能修改
			unset($_POST['id']);
			unset($_POST['mch_id']);
			
			// 添加
			if(!$_GET['id']){
				$_POST['pid'] = $_GET['pid'];
				if(!IS_ADMIN){
					$_POST['mch_id'] = session('mch.id');
				}
			}
			// 修改
			else{
				unset($_POST['pid']);
			}
		}
		$this -> _edit('product_cate',U('cate?pid='.$_GET['pid']));
	}
	
	// 删除
	public function cate_del(){
		$this -> _del('product_cate', $_GET['id']);
		$this -> success('操作成功！', U('cate'));
	}
}