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

  <!-- Custom Theme Style -->
  <link href="../build/css/custom.min.css" rel="stylesheet">
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
        <!--
        <div class="row tile_count">
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Users</span>
            <div class="count">2500</div>
            <span class="count_bottom"><i class="green">4% </i> From last Week</span>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-clock-o"></i> Average Time</span>
            <div class="count">123.50</div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>3% </i> From last Week</span>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Males</span>
            <div class="count green">2,500</div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Females</span>
            <div class="count">4,567</div>
            <span class="count_bottom"><i class="red"><i class="fa fa-sort-desc"></i>12% </i> From last Week</span>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Collections</span>
            <div class="count">2,315</div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
          </div>
          <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
            <span class="count_top"><i class="fa fa-user"></i> Total Connections</span>
            <div class="count">7,325</div>
            <span class="count_bottom"><i class="green"><i class="fa fa-sort-asc"></i>34% </i> From last Week</span>
          </div>
        </div>
      -->



      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Overview <small>(Today)</small></h2>



                <div class="clearfix"></div>
              </div>
              <div class="x_content">

                <h4>Top Transactions</h4>
                <div class="col-md-9 col-sm-12 col-xs-12">



                  <div id="tablecontainer">

                    <div class="table-responsive" >
                      <table class="table table-fixed table-striped jambo_table scrollbar" id="audittable">
                        <thead>
                          <tr class='headings'>
                            <th class='column-title'>Rank</th>
                            <th class='column-title'>Transaction Number</th>
                            <th class='column-title'>Customer Name </th>
                            <th class='column-title'>Cashier Name </th>
                            <th class='column-title'>Total </th>
                            <th class='column-title'>Transaction Date </th>

                          </th>
                        </tr>
                      </thead>
                      <tbody id="todaytoptrans">

                      </tbody>
                    </table>
                  </div>
                </div>



                <div class="row">
                  <div class="col-md-2 tile">
                    <img src="images/Items Sold-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Items Sold</span>
                    <h2 id="lblitemssold">0</h2>
                  </div>
                  <div class="col-md-2 tile">
                    <img src="images/Total Sales-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Sales</span>
                    <h2 id="lbltotalsales">0.00</h2>

                  </div>
                  <div class="col-md-2 tile">
                    <img src="images/Product Delivered-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Product Delivered</span>
                    <h2 id="lblproductdelivered">0</h2>

                  </div>
                </div>

                <br>
                <div class="row">

                  <div class="col-md-2 tile">
                    <img src="images/New Customer-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total of New Customer</span>
                    <h2 id="lblcustomercount">0</h2>

                  </div>
                  <div class="col-md-2 tile">
                    <img src="images/No Transactions-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Number of Transactions</span>
                    <h2 id="lbltransactioncount">0</h2>

                  </div>

                  <div class="col-md-2 tile">
                    <img src="images/TotalDeliveries-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Deliveries</span>
                    <h2 id="lbltotaldeliveries">0</h2>

                  </div>
                </div>
              </div>



              <div class="col-md-3 col-sm-12 col-xs-12">
                <div>
                  <div class="x_title">
                    <h2>Top Products Sold</h2>
                    <div class="clearfix"></div>
                  </div>
                  <ul class="list-unstyled top_profiles scroll-view" id="producttoday">

                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>



      </div>

