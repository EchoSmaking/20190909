<?php
namespace Admin\Controller;
use Think\Controller;
class MedalController extends AdminController {
    // 记录列表
	public function index(){
		$this -> _list('medal');
	}
	
	// 发放分红
	public function edit(){
		
		$config = $this->_month_medal;
		$where = array();
		foreach($config as $k=>$c){
			if($c['money']>0){
				$where[] = array(
					'dd_m_consume.self_point' => array('egt', $config[$k]['self_point']),
					'dd_m_consume.s1_point' => array('egt', $config[$k]['s1_point']),
					'dd_m_consume.s2_point' => array('egt', $config[$k]['s2_point']),
					'dd_m_consume.xstatus' =>0,
				);
			}
		}
		$where['_logic'] = 'OR';
		$count = M('m_consume')->where($where) -> join("dd_user on dd_user.id = dd_m_consume.user_id")->count();
		$page = new \Think\Page($count,25);
		$list = M('m_consume') ->field(array(
			'dd_m_consume.id'=>'id',
			'dd_user.id'=>'user_id',
			'dd_user.level'=>'level',
			'dd_m_consume.self_point'=>'self_point',
		))-> where($where) -> join("dd_user on dd_user.id = dd_m_consume.user_id")->limit($page -> limit())-> select();
		if(IS_POST){
			if(empty($list)){
				$this->error('没有可发放的用户');
				exit;
			}
			foreach($list as $k=>$v){
				if($v['xstatus'] == 0){
					$user = M('user')->find(intval($v['user_id']));
					$money  = getMlevel($user,2);
					if(M('user')->where(array('id'=>$user['id']))->save(array('money' => array('exp', 'money+'.$money)))){
						flog($user['id'], 'money', $money, 11);
						$year = date('Y');
						$month = date('m');
						M('medal')->add(array(
							'user_id'=>$v['user_id'],
							'level'=>$user['level'],
							'money'=>$money,
							'year'=>$year,
							'month'=>$month,
							'create_time'=>time(),
						));
						M('m_consume')->where(array('id'=>$v['id']))->save(array('xstatus'=>1));
					}
				}
			}
			$this->success('发放成功',U('index'));
			exit;
		}
		$this->assign('list',$list);
		$this->assign('page',$page->show());
		$this -> display();
	}
	
	
	
	//月度勋章奖励设置
	public function month_medal(){
		if(IS_POST){
			$config = array();
			foreach($_POST['name'] as $key => $val){
				if(empty($val)){
					continue;
				}else{
					empty($_POST['self_point'][$key]) && $_POST['self_point'][$key] = 0;
					empty($_POST['s1_point'][$key]) && $_POST['money'][$key] = 0;
					empty($_POST['s2_point'][$key]) && $_POST['one_money'][$key] = 0;
					empty($_POST['s1_lv'][$key]) && $_POST['s1_lv'][$key] = 0;
					empty($_POST['s2_lv'][$key]) && $_POST['s2_lv'][$key] = 0;
				}
				
				$config[] = array(
					'name' => $val,
					'self_point' => $_POST['self_point'][$key],
					's1_point' => $_POST['s1_point'][$key],
					's2_point' => $_POST['s2_point'][$key],
					's1_lv' => $_POST['s1_lv'][$key],
					's2_lv' => $_POST['s2_lv'][$key],
					'money' => (($_POST['s1_lv'][$key]*$_POST['s1_point'][$key])+($_POST['s2_lv'][$key]*$_POST['s2_point'][$key]))/100,
				);
			}
			unset($_POST);
			$_POST = $config;
			// 有此配置则更新,没有则新增
			if(array_key_exists(ACTION_NAME, $this -> _CFG)){
				M('config') -> where(array('name' => ACTION_NAME)) -> save(array(
					'value' => serialize($_POST)
				));
			}else{
				M('config') -> add(array(
					'name' => ACTION_NAME,
					'value' => serialize($_POST)
				));
			}
			$this -> success('操作成功！');
			exit;
		}
		$this->display();
	}
}