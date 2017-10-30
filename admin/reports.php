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




          <div class="col-md-4 col-sm-4 col-xs-4">
            <div class="x_panel">
              <div class="x_title">
                <h2 id="">Generate Report </h2>

                <div class="clearfix"></div>
              </div>

              <div class="x_content">



                <div class="input-group">
                  <select class="form-control" id="logcombo">
                  <option value="salesrep">Sales Report</option>
                    <option value="trans">Sales Transactions</option>
                    <option value="pos">Purchase Orders</option>
                    <option value="dels">Deliveries</option>
                    <option value="stockadj">Stock Adjustment</option>
                    <option value="refss">Refunds</option>
                    <option value="prodA">Products Overview (All)</option>
                    <option value="prodC">Products Overview (Critical)</option>
                    <option value="prodN">Products Overview (Normal)</option>
                    <option value="prodO">Products Overview (Overstocked)</option>
                  </select>
                </div>

                <div class="input-group">
                  <label class="input-group-btn" for="date-from">
                    <span class="btn btn-default">
                      From
                      <span class="glyphicon glyphicon-calendar"></span>
                    </span>
                  </label>
                  <input type="date" class="form-control date-input" id="date-from" />
                </div>

                <div class="input-group">
                  <label class="input-group-btn" for="date-to">
                    <span class="btn btn-default">
                     Up to
                     <span class="glyphicon glyphicon-calendar"></span>
                   </span>
                 </label>
                 <input type="date" class="form-control date-input" id="date-to" />
               </div>

               <button type="button" class="btn btn-primary pull-right" onclick="generateReport()">Generate</button>
               <input type="hidden" name="StoreName" id="StoreName" value="">
               <input type="hidden" name="StoreNumber" id="StoreNumber" value="">
               <input type="hidden" name="StoreAddress" id="StoreAddress" value="">
             </div>
           </div>
         </div>

         <div class="col-md-8 col-sm-8 col-xs-8">
          <div class="x_panel">
            <div class="x_title">
              <h2 id="reporttitle">Report </h2>

              <div class="clearfix"></div>
            </div>

            <div class="x_content">

              <p id="reportmessage">Showing Result From Database</p>
              <div id="tablecontainer">

                <div class="table-responsive" >
                  <table class="table table-fixed table-striped jambo_table scrollbar" id="reporttable">

                  </table>
                </div>

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
    loadCompInfo();


    $("#logcombo").change(function() {
          var e = document.getElementById("logcombo");
          var strUser = e.options[e.selectedIndex].value;


        switch (strUser) {

          case "salesrep":
            $("#date-to").prop('disabled', false);
            $("#date-from").prop('disabled', false);
          break;


          case "refss":
            $("#date-to").prop('disabled', false);
            $("#date-from").prop('disabled', false);
          break;

          
          case "trans":
            $("#date-to").prop('disabled', false);
            $("#date-from").prop('disabled', false);
          break;

          case "pos":
            $("#date-to").prop('disabled', false);
            $("#date-from").prop('disabled', false);
          break;
          case "dels":
            $("#date-to").prop('disabled', false);
            $("#date-from").prop('disabled', false);
          break;
          case "stockadj":
            $("#date-to").prop('disabled', false);
            $("#date-from").prop('disabled', false);
          break;

          



          case "prodA":
            $("#date-to").prop('disabled', true);
            $("#date-from").prop('disabled', true);
          break;
          case "prodC":
            $("#date-to").prop('disabled', true);
            $("#date-from").prop('disabled', true);
          break;
          case "prodN":
            $("#date-to").prop('disabled', true);
            $("#date-from").prop('disabled', true);
          break;
          case "prodO":
            $("#date-to").prop('disabled', true);
            $("#date-from").prop('disabled', true);
          break;
        }
    });

  });


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






  function showSalesReport(from, to)
  { 
    $("#reporttitle").text("Sales Reports");
    $("#reportmessage").text("Showing Sales Report");
    $.ajax({
      url: 'reports/reportsfunc.php',
      type: 'POST',
      data: {action : 'showSalesReport', startdate:from , enddate:to},
      dataType: 'html',
      success: function(result)
      {
        $('#reporttable').html(result);
        printtable(0);
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





  function showTransaction(from, to)
  { 
    $("#reporttitle").text("Sales Transactions");
    $("#reportmessage").text("Showing Reports of Transactions");
    $.ajax({
      url: 'reports/reportsfunc.php',
      type: 'POST',
      data: {action : 'showTransactions', startdate:from , enddate:to},
      dataType: 'html',
      success: function(result)
      {
        $('#reporttable').html(result);
        printtable(0);
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

  function showPurchaseOrders(from, to)
  { 
    $("#reporttitle").text("Purchase Order Reports");
    $("#reportmessage").text("Showing Reports of Purchase Orders");
    $.ajax({
      url: 'reports/reportsfunc.php',
      type: 'POST',
      data: {action : 'showPurchaseOrders', startdate:from , enddate:to},
      dataType: 'html',
      success: function(result)
      {
        $('#reporttable').html(result);
        printtable(0);
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

  function showDeliveries(from, to)
  { 
    $("#reporttitle").text("Deliveries Reports");
    $("#reportmessage").text("Showing Reports of Deliveries");
    $.ajax({
      url: 'reports/reportsfunc.php',
      type: 'POST',
      data: {action : 'showDeliveries', startdate:from , enddate:to},
      dataType: 'html',
      success: function(result)
      {
        $('#reporttable').html(result);
        printtable(0);
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



    function showRefunds(from, to)
  { 
    $("#reporttitle").text("Refunds Reports");
    $("#reportmessage").text("Showing Reports of Refunds");
    $.ajax({
      url: 'reports/reportsfunc.php',
      type: 'POST',
      data: {action : 'showRefunds', startdate:from , enddate:to},
      dataType: 'html',
      success: function(result)
      {
        $('#reporttable').html(result);
        printtable(0);
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

  function showProduct(status)
  { 
    $("#reporttitle").text("Products Report");
    $("#reportmessage").text("Showing Reports of Products");
    $.ajax({
      url: 'reports/reportsfunc.php',
      type: 'POST',
      data: {action : 'showProduct', stat: status},
      dataType: 'html',
      success: function(result)
      {
        $('#reporttable').html(result);
        printtable(0);
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


  function showStockAdjustment(from , to){
        $("#reporttitle").text("Stock Adjustment");
    $("#reportmessage").text("Showing Reports of Stock Adjustment");
    $.ajax({
      url: 'reports/reportsfunc.php',
      type: 'POST',
      data: {action : 'showStockAdjustment', startdate:from , enddate:to},
      dataType: 'html',
      success: function(result)
      {
        $('#tablecontainer').html(result);
        printtable(1);
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



  function generateReport(){
    var e = document.getElementById("logcombo");
    var strUser = e.options[e.selectedIndex].value;


    var from = $("#date-from").val();
    var to = $("#date-to").val();

    switch (strUser) {

      case "salesrep":
      showSalesReport(from , to);
      break;

      case "trans":
      showTransaction(from , to);
      break;


      case "refss":
      showRefunds(from , to);
      break;


      case "stockadj":
      showStockAdjustment(from , to);
      break;

    
      case "pos":
      showPurchaseOrders(from, to);
      break;

      case "dels":
      showDeliveries(from , to);
      break;

      case "prodA":
      showProduct("All");
      break;
      case "prodC":
      showProduct("Critical");
      break;
      case "prodN":
      showProduct("Normal");
      break;
      case "prodO":
      showProduct("Overstocking");
      break;
    }
  }
  

  function printtable(x){
    var divToPrint;
    if(x == 0){
      divToPrint = document.getElementById('reporttable');
    }else{
      divToPrint = document.getElementById('tablecontainer');
    }

    var StoreName = document.getElementById('StoreName');
    var StoreAddress = document.getElementById('StoreAddress');
    var StoreNumber = document.getElementById('StoreNumber');
    var ReportName = document.getElementById('logcombo');

    var htmlToPrint = '' +
        '<style type="text/css">' +
        '@font-face {'+
        'font-family: Calli;'+
        'src: url(../../fonts/Raleway-Regular.ttf);'+
        '}'+
        'table, td, th { border: 1px solid #ddd; text-align: left; }'+
        'table { border-collapse: collapse; width: 100%; }'+
        'th, td { padding: 3px; font-size: 11pt; font-family: "Segoe UI";}'+
        +'img{max-width:100%;height:auto;}'+
        '</style>' + 
        '<style> #total { text-align: right; padding-left: 50px; padding-top: 20px; }</style>';
    htmlToPrint += "<center><img src=\"images/customlogo.jpg\" alt=\"Smiley face\" height=\"90\" width=\"230\">";
    htmlToPrint += "<br><strong>" + StoreName.value + "</strong>";
    htmlToPrint += "<br><strong>" + StoreAddress.value + "</strong>";
    htmlToPrint += "<br><strong>" + StoreNumber.value + "</strong></br>";
    htmlToPrint += "<strong><h3>" + ReportName.options[ReportName.selectedIndex].text + "<h3></strong></center>";

    htmlToPrint += divToPrint.outerHTML;

    newWin = window.open("");
    newWin.document.write(htmlToPrint);
    setTimeout(function(){
      newWin.print();
      newWin.close();
    },250);
  }
</script>
</body>
</html>
