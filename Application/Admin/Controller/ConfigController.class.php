<?php
namespace Admin\Controller;
use Think\Controller;
class ConfigController extends AdminController {
	public function _initialize(){
		parent::_initialize();
	}
	
	// 站点设置
	public function site(){
		$this -> _save();
		$this -> display();
	}
	
	
	// 短信平台
	public function sms(){
		$this -> _save();
		$this -> display();
	}
	
	// 配置管理账号
	public function user(){
		if(IS_POST){
			if(empty($_POST['name'])){
				
				$this -> error('请正确填写登录名');
				
			}else if($_POST['pass'] != $_POST['pass2'] || empty($_POST['pass'])){
				
				$this -> error('请正确填写密码!');
			}
			
			$_POST['pass'] = xmd5($_POST['pass']);
			unset($_POST['pass2']);
			
			// 调用保存方法
			$this -> _save();
		}
		
		$this -> display();
	}
	
	// 配置公众号
	public function mp(){
		if(IS_POST){
			if(!empty($_FILES['cert']) && $_FILES['cert']['name'] == 'cert.zip'){
				 $upload = new \Think\Upload();
				 $upload->maxSize   =     3145728 ;
				 $upload->exts      =     array('zip');
				 $upload->rootPath  =     './Public/cert/';
				 $upload->savePath  =     xmd5(time().rand()).'/';
				 $upload ->autoSub = false;
				 $info   =   $upload->upload();
				 if($info){
					$info = $info['cert'];
					
					// 解压
					$path = $upload->rootPath . $info['savepath'];
					$file = $path . $info['savename'];
					
					if(file_exists($file)){
						// 打开压缩文件
						$zip = new \ZipArchive();
						$rs = $zip -> open($file);
						if($rs && $zip -> extractTo($path)){
							$zip -> close();
							$_POST['cert'] = $path;
						}
						else{
							$this -> error('解压失败，请确认上传了正确的cert.zip');
						}
					}
					else{
						$this -> error('系统没找到上传的文件');
					}
				 }
				 else {
					$this -> error('证书上传错误');
				 }
			}
			else{
				$_POST['cert'] = $this -> _mp['cert'];
			}
		}
		$this -> _save();
		$this -> display();
	}
	
	// 分销设置
	public function dist(){
		$this -> _save();
		$this -> display();
	}
	
	// 配置等级
	public function level(){
		if(IS_POST){
			$config = array();
			foreach($_POST['name'] as $key => $val){
				if(empty($val)){
					continue;
				}else{
					empty($_POST['apply_money'][$key]) && $_POST['apply_money'][$key] = 0;
					empty($_POST['money'][$key]) && $_POST['money'][$key] = 0;
					empty($_POST['one_money'][$key]) && $_POST['one_money'][$key] = 0;
					empty($_POST['dist'][$key]) && $_POST['dist'][$key] = 0;
					empty($_POST['withdraw'][$key]) && $_POST['withdraw'][$key] = 0;
				}
				
				$config[] = array(
					'name' => $_POST['name'][$key],
					'apply_money' => $_POST['apply_money'][$key],
					'money' => $_POST['money'][$key],
					'one_money' => $_POST['one_money'][$key],
					'dist' => $_POST['dist'][$key],
					'withdraw' => $_POST['withdraw'][$key],
				);
			}
			
			unset($_POST);
			$_POST = $config;
			
			$this -> _save();
		}
		//var_dump($this->_level);
		$this -> display();
	}
	
	// 轮播图设置
	public function banner(){
		if(IS_POST){
			$_POST['config'] = array();
			foreach($_POST['pic'] as $key => $val){
				$_POST['config'][] = array('pic' => $_POST['pic'][$key], 'url' => $_POST['url'][$key]);
			}
			unset($_POST['pic']);
			unset($_POST['url']);
		}
		$this -> _save();
		$this -> display();
	}
	
	// 首页导航
	public function topcate(){
		if(IS_POST){
			$config = array();
			foreach($_POST['pic'] as $key => $val){
				$config[] = array('pic' => $_POST['pic'][$key], 'url' => $_POST['url'][$key],'title' => $_POST['title'][$key]);
			}
			$_POST = $config;
		}
		
		$this -> _save();
		$this -> display();
	}
	
	// 首页显示分类
	public function topshow(){
		if(IS_POST){
			$config = array();
			foreach($_POST['pic'] as $key => $val){
				$config[$key+1] = array('pic' => $_POST['pic'][$key], 'title' => $_POST['title'][$key]);
			}
			$_POST = $config;
		}
		$this -> _save();
		$this -> display();
	}
	
	
	private function _save($exit = true){
		// 通用配置保存操作
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
			if($exit){
				$this -> success('操作成功！');
				exit;
			}
		}
	}
}?>