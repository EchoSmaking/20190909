<?php
namespace Admin\Controller;
use Think\Controller;
class UserController extends AdminController {
	public function _initialize(){
		parent::_initialize();
	}
	
    // 通知列表
	public function index(){
		if(IS_POST){
			$_GET = $_REQUEST;
		}
		if(!empty($_GET['id'])){
			$where['id'] = intval($_GET['id']);
		}
		if(!empty($_GET['level'])){
			$where['level'] = intval($_GET['level']);
		}
		if($_GET['reset']!=''){
			$where['reset'] = intval($_GET['reset']);
		}
		
		if(!empty($_GET['parent1'])){
			$where['parent1'] = intval($_GET['parent1']);
		}
		if(!empty($_GET['parent2'])){
			$where['parent2'] = intval($_GET['parent2']);
		}
		if(!empty($_GET['parent3'])){
			$where['parent3'] = intval($_GET['parent3']);
		}
		if(!empty($_GET['nickname'])){
			$where['nickname'] = array('like','%'.$_GET['nickname'].'%');
		}
		
		$this->assign('product',M('product')->order('sort desc')->select());
		
		// 组合排序方式
		if(in_array($_GET['order'], array('id','expense_total', 'agent1','agent2','agent3','sub_time'))){
			$type = $_GET['type'] == 'asc' ? 'asc' : 'desc';
			$order = $_GET['order'].' '.$type;
		}
		$this -> _list('user', $where, $order);
	}
	
	// 用户详细信息
	public function detail(){
		$id = intval($_GET['id']);
		$info = M('user') -> find($id);
		$this -> assign('info', $info);
		
		// 查询上级信息
		if($info['parent1']){
			$this -> assign('parent', M('user') -> find($info['parent1']));
		}

		// 查询分成总额
		$separate_money = M('separate_log') -> where(array('user_id'=>$info['id'],'status'=>4)) -> sum('money');
		$separate_points = M('separate_log') -> where(array('user_id'=>$info['id'],'status'=>4)) -> sum('points');
		$this -> assign('separate_money', $separate_money);
		$this -> assign('separate_points', $separate_points);
		$this -> display();
	}
	
	// 赠送分红
	public function reward(){
		$user_id = intval($_POST['user_id']);
		$money = floatval($_POST['money']);
		$type = intval($_POST['type']);
		
		if($user_id < 1 || $money <=0 ){
			$this -> error('操作错误');
		}
		
		$data = array(
			'expense_avail' => array('exp', 'expense_avail+'.$money)
		);
		if($type==1){
			$data['reward'] = array('exp', 'reward+'.$money);
			$tips = "绩效分红";
		}else{
			$data['reward_global'] = array('exp', 'reward_global+'.$money);
			$tips = "全球分红";
		}
		$rs = M('user') -> where('id='.$user_id) -> save($data);
		flog($user_id, 'expense', $money, $tips); // 财务记录
		
		if($rs){
			$this -> success('操作成功！');
			exit;
		}
	}
	
	private function _get_where(){
		if(IS_POST){
			$_GET  = array_merge($_GET, $_POST);
			$_GET['p'] = 1; //如果是post的话回到第一页
		}
		if(!empty($_GET['level'])){
			$where['level'] = intval($_GET['level']);
		}
		
		if(!empty($_GET['user_id'])){
			$where['user_id'] = intval($_GET['user_id']);
		}
		
		
		if(!empty($_GET['time1']) && !empty($_GET['time2'])){
			$where['create_time'] = array(
				array('gt', strtotime($_GET['time1'])),
				array('lt', strtotime($_GET['time2']) + 86400)
			);
		}
		elseif(!empty($_GET['time1'])){
			$where['create_time'] = array('gt', strtotime($_GET['time1']));
		}
		elseif(!empty($_GET['time2'])){
			$where['create_time'] = array('lt', strtotime($_GET['time2'])+86400);
		}
		return $where;
	}
	
	// 校准下级代理数
	public function correct_agent(){
		$user_id = intval($_GET['id']);
		$agent1 = M('user') -> where('parent1='.$user_id) -> count();
		$agent2 = M('user') -> where('parent2='.$user_id) -> count();
		$agent3 = M('user') -> where('parent3='.$user_id) -> count();
		M('user') -> where('id='.$user_id) -> save(array(
			'agent1' => $agent1,
			'agent2' => $agent2,
			'agent3' => $agent3
		));
		
		$this -> success('操作成功！', $_SERVER['HTTP_REFERER']);
	}
	
	
	//申请代理列表
	public function agent(){
		$where = $this->_get_where();
		$model = M('agent');
		$count = $model -> where($where) -> count();
		$page = new \Think\Page($count, 25);
		if(!$order){
			$order = "id desc";
		}
		// 组合排序方式
		if($_GET['order'] == 'id'){
			$type = $_GET['type'] == 'asc' ? 'asc' : 'desc';
			$order = $_GET['order'].' '.$type;
		}
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order($order) -> select();
		foreach($list as $k=>$v){
			$list[$k]['user'] = M('user')->find(intval($v['user_id']));
		}
		$this->assign('list',$list);
		$this->assign('page',$page->show());
		$this->display();
	}
	
