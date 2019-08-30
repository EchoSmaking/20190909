<?php
namespace Admin\Controller;
use Think\Controller;
class TeamController extends AdminController {
    // 记录列表
	public function index(){
		$this -> _list('team');
	}
	
	// 发放分红
	public function edit(){	
		$config = $this->_month_team;
		$where[] = array(
			'dd_user.level' => array('in',implode($config['level'])),
			'dd_m_consume.year' => date('Y'),
			'dd_m_consume.month' => date('m'),
			'dd_m_consume.tstatus'=>0
		);
		$count = M('m_consume')->where($where) -> join("dd_user on dd_user.id = dd_m_consume.user_id")->count();
		$page = new \Think\Page($count,25);
		$list = M('m_consume') ->field(array(
			'dd_m_consume.id'=>'id',
			'dd_user.id'=>'user_id',
			'dd_user.level'=>'level',
			'dd_m_consume.self_point'=>'self_point',
		))-> where($where) -> join("dd_user on dd_user.id = dd_m_consume.user_id")->limit($page -> limit())-> select();
		foreach($list as $k=>$v){
			$list[$k]['s1_money'] = M('m_consume')->where(array('year'=>date('Y'),'month'=>date('m'),'parent1'=>$v['user_id']))->sum('self_point');
			$list[$k]['s2_money'] = M('m_consume')->where(array('year'=>date('Y'),'month'=>date('m'),'parent2'=>$v['user_id']))->sum('self_point');
			
		}
		if(IS_POST){
			if(empty($list)){
				$this->error('没有可发放的用户');
				exit;
			}
			foreach($list as $k=>$v){
				if($v['tstatus'] == 0){
					$user = M('user')->find(intval($v['user_id']));
					$money = getTeamMoney($v['user_id']);
					if(M('user')->where(array('id'=>$user['id']))->save(array('money' => array('exp', 'money+'.$money)))){
						flog($user['id'], 'money', $money, 12);
						$year = date('Y');
						$month = date('m');
						M('team')->add(array(
							'user_id'=>$v['user_id'],
							'level'=>$user['level'],
							'money'=>$money,
							'year'=>$year,
							'month'=>$month,
							'create_time'=>time(),
						));
						M('m_consume')->where(array('id'=>$v['id']))->save(array('tstatus'=>1));
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
	
	
	
	//月度分红奖励
	public function month_team(){
		if(IS_POST){
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
		//var_dump($this->_month_team);
		$this->display();
	}
}