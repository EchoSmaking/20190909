// JavaScript Document
<!--
//图片滚动列表 mengjia 070927
var Speed_1 = 10; //速度(毫秒)
var Space_1 = 20; //每次移动(px)
var PageWidth_1 = 155 * 3; //翻页宽度
var interval_1 = 2000; //翻页间隔
var fill_1 = 0; //整体移位
var MoveLock_1 = false;
var MoveTimeObj_1;
var MoveWay_1="right";
var Comp_1 = 0;
var AutoPlayObj_1=null;
function GetObj(objName){if(document.getElementById){return eval('document.getElementById("'+objName+'")')}else{return eval('document.all.'+objName)}}
function AutoPlay_1(){clearInterval(AutoPlayObj_1);AutoPlayObj_1=setInterval('ISL_GoDown_1();ISL_StopDown_1();',interval_1)}
function ISL_GoUp_1(){if(MoveLock_1)return;clearInterval(AutoPlayObj_1);MoveLock_1=true;MoveWay_1="left";MoveTimeObj_1=setInterval('ISL_ScrUp_1();',Speed_1);}
function ISL_StopUp_1(){if(MoveWay_1 == "right"){return};clearInterval(MoveTimeObj_1);if((GetObj('ISL_Cont_1').scrollLeft-fill_1)%PageWidth_1!=0){Comp_1=fill_1-(GetObj('ISL_Cont_1').scrollLeft%PageWidth_1);CompScr_1()}else{MoveLock_1=false}
AutoPlay_1()}
function ISL_ScrUp_1(){if(GetObj('ISL_Cont_1').scrollLeft<=0){GetObj('ISL_Cont_1').scrollLeft=GetObj('ISL_Cont_1').scrollLeft+GetObj('List1_1').offsetWidth}
GetObj('ISL_Cont_1').scrollLeft-=Space_1}
function ISL_GoDown_1(){clearInterval(MoveTimeObj_1);if(MoveLock_1)return;clearInterval(AutoPlayObj_1);MoveLock_1=true;MoveWay_1="right";ISL_ScrDown_1();MoveTimeObj_1=setInterval('ISL_ScrDown_1()',Speed_1)}
function ISL_StopDown_1(){if(MoveWay_1 == "left"){return};clearInterval(MoveTimeObj_1);if(GetObj('ISL_Cont_1').scrollLeft%PageWidth_1-(fill_1>=0?fill_1:fill_1+1)!=0){Comp_1=PageWidth_1-GetObj('ISL_Cont_1').scrollLeft%PageWidth_1+fill_1;CompScr_1()}else{MoveLock_1=false}
AutoPlay_1()}
function ISL_ScrDown_1(){if(GetObj('ISL_Cont_1').scrollLeft>=GetObj('List1_1').scrollWidth){GetObj('ISL_Cont_1').scrollLeft=GetObj('ISL_Cont_1').scrollLeft-GetObj('List1_1').scrollWidth}
GetObj('ISL_Cont_1').scrollLeft+=Space_1}
function CompScr_1(){if(Comp_1==0){MoveLock_1=false;return}
var num,TempSpeed=Speed_1,TempSpace=Space_1;if(Math.abs(Comp_1)<PageWidth_1/2){TempSpace=Math.round(Math.abs(Comp_1/Space_1));if(TempSpace<1){TempSpace=1}}
if(Comp_1<0){if(Comp_1<-TempSpace){Comp_1+=TempSpace;num=TempSpace}else{num=-Comp_1;Comp_1=0}
GetObj('ISL_Cont_1').scrollLeft-=num;setTimeout('CompScr_1()',TempSpeed)}else{if(Comp_1>TempSpace){Comp_1-=TempSpace;num=TempSpace}else{num=Comp_1;Comp_1=0}
GetObj('ISL_Cont_1').scrollLeft+=num;setTimeout('CompScr_1()',TempSpeed)}}
function picrun_ini(){
GetObj("List2_1").innerHTML=GetObj("List1_1").innerHTML;
GetObj('ISL_Cont_1').scrollLeft=fill_1>=0?fill_1:GetObj('List1_1').scrollWidth-Math.abs(fill_1);
GetObj("ISL_Cont_1").onmouseover=function(){clearInterval(AutoPlayObj_1)}
GetObj("ISL_Cont_1").onmouseout=function(){AutoPlay_1()}
AutoPlay_1();
}
//展示滚动图片结束
//-->