	//审核代理
	public function doAgent(){
		$id = I('get.id');
		$status = I('get.status');
		$agent = M('agent')->where(array('id'=>$id,'status'=>0))->find();
		if(!$agent){
			$this->error('没有该用户申请信息');
		}
		if(M('agent')->where(array('id'=>$id))->save(array('status'=>$status))){
			M('user')->where(array('id'=>$agent['user_id']))->save(array(
				'level'=>$agent['level'],
				'true_name'=>$agent['true_name'],
				'mobile'=>$agent['mobile'],
				'cardno'=>$agent['cardno'],
			));
			$this->success('审核成功');
		}else{
			$this->error('审核失败');
		}
	}
	
	
	//设置上级
	public function setParent(){
		if(IS_POST){
			$user_id = $_POST['id'];
			$parent_id = $_POST['parent'];
			if(!$user_id){
				$this->error('参数错误');
			}
			if(!$parent_id){
				$this->error('请选择检索的上级信息');
			}
			if($user_id == $parent_id){
				$this->error('上级不能是自己');
			}
			if(M('user')->where(array('parent1'=>$user_id))->find()){
				$this->error('该用户存在下级，不符合！');
			}
			
			$parent = M('user')->find(intval($parent_id));

			if(M('user')->where(array('id'=>$user_id))->save(array(
				'parent1'=>$parent_id,
				'parent2'=>$parent['parent1'],
				'parent3'=>$parent['parent2'],
			))){
				$this->success('设定成功',U('index'));
			}else{
				$this->error('设定失败');
			}
			exit;
		}
		$this->assign('id',I('get.id'));
		$this->display();
	}
	
	//AJAX获取用户信息
	public function getUser(){
		$userid = I('user_id') ? I('user_id') : 0;

		if(!$userid){
			$data['status'] = 0;
			$data['info'] = '丢失参数';
			$this->ajaxReturn($data);
		}
		$where['id'] = array('like','%'.$userid.'%');
		$list = M('user')->where($where)->limit(200)->select();
		$this->ajaxReturn($list);
	}
	
	//AJAX获取产品属性
	public function getAttr(){
		$product_id = I('post.product_id')?I('post.product_id'):1;
		$attr = M('product_attr')->where(array('product_id'=>$product_id))->select();
		if($attr){
			$html='<div class="m-label">';
			$html.='<span>属性</span>';
			$html.='</div>';
			$html.='<div class="m-text">';
			$html.='<select name="attr" id="attr">';
			$html.='<option value="">--请选择产品属性--</option>';
			foreach($attr as $v){
				$html.='<option value="'.$v['attr'].'">'.$v['attr'].'</option>	';
			}	
			$html.='</select>';
			$html.='</div>';
			$this->success($html);
		}else{
			$this->error('没有属性');
		}
	}
	
	//修改库存
	public function updateStock(){
		$post = I('post.');
		if($post['attr']){
			$stock = M('user_stock')->where(array('user_id'=>$post['user_id'],'product_id'=>$post['product_id'],'attr'=>$post['attr']))->find();
			if($stock){
				if($stock['stock']+$post['nums']<0){
					$this->error('减少库存不能超过自身库存,用户该产品库存为'.$stock['stock']);
				}
				M('user_stock')->where(array('user_id'=>$post['user_id'],'product_id'=>$post['product_id'],'attr'=>$post['attr']))->save(array(
					'stock' => array('exp', 'stock+'.$post['nums'])
				));
			}else{
				if($post['nums']<0){
					$this->error('该用户没有该产品库存，不能减少库存');
				}
				M('user_stock')->add(array(
					'user_id'=>$post['user_id'],
					'product_id'=>$post['product_id'],
					'attr'=>$post['attr'],
					'stock'=>$post['nums'],
					'create_time'=>time(),
				));
			}
		}else{
			$stock = M('user_stock')->where(array('user_id'=>$post['user_id'],'product_id'=>$post['product_id']))->find();
			if($stock){
				if($stock['stock']+$post['nums']<0){
					$this->error('减少库存不能超过自身库存,用户该产品库存为'.$stock['stock']);
				}
				M('user_stock')->where(array('user_id'=>$post['user_id'],'product_id'=>$post['product_id']))->save(array(
					'stock' => array('exp', 'stock+'.$post['nums'])
				));
			}else{
				if($post['nums']<0){
					$this->error('该用户没有该产品库存，不能减少库存');
				}
				M('user_stock')->add(array(
					'user_id'=>$post['user_id'],
					'product_id'=>$post['product_id'],
					'stock'=>$post['nums'],
					'create_time'=>time(),
				));
				
			}
		}
		//增加系统操作库存日至
		$post['create_time'] = time();
		$post['day'] = date('Y-m-d H:i:s');
		M('stock_log')->add($post);
		$this->success('修改库存成功');
	}
	
	
	
	
}