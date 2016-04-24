<?php
require("header.php");
?>

<div class="container">
	<div class="col-md-6 well" style="margin:20px auto; float:none;">
		<form action="/login" method="post">
			<?php echo csrf_field(); ?>
			<?php if (session('loginErrors')) : ?>
				<div class="alert alert-danger">
					<p>Email or password is incorrect. Please try again.</p>
					<?php if (session('loginErrors') >= 4) : ?>
						<p id="timeLeft"></p>
					<?php endif ?>
				</div>
			<?php endif ?>
			<div class="form-group">
				<input id='loginErrorsHiddenForm' type="hidden" name="loginErrors" value="<?php echo Session::get('loginErrors'); ?>" >
				<label class="control-label" for="email">Email: </label>
				<input class="form-control" id="loginUserField" type="text" name="email">
			</div>
			<div class="form-group">
				<label class="control-label" for="password">Password: </label>
				<input class="form-control" id="loginPasswordField" type="password" name="password">
			</div>
			<button class="btn btn-success" id="loginSubmitButton" type="submit">Login</button>

		</form>
	</div>
</div>

<script type="text/javascript">
	<?php if(session('loginErrors') >= 4): ?>
			document.getElementById('loginSubmitButton').disabled = 'disabled';
		    setTimeout (function(){
		    	document.getElementById('loginSubmitButton').disabled = null;
		    	<?php Session::put('loginErrors', 0); ?>
		    },60000);
	<?php endif ?>


    var countdownNum = 60;
    incTimer();

    function incTimer(){
        setTimeout (function(){
            if(countdownNum > 0){
	            countdownNum--;
	            document.getElementById('timeLeft').innerHTML = 'You have tried to login too many times, please wait ' + countdownNum + ' seconds.';
	            incTimer();
            } 
            else {
            	document.getElementById('timeLeft').innerHTML = '';
				//after 60 seconds from loading the page, reset login attempts to 0
				<?php Session::put('loginErrors', 0); ?>
            }
        },1000);
    }

</script>


</body>
</html>
