<?php

// 对字符串进行加盐散列加密
function xmd5($str){
	return md5(md5($str).C('SAFE_SALT'));
}

// 获得当前的url
function get_current_url(){
	$url = "http://" . $_SERVER['SERVER_NAME'];
	$url .= $_SERVER['REQUEST_URI'];
	return $url;
}

// 补全url
function complete_url($url){
	$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
	if(substr($url,0,1) == '.'){
		return $protocol . $_SERVER['SERVER_NAME'].__ROOT__.substr($url,1);
	}
	elseif(substr($url,0,7) != 'http://' && substr($url,0,8) != 'https://'){
		return $protocol . $_SERVER['SERVER_NAME'].$url;
	}
	else{
		return $url;
	}
	
}

//发送短信:$con 为数据库存储的字段名称
function sms($mobile, $field){
	$sms = $GLOBALS['_CFG']['sms'];
	$content = '【'.$sms['sms_sign'].'】'.$sms[$field];
	$url = "http://api.smsbao.com/sms?u=".$sms['sms_user']."&p=".md5($sms['sms_psw'])."&m=".$mobile."&c=".urlencode($content);
	$rt = file_get_contents($url);
	var_dump($rt);
}

// 根据订单状态返回状态信息
function get_order_status($status){
	$status_str = '';
	switch($status){
		case -1: $status_str = '已关闭'; break;
		case 0: $status_str = '库存不足'; break;
		case 1: $status_str = '待支付'; break;
		case 2: $status_str = '待发货'; break;
		case 3: $status_str = '待确认'; break;
		case 4: $status_str = '已完成'; break;
		default : $status_str = '未知状态';
	}
	return $status_str;
}

// 根据订单状态返回状态信息
function get_stock_order($status){
	$status_str = '';
	switch($status){
		case -1: $status_str = '已关闭'; break;
		case 1: $status_str = '待支付'; break;
		case 2: $status_str = '待发货'; break;
		case 3: $status_str = '已发货'; break;
		default : $status_str = '未知状态';
	}
	return $status_str;
}

// 根据订单提现申请返回状态信息
function get_withdraw_status($status){
	$status_str = '';
	switch($status){
		case -1: $status_str = '已拒绝'; break;
		case 1: $status_str = '待审核'; break;
		case 2: $status_str = '待确认'; break;
		case 3: $status_str = '已完成'; break;
		default : $status_str = '未知状态';
	}
	return $status_str;
}

// 根据等级获取等级名称
function get_level_name($user,$config){
	if(!$config)$config = $GLOBALS['_CFG']['level'];
	if(!is_array($user)){
		$user = M('user')->find(intval($user));
	}
	return $config[$user['level']]['name'];
}


// 根据自定义菜单类型返回名称
function get_selfmenu_type($type){
	$type_name = '';
	switch($type){
		case 'click':
			$type_name = '点击推事件';
			break;
		case 'view':
			$type_name = '跳转URL';
			break;
		case 'scancode_push':
			$type_name = '扫码推事件';
			break;
		case 'scancode_waitmsg':
			$type_name = '扫码推事件且弹出“消息接收中”提示框';
			break;
		case 'pic_sysphoto':
			$type_name = '弹出系统拍照发图';
			break;
		case 'pic_photo_or_album':
			$type_name = '弹出拍照或者相册发图';
			break;
		case 'pic_weixin':
			$type_name = '弹出微信相册发图器';
			break;
		case 'location_select':
			$type_name = '弹出地理位置选择器';
			break;
		default : $type_name = '不支持的类型';
	}
	return $type_name;
}

// 更改用户等级
function update_level($order){
	if(!is_array($order)){
		$order = M('order')->find(intval($order));
	}
	$user =	M('user')->find(intval($order['user_id']));
	
	if(!$config)$config = $GLOBALS['_CFG']['level'];
	
	// 从高等级到低等级判断
	for($i = count($config)-1; $i>0; $i--){
		if($order['amount']>=$config[$i]['one_money']){
			if($user['level']<$i){
				M('user') -> where(array('id='.$user['id'])) -> save(array(
					'level' => $i,
				));
				break;
			}
		}
	}
	return;
}

//根据金额获得等级
// 更改用户等级
function getLevel($amount){
	if(!$config)$config = $GLOBALS['_CFG']['level'];
		for($i = count($config)-1; $i>0; $i--){
			if($amount>=$config[$i]['one_money']){
				$level = $i;
				break;
			}
		}
	return $level;
}

