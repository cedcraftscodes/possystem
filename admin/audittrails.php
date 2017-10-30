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

  <link rel="stylesheet" type="text/css" href="css/tablescrollbar.css">

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
          <div class="page-title">
            <div class="title_left">
              <h3>Audit Trails</h3>
            </div>

            <div class="title_right">
              <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                <div class="input-group">
                  <div class="form-group">
                    <select class="form-control" id="logcombo">
                      <option value="trans">Transaction</option>
                      <option value="logh">Login History</option>
                      <option value="purc">Purchase Orders</option>
                      <option value="backup">Backup</option>
                      <option value="restore">Restore</option>
                      <option value="badord">Bad Orders</option>
                      <option value="invlogs">Inventory Logs</option>
                    </select>
                  </div>
                  <span class="input-group-btn">
                    <button class="btn btn-default" onclick="switchTable()" type="button">Go!</button>
                  </span>
                </div>
              </div>
            </div>
          </div>





          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2 id="audittitle">Sales Transaction </h2>

                <div class="clearfix"></div>
              </div>

              <div class="x_content">

                <p id="auditmessage">Showing 100 most recent transation</p>
                <div id="tablecontainer">
                  
                <div class="table-responsive" >
                  <table class="table table-fixed table-striped jambo_table scrollbar" id="audittable">

                  </table>
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




  <script type="text/javascript">

    $(document).ready(function(){


    showTransaction();

    });

    function onQuantityChange(barcode){

      



    }

    function showTransaction()
      { 
        $("#audittitle").text("Sales Transaction");
        $("#auditmessage").text("Showing Trails of Sales Transaction");
        $.ajax({

          url: 'audittrails/auditfunction.php',
          type: 'POST',
          data: {action : 'showTransactions'},
          dataType: 'html',
          success: function(result)
          {
            $('#audittable').html(result);
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


      function showLoginHistory()
      { 
        $("#audittitle").text("Login History");
        $("#auditmessage").text("Showing Trails of Login History");
        $.ajax({

          url: 'audittrails/auditfunction.php',
          type: 'POST',
          data: {action : 'showLoginHistory'},
          dataType: 'html',
          success: function(result)
          {
            $('#audittable').html(result);
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


      function showRestoreHistory()
      { 
        $("#audittitle").text("Restore History");
        $("#auditmessage").text("Showing Trails of Restore History");



        $.ajax({

          url: 'audittrails/auditfunction.php',
          type: 'POST',
          data: {action : 'showRestoreHistory'},
          dataType: 'html',
          success: function(result)
          {
            $('#audittable').html(result);
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







      function showBackupHistory()
      { 
        $("#audittitle").text("Backup History");
        $("#auditmessage").text("Showing Trails of Backup History");



        $.ajax({

          url: 'audittrails/auditfunction.php',
          type: 'POST',
          data: {action : 'showBackupHistory'},
          dataType: 'html',
          success: function(result)
          {
            $('#audittable').html(result);
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


      function showPurchaseOrders()
      { 
        $("#audittitle").text("Purchase Orders");
        $("#auditmessage").text("Showing Trails of Purchase Orders");



        $.ajax({

          url: 'audittrails/auditfunction.php',
          type: 'POST',
          data: {action : 'showPurchaseOrders'},
          dataType: 'html',
          success: function(result)
          {
            $('#audittable').html(result);
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


      function showBadOrders()
      { 
        $("#audittitle").text("Bad Orders");
        $("#auditmessage").text("Showing Trails of Bad Orders");



        $.ajax({

          url: 'audittrails/auditfunction.php',
          type: 'POST',
          data: {action : 'showBadOrders'},
          dataType: 'html',
          success: function(result)
          {
            $('#audittable').html(result);
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




      function showInventoryLogs()
      { 
        $("#audittitle").text("Inventory Logs");
        $("#auditmessage").text("Showing Trails of Inventory Logs");



        $.ajax({

          url: 'audittrails/auditfunction.php',
          type: 'POST',
          data: {action : 'showInventoryLogs'},
          dataType: 'html',
          success: function(result)
          {
            $('#audittable').html(result);
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











    function switchTable(){
      var e = document.getElementById("logcombo");
      var strUser = e.options[e.selectedIndex].value;

      switch (strUser) {
        case "trans":
          showTransaction();
        break;

        case "logh":
          showLoginHistory();
        break;

        case "purc":
          showPurchaseOrders();
        break;
        case "backup":
          showBackupHistory();
        break;
        case "restore":
          showRestoreHistory();
        break;


        case "badord":
          showBadOrders();
        break;

        case "invlogs":
          showInventoryLogs();
        break;


        



      }



    }
  </script>
</body>
</html>
