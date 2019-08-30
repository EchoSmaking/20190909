<?php
namespace Home\Controller;
use Think\Controller;
class ProductController extends Controller {
    public function airpump(){
	
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('store_cate=25 OR store_cate=26 OR store_cate=27') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$comment = $model -> where('store_cate=28') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		/**foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}**/
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->assign('comment',$comment);
		$this->display();
		
}
	public function airpumpinfo(){
		$where['id'] = I('get.id');
		$a = I('get.store_cate');

		$model = M('paper');
		
		$page = new \Think\Page($count,16);
		$list = $model -> where("id = $a") -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$comment = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->assign('comment',$comment);
		$this->display();
	}
	
	public function airpumpcase(){
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
		
	}

    public function combinedpump(){
	$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('store_cate=36 OR store_cate=37') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$comment = $model -> where('store_cate=29') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();


		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->assign('comment',$comment);
		$this->display();
}
	public function combinedpumpinfo(){
		
		$where['id'] = I('get.id');
		$a = I('get.store_cate');
		
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where("id = $a") -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$comment = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('comment',$comment);
		$this->assign('list',$list);
		$this->display();

}
		public function combinedpumpcase(){
		
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
}

    public function electheater(){
	$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('store_cate=18') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$comment = $model -> where('store_cate=30') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('comment',$comment);
		$this->assign('list',$list);
		$this->display();
}
	public function electheaterinfo(){
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('id = 121') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$comment = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('comment',$comment);
		$this->assign('list',$list);
		$this->display();
}
	public function electheatercase(){
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}
	
    public function makingmist(){	
	$model = M('paper');
		$page = new \Think\Page($count,16);
		$comment = $model -> where('store_cate=32') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$list = $model -> where('store_cate=20') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('comment',$comment);
		$this->assign('list',$list);
		$this->display();

}
	public function makingmistinfo(){
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('id = 122') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$comment = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('comment',$comment);
		$this->assign('list',$list);
		$this->display();
}

	public function makingmistcase(){
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
}

    public function makingwave(){	
	
		$model = M('paper');
		$page = new \Think\Page($count,16);
		$comment = $model -> where('store_cate=31') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$list = $model -> where('store_cate=19') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('comment',$comment);
		$this->assign('list',$list);
		$this->display();
}

	public function makingwaveinfo(){
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('id = 123') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$comment = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('comment',$comment);
		$this->assign('list',$list);
		$this->display();
}

	public function makingwavecase(){
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
}


    public function otherproduct(){	
	
		$model = M('paper');
		$page = new \Think\Page($count,16);
		$comment = $model -> where('store_cate=34') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		
		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('comment',$comment);
		$this->assign('list',$list);
		$this->display();
}
	public function otherproductcase(){
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
	}



	public function otherproductinfo1(){

		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('id = 380') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();
		$comment = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('comment',$comment);
		$this->assign('list',$list);
		$this->display();
}


	public function otherproductinfo2(){
	$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('id = 378') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
}

	public function otherproductinfo3(){
	$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('id = 379') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
}






	public function info(){
	$model = M('paper');
		$page = new \Think\Page($count,16);

		$list = $model -> where('id = 85') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id asc') -> select();

		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		$this -> assign('page',$page->show());
		$this->assign('list',$list);
		$this->display();
		
		
		$where['id'] = I('get.id');
		$model = M('paper');
		$page = new \Think\Page($count, 9);
		$list = $model -> where($where) -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id desc') -> select();
		foreach($list as $k=>$v){
			$list[$k]['store_cate'] = M('product_cate')->where(array('id'=>$v['cate_tree']))->getField('name');
		}
		//var_dump($list);
		
		
		$news = $model -> where('store_cate=23 or store_cate=24') -> limit($page -> firstRow . ',' . $page -> listRows ) -> order('id desc') -> select();
		$this -> assign('page',$page->show());
		$this->assign('news',$news);
		$this->assign('list',$list);
		$this->display();
		
		
	}



}