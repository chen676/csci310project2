

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
             					url: '/clickBudgetButton',
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