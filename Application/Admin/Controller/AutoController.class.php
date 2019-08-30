<?php
namespace Admin\Controller;
use Think\Controller;
class AutoController extends Controller {
	 public function _initialize(){
		// 从数据读取配置参数
		$config = M('config') -> select();
		foreach($config as $v){
			$key = '_'.$v['name'];
			$this -> $key = unserialize($v['value']);
			$_CFG[$v['name']] = $this -> $key;
		}
		$this -> assign('_CFG', $_CFG);
		$GLOBALS['_CFG'] = $_CFG;
    }
	
	
	//自动判断订单的上级是否补货（若上级没补货则订单进入上上级，若没上上级则进入平台）
	public function auto_order(){
		//系统设定了自动补货延期的时间
		if($this->_site['hours'] && $this->_site['hours']>0){
			$orders = M('order')->where(array('gt_stock'=>1,'is_stock'=>0,'own_id'=>array('gt',0)))->select();
			foreach($orders as $v){
				if($v['create_t_time']){
					$time = (time()-$v['create_t_time'])/3600;
				}else{
					$time = (time()-$v['create_time'])/3600;
				}
				if($time>$this->_site['hours']){//若时间差大于设定的时间差,则要进行查询上级的库存
					$order_product = M('order_product')->where(array('order_id'=>$v['id']))->select();
					
					foreach($order_product as $op){
						if($op['attr']){
							$whs = array('user_id'=>$v['own_id'],'product_id'=>$op['product_id'],'attr'=>$op['attr']);
						}else{
							$whs = array('user_id'=>$v['own_id'],'product_id'=>$op['product_id']);
						}
						if(!M('user_stock')->where($whs)->find()){
							$gt_stock = 1;
							break;
						}else{
							$gt_stock = 0;
						}
					}
					if($gt_stock == 1 ){//上级没库存，查询上上级
						$parent1 = M('user')->find(intval($v['own_id']));
						if($parent1['parent1']){//若有上上级,则查询上上级库存
							foreach($order_product as $op){
								if(!M('user_stock')->where(array('product_id'=>$op['product_id'],'user_id'=>$parent1['parent1'],'attr'=>$op['attr']))->find()){
									$gt_stock = 1;
									break;
								}else{
									$gt_stock = 0;
								}
							}
							M('order')->where(array('id'=>$v['id']))->save(array('own_id'=>$parent1['parent1'],'gt_stock'=>$gt_stock,'create_t_time'=>NOW_TIME));
						}else{
							M('order')->where(array('id'=>$v['id']))->save(array('own_id'=>0,'gt_stock'=>0,'create_t_time'=>NOW_TIME));
						}
					}else{
						M('order')->where(array('id'=>$v['id']))->save(array('gt_stock'=>0,'create_t_time'=>NOW_TIME));
					}
				}
			}
		}
	}
	
