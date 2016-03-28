<!DOCTYPE html>
<html lang="en-US">

	<body>

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>

		<div id="BudgetDiv"> 
			<table width="100%">
				<tr>
					<td>Name1</td>
				</tr>
				<tr>
					<td>Name1</td>
				</tr>
				<tr>
					<td>Name1</td>
				</tr>
				<tr>
					<td>Name1</td>
				</tr>
				<tr>
					<td>Name1</td>
				</tr>
				<tr>
					<td>Name1</td>
				</tr>
				<tr>
					<td>Name1</td>
				</tr>
				<tr>
					<td>Name1</td>
					<td><input type="text" id="name1input"></td>
					<td><button id="name1button">Button1</button></td>

					<script type="text/javascript">
						$("#name1button").click(function()
           				{
             				$.ajax({
             					type: "POST",
             					url: './clickBudgetButton',
             					data:"",
             					success: function() {
             						alert("button clicked");
             					}
             				})


          				 }
      				);
					</script>
				</tr>
			</table>
		</div>
	</body>