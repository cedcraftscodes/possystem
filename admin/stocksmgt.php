<?php include 'auth.php'; ?> 
<?php include 'accountinfo.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
   <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
   <!-- Meta, title, CSS, favicons, etc. -->
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <title>Admin Panel | POS</title>
   <!-- Bootstrap -->
   <link href="../vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
   <!-- Font Awesome -->
   <link href="../vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
   <!-- NProgress -->
   <link href="../vendors/nprogress/nprogress.css" rel="stylesheet">
   <!-- iCheck -->
   <link href="../vendors/iCheck/skins/flat/green.css" rel="stylesheet">
   <!-- bootstrap-progressbar -->
   <link href="../vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
   <!-- JQVMap -->
   <link href="../vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
   <!-- bootstrap-daterangepicker -->
   <link href="../vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
   <!-- My Modal Stylesheet -->
   <link rel="stylesheet" type="text/css" href="../build/css/modalstyle.css">
   <!-- Custom Theme Style -->
   <link href="../build/css/custom.min.css" rel="stylesheet">


  <link rel="stylesheet" type="text/css" href="../vendors/jquery/dist/jquery-ui.css">



   <style type="text/css">
      body { padding-right: 0 !important }
      
  .ui-autocomplete {
    z-index: 10000000;
  }
   </style>
</head>
<body class="nav-md">
   <div class="container body">
      <div class="main_container">
         <div class="col-md-3 left_col">
            <div class="left_col scroll-view">
               <div class="navbar nav_title" style="border: 0;">
                  <a href="index.php" class="site_title"><i class="fa fa-shopping-cart"></i> <span>Sales | Inventory</span></a>
               </div>
               <div class="clearfix"></div>
               <?php include('templates/admin.quickinfo.php'); ?> 
               <br />
               <?php include('templates/admin.sidebar.php'); ?> 
               <?php include('templates/admin.menufooter.php'); ?> 
            </div>
         </div>
         <?php include('templates/admin.topnav.php'); ?>
         <!-- page content -->
         <div class="right_col" role="main">
            <div class="container">
               <div class="x_panel">
                  <div class="x_title">
                     <h2>Stocks Management </h2>
                     <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                     <div class="row">
                        <div class="col-sm-3">
                           <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addStockModal">Add new Stock</button>
                           <p></p>
                           <!-- Trigger the modal with a button -->
                        </div>
                        <div class="col-sm-5">

                        </div>
                        <div class="col-sm-4">
                           <div class="form-group">
                              <div class="input-group">
                                 <span class="input-group-addon">Search</span>
                                 <input type="text" name="search_text" id="search_text" placeholder="Name of Supplier / Product" class="form-control" />
                              </div>
                           </div>
                        </div>
                     </div>
                     <div id="printArea">
                        <div class="table-responsive">
                           <table id="itemtable" class="table table-condensed">
                              <!-- Start of Table -->
                              <thead>
                                 <tr>
                                    <th>Stock ID</th>
                                    <th>Product Name</th>
                                    <th>Supplier</th>
                                    <th>Supplier Price</th>
                                    <th>Selling Price</th>
                                    <th>Quantity</th>
                                    <th>Date Added</th>
                                    <th class="col-md-3">Action</th>
                                 </tr>
                              </thead>
                              <tbody id="itemsbody"></tbody>
                           </table>
                        </div>
                     </div>
                  </div>
               </div>
               <!-- End of Table -->
               <!-- Add Item Modal -->
               <div id="addStockModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                     <!-- Modal content-->
                     <div class="modal-content">
                        <div class="modal-header modal-header-info">
                           <button type="button" class="close" data-dismiss="modal">&times;</button>
                           <h4 class="modal-title">Add new Stock</h4>
                        </div>
                        <div class="modal-body">
                           <form class="form-horizontal" id="addstock-form" enctype="multipart/form-data">

                            <div class="form-group">
                             <label class="control-label col-sm-3" for="cboproducts">Product Name:</label>
                             <div class="col-sm-9">
                              <select class="form-control" id="cboproducts" name="cboproducts">
                              </select>
                           </div>
                        </div>


                        <div class="form-group">
                          <label class="control-label col-sm-3" for="cbosupplier">Supplier:</label>
                          <div class="col-sm-9">
                           <select class="form-control" id="cbosupplier" name="cbosupplier">
                           </select>
                        </div>
                     </div>

                     <div class="form-group">
                       <label class="control-label col-sm-3" for="cboproducts">Markup Percentage:</label>
                       <div class="col-sm-9">
                          <label class="control-label" id="markuppercent">0 %:</label>
                       </select>
                    </div>
                 </div>


                 <div class="form-group">
                    <label class="control-label col-sm-3" for="supplierprice">Supplier Price:</label>
                    <div class="col-sm-9">
                     <input type="number" class="form-control" id="supplierprice"  title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onkeyup="setTwoNumberDecimal()" min="0" step="0.01" value="0.00" name="supplierprice">
                  </div>
               </div>

               <div class="form-group">
                 <label class="control-label col-sm-3" for="sellingprice">Selling Price:</label>
                 <div class="col-sm-9">
                    <label class="control-label" id="sellingprice">0</label>
                 </div>
              </div>


              <div class="form-group">
                 <label class="control-label col-sm-3" for="stockqty">Quantity:</label>
                 <div class="col-sm-9">
                  <input type="number" class="form-control" id="stockqty"  min=1 name="stockqty" onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
               </div>
            </div>

            <input type = "hidden" name = "action" value = "addStock">
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
         <div class="modal-header modal-header-danger">
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
</div>
<!-- End of container -->
</div>
</div>
<!-- /page content -->
<?php include('templates/admin.footer.php'); ?>
</div>
</div>
<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>

