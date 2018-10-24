<html>
	<head>
		<title>喜豆商家营销管理后台</title>
		<link rel="icon" href="/img/logo.ico" type="image/x-icon">
	<style>
		body{
			background:white;
			margin:0;
		}
		.half{
			background:#60A4FE;
			height:50%;
		}
		.input-div{
			background:white;
			box-shadow: #57A0FF 0px 0px 16px 0px;
			border-radius:4px;
			width:520px;
			padding:40px 38px;
			position: absolute;
			margin: auto;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
		}
		.login{
			height: 280px;
		}
		.form-group{
			margin-bottom: 18px;
		}
		.input-div input{
			padding:20px 23px;
			width:100%;
			height:57px;
			display: block;
			border-radius:3px;
			border-right: 0;
			border: 1px solid #ccc;
			font-size: 16px;
		}
		.login_button{
			width:100%;
			height:56px;
			background:#60A4FE;
			border:1px solid #60A4FE;
			border-radius:3px;
			color:white;
			font-size:18px;
			margin-top:14px;
		}
		.login-foget{
			float:right;
			color:#666666;
			cursor:pointer;
			margin-top:20px;
		}
		.reset{
			display:none;
			height:372px;
		}
		.code-div{
			position:relative;
		}
		.code-button{
			position: absolute;
			top: 10px;
			right: 15px;
			font-size:16px;
			padding:7px 10px;
			background:#60A4FE;
			border-radius:3px;
			border:1px solid #60A4FE;
			color:white;
		}
		.top{
			position: absolute;
			text-align:center;
			margin: auto;
			top: -142px;
			left: 0;
			right: 0;
			bottom: 34px;
		}
		.top-img{

		}
		.top-text{
			color:white;
			font-size:18px;
			margin-top:10px;
		}
		.login .top{
			bottom:333px;
		}
		.reset .top{
			bottom:448px;
		}

		.validator{
			height: 22px;
			/* padding-left: 20px; */
			display: none;
			margin-top: 5px;
		}
		.validator-text{
			color: #dd514c;
			font-size: 14px;
			vertical-align: top;
			margin-left: 5px;
		}

		.tip-container{
			position: fixed;
			z-index: 999;
			pointer-events: none;
			left: 0;
			top: 20%;
			width: 100%;
			display: none;
		}
		.tip-error{
			max-width: 200px;
			margin: 0 auto;
			height: 24px;
			text-align: center;
			position: relative;
			display: flex;
			align-items: center;
			justify-content: center;
			pointer-events: auto;
			overflow: hidden;
			padding: 10px 0px;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
			border-radius: 3px;
			-moz-box-shadow: 0 0 12px #999;
			-webkit-box-shadow: 0 0 12px #999;
			box-shadow: 0 0 12px #999;
			background: #BD362F;
			color: #FFF;
			opacity: .8;
			-ms-filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=80);
			filter: alpha(opacity=80);
		}
		.tip-error-msg{
			word-wrap: break-word;
			font-size: 14px;
			line-height: 20px;
			margin-left: 15px;
		}
	</style>
	</head>
	<body>
		<div class="half">

		</div>
		<div class="tip-container">
			<div class="tip-error">
				<img src="/img/main/icon_error.png"/>
				<span class="tip-error-msg"></span>
			</div>
		</div>
		<div class="input-div login">
			<div class="top">
				<div class="top-img"><img src="img/logo.png"></div>
				<div class="top-text">喜豆商家营销管理后台</div>
			</div>
			<form action="/api/login" method="post" class="login_from">
				<div class="form-group">
					<input type="text" placeholder="手机号" name="phone" id="phone"/>
					<div class="validator">
						<img src="/img/main/icon_warning.png" alt="">
						<span class="validator-text">手机号不能为空</span>
					</div>
				</div>
				<div class="form-group">
					<input type="password" placeholder="账户密码" name="password" id="password"/>
					<div class="validator">
						<img src="/img/main/icon_warning.png" alt="">
						<span class="validator-text">密码不能为空</span>
					</div>
				</div>
				<button class="login_button login_submit" type="button">登录</button>
				<div class="login-foget">
					<span class="foget">忘记密码?</span>
				</div>
			</form>
		</div>
		<div class="input-div reset">
			<div class="top">
				<div class="top-img"><img src="img/logo.png"></div>
				<div class="top-text">喜豆商家营销管理后台</div>
			</div>
			<form id="login_by_code">
				<div class="form-group">
					<input type="text" placeholder="输入手机号" name="phone" id="phone_1"/>
				</div>
				<div class="form-group">
					<div class="code-div">
						<button type="button" class="code-button">获取验证码</button>
						<input type="text" placeholder="输入验证码" name="code" id="validator_code"/>
					</div>
				</div>
				<div class="form-group">
					<input type="password" placeholder="设置新密码" name="password" id="password1"/>
				</div>
				<div class="form-group">
					<input type="password" placeholder="再次确认新密码" name="repeatPassword" id="re_password1"/>
				</div>
				<button class="login_button reset_submit" type="button">登录</button>
			</form>
		</div>
		<div class="footer">
		</div>
		<script src="js/jquery-2.1.1.js"></script>
		<script>
			function showErrorMsg (e) {
				$(".tip-error").text(e)
				$(".tip-container").fadeIn()
				setTimeout(function () {
					$(".tip-container").fadeOut()
				}, 2000)
			}
			$('.foget').click(function(){
				$('.reset').show();
				$('.login').hide();
			})
			$('.login_submit').click(function(){
				if ($("#phone").val() == null || $("#phone").val() == '') {
					$("#phone").siblings(".validator").show()
					return false;
				}
				$("#phone").siblings(".validator").hide()
				if ($("#password").val() == null || $("#password").val() == '') {
					$("#password").siblings(".validator").show()
					return false;
				}
				$("#password").siblings(".validator").hide()
				$.ajax({
					url: "{{ url('/api/login') }}",
					dataType: 'json',
					data:{
						phone:$('#phone').val(),
						password:$('#password').val()
					},
					type: 'post',
					success: function(response){
						if(response.code== 200){
							window.location.href="/" 
						}else{
							showErrorMsg(response.message)
						} 
					},
					error: function(e) {
						console.log(e);
					}
				}).always(function(){
				});
			})
			$('.reset_submit').click(function(){
				
				$.ajax({
					url: "{{ url('/api/login/code') }}",
					dataType: 'json',
					data:$('#login_by_code').serialize(),
					type: 'post',
					success: function(response){
						if(response.code== 200){
							window.location.href="/" 
						}else{
							console.error(response.message);
						}
					},
					error: function(e) {
						console.log(e);
					}
				}).always(function(){
				});
			})
			$('.code-button').click(function(){
				$.ajax({
					url: "{{ url('/api/login/sendCode') }}",
					dataType: 'json',
					data:{
						phone:$('#phone_1').val(),
					},
					type: 'post',
					success: function(response){
						if(response.code == '200'){
							console.log('send success');
						}else{
							console.error(response.message);
						}
						// window.location.href="/" 
					},
					error: function(e) {
						console.log(e);
					}
				}).always(function(){
				});
			})
		</script>
	</body>
</html>