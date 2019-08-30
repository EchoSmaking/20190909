<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>管理后台</title>
<link rel="stylesheet" href="/newsapxl/Public/admin/css/style.default.css" type="text/css" />
<link rel="stylesheet" href="/newsapxl/Public/plugins/bootstrap/css/bootstrap.font.css" type="text/css" />
<script type="text/javascript" src="/newsapxl/Public/admin/js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="/newsapxl/Public/admin/js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="/newsapxl/Public/admin/js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="/newsapxl/Public/admin/js/custom/general.js"></script>

<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
	<script src="js/plugins/css3-mediaqueries.js"></script>
<![endif]-->
</head>

<body class="withvernav">
<div class="bodywrapper">
    <div class="topheader">
        <div class="left">
            <h1 class="logo"><?php echo ($_site['name']); ?>.<span>后台</span></h1>
            <span class="slogan">后台管理系统</span>
                 
            <br clear="all" />
            
        </div><!--left-->
		<div class="right">
        	 <span style=" color:#fff;"><?php echo session('admin');?> <a href="<?php echo U('Index/logout');?>" style=" color:#ccc;">[退出]</a></span>
        </div><!--right-->

    </div><!--topheader-->
    
    <style>
	.vernav2 span.text{ padding-left:10px;}
	.menucoll2 span.text{ display:none;}
	.menucoll2>ul>li>a{ width:12px; padding:9px 10px; !important;}
	.dataTables_paginate a{ padding:0 10px;}
	</style>
    <div class="vernav2 iconmenu">
    	<ul>
<!--         	<li>
				<a href="#formsub">
					<span class="glyphicon glyphicon-cog" aria-hidden="true"></span>
					<span class="text">系统设置</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="formsub">
               		<li><a href="<?php echo U('Config/site');?>">网站设置</a></li>
					<li><a href="<?php echo U('Config/user');?>">管理员设置</a></li>
                    <li><a href="<?php echo U('Config/mp');?>">公众号设置</a></li>
                    <li><a href="<?php echo U('Config/dist');?>">分销设置</a></li>
					<li><a href="<?php echo U('Config/level');?>">等级设置</a></li>
					<li><a href="<?php echo U('Config/banner');?>">轮播图设置</a></li>
					<li><a href="<?php echo U('Config/topshow');?>">首页显示分类</a></li>
					<li><a href="<?php echo U('Config/topcate');?>">首页导航</a></li>
					<li><a href="<?php echo U('Logis/index');?>">运费设置</a></li>
                </ul>
            </li> -->