<!-- Bootstrap -->
<script src="../vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="../vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="../vendors/nprogress/nprogress.js"></script>
<!-- Chart.js -->
<script src="../vendors/Chart.js/dist/Chart.min.js"></script>
<!-- gauge.js -->
<script src="../vendors/gauge.js/dist/gauge.min.js"></script>
<!-- bootstrap-progressbar -->
<script src="../vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
<!-- iCheck -->
<script src="../vendors/iCheck/icheck.min.js"></script>
<!-- Skycons -->
<script src="../vendors/skycons/skycons.js"></script>
<!-- Flot -->
<script src="../vendors/Flot/jquery.flot.js"></script>
<script src="../vendors/Flot/jquery.flot.pie.js"></script>
<script src="../vendors/Flot/jquery.flot.time.js"></script>
<script src="../vendors/Flot/jquery.flot.stack.js"></script>
<script src="../vendors/Flot/jquery.flot.resize.js"></script>
<!-- Flot plugins -->
<script src="../vendors/flot.orderbars/js/jquery.flot.orderBars.js"></script>
<script src="../vendors/flot-spline/js/jquery.flot.spline.min.js"></script>
<script src="../vendors/flot.curvedlines/curvedLines.js"></script>
<!-- DateJS -->
<script src="../vendors/DateJS/build/date.js"></script>
<!-- JQVMap -->
<script src="../vendors/jqvmap/dist/jquery.vmap.js"></script>
<script src="../vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
<script src="../vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="../vendors/moment/min/moment.min.js"></script>
<script src="../vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- Custom Theme Scripts -->
<script src="../build/js/custom.min.js"></script>

<link rel="stylesheet" type="text/css" href="./css/footable.standalone.min.css">
<script src="./js/footable.js" type="text/javascript"></script>




<div class="modal fade" id="msgmodal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
         <div id="msgmodalheader" class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
            <h4 class="modal-title" id="msgtitle"></h4>
         </div>
         <div class="modal-body">
            <p id="modalmsg"></p>
         </div>
         <div class="modal-footer">
            <button type="button" id="msgmodalbtn" class="btn btn-danger pull-right" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>

