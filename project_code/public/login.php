<?php 
/*
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>	
	<link rel="stylesheet" type="text/css" href="../css/main.css">
</head>
<body>
*/
	?>
	<script src="http://crypto-js.googlecode.com/svn/tags/3.1.2/build/rollups/sha1.js"></script>
	<script type="text/javascript">

		function login(){
			
			var pass = document.getElementById("password").value;
			document.getElementById("password").value = CryptoJS.SHA1(pass);
			
			document.getElementById("login").submit();
		}
	</script>
	<div id="loginform">
		<?php
		if($login_error == true){
			echo '<div id="loginerror">Error in unsername,password or role selected</div>';
		}
		?>
		<form id="login" action=<?php echo '"http://'.$_SERVER['HTTP_HOST'].'/~unn_w12038150/"'; ?> method="post">
			<div class="label">Username: </div><div class="forminput"><input name="username" type="text" /></div><br/>
			<div class="label">Password: </div><div class="forminput"><input id="password" name="password" type="password" title="Please Enter Your Password"/></div><br/>
			<input type="hidden" name="loginform" value="1" />
			<div id="roleselect">
				<select name="role">
					<option value="1">Admin</option>
					<option value="2">Editor</option>
					<option value="3">Reporter</option>
					<option value="4">Reader</option>
				</select></div><br>
				<div class="button" style="margin-left:77%;margin-bottom:5px;"><input type="button" value="Login" onclick="login()"/></div>
			</form>
		</div>
		<?php
/*
</body>
</html>
*/
?>
