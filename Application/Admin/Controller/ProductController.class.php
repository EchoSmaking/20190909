<?php
namespace Admin\Controller;
use Think\Controller;
class ProductController extends AdminController {
    // 商品列表
	public function index(){
		$model = M('product');
		$count = $model -> where($where) -> count();
		$page = new \Think\Page($count, 25);
		if(!$order){
			$order = "sort desc";
		}
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order($order) -> select();
		foreach($list as $k=>$v){
			$list[$k]['price'] = unserialize($v['price']);
			$list[$k]['stocktotal'] = M('user_stock')->where(array('product_id'=>$v['id']))->sum('stock');
		}
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
		
	}
	
	//用户库存
	public function userStock(){
		$where['product_id'] = I('get.id');
		$model = M('user_stock');
		$count = $model  -> where($where)->count();
		$page = new \Think\Page($count, 25);
		$list = $model ->where($where)->limit($page -> firstRow . ',' . $page -> listRows ) -> order($order) -> select();
		foreach($list as $k=>$v){
			$list[$k]['title'] = M('product')->where(array('product_id'=>$v['id']))->getField('title');
			$list[$k]['nickname'] = M('user')->where(array('id'=>$v['user_id']))->getField('nickname');
		}
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}
	
	// 编辑、添加商品
	public function edit(){
		if(IS_POST){
			
			//var_dump($_POST);
			//exit;
			// 判断分类是否可用
			if(!empty($_POST['cate_id'])){
				$find = M('product_cate') -> where(array('id' => intval($_POST['cate_id']))) -> find();
				if(!$find){
					$this -> error('请选择正确的分类');
				}
			}
			
			// 判断商城分类是否可用
			if(!empty($_POST['store_cate'])){
				$find = M('product_cate') -> where(array('id' => intval($_POST['store_cate']))) -> find();
				if(!$find){
					$this -> error('请选择正确的商城分类');
				}
			}
			
			if($_POST['attr_open'] != 1){
				$_POST['attr_open'] = 0;
			}
			
			$_POST['attr'] = implode(',',$_POST['attr_name']); // 属性
			
			//运费
			$weight = $_POST['weight']?$_POST['weight']:0;
			$attr_type = count($_POST['attr_name']);
			foreach($_POST['attr_value'] as $key => $val){
				$_POST['attr_values'][$key%$attr_type][] = $val;
			}
			$_POST['attr_values'] = serialize($_POST['attr_values']);
			$attr_table = array(
				'attr' => $_POST['attr_value'],
				'stock' => $_POST['attr_stock'],
				'code' => $_POST['attr_code']
			);
			$price = $_POST['price'];
			$_POST['price'] = serialize($price);
			
			// 修改
			if(isset($_GET['id'])){
				$rs = M('product') -> where('id='.intval($_GET['id'])) -> save($_POST);
				$product_id = intval($_GET['id']);
			}
			
			// 添加
			else{
				$_POST['create_time'] = NOW_TIME;
				$rs = M('product') -> add($_POST);
				$product_id = $rs;
			}
			
			// 如果操作成功则处理属性内容
			$rows = $this -> format($attr_table);
			foreach($rows as $row){
				$row['product_id'] = $product_id;
				$row['create_time'] = NOW_TIME;
				
				$where = array(
					'product_id' => $row['product_id'],
					'attr' => $row['attr']
				);
				
				// 有相同属性组合则修改，没有则增加
				if(M('product_attr') -> where($where) -> find()){
					M('product_attr') -> where($where) -> save($row);
				}else{
					M('product_attr') -> add($row);
				}
			}
			// 删除本次没有修改的属性组合
			M('product_attr') -> where(array('product_id' => $product_id, 'create_time' => array('neq', NOW_TIME))) -> delete();
			$this -> success('操作成功！', U('index'));
			exit;
		}
		
		if(!empty($_GET['id'])){
			$where = array();
			$info = M('product') -> find($_GET['id']);
			if(!$info){
				$this -> error('没有这个商品');
			}
		}
		
		$info['price'] = unserialize($info['price']);
	
		$info['attr'] = explode(',', $info['attr']);
		
		$temp = unserialize($info['attr_value']);
		
		$info['attr_table'] = M('product_attr') -> where(array('product_id' => $info['id'])) -> order('id asc') -> select();

		// 对属性组合进行分解
		foreach($info['attr_table'] as &$val){
			$val['attr'] = explode(',', $val['attr']);
		}
		
		// 查询商户自己的分类信息
		$cates = M('product_cate') -> where(array('admin_id' => $this->admin['id'])) -> select();
		$this -> assign('cates', $cates);
		
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
		M('product')->where($where)->delete();
		// 删除属性
		unset($where['id']);
		$where['product_id'] = intval($_GET['id']);
		M('product_attr') -> where(array('product_id'=>intval($_GET['id']))) -> delete();// 删除相关的属性
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