<!-- Update Modal -->
<div id="stockOutModal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Stock Out</h4>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" id="stockout-form">
              <div class="form-group">
               <label class="control-label col-sm-3" for="u_sname">Stock ID:</label>
               <div class="col-sm-9">
                  <label id="soId"> </label>
               </div>
            </div>

            <div class="form-group">
               <label class="control-label col-sm-3" for="u_sname">Product Name:</label>
               <div class="col-sm-9">
                  <label id="soProductName"> </label>
               </div>
            </div>
            <div class="form-group">
               <label class="control-label col-sm-3" for="u_sname">Product Quantity:</label>
               <div class="col-sm-9">
                  <label id="soQuantity"> </label>
               </div>
            </div>

            <div class="form-group">
               <label class="control-label col-sm-3" for="u_sname">Product Price:</label>
               <div class="col-sm-9">
                  <label id="soProductPrice"> </label>
               </div>
            </div>

            <div class="form-group">
               <label class="control-label col-sm-3" for="u_sname">Quantity:</label>
               <div class="col-sm-9">
                  <input type="Number" class="form-control" id="u_quantity" placeholder="Enter stock out quantity" name="u_quantity" required="">
               </div>
            </div>
            <input type = "hidden" id = "u_sid" name = "u_sid" >
            <input type = "hidden" name = "action" value = "stockOut">
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Stock Out</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
      </form>
   </div>
</div>
</div>


<!-- Update Modal -->
<div id="stockUpdateModal" class="modal fade" role="dialog">
   <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Update Stock</h4>
         </div>
         <div class="modal-body">
            <form class="form-horizontal" id="updatestock-form">
              <div class="form-group">
               <label class="control-label col-sm-3" for="suId">Stock ID:</label>
               <div class="col-sm-9">
                  <label id="suId"> </label>
               </div>
            </div>

            <div class="form-group">
               <label class="control-label col-sm-3" for="suProductName">Product Name:</label>
               <div class="col-sm-9">
                  <label id="suProductName"> </label>
               </div>
            </div>

            <div class="form-group">
               <label class="control-label col-sm-3" for="suSupplier">Supplier Name:</label>
               <div class="col-sm-9">
                  <label id="suSupplier"> </label>
               </div>
            </div>


            <div class="form-group">
               <label class="control-label col-sm-3" for="suSupPrice">Supplier Price:</label>
               <div class="col-sm-9">
                  <label id="suSupPrice"> </label>
               </div>
            </div>

            <div class="form-group">
               <label class="control-label col-sm-3" for="su_quantity">Quantity:</label>
               <div class="col-sm-9">
                  <input type="Number" class="form-control" id="su_quantity" placeholder="Enter stock out quantity" name="su_quantity" required="">
               </div>
            </div>

            <div class="form-group">
               <label class="control-label col-sm-3" for="su_quantity">Remarks:</label>
               <div class="col-sm-9">
                  <input type="text" class="form-control" id="su_remarks" placeholder="Enter Remarks" name="su_remarks" required="">
               </div>
            </div>

            
            <div class="form-group">
            <label class="control-label col-sm-3" for="su_quantity">Liable:</label>
               <div class="col-sm-9">
                  <input type="text" class="form-control" id="su_liable" placeholder="Enter Name" name="su_liable" required="">
               </div>
            </div>



            <input type = "hidden" id = "su_id" name = "su_id" >
            <input type = "hidden" name = "action" value = "updateStock">
         </div>
         <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Update Stock</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
         </div>
      </form>
   </div>
</div>
</div>





