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
   .invoice-title h2, .invoice-title h3 {
     display: inline-block;
   }
   .table > tbody > tr > .no-line {
     border-top: none;
   }
   .table > thead > tr > .no-line {
     border-bottom: none;
   }
   .table > tbody > tr > .thick-line {
     border-top: 2px solid;
   }
   @media (min-width: 992px) {
     .equal{  
       display: -ms-flexbox;
       display: -webkit-flex;
       display: flex;
     }
   }
   .panel {
     width: 100%;
     height: 90%;
   }
 </style>

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
    <div class="col-md-8">
     <div class="row equal">
      <div class="col-md-6">
       <div class="panel panel-default">
        <div class="panel-heading">
         <h3 class="panel-title"><strong>Scan Barcode</strong></h3>
       </div>
       <div class="panel-body">
         <form id="bcodeform" method="POST">
          <div class="input-group">
           <input type="text" class="form-control" name="bcode" id="bcode" placeholder="Barcode" >
           <input type="hidden" name="action" value="addbcode">
           <span class="input-group-btn">
             <button class="btn btn-default" type="submit" >Submit</button>
           </span>
         </div>
       </form>
     </div>
   </div>
 </div>
 <div class="col-md-6">
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title"><strong>Total</strong></h3>
   </div>
   <div class="panel-body">
     <h1>₱ <label id="totalbig">0.00</label></h1>
   </div>
 </div>
</div>
</div>
<div class="row">
  <div class="col-md-12">
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title"><strong>Order summary</strong></h3>
   </div>
   <div class="panel-body">
     <div class="table-responsive">
      <table class="table table-condensed">
       <thead>
        <tr>
         <td><button type='button' class='btn btn-sm btn-default' aria-label='Close'>&times</button></td>
         <td><strong>ItemCode</strong></td>
         <td><strong>Item Name</strong></td>
         <td class="text-center"><strong>Price</strong></td>
         <td class="text-center"><strong>Quantity</strong></td>
         <td class="text-right"><strong>Totals</strong></td>
       </tr>
     </thead>
     <tbody id="productsTable">
     </tbody>
   </table>
 </div>
 <div id="product">
 </div>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-4">
 <div class="row">
  <div class="col-md-12">
   <div class="panel panel-default">
    <div class="panel-heading">
     <h3 class="panel-title"><strong>Invoice Number: </strong> <label id="InvoiceNo">0000000</label></h3>
   </div>
   <div class="panel-body">
     <h4><strong>Staff Information</strong></h4>
     <p>Name: <?php echo $_SESSION['fullname']; ?></p>
     <p>Position: Admin </p>
     <h4><strong>Transaction Details</strong></h4>
     <p>Total Items: <span class="pull-right"><label id="NoOfItems">0</label></span></p>
     <p>VAT Tax: <span class="pull-right"><label id="VatTax">0</label></span></p>
     <p>VATable: <span class="pull-right"><label id="Vatable">0</label></span></p>
     <p>Total: <span class="pull-right"><label id="Total">0</label></span></p>
     <hr>
     <a class="btn btn-app pull-right" id="btnsettle">
       <i class="fa fa-cart-arrow-down"></i> Settle Payment
     </a>

      <a onclick="pricechk()" class="btn btn-app pull-right" id="btnpricechk">
       <i class="fa fa-money"></i> Price Checker
     </a>


   </div>
 </div>
</div>
</div>
</div>
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
<!-- jQuery Sparklines -->
<script src="../vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
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
<div id="updateQuantityModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
   <div class="modal-header modal-header-info">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Update Quantity</h4>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="update-form">
     <div class="form-group">
      <label class="control-label col-sm-2" for="u_sname">Product Name:</label>
      <div class="col-sm-10">
       <input type="text" class="form-control" id="pname" readonly="" name="pname" required="">
     </div>
   </div>
   <div class="form-group">
    <label class="control-label col-sm-2" for="u_sname">Price:</label>
    <div class="col-sm-10">
     <input type="text" class="form-control" id="price" readonly="" name="u_sname" required="">
   </div>
 </div>
 <div class="form-group">
  <label class="control-label col-sm-2" for="u_sname">Quantity:</label>
  <div class="col-sm-10">
   <input type="number" class="form-control" oninput="validity.valid||(value='');" min=1 id="quantity"  name="quantity" required="">
 </div>
</div>
<input type = "hidden" id = "barcode" name = "barcode" >
<input type = "hidden" name = "action" value = "setQuantity">
</div>
<div class="modal-footer">
 <button type="submit" class="btn btn-primary">Submit</button>
 <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
