<?php include 'auth.php'; ?> 
<?php include 'accountinfo.php'; ?>

<?php 



function secure($str){
  return strip_tags(trim(htmlspecialchars($str)));
}

if(isset($_GET['id'])){
  $id = secure($_GET['id']);
  if(!is_numeric($id)){
    header("Location: deliveries.php");
  }
}else{
  header("Location: deliveries.php");
}


?>


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
  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">

  <style> #total { text-align: right; padding-left: 50px; padding-top: 50px; }</style>



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
     <div class="x_panel">
      <div class="x_title">
       <h2>Deliveries</h2>
       <div class="clearfix"></div>
     </div>

     <div class="x_content">

      <div class="row">
        <div class="col-sm-3">
          <a href="deliveries.php" class="btn btn-info btn-md" > <i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a><p></p>    <!-- Trigger the modal with a button -->
        </div>
        <div class="col-sm-6">
        </div>
        <div class="col-sm-3">
          <a  class="btn btn-primary btn-md pull-right" onclick="printDelivery()"> <i class="fa fa-print" aria-hidden="true"></i> Print</a><p></p>
        </div>
      </div>


      <div class="row">
        <div id="printArea">
         <div class="table-responsive">
          <table id="itemtable" class="table table-condensed">
           <!-- Start of Table -->
           <thead>
            <tr>
             <th>Item #</th>
             <th>Product Name</th>
             <th>Supplier Price</th>
             <th>Quantity</th>
             <th>Total</th>
           </tr>
         </thead>
         <tbody id="delitems">

          <?php 
          include 'config/config.php';  
          $total = 0;

          $stmt = $conn->prepare("SELECT
            `del_item_id`,
            pr.Product_name,
            `SupplierPrice`,
            `Quantity_Delivered`,
            (`SupplierPrice` * `Quantity_Delivered`) as 'Total'
            FROM
            `tblpodel_items` AS pdi
            INNER JOIN tblproducts AS pr
            ON
            pr.id = pdi.`ProductId`
            WHERE `Pod_id`=?");
          if ($stmt->execute(array($id))) {
            while ($r = $stmt->fetch()) {
              echo "<tr>";
              echo "<td>".$r['del_item_id']."</td>";
              echo "<td>".$r['Product_name']."</td>";
              echo "<td>".$r['SupplierPrice']."</td>";
              echo "<td>".$r['Quantity_Delivered']."</td>";
              echo "<td>₱ ".number_format($r['Total'], 2, '.', ',')."</td>";
              echo "</tr>";
              $total += $r['Total'];
            }
            echo "<tr>";
            echo "<td colspan='3' align='right' id='total'>Total</td>";
            echo "<td colspan='2' align='right' id='total'>₱ ".number_format($total, 2, '.', ',')."</td>";
            echo "</tr>";

          }
          ?>



        </tbody>
      </table>
    </div>
  </div>
</div>
</div>
</div>

</div>


<?php 
include 'config/config.php';

$stmt = $conn->prepare("SELECT
  `Pod_id`,
  po.Po_number,
  sup.Supplier_name,
  `DeliveryNumber`,
  CONCAT(us.fname, ' ', us.lname) as 'Receiver',
  pd.`DateDelivered`
  FROM
  `tblpodeliveries` AS pd
  INNER JOIN tblpurchaseorders AS po
  ON
  po.Po_id = pd.`Po_id`
  INNER JOIN tblsuppliers AS sup
  ON
  sup.Supplier_id = po.Supplier_id
  INNER JOIN tblusers AS us
  ON
  us.userid = pd.`ReceivedBy_id`
  WHERE `Pod_id`=:id");
$stmt->bindParam(':id',$id);
$stmt->execute(); 
$row = $stmt->fetch();

$pid = $row['Pod_id'];
$pon = $row['Po_number'];
$supplier = $row['Supplier_name'];
$receiver = $row['Receiver'];
$deliverdate = date("F j, Y", $row['DateDelivered']);
$delnum = $row['DeliveryNumber'];






?>
<div class="col-md-4">
 <div class="x_panel">
  <div class="x_title">
   <h2>Delivery Information</h2>
   <div class="clearfix"></div>
 </div>
 <div class="x_content">
   <div class="row">
    <form id="po-form" style="margin-left: 20px">



     <div class="row">
      <div class="col-md-4">
       <div class="form-group">
        <label for="usr">Delivery Id:</label>
      </div>
    </div>
    <div class="col-md-8">
     <p id="bckdate"><?php echo $pid; ?></p>
   </div>
 </div>


 <div class="row">
  <div class="col-md-4">
   <div class="form-group">
    <label for="usr">PO Number:</label>
  </div>
</div>
<div class="col-md-8">
 <p id="bckdate"> <?php echo $pon; ?></p>
</div>
</div>

<div class="row">
  <div class="col-md-4">
   <div class="form-group">
    <label for="usr">Delivery Number:</label>
  </div>
</div>
<div class="col-md-8">
 <p id="DeliveryNumber"> <?php echo $delnum; ?></p>
</div>
</div>



<div class="row">
  <div class="col-md-4">
   <div class="form-group">
    <label for="usr">Supplier:</label>
  </div>
</div>
<div class="col-md-8">
 <p id="Supplier"> <?php echo $supplier; ?></p>
</div>
</div>


<div class="row">
  <div class="col-md-4">
   <div class="form-group">
    <label for="usr">Received By:</label>
  </div>
</div>
<div class="col-md-8">
 <p id="ReceivedBy"> <?php echo $receiver; ?></p>
</div>
</div>


<div class="row">
  <div class="col-md-4">
   <div class="form-group">
    <label for="usr">Delivery Date:</label>
  </div>
</div>
<div class="col-md-8">
 <p id="DeliveryDate"> <?php echo $deliverdate ; ?></p>
</div>
</div>


</form>
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

<input type="hidden" name="StoreName" id="StoreName" value="">
<input type="hidden" name="StoreNumber" id="StoreNumber" value="">
<input type="hidden" name="StoreAddress" id="StoreAddress" value="">



<script type="text/javascript">

  function printDelivery(){
    var divToPrint = document.getElementById('printArea');
    var StoreName = document.getElementById('StoreName');
    var StoreAddress = document.getElementById('StoreAddress');
    var StoreNumber = document.getElementById('StoreNumber');
    var ReportName = "Delivery Receipt";



    var DeliveryNumber = document.getElementById('DeliveryNumber');
    var Supplier = document.getElementById('Supplier');
    var ReceivedBy = document.getElementById('ReceivedBy');
    var DeliveryDate = document.getElementById('DeliveryDate');




    var htmlToPrint = '' +
    '<style type="text/css">' +
    '@font-face {'+
    'font-family: Calli;'+
    'src: url(../../fonts/Raleway-Regular.ttf);'+
    '}'+
    'table, td, th { border: 1px solid #ddd; text-align: left; }'+
    'table { border-collapse: collapse; width: 100%; }'+
    'th, td { padding: 5px; font-size: 12pt; font-family: "Segoe UI";}'+
    +'img{max-width:100%;height:auto;}'+
    '</style>' + 
    '<style> #total { text-align: right; padding-left: 50px; padding-top: 50px; }</style>';
    htmlToPrint += "<center><img src=\"images/customlogo.jpg\" alt=\"Smiley face\" height=\"90\" width=\"230\">";
    htmlToPrint += "<br><strong>" + StoreName.value + "</strong>";
    htmlToPrint += "<br><strong>" + StoreAddress.value + "</strong>";
    htmlToPrint += "<br><strong>" + StoreNumber.value + "</strong>";
    htmlToPrint += "<br><strong><h3>" + ReportName + "</h3></strong>";
    htmlToPrint += "<strong>" + DeliveryNumber.innerHTML + "</strong>";
    htmlToPrint += "<br><strong>" + Supplier.innerHTML + "</strong>";
    htmlToPrint += "<br><strong>" + ReceivedBy.innerHTML + "</strong>";
    htmlToPrint += "<br><strong>" + DeliveryDate.innerHTML + "</strong></center></br>";
    htmlToPrint += divToPrint.outerHTML;
    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    setTimeout(function(){
      newWin.print();
      newWin.close();
    },250);
  }


  $(document).ready(function(){
   loadSuppliers();
   loadAdmins();
   loadCompInfo();


   
  function loadCompInfo(){
    $.ajax({
      url : 'companyinfo/compaction.php',
      type : 'POST',
      data : {action : 'showcompinfo'},
      dataType: 'json',
      success : function(result)
      {
        $('#StoreName').val(result.compname);        
        $('#StoreAddress').val(result.street + " " + result.city + " " + result.province + " " + result.zipcode);
        $('#StoreNumber').val(result.phone);
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






   $( "#btnload" ).click(function() {
     loadCurrentPo($("#cbosuppliers").val());
     $("#sup_id").val($("#cbosuppliers").val());
   });


   $('#po-form').submit(function(e){
    $("#cbosuppliers").val($("#sup_id").val());


    e.preventDefault();

    var formData = new FormData(this);

    $.ajax({
     url: 'purchaseorders/pofunctions.php',
     type: 'POST',
     cache: false,
     data: formData,
     async: false,
     processData: false,
     contentType: false,
     dataType: 'json',
     success: function(response)
     {
      if(response.success){

        $('#msgtitle').text('Success!');
        $('#modalmsg').text(response.message);
        $('#msgmodalbtn').text('Close');
        $('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
        $('#msgmodalheader').attr('class', 'modal-header modal-header-success');
        $('#msgmodal').modal('show');
      }else{
        $('#msgtitle').text('Error!');
        $('#modalmsg').text(response.message);
        $('#msgmodalbtn').text('Close');
        $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
        $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
        $('#msgmodal').modal('show');                      
      }

                    //reset values
                    loadSuppliers();
                    loadAdmins();
                    loadCurrentPo(0);
                    $("#ponumber").val("");
                    $("#password").val("");
                    $("#deldate").val("");






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



  function loadCurrentPo(id){

   $.ajax({

    url: 'purchaseorders/pofunctions.php',
    type: 'POST',
    data: {action : 'loadProductsToOrder', id : id},
    dataType: 'html',
    success: function(result)
    {
     $('#poitems').html(result);
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

 function loadSuppliers()
 { 
   $.ajax({

    url: 'purchaseorders/pofunctions.php',
    type: 'POST',
    data: {action : 'loadSuppliers'},
    dataType: 'html',
    success: function(result)
    {
     $('#cbosuppliers').html(result);
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




 function loadAdmins()
 { 
   $.ajax({

    url: 'purchaseorders/pofunctions.php',
    type: 'POST',
    data: {action : 'loadAdmins'},
    dataType: 'html',
    success: function(result)
    {
     $('#cboadmins').html(result);
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