	//库存订单24小时判断上级是否有货源
	public function auto_stock(){
		//系统设定了自动补货延期的时间
		if($this->_site['hours'] && $this->_site['hours']>0){
			$orders = M('order')->where(array('gt_stock'=>1,'is_stock'=>1,'own_id'=>array('gt',0)))->select();
			foreach($orders as $v){
				if($v['create_t_time']){
					$time = (time()-$v['create_t_time'])/3600;
				}else{
					$time = (time()-$v['create_time'])/3600;
				}
				if($time>$this->_site['hours']){//若时间差大于设定的时间差,则要进行查询上级的库存
					$order_product = M('order_product')->where(array('order_id'=>$v['id']))->select();
					foreach($order_product as $op){
						if($op['attr']){
							$whs = array('user_id'=>$v['own_id'],'product_id'=>$op['product_id'],'attr'=>$op['attr']);
						}else{
							$whs = array('user_id'=>$v['own_id'],'product_id'=>$op['product_id']);
						}
						if(!M('user_stock')->where($whs)->find()){
							$gt_stock = 1;
							break;
						}else{
							$gt_stock = 0;
						}
					}
					if($gt_stock == 1 ){//上级没库存，查询上上级
						$parent1 = M('user')->find(intval($v['own_id']));
						if($parent1['parent1']){//若有上上级,则查询上上级库存
							foreach($order_product as $op){
								if($op['attr']){
									$where['attr'] = $op['attr'];
								}
								$where['product_id'] = $op['product_id'];
								$where['user_id'] = $parent1['parent1'];
								if(!M('user_stock')->where($where)->find()){
									$gt_stock = 1;//没货
									break;
								}else{
									$gt_stock = 0;
								}
							}
							//若上上级级有货,则增加发货库存
							if($gt_stock==0){
								//变更订单信息
								M('order')->where(array('id'=>$v['id']))->save(array('own_id'=>$parent1['parent1'],'gt_stock'=>0,'status'=>4));
								foreach($order_product as $op){
									//减少上上级库存
									if($op['attr']){
										$wh = array('user_id'=>$v['user_id'],'product_id'=>$op['product_id'],'attr'=>$op['attr']);
										$mp = array('user_id'=>$parent1['parent1'],'product_id'=>$op['product_id'],'attr'=>$op['attr']);
									}else{
										$wh = array('user_id'=>$v['user_id'],'product_id'=>$op['product_id']);
										$mp = array('user_id'=>$parent1['parent1'],'product_id'=>$op['product_id']);
									}
									M('user_stock')->where($mp)->setDec('stock',$op['nums']);
									//增加扣存记录
									M('user_minus_stock')->add(array(
										'user_id'=>$parent1['parent1'],
										'order_id'=>$v['id'],
										'product_id'=>$op['product_id'],
										'attr'=>$op['attr'],
										'stock'=>$op['nums'],
										'create_time'=>NOW_TIME,
									));
																	
									if(!M('user_stock')->where($wh)->find()){
										M('user_stock')->add(array(
											'user_id'=>$v['user_id'],
											'product_id'=>$op['product_id'],
											'stock'=>$op['nums'],
											'attr'=>$op['attr'],
											'create_time'=>NOW_TIME,
										));
									}else{
										M('user_stock')->where($wh)->save(array(
											'stock' => array('exp', 'stock+'.$op['nums']),
											'update_time' => NOW_TIME,	
										));
									}	
								}
								//增加上上级金额
								M('user')->where(array('id'=>$parent1['parent1']))->setInc('money',$v['total']);
								//拿库存也要更新等级
								update_level($v);
								//增加商品销量
								addSold($v);
								
							}else{
								//变更订单信息
								M('order')->where(array('id'=>$v['id']))->save(array('own_id'=>$parent1['parent1'],'gt_stock'=>1,'status'=>2,'create_t_time'=>NOW_TIME));
							}
						}else{
							//变更订单信息
							M('order')->where(array('id'=>$v['id']))->save(array('own_id'=>0,'gt_stock'=>0,'create_t_time'=>NOW_TIME,'status'=>4));
							foreach($order_product as $op){
								if($op['attr']){
									$wh = array('user_id'=>$v['user_id'],'product_id'=>$op['product_id'],'attr'=>$op['attr']);
								}else{
									$wh = array('user_id'=>$v['user_id'],'product_id'=>$op['product_id']);
								}
								if(!M('user_stock')->where($wh)->find()){
									M('user_stock')->add(array(
										'user_id'=>$v['user_id'],
										'product_id'=>$op['product_id'],
										'stock'=>$op['nums'],
										'attr'=>$op['attr'],
										'create_time'=>NOW_TIME,
									));
								}else{
									M('user_stock')->where($wh)->save(array(
										'stock' => array('exp', 'stock+'.$op['nums']),
										'update_time' => NOW_TIME,	
									));
								}	
							}
						}
					}else{
						
						//变更订单信息
						M('order')->where(array('id'=>$v['id']))->save(array('gt_stock'=>0,'status'=>4));
						foreach($order_product as $op){
							//减少上级库存
							if($op['attr']){
								$wh = array('user_id'=>$v['user_id'],'product_id'=>$op['product_id'],'attr'=>$op['attr']);
								$mp = array('user_id'=>$v['own_id'],'product_id'=>$op['product_id'],'attr'=>$op['attr']);
							}else{
								$wh = array('user_id'=>$v['user_id'],'product_id'=>$op['product_id']);
								$mp = array('user_id'=>$v['own_id'],'product_id'=>$op['product_id']);
							}
							M('user_stock')->where($mp)->setDec('stock',$op['nums']);	
							//增加扣存记录
							M('user_minus_stock')->add(array(
								'user_id'=>$v['own_id'],
								'order_id'=>$v['id'],
								'product_id'=>$op['product_id'],
								'attr'=>$op['attr'],
								'stock'=>$op['nums'],
								'create_time'=>NOW_TIME,
							));
							
							if(!M('user_stock')->where($wh)->find()){
								M('user_stock')->add(array(
									'user_id'=>$v['user_id'],
									'product_id'=>$op['product_id'],
									'stock'=>$op['nums'],
									'attr'=>$op['attr'],
									'create_time'=>NOW_TIME,
								));
							}else{
								M('user_stock')->where($wh)->save(array(
									'stock' => array('exp', 'stock+'.$op['nums']),
									'update_time' => NOW_TIME,	
								));
							}	
						}
						//增加上上级金额
						M('user')->where(array('id'=>$v['own_id']))->setInc('money',$v['total']);
						//拿库存也要更新等级
						update_level($v);
						//增加商品销量
						addSold($v);
					}
				}
			}
		}
	}
	
	//计划任务判断月底最后一天清空等级
	public function cancle_level(){
		//有等级的level
		$day = intval(date('d'));
		$BeginDate=date('Y-m-01', strtotime(date("Y-m-d")));
		$last = date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
		if($day == intval($last)){
			$user = M('user')->where(array('level'=>array('gt',0)))->find();
			if($user){
				M('user')->where(array('level'=>array('gt',0)))->save(array('level'=>0));
			}
		}
	}
	
	//计划任务自动收货
	public function confirm_order(){
		if(!empty($this -> _site['auto_confirm']) && $this -> _site['auto_confirm'] >0){
			$time = strtotime('-'.$this -> _site['auto_confirm'].'days');
			// 所有发货时间超过制定时间的待收货的订单
			$orders = M('order') -> where(array(
				'delivery_time' => array('lt', $time),
				'status' => 3
			)) -> select();
			foreach($orders as $order_info){
				confirm_order($order_info);
			}
		}
	}
}