</div>
</form>
</div>
</div>
</div>
<div id="settlePaymentModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
   <div class="modal-header modal-header-info">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Settle Payment</h4>
  </div>
  <div class="modal-body">
    <form class="form-horizontal" id="settle-form">
     <h4><strong>Customer Information</strong></h4>
     <label>Customer Name:</label>
     <input type="text" class="form-control" id="customername"  name="customername" placeholder="Enter Customer Name (Optional)">
     <br>
     <label>Address: </label>
     <input type="text" class="form-control" id="custaddress"  name="custaddress" placeholder="Enter Customer Address (Optional)">
     <br>



     <h4><strong>Payment Information</strong></h4>
     <br>
     <label>Total: </label>
     <h4 class="pull-right" id="totalsettle"> --------- </h4>
     <br>
     <label>Payment: </label>
     <div class="row">
      <a class="btn btn-app pull-right" onclick="setCashTendered(1000)" style="background-color: #6697b2; color: white;">
        <i class="fa fa-money"></i> 1000
      </a>          
      <a class="btn btn-app pull-right" onclick="setCashTendered(500)"style="background-color: #dabb4a; color: white;">
        <i class="fa fa-money"></i> 500
      </a>
      <a class="btn btn-app pull-right" onclick="setCashTendered(200)" style="background-color: #6b9661; color: white;">
        <i class="fa fa-money"></i> 200
      </a>
      <a class="btn btn-app pull-right" onclick="setCashTendered(100)" style="background-color: #3f74a5; color: white;">
        <i class="fa fa-money"></i> 100
      </a>
      <a class="btn btn-app pull-right" onclick="setCashTendered(50)" style="background-color: #d6826b; color: white;">
        <i class="fa fa-money"></i> 50
      </a>
      <a class="btn btn-app pull-right" onclick="setCashTendered(20)" style="background-color: #e89713; color: white;">
        <i class="fa fa-money"></i> 20
      </a>
    </div>
    <input type="number" class="form-control pull-right" id="cashtendered"  title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onkeyup="setTwoNumberDecimal()" min=0 step="0.01" oninput="validity.valid||(value='');" value="0.00" style="text-align:right;" name="cashtendered" placeholder="Cash Tendered">

    <br>



    <br>
    <h4><strong>Manager Discount</strong></h4>

    <div class="checkbox">
      <label><input type="checkbox" value="1" id="chkmngdiscount" name="chkmngdiscount">Apply Manager Discount</label>
    </div>
    <br>


    <div id="mgrdiscountdiv"> 
       <label>Manager Name:</label>

       <select class="form-control" id="cboadmins" name="cboadmins">
       </select>
       </br>
       <input type="password" class="form-control" id="mngpass"  name="mngpass" placeholder="Manager Password">
      <br>
      <input type="number" class="form-control pull-right" id="discount"  title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onkeyup="setTwoNumberDecimal()" min=0 step="0.01" oninput="validity.valid||(value='');" value="0.00" style="text-align:right;" name="discount" placeholder="Manager Discount">
      <br>
    </div>
    <br>
    <label>Change: </label>
    <h4 class="pull-right" id="changesettle">P 0.00</h4>
    <br>
    <input type = "hidden" name = "total" id="totalsettlehidden" value = "0">
    <input type = "hidden" name = "action" value = "settleTransaction">
  </div>
  <div class="modal-footer">
   <button type="submit" class="btn btn-primary" id="btnfinalize" disabled="">Submit</button>
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
    <h4 class="modal-title">Delete Order</h4>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to delete this order?</p>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-danger yes" >Yes</button>
    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
  </div>
</div>
</div>
</div>
<!-- Delete Modal-->
<div id="voidModal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
   <div class="modal-header modal-header-danger">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Void Transaction</h4>
  </div>
  <div class="modal-body">
    <p>Are you sure you want to void current transaction?</p>
  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-danger yes" >Yes</button>
    <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
  </div>
</div>
</div>
</div>


<div id="pricheckermodal" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
   <div class="modal-header modal-header-info">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Price Checker</h4>
  </div>
  <div class="modal-body">
    <form id="pricechk-form" method="POST">
      <div class="input-group">
       <input type="text" class="form-control" name="pricechk-bcode" id="pricechk-bcode" placeholder="Barcode" >
       <input type="hidden" name="action" value="pricecheck">
       <span class="input-group-btn">
         <button class="btn btn-default" type="submit" >Submit</button>
       </span>
     </div>
   </form>
 </div>
 <div class="modal-footer">
  <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>
</div>
</div>
</div>