<script type="text/javascript">

   $('#quantity').on('change keyup', function() {
    var sanitized = $(this).val().replace(/[^0-9]/g, '');
    $(this).val(sanitized);
 });


   $('#u_quantity').on('change keyup', function() {
    var sanitized = $(this).val().replace(/[^0-9]/g, '');
    $(this).val(sanitized);
 });

   $('#su_quantity').on('change keyup', function() {
    var sanitized = $(this).val().replace(/[^0-9]/g, '');
    $(this).val(sanitized);
 });

   function setTwoNumberDecimal(event) {
     this.value = parseFloat(this.value).toFixed(2);
  }

  $(document).ready(function(){


loadAccountAutoComplete();


   function showStocks()
   { 
     $.ajax({

      url: 'stocksmgt/stockmgt.php',
      type: 'POST',
      data: {action : 'showStocks'},
      dataType: 'html',
      success: function(result)
      {
       $('#itemsbody').html(result);
    },
    error: function()
    {
       $('#msgtitle').text('Something Went Wrong!');
       $('#modalmsg').text('Please contant administrator for assistance!');
       $('#msgmodalbtn').text('Close');
       $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
       $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
       $('#msgmodal').modal('show');

    }
 })
  }


function loadAccountAutoComplete(){

  $.ajax({

    url : 'stocksmgt/stockmgt.php',
    type : 'POST',
    data : {action : 'showAccountsComplete'},
    dataType: 'json',
    success : function(result)
    {

      $("#su_liable").autocomplete({
        source: result
      });

    },
    error: function()
    {
      $('#msgtitle').text('Something Went Wrong!');
      $('#modalmsg').text('Please contant administrator for assistance!');
      $('#msgmodalbtn').text('Close');
      $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
      $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
      $('#msgmodal').modal('show');

    }
  });
}




  function loadSuppliers()
  { 
     $.ajax({

       url: 'stocksmgt/stockmgt.php',
       type: 'POST',
       data: {action : 'loadSuppliers'},
       dataType: 'html',
       success: function(result)
       {
         $('#cbosupplier').html(result);
      },
      error: function(xhr, status, error)
      {
         alert(xhr.responseText);
         $('#msgtitle').text('Something Went Wrong!');
         $('#modalmsg').text('Please contant administrator for assistance!');
         $('#msgmodalbtn').text('Close');
         $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
         $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');

         $('#msgmodal').modal('show');

      }
   });
  }


  function loadProducts()
  { 
     $.ajax({

       url: 'stocksmgt/stockmgt.php',
       type: 'POST',
       data: {action : 'loadProducts'},
       dataType: 'html',
       success: function(result)
       {

         $('#cboproducts').html(result);
         $( "#cboproducts" ).change();
      },
      error: function(xhr, status, error)
      {
         alert(xhr.responseText);
         $('#msgtitle').text('Something Went Wrong!');
         $('#modalmsg').text('Please contant administrator for assistance!');
         $('#msgmodalbtn').text('Close');
         $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
         $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');

         $('#msgmodal').modal('show');

      }
   });
  }


  $( "#cboproducts" ).change(function() {
     var id = $('#cboproducts').val();
     $.ajax({
      url : 'stocksmgt/stockmgt.php',
      type : 'POST',
      data : {pid : id, action : 'showMarkupPercent'},
      dataType: 'json',
      success : function(result)
      {
       $('#markuppercent').text(result.markup +" %");
       computeSellingPrice();
    },
    error: function()
    {
       $('#msgtitle').text('Something Went Wrong!');
       $('#modalmsg').text('Please contant administrator for assistance!');

       $('#msgmodalbtn').text('Close');
       $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');

       $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');

       $('#msgmodal').modal('show');

    }
 });
  });


  $("#supplierprice").bind('keyup input', function(){

   computeSellingPrice();
});



  function computeSellingPrice(){
    var supprice = $("#supplierprice").val();
    var id = $('#cboproducts').val();
    $.ajax({
      url : 'stocksmgt/stockmgt.php',
      type : 'POST',
      data : {pid : id, supplier_price:supprice, action : 'computeSellingPrice'},
      dataType: 'json',
      success : function(result)
      {
       $('#sellingprice').text(result.sellingprice);
    },
    error: function(a)
    {
       $('#msgtitle').text('Something Went Wrong!');
       $('#modalmsg').text('Please contant administrator for assistance!');
       $('#msgmodalbtn').text('Close');
       $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
       $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
       $('#msgmodal').modal('show');

    }
 });

 }




 $('#addstock-form').submit(function(e){
   e.preventDefault();

   var formData = new FormData(this);

   $.ajax({
    url: 'stocksmgt/stockmgt.php',
    type: 'POST',
    cache: false,
    data: formData,
    async: false,
    processData: false,
    contentType: false,
    dataType: 'html',
    success: function(result)
    {
     $('#itemsbody').html(result);
     $('#addStockModal').modal('toggle');
  },
  error: function()
  {
     $('#msgtitle').text('Something Went Wrong!');
     $('#modalmsg').text('Please contant administrator for assistance!');

     $('#msgmodalbtn').text('Close');
     $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');

     $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');

     $('#msgmodal').modal('show');
  }
})
});


 showStocks();
 //setInterval(function(){ showStocks(); }, 3000);

 loadSuppliers();
 loadProducts();



 var searchreq = null;
 function load_data(query)
 {
  if (searchreq != null) searchreq.abort();
  searchreq = $.ajax({
    url:"stocksmgt/searchstock.php",
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
    showStocks();

 }
});





});





