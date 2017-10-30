<!DOCTYPE html>
<html>
<head>
	<title>Items</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" >
	<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>

	

</head>
<body>

	<div class="container"><!-- Start of container -->
		<h1>Inventory</h1>
		<p>Manage your items.</p>


		
		<div class="row">
			<div class="col-sm-3">
				<button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#additemModal">Add new Item</button><p></p>		<!-- Trigger the modal with a button -->
			</div>
			<div class="col-sm-6">
				<input type="button"  class='btn btn-primary pull-right' onclick="printDiv('printArea')" value="Print Report!" />

			</div>
			<div class="col-sm-3">
				
				<div class="form-group">
					<div class="input-group">
						<span class="input-group-addon">Search</span>
						<input type="text" name="search_text" id="search_text" placeholder="Item Name or Description" class="form-control" />
					</div>
				</div>
			</div>
		</div>


		<div id="printArea">
			
			<table id="itemtable" class="table table-condensed">	<!-- Start of Table -->
				<thead>
					<tr>
						<th class="col-md-1">ItemID</th>
						<th class="col-md-2">Item Name</th>
						<th class="col-md-3">Item Description</th>
						<th class="col-md-1">Item Brand</th>
						<th class="col-md-1" >Item Price</th>
						<th class="col-md-1">Item Quantity</th>
						<th class="col-md-2">Date Added</th>
						<th class="col-md-1">Action</th>
					</tr>


				</thead>
				<tbody id="itemsbody"></tbody>
			</table>


		</div>

		<!-- End of Table -->

		<!-- Add Item Modal -->
		<div id="additemModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Add new Item</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" id="add-form">
							<div class="form-group">
								<label class="control-label col-sm-2" for="iname">Item Name:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="iname" placeholder="Enter Item Name" name="name">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="description">Description:</label>
								<div class="col-sm-10">
									<textarea class="form-control custom-control" rows="5" style="resize:none" placeholder="Enter Item Description" name="description"></textarea>
								</div>
							</div>



							<div class="form-group">
								<label class="control-label col-sm-2" for="brand">Brand:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="brand" placeholder="Enter Item Brand" name="brand">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="price">Price:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="price" placeholder="Enter Item Price" name="price">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="quantity">Quantity:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="quantity" placeholder="Enter Item Quantity" name="quantity">
								</div>
							</div>
							<input type = "hidden" name = "action" value = "addItem">


						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>


					</form>
				</div>

			</div>
		</div>




		<!-- Update Modal -->
		<div id="updateItemModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Update Item</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" id="update-form">
							<div class="form-group">
								<label class="control-label col-sm-2" for="u_name">Item Name:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="u_name" placeholder="Enter Item Name" name="name">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="u_description">Description:</label>
								<div class="col-sm-10">
									<textarea class="form-control custom-control" rows="5" style="resize:none" placeholder="Enter Item Description" name="description" id="u_description"></textarea>
								</div>
							</div>



							<div class="form-group">
								<label class="control-label col-sm-2" for="u_brand">Brand:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="u_brand" placeholder="Enter Item Brand" name="brand">
								</div>
							</div>
							<div class="form-group">
								<label class="control-label col-sm-2" for="u_price">Price:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="u_price" placeholder="Enter Item Price" name="price">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-sm-2" for="u_quantity">Quantity:</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="u_quantity" placeholder="Enter Item Quantity" name="quantity">
								</div>
							</div>
							<input type = "hidden" id = "u_id" name = "u_id" >
							<input type = "hidden" name = "action" value = "updateItem">


						</div>
						<div class="modal-footer">
							<button type="submit" class="btn btn-primary">Submit</button>
							<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>


					</form>
				</div>

			</div>
		</div>



		<!-- Delete Modal-->
		<div id="deleteModal" class="modal fade" role="dialog">
			<div class="modal-dialog">

				<!-- Modal content-->
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Delete Item</h4>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete this item?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger yes" >Yes</button>
						<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
					</div>
				</div>

			</div>
		</div>





	</div>	<!-- End of container -->

	<script type="text/javascript">

		function printDiv(divName) {


			var newWindow = window.open();
			var doc  = newWindow.document;
			doc.write("<html><head>" +
			"<title>Report</title>" + 
			"<link rel=\'stylesheet\' type=\'text/css\' href=\'../css/bootstrap.min.css\' >" + "<style type=\'text/css\'>" + 
			"@media print {table td:last-child {display:none}table th:last-child {display:none}	html, body { display: block; }	}"+
			"</style>"+
			"</head><body>" +
			"<h1>Products</h1><br>"  +document.getElementById(divName).innerHTML  + "</body></html>");
			setTimeout(function(){newWindow.print(); newWindow.close(); }, 100);
			
		}




		//When the Html or Document Loads, Load the datas in table.
		$(document).ready(function(){
			function showData()
			{ 
				$.ajax({

					url: 'productFunction.php',
					type: 'POST',
					data: {action : 'showItem'},
					dataType: 'html',
					success: function(result)
					{
						$('#itemsbody').html(result);
					},
					error: function()
					{
						alert('failed!');
					}
				})
			}
			showData();



			var searchreq = null;
			function load_data(query)
			{
				if (searchreq != null) searchreq.abort();
				searchreq = $.ajax({
					url:"searchproduct.php",
					method:"GET",
					data:{query:query},
					success:function(data)
					{
						$('#itemsbody').html(data);
					}
				});
			}
			$('#search_text').keyup(function(){
				var search = $(this).val();
				if(search != '')
				{
					load_data(search);
				}
				else
				{
					showData();

				}
			});




		});




		//Add Form submit handler
		$('#add-form').submit(function(e){

			e.preventDefault();

			$.ajax({

				url: 'productFunction.php',
				type: 'POST',
				data: $(this).serialize(),
				dataType: 'html',
				success: function(result)
				{
					$('#itemsbody').html(result);
					$('#additemModal').modal('toggle');


				},
				error: function()
				{
					alert('failed!');
				}
			})
		});




		function deleteItem(id)
		{

			$("#deleteModal").modal("show");
			$('.yes').click(function(e){

				$.ajax({

					url : 'productFunction.php',
					type : 'POST',
					data : {action : 'deleteItem', id : id},
					dataType: 'html',

					success: function(result)
					{
						$('#itemsbody').html(result);
						$("#deleteModal").modal("hide");

					}
				})

			})
		}


		function updateItem(id)
		{
			$("#updateItemModal").modal("show");

			$.ajax({

				url : 'productFunction.php',
				type : 'POST',
				data : {id : id, action : 'showUpdateItem'},
				dataType: 'json',
				success : function(result)
				{
					$('#u_name').val(result.name);
					$('#u_description').val(result.description);
					$('#u_price').val(result.price);
					$('#u_brand').val(result.brand);
					$('#u_quantity').val(result.quantity);
					$('#u_id').val(id);
				}
			})

			$('#update-form').submit(function(e){

				e.preventDefault();

				$.ajax({

					url: 'productFunction.php',
					type: 'POST',
					data: $(this).serialize(),
					dataType: 'html',
					success: function(result)
					{
						$('#itemsbody').html(result);
						$("#updateItemModal").modal("hide");

					},
					error: function()
					{
						alert('failed!');
					}
				})
			}); 
		} 




	</script>

</body>
</html>