<div id="pricheckermodalresult" class="modal fade" role="dialog">
 <div class="modal-dialog">
  <!-- Modal content-->
  <div class="modal-content">
   <div class="modal-header modal-header-info">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Price Checker</h4>
  </div>
  <div class="modal-body">

    <div class="row">
      <div class="col-md-5">
        <label>Product Name</label>
      </div>

      <div class="col-md-7">
        <p id="pchk-prodname"></p>
      </div>
    </div>

    <div class="row">
      <div class="col-md-5">
        <label>Product Price</label>
      </div>

      <div class="col-md-7">
        <p id="pchk-prodprice"></p>
      </div>
    </div>



    <div class="row">
      <div class="col-md-5">
      <label>Quantity</label>
      </div>

      <div class="col-md-7">
        <p id="pchk-quantity"></p>
      </div>
    </div>






  </div>
  <div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
  </div>
</div>
</div>
</div>
<script type="text/javascript">
  function printReceipt(idToPrint)
  { 

    $.ajax({

     url: 'transaction/transaction.php',
     type: 'POST',
     data: {action : 'printReceipt', id: idToPrint},
     dataType: 'html',
     success: function(result)
     {
      $('#receiptarea').html(result);

      var mywindow = window.open('', 'PRINT', 'height=400,width=600');

      mywindow.document.write('<html><head><title>' + document.title  + '</title>');
      mywindow.document.write('</head><style> hr { display: block; height: 1px; background: transparent; width: 100%; border: none; border-top: solid 1px #aaa; } </style><body >');
      mywindow.document.write(document.getElementById('receiptarea').innerHTML);
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

<div id="receiptarea" style="visibility: hidden;
position: absolute;
top: -9999px;">
<center><strong>Company Name</strong> </center>
<center>Company Address</center>
<center>Email</center>
<center>Phone #</center>
<center> <strong>Transaction #: -----------</strong> </center>
<center> <strong>OR Number #: 0000</strong> </center>
<center>Transaction Date</center>
<table style=" width:100%; margin-top: 20px; " >
  <tr>
    <th>Product</th> 
    <th >Qty</th>
    <th>Price</th> 
    <th ">Total</th>
  </tr>
</table>
<hr style="height:1px;border:none;color:#333;background-color:#333;" />

<table style="width:100%; margin-top: 20px;" >
  <tr>
    <td>VaT Tax</td>
    <td>----------</td>
  </tr>
  <tr>
    <td>Vatable</td>
    <td>----------</td>

  </tr>
  <tr>
    <td>Change</td>
    <td>----------</td>
  </tr>
  <tr>
    <td><strong>Total</strong></td>
    <td><strong>----------</strong></td>
  </tr>
</table>

<hr style="height:1px;border:none;color:#333;background-color:#333;" />

<table style=" width:100%; margin-top: 20px;" >

  <tr>
    <td><strong>Customer Name: </strong></td>
    <td>--------------</td>
  </tr>
  <tr>
    <td><strong>Customer Address: </strong></td>
    <td>--------------</td>

  </tr>
</table>
<hr style="height:1px;border:none;color:#333;background-color:#333;" />
<center><strong>Thank you! Come Again!</strong></center>
</div>





<script>
  function setTwoNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(2);
  }
  function setFocusToBCode(){
   document.getElementById("bcode").focus();
 }
 setFocusToBCode();

          /*
         //Prevent Barcode To lose Focus
         $('#bcode').blur(function(){
           $(this).focus();
         });
         
         */
       </script>
       <script type="text/javascript">
         var cashtendered = 0;
         var total = 0;
         var truetotal = 0;
         var change = 0;
         


         $(document).ready(function(){



          $("#mgrdiscountdiv").hide(); 
          $('#chkmngdiscount').change(function() {
              if(this.checked) {
                $("#mgrdiscountdiv").show(); 
              }else{
                $("#mgrdiscountdiv").hide();             
              }
          });

          loadAdmins();
          loadOrders();
          loadTransactionInfo();



           $('#btnsettle').click(function() {
            $('#settlePaymentModal').modal('show');
            loadTransactionInfo();
          });



           $('#cashtendered').keyup(function() {
             computeChange(cashtendered = $('#cashtendered').val());
           });


           $('#discount').keyup(function() {
             computeChange(cashtendered = $('#cashtendered').val());


            var hasDiscount = $('#chkmngdiscount').is(":checked");
            var discount = 0;

               if(hasDiscount){
                discount = $('#discount').val();
                 total = truetotal - discount;
                 var vvtax = total / 1.12 * .12 ;
                $('#VatTax').text(vvtax.toFixed(2));
                $('#Vatable').text(total - vvtax);
               }

               
               $('#totalbig').text(total);
               $('#totalsettle').text('₱ ' + total);
               $('#totalsettlehidden').val(total);
               $('#Total').text(total);
           });


           $('#cashtendered').change(function() {
             computeChange(cashtendered = $('#cashtendered').val());
           });

           $('#change').keyup(function() {
             computeChange(cashtendered = $('#cashtendered').val());
           });

           $('#pricechk-form').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
             url: 'possystem.php',
             type: 'POST',
             cache: false,
             data: formData,
             async: false,
             processData: false,
             contentType: false,
             dataType: 'json',
             success: function(response)
             { 

              if(response.success == true){
                $('#pricechk-bcode').val("");
                $('#pricheckermodal').modal('toggle');
                $('#pricheckermodalresult').modal('toggle');
                $('#pricecheck-bcode').text('');
                $('#pchk-prodname').text(response.pname);
                $('#pchk-prodprice').text("₱ " + response.price);
                $('#pchk-quantity').text(response.qout);
                $("#bcode").focus();

              }else{
                $('#pricechk-bcode').val("");
                $('#pricheckermodal').modal('toggle');
                $('#msgtitle').text('Error!');
                $('#modalmsg').text(response.message);
                $('#msgmodalbtn').text('Close');
                $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
                $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
                $('#msgmodal').modal('show');  

                $("#bcode").focus();

              }

            },
            error: function(a,b,c)
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




           
           $('#settle-form').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $('#btnfinalize').attr('disabled', true);

            $.ajax({
             url: 'possystem.php',
             type: 'POST',
             cache: false,
             data: formData,
             async: false,
             processData: false,
             contentType: false,
             dataType: 'json',
             success: function(response)
             { 

              if(response.success == true){
                printReceipt(response.transid);
                $('#msgtitle').text('Success!');
                $('#modalmsg').text(response.message);
                $('#msgmodalbtn').text('Close');
                $('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
                $('#msgmodalheader').attr('class', 'modal-header modal-header-success');
                $('#msgmodal').modal('show');
                $('#settlePaymentModal').modal('toggle');
              }else{
                $('#msgtitle').text('Error!');
                $('#modalmsg').text(response.message);
                $('#msgmodalbtn').text('Close');
                $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
                $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
                $('#msgmodal').modal('show');  
                $('#settlePaymentModal').modal('toggle');                   
              }
              $('#btnfinalize').attr('disabled', false);
              loadTransactionInfo();
              loadOrders();


              $('#changesettle').text("₱ 0.00");
              $('#discount').val(0.00);
              $('#cashtendered').val(0.00);
              $('#chkmngdiscount').prop("checked", false);
              $("#mgrdiscountdiv").hide();
              $("#mngpass").val("");



            },
            error: function(a,b,c)
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
         });

         function loadAdmins()
         { 
           $.ajax({
         
            url: 'possystem.php',
            type: 'POST',
            data: {action : 'loadAdmins'},
            dataType: 'html',
            success: function(result)
            {
             $('#cboadmins').html(result);
           },
           error: function(xhr, status, error)
           {
             //alert(xhr.responseText);
             $('#msgtitle').text('Something Went Wrong!');
             $('#modalmsg').text('Please contant administrator for assistance!');
             $('#msgmodalbtn').text('Close');
             $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
             $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
             $('#msgmodal').modal('show');
           }
         });
         }

function setCashTendered(money){
  $('#cashtendered').val(money);
  computeChange(cashtendered = $('#cashtendered').val())
}
function computeChange(money){
  var hasDiscount = $('#chkmngdiscount').is(":checked");
  var discount = 0;

 if(hasDiscount){
  discount = $('#discount').val();
   change = cashtendered - (truetotal- discount);
 }else{
   change = cashtendered - truetotal;
 }


 $('#changesettle').text("₱ " + change.toFixed(2));
 if(change >= 0){
   $('#btnfinalize').attr('disabled', false);
 }else{
   $('#btnfinalize').attr('disabled', true);
 }
}


function loadTransactionInfo(){
 $.ajax({
   url : 'possystem.php',
   type : 'POST',
   data : { action : 'loadTransInfo'},
   dataType: 'json',
   success : function(result)
   {
               //alert(JSON.stringify(result));
               $('#NoOfItems').text(result.NoOfItems);
               $('#InvoiceNo').text(result.InvoiceNo);





               truetotal = result.Total;
               
              var hasDiscount = $('#chkmngdiscount').is(":checked");
              var discount = 0;

               if(hasDiscount){
                discount = $('#discount').val();
                 total = result.Total - discount;
                 var vvtax = total / 1.2 *  .12 ;
                $('#VatTax').text(vvtax);
                $('#Vatable').text((total - vvtax));
               }else{
                 total = result.Total;
                $('#VatTax').text('₱ ' + result.VatTaxDisp);
                $('#Vatable').text('₱ ' + result.VatableDisp);
               }

               $('#totalbig').text(result.TotalDisp);
               $('#totalsettle').text('₱ ' + result.TotalDisp);
               $('#totalsettlehidden').val(total);
               $('#Total').text('₱ ' + result.TotalDisp);




              $("#discount").attr({
                "max" : truetotal - 1,       
                "min" : 0       
              });

              








             },
             error: function(a,b,c)
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

function updateQuantity(id)
{
 $("#updateQuantityModal").modal("show");

 $.ajax({

   url : 'possystem.php',
   type : 'POST',
   data : {id : id, action : 'showUpdateQuantity'},
   dataType: 'json',
   success : function(result)
   {
     $('#pname').val(result.pname);
     $('#price').val(result.price);
     $('#quantity').val(result.quantity);
     $("#quantity").attr({
      "max" : result.qout,       
      "min" : 1         
    });
     $('#barcode').val(id);
   }
 });

 $('#update-form').submit(function(e){

   e.preventDefault();

   $.ajax({

     url: 'possystem.php',
     type: 'POST',
     data: $(this).serialize(),
     dataType: 'html',
     success: function(result)
     {
       $('#productsTable').html(result);
       $("#updateQuantityModal").modal("hide");
       loadTransactionInfo();
       $('#bcode').focus();
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

}




function loadOrders(){
 $.ajax({

  url: 'possystem.php',
  type: 'POST',
  data: {action : 'loadOrders'},
  dataType: 'html',
  success: function(result)
  {

   $('#productsTable').html(result);
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


function setQuantity(barcode){
 var quantity = document.getElementById(barcode).value;

 $.ajax({

  url: 'possystem.php',
  type: 'POST',
  data: { action : 'setQuantity', 
  bcode : barcode, 
  qty : quantity },

  dataType: 'html',
  success: function(result)
  {
   $('#productsTable').html(result);
   loadTransactionInfo();
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

function voidTransaction()
{

 $("#voidModal").modal("show");
 $('.yes').click(function(e){

   $.ajax({

     url : 'possystem.php',
     type : 'POST',
     data : {action : 'voidTransaction'},
     dataType: 'html',

     success: function(result)
     {

       $("#voidModal").modal("hide");
       loadOrders();
       loadTransactionInfo();
       $('#changesettle').text("₱ 0.00");
      $('#discount').val(0);
      $('#cashtendered').val(0);
      $('#chkmngdiscount').prop("checked", false);
      $("#mgrdiscountdiv").hide();
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
function pricechk()
{
 $("#pricheckermodal").modal("show");
 $('#pricechk-bcode').focus();
}

function deleteOrder(id)
{

 $("#deleteModal").modal("show");
 $('.yes').click(function(e){

   $.ajax({

     url : 'possystem.php',
     type : 'POST',
     data : {action : 'deleteOrder', id : id},
     dataType: 'html',

     success: function(result)
     {
       $('#productsTable').html(result);
       $("#deleteModal").modal("hide");
       $("#bcode").focus();
       loadTransactionInfo();
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

$('#bcodeform').submit(function(e){
  e.preventDefault();
  $.ajax({
   url: 'possystem.php',
   type: 'POST',
   data : {action : 'getVoidCode'},
   dataType: 'json',
   async: false,
   success: function(ret)
   {
     var voidvcd = ret.voidcode;
     var inputVcode = $('#bcode').val();

     if(voidvcd === inputVcode){
      $('#bcode').val("");
      $('#bcode').focus();
      voidTransaction();
    }else{
     $.ajax({
       url: 'possystem.php',
       type: 'POST',
       data: $('#bcodeform').serialize(),
       async: false,
       dataType: 'html',
       success: function(result)
       {
         $('#productsTable').html(result);
         $('#bcode').val("");
         $('#bcode').focus();
         loadTransactionInfo();
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
 },
 error: function(a,b,c)
 {
  return '';
  $('#msgtitle').text('Something Went Wrong!');
  $('#modalmsg').text('Please contant administrator for assistance!');

  $('#msgmodalbtn').text('Close');
  $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');

  $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');

  $('#msgmodal').modal('show');

}
})
});
</script>
</body>
</html>