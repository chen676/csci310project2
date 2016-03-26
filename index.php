<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
		<link rel="stylesheet" href="loginPageStyle.css">

		<script>
			function httpGet(theUrl){
				var xmlHttp = new XMLHttpRequest();
				xmlHttp.open( "GET", theUrl, false ); // false for synchronous request
				xmlHttp.send( null );
				var string = JSON.stringify(xmlHttp.responseText);
				console.log(string);
				return xmlHttp.responseText;
			}
		</script>

	</head>

   <body>

		<div class = "widget" id="login">
			<h1>Welcome to BudgetMe!</h1><br>
			<h2>Login</h2> <br>
			<form action="loginScript.php" method = "POST">
				Username:<input type="text" name = "user" required><br><br>
				Password:<input type="password" name = "password" required><br><br>
				<input type="submit" value="Login">
			</form>
		</div>

	</body>
</html>	
