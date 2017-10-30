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
  <style type="text/css">
   body { padding-right: 0 !important }
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
      <h2>Purchase Orders </h2>
      <div class="clearfix"></div>
    </div>
    <div class="x_content">
      <div class="row">
       <div class="col-sm-6">

        <!-- Trigger the modal with a button -->
      </div>
      <div class="col-sm-1">

      </div>
      <div class="col-sm-5">
        <div class="form-group">
         <div class="input-group">
          <span class="input-group-addon">Search</span>
          <input type="text" name="search_text" id="search_text" placeholder="Purchase Order Number / Supplier" class="form-control" />
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
       <th>Purchase Order #</th>
       <th>Supplier</th>
       <th>Prepared By</th>
       <th>Checked By</th>
       <th>Expected Delivery</th>
       <th>Date Prepared</th>
        <th>Status</th>
       <th class="col-md-2">Action</th>
     </tr>
   </thead>
   <tbody id="pobody"></tbody>
 </table>
</div>
</div>
</div>
</div>
<!-- End of Table -->
<!-- Add Item Modal -->
<div id="addadminModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
   <div class="modal-header modal-header-info">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Add new Stock</h4>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="add-form" enctype="multipart/form-data">
     <div class="form-group">
      <label class="control-label col-sm-2" for="sname">Supplier Name:</label>
      <div class="col-sm-10">
       <input type="text" class="form-control" id="sname" placeholder="Enter Supplier Name" name="sname" required="">
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
<!-- Update Modal -->
<div id="updateStockModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
   <div class="modal-header modal-header-info">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Update Stock</h4>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="update-form">
     <div class="form-group">
      <label class="control-label col-sm-2" for="u_sname">Selling Price:</label>
      <div class="col-sm-10">
       <input type="text" class="form-control" id="u_sname" placeholder="Enter Supplier Name" name="u_sname" required="">
     </div>
   </div>
   <input type = "hidden" id = "u_id" name = "u_id" >
   <input type = "hidden" name = "action" value = "updateAdmin">
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




<div id="sliparea" style="visibility: hidden;
position: absolute;
top: -9999px;">
<center><strong>Company Name</strong> </center>
<center>Company Address</center>
<center>Email</center>
<center>Phone #</center>
<center> <strong>Purchase Order #: -----------</strong> </center>
<center>Date Prepared</center>

<table style=" width:100%; margin-top: 20px; " >
  <tr>
    <th>Product</th> 
    <th >Qty</th>
  </tr>
</table>

<hr style="height:1px;border:none;color:#333;background-color:#333;" />

<table style=" width:100%; margin-top: 20px;" >

  <tr>
    <td><strong>Supplier Name: </strong></td>
    <td>--------------</td>
  </tr>
  <tr>
    <td><strong>Supplier Receiver: </strong></td>
    <td>--------------</td>
  </tr>
    <tr>
    <td><strong>Supplier Address: </strong></td>
    <td>--------------</td>
  </tr>

    <tr>
    <td><strong>Supplier Contact: </strong></td>
    <td>--------------</td>
  </tr>



</table>
<hr style="height:1px;border:none;color:#333;background-color:#333;" />
</div>






<script type="text/javascript">





    function printslip(idToPrint)
    { 
      $.ajax({

       url: 'purchaseorders/pofunctions.php',
       type: 'POST',
       data: {action : 'printslip', id: idToPrint},
       dataType: 'html',
       success: function(result)
       {
        $('#sliparea').html(result);

        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title>' + document.title  + '</title>');
        mywindow.document.write('</head><style> hr { display: block; height: 1px; background: transparent; width: 100%; border: none; border-top: solid 1px #aaa; } </style><body >');
        mywindow.document.write(document.getElementById('sliparea').innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10*/

        mywindow.print();
        mywindow.close();



      },
      error: function(xhr, status, error)
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
</script>


<script type="text/javascript">


         $(document).ready(function(){
            showPurchaseOrders();


          var searchreq = null;
          function load_data(query)
          {
            if (searchreq != null) searchreq.abort();
            searchreq = $.ajax({
              url:"purchaseorders/searchpo.php",
              method:"GET",
              data:{query:query},
              success:function(data)
              {
                $('#pobody').html(data);
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
              showPurchaseOrders();

            }
          });


         });




    function showPurchaseOrders()
         { 
           $.ajax({
         
            url: 'purchaseorders/pofunctions.php',
            type: 'POST',
            data: {action : 'showPurchaseOrders'},
            dataType: 'html',
            success: function(result)
            {
             $('#pobody').html(result);
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

</script>
</body>
</html>