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


    .table tbody tr > td.success {
  background-color: #dff0d8 !important;
}

.table tbody tr > td.error {
  background-color: #f2dede !important;
}

.table tbody tr > td.warning {
  background-color: #fcf8e3 !important;
}

.table tbody tr > td.info {
  background-color: #d9edf7 !important;
}

.table-hover tbody tr:hover > td.success {
  background-color: #d0e9c6 !important;
}

.table-hover tbody tr:hover > td.error {
  background-color: #ebcccc !important;
}

.table-hover tbody tr:hover > td.warning {
  background-color: #faf2cc !important;
}

.table-hover tbody tr:hover > td.info {
  background-color: #c4e3f3 !important;
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






                <!-- top tiles -->
          <div class="row tile_count">

          <!--
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Total Price on Stock</span>
              <div class="count"><label id="TotalPrice"></label></div>
              <span class="count_bottom"><i class="green"></i> Total In PHP</span>
            </div>

            -->
            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i>  No of Products</span>
              <div class="count"><label id="NoOfProduct"></label></div>
              <span class="count_bottom"><i class="green"></i> <p>Products In Stock</p></span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Over Stocked Products</span>
              <div class="count"><label id="OverStocked"></label></div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i><label id="OverStockedPercent"></label></i> of Total Stock</span>
            </div>

            <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-user"></i> Critical Level Products</span>
              <div class="count red"><label id="CriticalLevel"></label></div>
              <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i><label id="CriticalLevelPercent"></label></i> of Total Products</span>
            </div>

            <div class="col-md-3 col-sm-5 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Quantity of Stock (Inside)</span>
              <div class="count"><label id="QtyIn"></label></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><label id="QtyInPercent"></label></i> of Total Quantity on Prodcts</span>
            </div>

           <div class="col-md-3 col-sm-5 col-xs-6 tile_stats_count">
              <span class="count_top"><i class="fa fa-clock-o"></i> Quantity of Stock (Outside)</span>
              <div class="count"><label id="QtyOut"></label></div>
              <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i><label id="QtyOutPercent"></label> </i> of Total Quantity on Stock</span>
            </div>



          </div>
          <!-- /top tiles -->

        <div class="container">

          <div class="x_panel">
            <div class="x_title">
              <h2>Product Overview </h2>
              <div class="clearfix"></div>

            </div>
            <div class="x_content">


              <div class="row">
                <div class="col-sm-3">
                </div>
                <div class="col-sm-5">

                </div>
                <div class="col-sm-4">

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Search</span>
                      <input type="text" name="search_text" id="search_text" placeholder="Name / Code of Product" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>


              <div id="printArea">
                <div class="table-responsive">
                  <table id="itemtable" class="table table-condensed">  <!-- Start of Table -->
                    <thead>
                      <tr>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Category</th>
                        <th>Supplier</th>
                        <th>Flooring</th>
                        <th>Ceiling</th>
                        <th>Quantity on Stocks</th>
                        <th>Needed</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody id="itemsbody"></tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
          <!-- End of Table -->


      </div>  <!-- End of container -->
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
<!-- Update Modal -->
<div id="inputbarcodemodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-header-info">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Scan / Input Barcode</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="changebc-form">
          <div class="form-group">
            <label class="control-label col-sm-2" for="barcode_scan">Barcode:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="barcode_scan" placeholder="Scan Barcode" name="barcode_scan" required="">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>



<div id="u_inputbarcodemodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-header-info">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Scan / Input Barcode</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="u_changebc-form">
          <div class="form-group">
            <label class="control-label col-sm-2" for="barcode_scan">Barcode:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="u_barcode_scan" placeholder="Scan Barcode" name="u_barcode_scan" required="">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
          <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>


<script type="text/javascript">
      $(document).ready(function(){

        setInterval(function(){ showData(); }, 10000);


      function showData()
      { 
        $.ajax({

          url: 'prodover/prodover.php',
          type: 'POST',
          data: {action : 'showOverView'},
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
        });

        $.ajax({

          url : 'prodover/prodover.php',
          type : 'POST',
          data : {action : 'showOverViewStatus'},
          dataType: 'json',
          success : function(result)
          {
            $('#NoOfProduct').text(result.NoOfProduct);
            $('#OverStocked').text(result.OverStocked);
            $('#OverStockedPercent').text(result.OverStockedPercent.toFixed(2) + " %");
            $('#CriticalLevel').text(result.CriticalLevel);
            $('#CriticalLevelPercent').text(result.CriticalLevelPercent.toFixed(2) + " %");
            $('#QtyIn').text(result.QtyIn);
            $('#QtyInPercent').text(result.QtyInPercent.toFixed(2) + " %");
            $('#QtyOut').text(result.QtyOut);
            $('#QtyOutPercent').text(result.QtyOutPercent.toFixed(2) + " %");
            //$('#TotalPrice').text(result.TotalPrice);

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

      showData();

      var searchreq = null;
      function load_data(query)
      {
        if (searchreq != null) searchreq.abort();
        searchreq = $.ajax({
          url:"prodover/searchoverview.php",
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





</script>



</body>
</html>
