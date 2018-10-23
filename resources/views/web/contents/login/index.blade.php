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
			height:257px;
		}
		.input-div input{
			padding:20px 23px;
			width:100%;
			height:57px;
			margin-bottom:19px;
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
	</style>
	</head>
	<body>
		<div class="half">

		</div>
		<div class="input-div login">
			<div class="top">
				<div class="top-img"><img src="img/logo.png"></div>
				<div class="top-text">喜豆商家营销管理后台</div>
			</div>
			<form action="/api/login" method="post" class="login_from">
				<input type="text" placeholder="手机号" name="phone" id="phone"/>
				<input type="password" placeholder="账户密码" name="password" id="password"/>
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
			<form>
				<input type="text" placeholder="输入手机号" name="phone"/>
				<div class="code-div">
					<button type="button" class="code-button">获取验证码</button>
					<input type="text" placeholder="输入验证码" name="code"/>
				</div>
				<input type="password" placeholder="设置新密码" name="password"/>
				<input type="password" placeholder="再次确认新密码" name="repeatPassword"/>
				<button class="login_button reset_submit" type="button">登录</button>
			</form>
		</div>
		<div class="footer">
		</div>
		<script src="js/jquery-2.1.1.js"></script>
		<script>
		$('.foget').click(function(){
			$('.reset').show();
			$('.login').hide();
		})
		$('.login_submit').click(function(){
			console.log(1);
			$.ajax({
				url: "{{ url('/api/login') }}",
				dataType: 'json',
				data:{
					phone:$('#phone').val(),
					password:$('#password').val()
				},
				type: 'post',
				success: function(response){
					// console.log(123123);
					window.location.href="/" 
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