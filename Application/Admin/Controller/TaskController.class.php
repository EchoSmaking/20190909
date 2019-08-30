<?php
namespace Admin\Controller;
use Think\Controller;
class TaskController extends AdminController {
    // 通知列表
	public function index(){
		$this -> _list('task');
	}
	
	public function edit(){
		$_POST['create_time'] = time();
		$this->_edit('task');
	}
	
	public function setStatus(){
		$id = $_GET['id'];
		$status = $_GET['status'];
		M('task')->where(array('id'=>$id))->save(array('status'=>$status));
		$this->success('操作成功');
	}
	
	public function lists(){
		$where = $this->_get_where();
		$where['task_id']=I('get.id');
		$model = M('task_log');
		$count = $model ->where($where)-> count();
		$page = new \Think\Page($count, 25);
		if(!$order){
			$order = "create_time desc";
		}
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order($order) -> select();
		foreach($list as $k=>$v){
			$list[$k]['task'] = M('task')->find(intval($v['task_id']));
		}
		$this->assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}
	
	private function _get_where(){
		if(IS_POST){
			$_GET  = array_merge($_GET, $_POST);
			$_GET['p'] = 1; //如果是post的话回到第一页
		}
		if(!empty($_GET['status'])){
			$where['status'] = intval($_GET['status']);
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
	
	
	public function setStatus_log(){
		$id = $_REQUEST['id'];
		$status = $_REQUEST['status'];
		$msg = $_REQUEST['msg'];
		if(M('task_log')->where(array('id'=>$id))->save(array('status'=>$status,'msg'=>$msg,'confirm_time'=>NOW_TIME))){
			if($status == 2){
				$log = M('task_log')->where(array('id'=>$id))->find();
				$task = M('task')->where(array('id'=>$log['task_id']))->find();
				if($task['way']==1){//赠送积分
					M('user')->where(array('id'=>$log['user_id']))->save(array(
						'points' => array('exp', 'points+'.$task['value']),
					));
				}else{
					M('user')->where(array('id'=>$log['user_id']))->save(array(
						'money' => array('exp', 'money+'.$task['money']),
					));
				}
			}
			$this->success('审核成功');
		}else{
			$this->error('审核失败');
		}
	}
}