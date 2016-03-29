		<meta name="csrf-token" content="{{ csrf_token() }}">
		<script src="http://code.jquery.com/jquery-1.8.3.min.js"></script>
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
					$.ajaxSetup({
					  headers: {
					    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					  }
					});
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
