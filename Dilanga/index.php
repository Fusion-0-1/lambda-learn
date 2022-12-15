<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>Login</title>
  <link rel="stylesheet" href="./login.css">

</head>
<body>

<div class="box-form">
	<div class="left">
		<div class="overlay">
		</div>
	</div>
	
	
	<div class="right">
			<img src="images/loginlogo.png">
			
			<h1>Login</h1>

			<form action="login.php" method="POST">

			<?php if (isset($_GET['error'])) { ?>
				<p class="error"><?php echo $_GET['error']; ?></p>
			<?php } ?>
			
			<div class="inputs">
				<input type="text" name="username" placeholder="User name">
				<br>
				<input type="password" name="password" placeholder="Password">
			</div>
				
				<br>
				
			<div class="forgot-password">
				<p>Forgot Password?</p>
			</div>
				
				<br>
				<button type="submit">Login</button>
			</form>
	</div>
	
</div>
  
</body>
</html>