function Marquee(){this.ID=document.getElementById(arguments[0]);if(!this.ID){alert('æ‚¨è¦è®¾ç½®çš„"'+arguments[0]+'"åˆå§‹åŒ–é”™è¯¯\r\nè¯·æ£€æŸ¥æ ‡ç­¾IDè®¾ç½®æ˜¯å¦æ­£ç¡®!');this.ID=-1;return}this.Direction=this.Width=this.Height=this.DelayTime=this.WaitTime=this.CTL=this.StartID=this.Stop=this.MouseOver=0;this.Step=1;this.Timer=30;this.DirectionArray={top:0,up:0,bottom:1,down:1,left:2,right:3};if(typeof arguments[1]=="number"||typeof arguments[1]=="string"){this.Direction=arguments[1]}if(typeof arguments[2]=="number"){this.Step=arguments[2]}if(typeof arguments[3]=="number"){this.Width=arguments[3]}if(typeof arguments[4]=="number"){this.Height=arguments[4]}if(typeof arguments[5]=="number"){this.Timer=arguments[5]}if(typeof arguments[6]=="number"){this.DelayTime=arguments[6]}if(typeof arguments[7]=="number"){this.WaitTime=arguments[7]}if(typeof arguments[8]=="number"){this.ScrollStep=arguments[8]}this.ID.style.overflow=this.ID.style.overflowX=this.ID.style.overflowY="hidden";this.ID.noWrap=true;this.IsNotOpera=(navigator.userAgent.toLowerCase().indexOf("opera")==-1);if(arguments.length>=7){this.Start()}}Marquee.prototype.Start=function(){if(this.ID==-1){return}if(this.WaitTime<800){this.WaitTime=800}if(this.Timer<20){this.Timer=20}if(this.Width==0){this.Width=parseInt(this.ID.style.width)}if(this.Height==0){this.Height=parseInt(this.ID.style.height)}if(typeof this.Direction=="string"){this.Direction=this.DirectionArray[this.Direction.toString().toLowerCase()]}this.HalfWidth=Math.round(this.Width/2);this.HalfHeight=Math.round(this.Height/2);this.BakStep=this.Step;this.ID.style.width=this.Width+"px";this.ID.style.height=this.Height+"px";if(typeof this.ScrollStep!="number"){this.ScrollStep=this.Direction>1?this.Width:this.Height}var d="<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;display:inline;'><tr><td noWrap=true style='white-space: nowrap;word-break:keep-all;'>MSCLASS_TEMP_HTML</td><td noWrap=true style='white-space: nowrap;word-break:keep-all;'>MSCLASS_TEMP_HTML</td></tr></table>";var b="<table cellspacing='0' cellpadding='0' style='border-collapse:collapse;'><tr><td>MSCLASS_TEMP_HTML</td></tr><tr><td>MSCLASS_TEMP_HTML</td></tr></table>";var e=this;e.tempHTML=e.ID.innerHTML;if(e.Direction<=1){e.ID.innerHTML=b.replace(/MSCLASS_TEMP_HTML/g,e.ID.innerHTML)}else{if(e.ScrollStep==0&&e.DelayTime==0){e.ID.innerHTML+=e.ID.innerHTML}else{e.ID.innerHTML=d.replace(/MSCLASS_TEMP_HTML/g,e.ID.innerHTML)}}var f=this.Timer;var a=this.DelayTime;var c=this.WaitTime;e.StartID=function(){e.Scroll()};e.Continue=function(){if(e.MouseOver==1){setTimeout(e.Continue,a)}else{clearInterval(e.TimerID);e.CTL=e.Stop=0;e.TimerID=setInterval(e.StartID,f)}};e.Pause=function(){e.Stop=1;clearInterval(e.TimerID);setTimeout(e.Continue,a)};e.Begin=function(){e.ClientScroll=e.Direction>1?e.ID.scrollWidth/2:e.ID.scrollHeight/2;if((e.Direction<=1&&e.ClientScroll<=e.Height+e.Step)||(e.Direction>1&&e.ClientScroll<=e.Width+e.Step)){e.ID.innerHTML=e.tempHTML;delete(e.tempHTML);return}delete(e.tempHTML);e.TimerID=setInterval(e.StartID,f);if(e.ScrollStep<0){return}e.ID.onmousemove=function(g){if(e.ScrollStep==0&&e.Direction>1){var g=g||window.event;if(window.event){if(e.IsNotOpera){e.EventLeft=g.srcElement.id==e.ID.id?g.offsetX-e.ID.scrollLeft:g.srcElement.offsetLeft-e.ID.scrollLeft+g.offsetX}else{e.ScrollStep=null;return}}else{e.EventLeft=g.layerX-e.ID.scrollLeft}e.Direction=e.EventLeft>e.HalfWidth?3:2;e.AbsCenter=Math.abs(e.HalfWidth-e.EventLeft);e.Step=Math.round(e.AbsCenter*(e.BakStep*2)/e.HalfWidth)}};e.ID.onmouseover=function(){if(e.ScrollStep==0){return}e.MouseOver=1;clearInterval(e.TimerID)};e.ID.onmouseout=function(){if(e.ScrollStep==0){if(e.Step==0){e.Step=1}return}e.MouseOver=0;if(e.Stop==0){clearInterval(e.TimerID);e.TimerID=setInterval(e.StartID,f)}}};setTimeout(e.Begin,c)};Marquee.prototype.Scroll=function(){switch(this.Direction){case 0:this.CTL+=this.Step;if(this.CTL>=this.ScrollStep&&this.DelayTime>0){this.ID.scrollTop+=this.ScrollStep+this.Step-this.CTL;this.Pause();return}else{if(this.ID.scrollTop>=this.ClientScroll){this.ID.scrollTop-=this.ClientScroll}this.ID.scrollTop+=this.Step}break;case 1:this.CTL+=this.Step;if(this.CTL>=this.ScrollStep&&this.DelayTime>0){this.ID.scrollTop-=this.ScrollStep+this.Step-this.CTL;this.Pause();return}else{if(this.ID.scrollTop<=0){this.ID.scrollTop+=this.ClientScroll}this.ID.scrollTop-=this.Step}break;case 2:this.CTL+=this.Step;if(this.CTL>=this.ScrollStep&&this.DelayTime>0){this.ID.scrollLeft+=this.ScrollStep+this.Step-this.CTL;this.Pause();return}else{if(this.ID.scrollLeft>=this.ClientScroll){this.ID.scrollLeft-=this.ClientScroll}this.ID.scrollLeft+=this.Step}break;case 3:this.CTL+=this.Step;if(this.CTL>=this.ScrollStep&&this.DelayTime>0){this.ID.scrollLeft-=this.ScrollStep+this.Step-this.CTL;this.Pause();return}else{if(this.ID.scrollLeft<=0){this.ID.scrollLeft+=this.ClientScroll}this.ID.scrollLeft-=this.Step}break}};
