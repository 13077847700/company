<!DOCTYPE html>
<html lang="en">
<head>
	<base href="<?php echo base_url();?>"/>

	<meta charset="utf-8">
	<meta name="renderer" content="webkit" />
	<!--<meta http-equiv="X-UA-Compatible" content="IE=edge">-->
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title><?= WEB_SITE_TITLE ?></title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="public/Resources/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
	<!-- Ionicons -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
	<!-- Theme style -->
	<link rel="stylesheet" href="public/Resources/dist/css/AdminLTE.min.css">
	<!-- iCheck -->
	<link rel="stylesheet" href="public/Resources/plugins/iCheck2/square/blue.css">

	<style>
		.login-page,.register-page
		{
			background:#768AB3;
		}

		.form-control
		{
			height : 40px;
		}

		.form-group
		{
			margin-bottom : 20px;
		}
	</style>
</head>
<body class="hold-transition login-page">
	<div class="login-box">
		<!--logo-->
		<div class="login-logo">
			<a href="http://www.mediav.cn/" target="_blank"><img src="public/Resources/dist/img/logo.png" title="logo"></a>
		</div>

		<div class="login-box-body" style="background-color:#eeeeee;border-radius:5px;box-shadow: 0px 0px 10px rgba(0,0,0,0.5);">
			<p class="login-box-msg" style="font-size:30px;">登录</p>

			<form action="<?php echo site_url('admin/Login/dologin') ?>" class="form-horizontal form-data" method="post" id="form">
				<div class="form-group has-feedback">
					<div class="col-sm-12">
						<input type="text" id="username" name="username" class="form-control" placeholder="请输入用户名" value='' />
						<span class="glyphicon glyphicon-user form-control-feedback" style="top:4px;"></span>
					</div>
				</div>

				<div class="form-group has-feedback">
					<div class="col-sm-12">
						<input type="password" id="password" name="password" class="form-control" placeholder="请输入密码" value='' />
						<span class="glyphicon glyphicon-lock form-control-feedback" style="top:4px;"></span>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-6">
						<input type="text" id="code" name="code" class="form-control" placeholder="请输入验证码" value='' />
					</div>
					<div class="col-sm-6 click-update">
						<img src="<?php echo site_url('admin/Login/code') ?>" title="点击刷新" onclick="this.src=this.src+'?'+Math.random()" >
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-6">
						<div class="checkbox icheck">
				            <input type="checkbox" name="remember"> <span>记住密码</span>
				        </div>
					</div>

					<div class="col-sm-6">
				        <button class="btn btn-primary btn-block btn-flat submit" type="button">提交登陆</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<!-- jQuery -->
	<script src="public/Resources/js/jquery.min.js"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="public/Resources/js/bootstrap.min.js"></script>
	<!-- iCheck -->
	<script src="public/Resources/plugins/iCheck2/icheck.min.js"></script>
	<!-- layer-->
	<script src="public/layer/layer.js"></script>

	<script>
		$(document).ready(function(){

			$('input').iCheck({
		    	checkboxClass: 'icheckbox_square-blue',
			    radioClass: 'iradio_square-blue',
			    increaseArea: '20%' // optional
		    });

		    $(this).keydown(function (e){
		    	if(e.which == "13")
		    	{
		    		$('.submit').click();
		    	}
		    })

			$('.submit').click(function(){
				var username = $('#username').val();
				var password = $('#password').val();
				var code = $('#code').val();

				if($.trim(username) == '')
		        {
		          	layer.tips('用户名不能为空！', '#username', {
		                tips : [1, '#3595CC'],
		                time : 2000
		            });
		            return;
		        }
		        else if(password == '')
		        {
		        	layer.tips('密码不能为空！', '#password', {
		                tips : [1, '#3595CC'],
		                time : 2000
		            });
		            return;
		        }
		        else if(code == '')
		        {
		        	layer.tips('验证码不能为空！', '#code', {
		                tips : [1, '#3595CC'],
		                time : 2000
		            });
		            return;
		        }

		        url = "<?php echo site_url('admin/Login/check_user') ?>";

		        $.ajax({
		        	url : url,
					type : "POST",
					data : 
					{
						username : username,
						password : password,
						code : code
					},
					dataType : "json",
					success : function(data){	

						if(data.status == 1)
						{
							$('.click-update').children('img').trigger('onclick');

							layer.tips('验证码不正确！', '#code', {
				                tips : [1, '#3595CC'],
				                time : 2000
				            });
				            return;
						}
						else if(data.status == 2)
						{
							layer.tips('用户名或密码不正确！', '#username', {
				                tips : [1, '#3595CC'],
				                time : 2000
				            });
				            return;
						}
						else if(data.status == 3)
						{
							layer.tips('该用户已被禁用！', '#username', {
				                tips : [1, '#3595CC'],
				                time : 2000
				            });
				            return;
						}
						else if(data.status == 0)
						{
							$("#form").submit();
						}		
					}
		        })
			})
		})
	</script>

</body>
</html>