function removeStock(id)
{

   $("#deleteModal").modal("show");
   $('.yes').click(function(e){

    $.ajax({

     url : 'stocksmgt/stockmgt.php',
     type : 'POST',
     data : {action : 'deleteStock', id : id},
     dataType: 'html',

     success: function(result)
     {
      $('#itemsbody').html(result);
      $("#deleteModal").modal("hide");





   },
   error: function()
   {
      $('#msgtitle').text('Something Went Wrong!');
      $('#modalmsg').text('Please contant administrator for assistance!');

      $('#msgmodalbtn').text('Close');
      $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');

      $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');

      $('#msgmodal').modal('show');

   }
})

 })
}





function stockOut(id)
{
  $("#stockOutModal").modal("show");

  $.ajax({

   url : 'stocksmgt/stockmgt.php',
   type : 'POST',
   data : {id : id, action : 'showStockOutProduct'},
   dataType: 'json',
   success : function(result)
   {

    $('#soId').text(result.soId);
    $('#soProductName').text(result.soProductName);
    $('#soQuantity').text(result.soQuantity);
    $('#soProductPrice').text("₱ "+result.soProductPrice);
    $('#u_sid').val(id);



 },
 error: function()
 {
    $('#msgtitle').text('Something Went Wrong!');
    $('#modalmsg').text('Please contant administrator for assistance!');

    $('#msgmodalbtn').text('Close');
    $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');

    $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');

    $('#msgmodal').modal('show');

 }
});

  $('#stockout-form').submit(function(e){
   e.preventDefault();
   $.ajax({
    url: 'stocksmgt/stockmgt.php',
    type: 'POST',
    data: $(this).serialize(),
    dataType: 'html',
    success: function(result)
    {
     $('#itemsbody').html(result);
     $("#stockOutModal").modal("hide");
  },
  error: function(x,y,z)
  {
     $('#msgtitle').text('Something Went Wrong!');
     $('#modalmsg').text('Please contant administrator for assistance!');
     $('#msgmodalbtn').text('Close');
     $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
     $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
     $('#msgmodal').modal('show');
  }
})
}); 
}

function updateStocks(id)
{
  $("#stockUpdateModal").modal("show");

  $.ajax({

   url : 'stocksmgt/stockmgt.php',
   type : 'POST',
   data : {id : id, action : 'showUpdateStocks'},
   dataType: 'json',
   success : function(result)
   {
    $('#su_id').val(id);
    $('#suProductName').text(result.suProductName);
    $('#suSupplier').text(result.suSupplier);
    $('#suSupPrice').text("₱ " + result.suSupPrice);
    $('#su_quantity').val(result.su_quantity);
    $('#suId').text(id);

 },
 error: function(a)
 {
    $('#msgtitle').text('Something Went Wrong!');
    $('#modalmsg').text('Please contant administrator for assistance!');

    $('#msgmodalbtn').text('Close');
    $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');

    $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');

    $('#msgmodal').modal('show');

 }
});

  $('#updatestock-form').submit(function(e){
   e.preventDefault();
   $.ajax({
    url: 'stocksmgt/stockmgt.php',
    type: 'POST',
    data: $(this).serialize(),
    dataType: 'html',
    success: function(result)
    {
     $('#itemsbody').html(result);
     $("#stockUpdateModal").modal("hide");
  },
  error: function(x,y,z)
  {
     $('#msgtitle').text('Something Went Wrong!');
     $('#modalmsg').text('Please contant administrator for assistance!');
     $('#msgmodalbtn').text('Close');
     $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
     $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
     $('#msgmodal').modal('show');
  }
})
}); 
}

/*
   jQuery(function($){
      $('.table').footable();
   });

   */


</script>
</body>
</html>