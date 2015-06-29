<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Авторизация</title>
<link rel="stylesheet" href="/css_admin/screen.css" type="text/css" media="screen" title="default" />
<!--  jquery core -->
<script src="/js_admin/jquery/jquery-1.4.1.min.js" type="text/javascript"></script>

<!-- Custom jquery scripts -->
<script src="/js_admin/jquery/custom_jquery.js" type="text/javascript"></script>

<!-- MUST BE THE LAST SCRIPT IN <HEAD></HEAD></HEAD> png fix -->
<script src="/js_admin/jquery/jquery.pngFix.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
$(document).pngFix( );
});
</script>
</head>
<body id="login-bg">

<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<a href="index.html"><img src="/images/shared/logo.png" width="156" height="40" alt="" /></a>
	</div>
	<!-- end logo -->

	<div class="clear"></div>

	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
<form method="post" action="/admin">
	<!--  start login-inner -->
	<div id="login-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Email</th>
			<td><input type="text"  class="login-inp" name="email" value="<?php echo set_value('email');?>" id="email"/></td>
		</tr>
		<tr>
			<th>Password</th>
			<td><input type="password" value="<?php echo set_value('password');?>" class="login-inp" name="password" id="password"/></td>
		</tr>
		<tr>
			<th></th>
			<td valign="top"><?=form_error('password')?></td>
		</tr>
		<tr>
			<th></th>
			<td><input type="submit" class="submit-login" name="add" /></td>
		</tr>
	</form>
		</table>
	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>

 </div>
 <!--  end loginbox -->

	<!--  start forgotbox ................................................................................... -->
	<div id="forgotbox">
		<div id="forgotbox-text">Please send us your email and we'll reset your password.</div>
		<!--  start forgot-inner -->
		<div id="forgot-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Email address:</th>
			<td><input type="text" value=""   class="login-inp" /></td>
		</tr>
		<tr>
			<th> </th>
			<td><input type="button" class="submit-login"  /></td>
		</tr>
		</table>
		</div>
		<!--  end forgot-inner -->
		<div class="clear"></div>
		<a href="" class="back-login">Back to login</a>
	</div>
	<!--  end forgotbox -->

</div>
<!-- End: login-holder -->
</body>
</html>
