<?php
namespace Admin\Controller;
use Think\Controller;
class LogisController extends AdminController {
    // 通知列表
	public function index(){
		$where = array();
		if($_POST['provice']){
			$_GET = $_POST;
			$where['provice'] = array('like','%'.$_POST['provice'].'%');
		}
		$this -> _list('logis',$where);
	}
	
	// 编辑、添加通知
	public function edit(){
		if(IS_POST){
			if($_POST['district']){
				$arr = explode('||',$_POST['district']);
				$_POST['provice'] = $arr[0];
				unset($_POST['district']);
			}
			if($_POST['id']){
				if(M('logis')->where(array('id'=>$_POST['id']))->save($_POST)){
					$this->success('修改成功',U('index'));
				}else{
					$this->error('修改失败',U('index'));
				}
			}else{
				if(M('logis')->where(array('provice'=>$_POST['provice']))->find()){
					$this->error('该省份已经设置了运费');
				}
				if(M('logis')->add($_POST)){
					$this->success('添加成功',U('index'));
				}else{
					$this->error('添加失败',U('index'));
				}
			}
			
			exit;
		}
		if($_GET['id']){
			$this->assign('info',M('logis')->find(intval($_GET['id'])));
		}
		$this->assign('id',$_GET['id']);
		$this->display();
	}
	
	// 删除通知
	public function del(){
		$this -> _del('logis', intval($_GET['id']));
		$this -> success('操作成功！', $_SERVER['HTTP_REFERER']);
	}
}