<div class="row">
          <div class="col-md-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Overview <small>(All Time)</small></h2>



                <div class="clearfix"></div>
              </div>
              <div class="x_content">

                <h4>Top Transactions</h4>
                <div class="col-md-9 col-sm-12 col-xs-12">

                  <div id="tablecontainer">

                    <div class="table-responsive" >
                      <table class="table table-fixed table-striped jambo_table scrollbar" id="audittable">
                        <thead>
                          <tr class='headings'>
                            <th class='column-title'>Rank</th>
                            <th class='column-title'>Transaction Number</th>
                            <th class='column-title'>Customer Name </th>
                            <th class='column-title'>Cashier Name </th>
                            <th class='column-title'>Total </th>
                            <th class='column-title'>Transaction Date </th>

                          </th>
                        </tr>
                      </thead>
                      <tbody id="alltimetoptrans">

                      </tbody>
                    </table>
                  </div>
                </div>



                <div class="row">
                  <div class="col-md-2 tile">
                    <img src="images/Items Sold-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Items Sold</span>
                    <h2 id="lblitemssoldall">0</h2>
                  </div>
                  <div class="col-md-2 tile">
                    <img src="images/Total Sales-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Sales</span>
                    <h2 id="lbltotalsalesall">0.00</h2>
                    
                  </div>
                  <div class="col-md-2 tile">
                    <img src="images/Product Delivered-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Product Delivered</span>
                    <h2 id="lblproductdeliveredall">0</h2>
                    
                  </div>
                </div>

                <br>
                <div class="row">
                  
                  <div class="col-md-2 tile">
                    <img src="images/New Customer-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total of New Customer</span>
                    <h2 id="lblcustomercountall">0</h2>
                    
                  </div>
                  <div class="col-md-2 tile">
                    <img src="images/No Transactions-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Number of Transactions</span>
                    <h2 id="lbltransactioncountall">0</h2>
                    
                  </div>

                  <div class="col-md-2 tile">
                    <img src="images/TotalDeliveries-min.png" alt="..." style="max-width:100%;
                    max-height:100%;
                    height: 65px;
                    width: 65px;">
                  </div>
                  <div class="col-md-2 tile">
                    <span>Total Deliveries</span>
                    <h2 id="lbltotaldeliveriesall">0</h2>
                    
                  </div>
                </div>
              </div>



              <div class="col-md-3 col-sm-12 col-xs-12">
                <div>
                  <div class="x_title">
                    <h2>Top Products Sold</h2>
                    <div class="clearfix"></div>
                  </div>
                  <ul class="list-unstyled top_profiles scroll-view" id="productalltime">
                  </ul>
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



<script type="text/javascript">


  $(document).ready(function(){
    topTransactionToday();
    topProductsToday();
    showOverviewStatusToday();  



    topTransactionAllTime();
    topProductsAllTime();
    showOverviewStatusAllTime();



  setInterval(function(){
    topTransactionToday();
    topProductsToday();
    showOverviewStatusToday();
   
    topTransactionAllTime();
    topProductsAllTime();
    showOverviewStatusAllTime();


   }, 2000);
    
  });

    function showOverviewStatusToday(){
      $.ajax({

          url : 'overview/overviewstat.php',
          type : 'POST',
          data : {action : 'showOverviewStatusToday'},
          dataType: 'json',
          success : function(result)
          {
         
            $('#lbltotaldeliveries').html(result.DeliveryCount);
            $('#lbltransactioncount').html(result.TransactionCount);
            $('#lblcustomercount').html(result.CustomerCount);
            $('#lblproductdelivered').html(result.ProductsDelivered);
            $('#lbltotalsales').html(result.TotalSales);
            $('#lblitemssold').html(result.ProdCount);
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

    function topTransactionToday()
    { 
      $.ajax({

       url: 'overview/overviewstat.php',
       type: 'POST',
       data: {action : 'topTransactionToday'},
       dataType: 'html',
       success: function(result)
       {
        $('#todaytoptrans').html(result);
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
    function topProductsToday()
    { 
      $.ajax({

       url: 'overview/overviewstat.php',
       type: 'POST',
       data: {action : 'topProductsToday'},
       dataType: 'html',
       success: function(result)
       {
        $('#producttoday').html(result);
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






function showOverviewStatusAllTime(){
      $.ajax({

          url : 'overview/overviewstat.php',
          type : 'POST',
          data : {action : 'showOverviewStatusAllTime'},
          dataType: 'json',
          success : function(result)
          {
            $('#lbltotaldeliveriesall').html(result.DeliveryCount);
            $('#lbltransactioncountall').html(result.TransactionCount);
            $('#lblcustomercountall').html(result.CustomerCount);
            $('#lblproductdeliveredall').html(result.ProductsDelivered);
            $('#lbltotalsalesall').html(result.TotalSales);
            $('#lblitemssoldall').html(result.ProdCount);
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

    function topTransactionAllTime()
    { 
      $.ajax({

       url: 'overview/overviewstat.php',
       type: 'POST',
       data: {action : 'topTransactionAllTime'},
       dataType: 'html',
       success: function(result)
       {
        $('#alltimetoptrans').html(result);
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
    function topProductsAllTime()
    { 
      $.ajax({

       url: 'overview/overviewstat.php',
       type: 'POST',
       data: {action : 'topProductsAllTime'},
       dataType: 'html',
       success: function(result)
       {
        $('#productalltime').html(result);
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


</body>
</html>
