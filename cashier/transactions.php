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
  <title>Cashier Panel | POS</title>
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
     <?php include('templates/cashier.quickinfo.php'); ?> 
     <br />
     <?php include('templates/cashier.sidebar.php'); ?> 
     <?php include('templates/cashier.menufooter.php'); ?> 
   </div>
 </div>
 <?php include('templates/cashier.topnav.php'); ?>
 <!-- page content -->
 <div class="right_col" role="main">
   <div class="container">

    <div class="col-md-6">
      <div class="x_panel">
        <div class="x_title">
          <h2>Transaction </h2>
          <div class="clearfix"></div>

        </div>
        <div class="x_content">


          <div class="row">
            <div class="col-sm-3">
            </div>
            <div class="col-sm-3">

            </div>
            <div class="col-sm-6">
              <div class="form-group">
                <div class="input-group">
                  <span class="input-group-addon">Search</span>
                  <input type="text" name="search_text" id="search_text" placeholder="Transaction #" class="form-control" />
                </div>
              </div>
            </div>
          </div>
          <div id="printArea">
            <div class="table-responsive">
              <table id="itemtable" class="table table-condensed">  <!-- Start of Table -->
                <thead>
                  <tr>
                    <th>Transaction #</th>
                    <th>Customer Name</th>
                    <th>Date of Transaction</th>
                    <th># of Items</th>
                    <th class="col-md-2">Action</th>
                  </tr>
                </thead>
                <tbody id="itemsbody"></tbody>
              </table>
            </div>
          </div>
        </div>

      </div>

    </div>


    <div class="col-md-6">
      <div class="x_panel">
        <div class="x_title">
          <h2>Receipt </h2>
          <div class="clearfix"></div>

        </div>
        <div class="x_content">
          <div id="receiptarea">
            <center><strong>Company Name</strong> </center>
            <center>Company Address</center>
            <center>Email</center>
            <center>Phone #</center>
            <center> <strong>Transaction #: -----------</strong> </center>
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

        </div>

      </div>

    </div>





    <!-- End of Table -->

  </div>
</div>
<!-- /page content -->
<?php include('templates/cashier.footer.php'); ?>
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

<script type="text/javascript">

  $(document).ready(function(){

    loadtransactions();




    var searchreq = null;
    function load_data(query)
    {
      if (searchreq != null) searchreq.abort();
      searchreq = $.ajax({
        url:"transaction/searchtrans.php",
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
        loadtransactions();
      }
    });

    function loadtransactions()
    { 
      $.ajax({

       url: 'transaction/transaction.php',
       type: 'POST',
       data: {action : 'loadtransactions'},
       dataType: 'html',
       success: function(result)
       {
        $('#itemsbody').html(result);
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






    
  });
</script>


</body>
</html>