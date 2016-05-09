<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta http-equiv=”Content-Type” content=”text/html; charset=UTF-8″ />
</head>
<script charset="UTF-8" type="text/javascript">
var now_p = 0;
var speed = 0;
$(document).ready(function(){
	$("#main_frame_2").load("classes_view.php?search=数据");
	$("#cla_2 a").click(function(){
		if (now_p != 5){
			$("#main_frame_2").load("classes_view.php?search=数据院");
			$("#main_frame_2").hide();
			$("#main_frame_2").fadeIn(speed);
			var self=$("#cla_2"); 
			self.parent().find('.active').removeClass('active'); 
			self.addClass('active');
		}
		now_p = 5;
		return false;
	});
	$("#cla_1 a").click(function(){
		if (now_p != 6){
			$("#main_frame_2").load("classes_view.php?search=数计院");
			$("#main_frame_2").hide();
			$("#main_frame_2").fadeIn(speed);
			var self=$("#cla_1"); 
			self.parent().find('.active').removeClass('active'); 
			self.addClass('active');
		}
		now_p = 6;
		return false;
	});
	$("#cla_3 a").click(function(){
		if (now_p != 7){
			$("#main_frame_2").load("classes_view.php?search=移动学院");
			$("#main_frame_2").hide();
			$("#main_frame_2").fadeIn(speed);
			var self=$("#cla_3"); 
			self.parent().find('.active').removeClass('active'); 
			self.addClass('active');
		}
		now_p = 7;
		return false;
	});
});
</script>

<!--全部班级-->
<div class="bs-callout bs-callout-info">
	<h4 style="display:inline-block;">全部班级</h4>
</div>
<ul class="nav nav-pills" >
	<li class="active" id="cla_2"><a href="#">数据院</a></li>
	<li class="" id="cla_1"><a href="#">数计院</a></li>
	<li class="" id="cla_3"><a href="#">移动学院</a></li>
</ul>
<br><br>
<div name = "main_frame_2" id = "main_frame_2" data-target="#navbarEx" data-offset = "0">

</div>
</html>