// 根据用户信息取得推广二维码路径信息
function get_qrcode_path($user){
	if(!is_array($user)){
		$user = M('user') -> find($user);
	}
	
	$path = './Public/qrcode/'.date('ym/d/',$user['sub_time']);
	return array(
			'path'		=> $path,
			'new'		=> $path.$user['id'].'_dragondean.jpg',
			'head' 		=> $path.$user['id'].'_head.jpg',
			'qrcode'	=> $path.$user['id'].'_qrcode.jpg',
			'full_path' => $_SERVER['DOCUMENT_ROOT'] . __ROOT__ . substr($path,1)
		);
}

//获得财务记录动作名称
function get_finance_action($action){
	$return = '';
	switch($action){
		case 1: $return = '在线充值';break;
		case 2: $return = '分红奖励';break;
		case 3: $return = '申请提现';break;
		case 4: $return = '提现退回';break;
		case 5: $return = '订单支付';break;
		case 6: $return = '订单分成';break;
		case 7: $return = '取消订单';break;
		case 8: $return = '取消分成';break;
		case 9: $return = '下级购买';break;
		case 10: $return = '月度分红';break;
		case 11: $return = '月度勋章';break;
		case 12: $return = '团队奖励';break;
		default : $return = '未知操作';
	}
	return $return;
}

/** 添加财务日志
*	type => money:余额记录,points:积分记录
*/
function flog($user_id, $type, $money, $action){
	M('finance_log') -> add(array(
		'user_id' => $user_id,
		'type' => $type,
		'money' => $money,
		'action' => $action,
		'create_time' => NOW_TIME
	));
}

//判断是否微信打开
function is_weixin() { 
    if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') !== false) { 
        return true; 
    } return false; 
}


// 确认订单
function confirm_order($order_info){
	if(!is_array($order_info)){
		$order_info = M('order') -> find($order_info);
	}
	
	if($order_info['status'] != 3)return;
	
	M('order') -> where(array('id' => $order_info['id'])) -> save(array(
		'status' => 4,
		'confirm_time' => NOW_TIME
	));
	//增加用户月消费记录
	m_consume($order_info);
	
	//如果订单是上级订单，则要扣除上级订单的库存和增加上级的余额
	if($order_info['own_id']>0){
		//增加余额
		M('user')->where(array('id'=>$order_info['own_id']))->save(array(
			'money' => array('exp', 'money+'.$order_info['total']),
			'points' => array('exp', 'points+'.$order_info['points_total']),
		));
		flog($order_info['own_id'], 'money', $order_info['total'],9);
		flog($order_info['own_id'], 'points', $order_info['points_total'],9);
		
		$order_product = M('order_product')->where(array('order_id'=>$order_info['id']))->select();
		foreach($order_product as $k=>$v){
			if($v['attr']){
				$where['attr'] = $v['attr'];
			}
			$where['user_id'] = $order_info['own_id'];
			$where['product_id'] = $v['product_id'];
			M('user_stock')->where($where)->setDec('stock',$v['nums']);
			//增加扣存记录
			M('user_minus_stock')->add(array(
				'user_id'=>$order_info['own_id'],
				'order_id'=>$order_info['id'],
				'product_id'=>$v['product_id'],
				'attr'=>$v['attr'],
				'stock'=>$v['nums'],
				'create_time'=>NOW_TIME,
			));
		}
	}
	
	// 将订单中的积分赠送到用户
	if($order_info['points_total'] >0 ){
		M('user') -> where(array('id='.$order_info['user_id'])) -> save(array(
			'points' => array('exp', 'points+'.$order_info['points_total'])
		));
		flog($order_info['user_id'], 'points', $order_info['points_total'],6);
	}
	// 将分成状态设置为已完成
	M('separate_log') -> where('order_id='.$order_info['id']) -> setField('status', 4);
	// 循环对分成添加到分销商账户
	$separate_logs = M('separate_log') -> where('order_id='.$order_info['id']) -> select();
	if($separate_logs){
		foreach((array)$separate_logs as $separate_log){
			M('user') -> where('id='.$separate_log['user_id']) -> save(array(
				'money' => array('exp', 'money+'.$separate_log['money']),
				'points' => array('exp', 'points+'.$separate_log['points']),
				'expense' => array('exp', 'expense+'.$separate_log['money']), // 总提成
				'sales' => array('exp', 'sales+'.$order_info['total']), // 总销售额
			));
			
			flog($separate_log['user_id'], 'money', $separate_log['money'],6);
			flog($separate_log['user_id'], 'points', $separate_log['points'],6);
		}
	}
	//更新用户等级
	update_level($order_info);
	//增加商品销量
	addSold($order_info);
}