<!-- 			<li>
				<a href="<?php echo U('Config/sms');?>" class="editor">
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
					<span class="text">短信平台</span>
				</a>
            </li> -->
			<li>
				<a href="#product" class="elements">
					<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
					<span class="text">文章管理</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="product">
					<li><a href="<?php echo U('Paper/index');?>">文章管理</a></li>
               		<li><a href="<?php echo U('Paper/cate');?>">分类设置</a></li>
                </ul>
            </li>
			<!-- <li>
				<a href="<?php echo U('Notice/index');?>" class="editor">
					<span class="glyphicon glyphicon-volume-down" aria-hidden="true"></span>
					<span class="text">通知公告管理</span>
				</a>
            </li> -->
			<!-- <li>
				<a href="#order" class="typo">
					<span class="glyphicon glyphicon-list" aria-hidden="true"></span>
					<span class="text">订单管理</span>
				</a>
				<span class="arrow"></span>
            	<ul id="order">
					<li><a href="<?php echo U('Order/index',array('is_stock'=>0));?>">购买订单</a></li>
					<li><a href="<?php echo U('Order/index',array('is_stock'=>1));?>">库存订单</a></li>
					<li><a href="<?php echo U('Order/stock');?>">提货订单</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo U('Task/index');?>" class="tables">
					<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					<span class="text">发布任务</span>
				</a>
            </li>
			<li>
				<a href="#user" class="elements">
					<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
					<span class="text">用户管理</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="user">
					<li><a href="<?php echo U('User/index');?>">用户列表</a></li>
					<li><a href="<?php echo U('Tree/index');?>">树形关系</a></li>
					<li><a href="<?php echo U('User/agent');?>">申请代理列表</a></li>
					<li><a href="<?php echo U('User/agent');?>">库存修改记录</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo U('Reward/index');?>" class="support">
					<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
					<span class="text">月度分红</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Medal/index');?>" class="support">
					<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
					<span class="text">月度勋章</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Team/index');?>" class="support">
					<span class="glyphicon glyphicon-gift" aria-hidden="true"></span>
					<span class="text">团队奖励</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Withdraw/index');?>" class="support">
					<span class="glyphicon glyphicon-import" aria-hidden="true"></span>
					<span class="text">提现管理</span>
				</a>
            </li>
			<li>
				<a href="#finance" class="elements">
					<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
					<span class="text">系统财务</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="finance">
					<li><a href="<?php echo U('Finance/separate_log');?>">分成记录</a></li>
					<li><a href="<?php echo U('Finance/finance_log');?>">账户变动记录</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo U('Selfmenu/index');?>" class="widgets">
					<span class="glyphicon glyphicon-equalizer" aria-hidden="true"></span>
					<span class="text">自定义菜单管理</span>
				</a>
            </li>
			<li>
				<a href="<?php echo U('Autoreply/index');?>" class="addons">
					<span class="glyphicon glyphicon-tags" aria-hidden="true"></span>
					<span class="text">话术和自动回复管理</span>
				</a>
            </li>
			<li>
				<a href="#report" class="elements">
					<span class="glyphicon glyphicon-stats" aria-hidden="true"></span>
					<span class="text">统计分析</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="report">
					<li><a href="<?php echo U('Report/index');?>">数据报表</a></li>
               		<li><a href="<?php echo U('Report/instant');?>">实时数据</a></li>
                </ul>
            </li> -->
			
        </ul>
        <a class="togglemenu"></a>
        <br /><br />
    </div><!--leftmenu-->
        
    <div class="centercontent">
		        <div class="pageheader notab">
            <h1 class="pagetitle">编辑商品分类</h1>
            <span class="pagedesc">请认真编辑各项信息</span>
            
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper lineheight21">
			
        
            <form class="stdform stdform2" method="post">
				<style>
				.form-table{ width:100%; background:#ddd;}
				.form-table th,.form-table td{ padding:15px;}
				.form-table th.title{ width:190px; background:#fcfcfc; color:#666; text-align:left;}
				.form-table th small{ font-weight:normal; color:#999; display:block;}
				.form-table td{ background:#fff; vertical-align:middle;}
				</style>
				<table class="form-table" cellspacing="1" border="0">
					<tr>
						<th class="title">分类名</th>
						<td>
							<input type="text" name="name" id="name" value="<?php echo ($info["name"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">
							分类图片
							<small>点击+可以上传，点击图片可更换</small>
						</th>
						<td>
							<iframe src="<?php echo U('upload', 'event=setPic&url='.$info['pic']);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic" id="pic" value="<?php echo ($info["pic"]); ?>" class="smallinput" />
							<script>
							function setPic(url){
								document.getElementById('pic').value = url;
							}
							</script>
						</td>
					</tr>
					
					<tr>
						<th class="title">排序</th>
						<td>
							<input type="text" name="sort" id="sort" value="<?php echo ($info["sort"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">显示在首页</th>
						<td>
							<select name="is_show" default="<?php echo ($info['is_show']); ?>">
								<option value="0">否</option>
								<option value="1">是</option>
							</select>
						</td>
					</tr>
					<tr>
						<th class="title">外链<small>设置了外连会跳转到外连地址</small></th>
						<td>
							<input type="text" name="url" id="url" value="<?php echo ($info["url"]); ?>" class="smallinput" />
						</td>
					</tr>
				</table>
				
				<p class="stdformbutton">
					<button class="submit radius2">提交</button>
					<input type="reset" class="reset radius2" value="重置" />
				</p>
			</form>
        
        </div><!--contentwrapper-->
        
	</div><!-- centercontent -->
    
    
</div><!--bodywrapper-->
<script>
	jQuery(document).ready(function(e){
		
		
		// 菜单添加提示 
		$ = jQuery;
		
		// 根据cookie打开对应的菜单
		if($.cookie('curIndex')){
			//console.log($.cookie('curIndex'));
			$(".vernav2>ul>li").eq($.cookie('curIndex')).find('ul').show();
		}
		
		$(".vernav2 ul li").each(function(index, el){
			$(this).attr('title', $(this).find("a").find('span.text').text());
			
		});
		
		
		$(".vernav2>ul>li>a").each(function(index,el){
			$(el).on('click',function(e){
				$.cookie('curIndex',$(this).parent('li').index());
			});
		});
		
		
		// 调整默认选择内容
		$("select").each(function(index, element) {
			$(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');
		});
		// 调整提示内容
	});
</script>
</body>
</html>