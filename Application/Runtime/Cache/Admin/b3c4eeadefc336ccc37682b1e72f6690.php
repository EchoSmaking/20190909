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
            <h1 class="logo"><?php echo ($_site['name']); ?>.<span>商城</span></h1>
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
        	<li>
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
            </li>
			<li>
				<a href="<?php echo U('Config/sms');?>" class="editor">
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span>
					<span class="text">短信平台</span>
				</a>
            </li>
			<li>
				<a href="#product" class="elements">
					<span class="glyphicon glyphicon-th" aria-hidden="true"></span>
					<span class="text">商品管理</span>
				</a>
            	<span class="arrow"></span>
            	<ul id="product">
					<li><a href="<?php echo U('Product/index');?>">商品管理</a></li>
               		<li><a href="<?php echo U('Product/cate');?>">分类设置</a></li>
                </ul>
            </li>
			<li>
				<a href="<?php echo U('Notice/index');?>" class="editor">
					<span class="glyphicon glyphicon-volume-down" aria-hidden="true"></span>
					<span class="text">通知公告管理</span>
				</a>
            </li>
			<li>
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
					<li><a href="<?php echo U('User/signed');?>">库存变化记录</a></li>
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
            </li>
			
        </ul>
        <a class="togglemenu"></a>
        <br /><br />
    </div><!--leftmenu-->
        
    <div class="centercontent">
		        <div class="pageheader notab">
            <h1 class="pagetitle">编辑产品</h1>
            <span class="pagedesc">请认真编辑产品的各项信息</span>
            
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper lineheight21">
			
        
            <form class="stdform stdform2" method="post">
				<style>
				.form-table{ width:100%; background:#ddd;}
				.form-table th,.form-table td{ padding:15px;}
				.form-table th.title{ width:190px; background:#fcfcfc; color:#666; text-align:left;}
				.form-table th small{ font-weight:normal; color:#999; display:block;}
				.form-table td{ background:#fff; vertical-align:middle;}
				
				#cate select{ width:100px; min-width:100px;}
				</style>
				<table class="form-table" cellspacing="1" border="0">
					<tr>
						<th class="title">商品标题<small>这里是提示您</small></th>
						<td>
							<input type="text" name="title" id="title" value="<?php echo ($info["title"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">所属分类</th>
						<td id="cate">
							
							<input type="hidden" name="store_cate" id="store_cate" value="<?php echo ($info["store_cate"]); ?>"/>
							<input type="hidden" name="cate_tree" id="cate_tree" value="<?php echo ($info["cate_tree"]); ?>"/>
							<select name="" id="store_select" default="<?php echo ($info["store_cate"]); ?>">
							</select>
							
							<script src="/newsapxl/Public/js/linkagesel-min.js" type="text/javascript"></script>
							<script>
							var opts = {
									//data: districtData,     // districtData为district-all.js中定义的变量
									select:  '#store_select',
									ajax: '<?php echo U("get_child_cates");?>',
									selClass:'select-fix-width',
									head:'请选择',
									fixWidth:'100%',
									autoLink:false,
									loaderImg:'/newsapxl/Public/images/loading_16.gif',
									defVal:<?php echo json_encode(explode(',',$info['cate_tree']));?>
							};
							var linkageSel = new LinkageSel(opts);
							districtData = opts = null; // 如果数据量大最好在创建LinkageSel实例之后清空
							linkageSel.onChange(function() {
								tmp = linkageSel.getSelectedArr();
								d=[];
								for(var i=0;i<tmp.length;i++){
									console.log(tmp[i]);
									if(tmp[i]!='' && tmp[i]!=null)d.push(tmp[i]);
								}
								$("#cate_tree").val(d.join(','));
								$("#store_cate").val(d[d.length-1]);
							});
							</script>
						</td>
					</tr>
					<tr>
						<th class="title">发布专区<small></small></th>
						<td>
							<select name="topshow" default="<?php echo ($info["topshow"]); ?>">
								<?php if(is_array($_topshow)): foreach($_topshow as $k=>$vo): ?><option value="<?php echo ($k); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
							</select>
						</td>
					</tr>
					<tr class="lingyuan">
						<th class="title">重量<small>单位：千克</small></th>
						<td>
							<input type="text" name="weight" id="weight" value="<?php echo ($info['weight']); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">
							商品封面图片
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
					</tr>
					<tr>
						<th class="title">
							商品详情轮播图片
							<small>点击+可以上传，点击图片可更换</small>
						</th>
						<td>
							<iframe src="<?php echo U('upload', 'event=setPic1&url='.$info['pic1']);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic1" id="pic1" value="<?php echo ($info["pic1"]); ?>" class="smallinput" />
							
							<iframe src="<?php echo U('upload', 'event=setPic2&url='.$info['pic2']);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic2" id="pic2" value="<?php echo ($info["pic2"]); ?>" class="smallinput" />
							
							<iframe src="<?php echo U('upload', 'event=setPic3&url='.$info['pic3']);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic3" id="pic3" value="<?php echo ($info["pic3"]); ?>" class="smallinput" />
							
							<iframe src="<?php echo U('upload', 'event=setPic4&url='.$info['pic4']);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic4" id="pic4" value="<?php echo ($info["pic4"]); ?>" class="smallinput" />
							
							<iframe src="<?php echo U('upload', 'event=setPic5&url='.$info['pic5']);?>" scrolling="no" width="100" height="100"></iframe>
							<input type="hidden" name="pic5" id="pic5" value="<?php echo ($info["pic5"]); ?>" class="smallinput" />
							
							
							<script>
							function setPic1(url){
								document.getElementById('pic1').value = url;
							}
							function setPic2(url){
								document.getElementById('pic2').value = url;
							}
							function setPic3(url){
								document.getElementById('pic3').value = url;
							}
							function setPic4(url){
								document.getElementById('pic4').value = url;
							}
							function setPic5(url){
								document.getElementById('pic5').value = url;
							}
							</script>
					</tr>
					<tr>
						<th class="title">官方价格</th>
						<td>
							<input type="text" name="market_price" id="market_price" value="<?php echo ($info["market_price"]); ?>" class="smallinput" />
						</td>
					</tr>
					<?php if($_GET['id']): ?><tr>
							<th class="title">销售价格</th>
							<td>
								<?php if(is_array($_level)): foreach($_level as $k=>$v): ?><span><?php echo ($v['name']); ?>价格:</span>
									<input type="text" name="price[]"  value="<?php echo ($info['price'][$k]); ?>" style="width:100px;" class="smallinput" />
									&nbsp;<?php endforeach; endif; ?>
							</td>
						</tr>
					<?php else: ?>
					<tr>
						<th class="title">销售价格</th>
						<td>
							<?php if(is_array($_level)): foreach($_level as $k=>$v): ?><span><?php echo ($v['name']); ?>价格:</span>
								<input type="text" name="price[]"  value="<?php echo ($info['price'][$k]); ?>" style="width:100px;" class="smallinput" />
								&nbsp;<?php endforeach; endif; ?>
						</td>
					</tr><?php endif; ?>
					<tr>
						<th class="title">排序</th>
						<td>
							<input type="text" name="sort" id="sort" value="<?php echo ($info["sort"]); ?>" class="smallinput" />
						</td>
					</tr>
					<?php if($_CFG['dist']['model'] == 2): ?><tr>
						<th class="title">分成金额</th>
						<td>
							<input type="text" name="separate_money" id="separate_money" value="<?php echo ($info["separate_money"]); ?>" class="smallinput" />
						</td>
					</tr><?php endif; ?>
					<tr>
						<th class="title">赠送<?php echo ($_CFG["site"]["points_name"]); ?></th>
						<td>
							<input type="text" name="points" id="points" value="<?php echo ($info["points"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">库存</th>
						<td>
							<input type="text" name="stock" id="stock" value="<?php echo ($info["stock"]); ?>" class="smallinput" />
						</td>
					</tr>
					<tr>
						<th class="title">初始化销售</th>
						<td>
							<input type="text" name="sold" id="sold" value="<?php echo ($info["sold"]); ?>" class="smallinput" />
						</td>
					</tr>
					
					<tr>
						<th class="title">
							产品属性
							<small><a href="javascript:;" onclick="addAttr()">[添加]</a></small>
						</th>
						<td>
							<div class="">
							<input type="checkbox" name="attr_open" id="attr_open" value="1" onclick="isAttrOpen()" <?php if($info['attr_open'] == 1): ?>checked<?php endif; ?> /> 启用
							</div>
							<style>
								.attr-table{ background:#ddd; border:0; border-spacing:1px; width:100%;}
								.attr-table tr{ background:#fff;}
								
								.attr-table th,.attr-table td{ vertical-align:middle;}
								.attr-value{position:relative; width:100px; height:30px; float:left;}
								.attr-value a{ background:red; color:#fff; height:32px; line-height:32px; padding:0 5px; 
										position:absolute; right:0; top:0; border-radius:0 2px 2px 0; 
									}
								input.short{ width:80px !important;}
							</style>
							<table class="attr-table" id="attr-table">
								<thead>
									<tr>
										<?php if(is_array($info['attr'])): $i = 0; $__LIST__ = $info['attr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><th>
											<span class="attr-value">
												<input type="text" value="<?php echo ($vo); ?>" name="attr_name[]" />
												<a href="javascript:;" onclick="delAttr(this)">X</a>
											</span>
										</th><?php endforeach; endif; else: echo "" ;endif; ?>
										<th>库存</th>
										<th>编码</th>
										<th>操作</th>
									</tr>
								</thead>
								<tbody>
									<?php if(is_array($info['attr_table'])): $i = 0; $__LIST__ = $info['attr_table'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
										<?php if(is_array($vo['attr'])): $i = 0; $__LIST__ = $vo['attr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vv): $mod = ($i % 2 );++$i;?><td><input type="text" class="short" name="attr_value[]" value="<?php echo ($vv); ?>"/></td><?php endforeach; endif; else: echo "" ;endif; ?>
										<td><input type="text" class="short" name="attr_stock[]" value="<?php echo ($vo["stock"]); ?>"/></td>
										<td><input type="text" class="short" name="attr_code[]" value="<?php echo ($vo["code"]); ?>"/></td>
										<td><a href="javascript:;" onclick="delRow(this)">删除</a></td>
									</tr><?php endforeach; endif; else: echo "" ;endif; ?>
								</tbody>
							</table>
							<div class="" id="attr-add" style=" line-height:30px; border:1px solid #ddd; border-top:none; text-align:center;">
								<a href="javascript:;" onclick="addRow()">添加一行</a>
							</div>
							<script>
							function isAttrOpen(){
								if(jQuery("#attr_open").is(':checked')){
									jQuery("#attr-table").show();
									jQuery("#attr-add").show();
								}else{
									jQuery("#attr-table").hide();
									jQuery("#attr-add").hide();	
								}
							}
							
							// 添加属性，添加一列
							function addAttr(){
								head_html = '<th>'
										+'<span class="attr-value">'
										+'		<input type="text" value="" name="attr_name[]" />'
										+'		<a href="javascript:;" onclick="delAttr(this)">X</a>'
										+'	</span>'
										+'</th>';
								row_html = '<td><input type="text" class="short" name="attr_value[]"/></td>';
								table = jQuery("#attr-table");
								
								// 添加表头
								table.find("thead").find("tr").prepend(head_html);
								
								// 挨行添加
								table.find("tbody").find("tr").each(function(index, el){
									jQuery(el).prepend(row_html);
								});
							}
							
							function delAttr(obj){
								table = jQuery("#attr-table");
								var thisth = jQuery(obj).parent("span").parent("th");
								var thisindex = null;
								table.find("thead").find("tr").find("th").each(function(index,el){
									if(el == thisth[0]){
										thisindex = index;
										thisth.remove();
									}
								});
								table.find("tbody").find("tr").each(function(index,el){
									jQuery(el).find("td").eq(thisindex).remove();
								});
							}
							
							function addRow(){
								attr_num = jQuery(".attr-value").size();
								html = '<tr>';
								for(i=0;i<attr_num;i++){
									html += '<td><input type="text" class="short" name="attr_value[]"/></td>';
								}
									
								html	+='<td><input type="text" class="short" name="attr_stock[]"/></td>'
										+'<td><input type="text" class="short" name="attr_code[]"/></td>'
										+'<td><a href="javascript:;" onclick="delRow(this)">删除</a></td>'
									+'</tr>';
								jQuery("#attr-table").append(html);
							}
							
							function delRow(obj){
								jQuery(obj).parent("td").parent("tr").remove();
							}
							
							jQuery(document).ready(function(e){
								isAttrOpen();
							});                     
							</script>
						</td>
					</tr>
					<tr>
						<th class="title">宝贝详情</th>
						<td>
							<textarea name="body" id="body" class="longinput" style="margin: 0px; height: 400px; max-width:640px;"><?php echo ($info["body"]); ?></textarea>
						</td>
					</tr>
				</table>
				
				
				
				<p class="stdformbutton">
					<button class="submit radius2">提交</button>
					<input type="reset" class="reset radius2" value="重置" />
				</p>
			</form>
			<script src="/newsapxl/Public/plugins/ueditor1.4.3/ueditor.config.js"></script>
			<script src="/newsapxl/Public/plugins/ueditor1.4.3/ueditor.all.min.js"></script>
			<script>
				ue = UE.getEditor('body');
				jQuery(document).ready(function(d){
					$ = jQuery;
					//调整下拉的默认选择
					$("select").each(function(index, element) {
					  $(element).find("option[value='"+$(this).attr('default')+"']").attr('selected','selected');
					});
				});
			</script>
        
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