function addSold($order){
	if(!is_array($order)){
		$order = M('order')->find(intval($order));
	}
	$order_product = M('order_product')->where(array('order_id'=>$order['id']))->select();
	foreach($order_product as $v){
		M('product')->where(array('id'=>$v['product_id']))->setInc('sold',$v['nums']);
	}
}

//每个用户的月消费记录
function m_consume($order){
	if(!is_array($order)){
		$order = M('order')->find(intval($order));
	}
	//判断是否有上级和上上级，若有则增加上级月消费记录里的下级消费总额
	$user = M('user')->find(intval($order['user_id']));
	$year = date('Y');
	$month = date('m');
	//自身累加消费记录
	$m = M('m_consume')->where(array('user_id'=>$order['user_id'],'month'=>$month,'year'=>$year))->find();
	if($m){
		M('m_consume')->where(array('user_id'=>$order['user_id'],'month'=>$month,'year'=>$year))->save(array(
			'money' => array('exp', 'money+'.$order['total']),
			'self_point' => array('exp', 'self_point+'.$order['total']),
		));
	}else{
		M('m_consume')->add(array(
			'user_id'=>$order['user_id'],
			'year'=>$year,
			'month'=>$month,
			'money'=>$order['total'],
			'self_point'=>$order['total'],
			'parent1'=>$user['parent1'],
			'parent2'=>$user['parent2'],
		));
	}
	for($i=1;$i<3;$i++){
		if($user['parent'.$i]>0){
			$parent = M('user')->find(intval($user['parent'.$i]));
			if($i == 1){
				$s1_point = $order['total'];
				$s2_point = 0;
			}else{
				$s1_point = 0;
				$s2_point = $order['total'];
			}
			if(M('m_consume')->where(array('user_id'=>$user['parent'.$i],'month'=>$month,'year'=>$year))->find()){
				M('m_consume')->where(array('user_id'=>$user['parent'.$i],'month'=>$month,'year'=>$year))->save(array(
					's1_point' => array('exp', 's1_point+'.$s1_point),
					's2_point' => array('exp', 's2_point+'.$s2_point),
				));
			}else{
				M('m_consume')->add(array(
					'user_id'=>$user['parent'.$i],
					'year'=>$year,
					'month'=>$month,
					'money'=>0,
					'self_point'=>0,
					's1_point'=>$s1_point,
					's2_point'=>$s2_point,
					'parent1'=>$parent['parent1'],
					'parent2'=>$parent['parent2'],
				));
			}
		}
	}
	
	
}

//获取当月用户发放月度勋章的等级和金额 1:月度分红，2：月度勋章
function getMlevel($user,$type){
	if(!is_array($user)){
		$user = M('user')->find($user);
	}
	if($type == 1){
		$config = $GLOBALS['_CFG']['month_divid'];
	}else if($type == 2){
		$config = $GLOBALS['_CFG']['month_medal'];
	}
	$year = date('Y');
	$month = date('m');
	$m_consume = M('m_consume')->where(array('year'=>$year,'month'=>$month,'user_id'=>$user['id']))->find();
	if($m_consume){
		for($i = count($config)-1; $i>0; $i--){
			// 从高等级到低等级判断
			if($m_consume['self_point']>=$config[$i]['self_point'] && $m_consume['s1_point']>=$config[$i]['s1_point'] && $m_consume['s2_point']>=$config[$i]['s2_point']){
				return  $config[$i]['money'];
			}
		}
	}
}

//获取当月团队奖励用户金额
function getTeamMoney($user){
	if(!is_array($user)){
		$user = M('user')->find($user);
	}
	$year = date('Y');
	$month = date('m');
	$config = $GLOBALS['_CFG']['month_team'];
	$m_consume = M('m_consume')->where(array('year'=>$year,'month'=>$month,'user_id'=>$user['id']))->find();
	$s1_money = M('m_consume')->where(array('year'=>$year,'month'=>$month,'parent1'=>$user['id']))->sum('self_point');
	$s2_money = M('m_consume')->where(array('year'=>$year,'month'=>$month,'parent2'=>$user['id']))->sum('self_point');
	$money = intval($s1_money/$config['s1_lv'])*$config['s1_money'] + intval($s2_money/$config['s2_lv'])*$config['s2_money'];
	return $money;
}
















