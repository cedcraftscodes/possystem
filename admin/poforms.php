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


              <form id="po-form">

               <div class="container">
                  <div class="col-md-8">
                     <div class="x_panel">
                        <div class="x_title">
                           <h2>Product Orders</h2>
                           <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="row">
                              <div id="printArea">
                                 <div class="table-responsive">
                                    <table id="itemtable" class="table table-condensed">
                                       <!-- Start of Table -->
                                       <thead>
                                          <tr>
                                             <th>#</th>
                                             <th>Product Name</th>
                                             <th>Supplier</th>
                                             <th>Quantity</th>
                                             <th class="col-md-2">Range</th>
                                             <th class="col-md-2">Remove to Critical</th>
                                          </tr>
                                       </thead>
                                       <tbody id="poitems"></tbody>
                                    </table>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>

                  </div>
                  <div class="col-md-4">
                     <div class="x_panel">
                        <div class="x_title">
                           <h2>Purchase Order Form</h2>
                           <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="row">

                                 <div class="form-group">

                                  <?php $time = time(); ?>

                                  <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="usr">Purchase Order #:</label>
                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <label for="pwd"><?php echo $time?></label>
                                    <input type="hidden" class="form-control" id="ponumber" name="ponumber" value="<?php echo $time; ?>">
                                    </div>
                                 </div>
                                 
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="usr">Prepared By:</label>
                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <p id="bckdate"> <?php echo $_SESSION['fullname']; ?></p>
                                    </div>
                                 </div>
                                 <label for="comment">Supplier:</label>
                                 <div class="input-group">
                                    <select class="form-control" id="cbosuppliers" name="cbosuppliers">
                                    </select>
                                    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button" id="btnload">Load!</button>
                                    </span>
                                 </div>
                                 <div class="form-group">
                                    <label for="deldate">Delivery Date:</label>
                                    <input type="date"  class="form-control" id="deldate" name="deldate">
                                 </div>
                                 <div class="form-group">
                                    <label for="comment">Checked By:</label>
                                    <select class="form-control" id="cboadmins" name="cboadmins">
                                    </select>
                                 </div>
                                 <div class="form-group">
                                    <label for="pwd">Confirmation:</label>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Checker Password">
                                 </div>
                                 <input type = "hidden" name = "action" value = "preparePo">
                                 <input type = "hidden" name = "sup_id" value = "sup_id" id="sup_id">
                                 <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                       <button type="submit" class="btn btn-primary pull-right">Prepare Purchase Order</button>
                                    </div>
                                 </div>

                           </div>
                        </div>
                     </div>
                  </div>
               </div>

            </form>





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
         var today = new Date();
          var dd = today.getDate();
          var mm = today.getMonth()+1; //January is 0!
          var yyyy = today.getFullYear();
           if(dd<10){
                  dd='0'+dd
              } 
              if(mm<10){
                  mm='0'+mm
              } 

          today = yyyy+'-'+mm+'-'+dd;
          document.getElementById("deldate").setAttribute("min", today);




         $(document).ready(function(){


           loadSuppliers();
           loadAdmins();

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
                      window.location = "purchaseorders.php";
                    }else{
                      $('#msgtitle').text('Error!');
                      $('#modalmsg').text(response.message);
                      $('#msgmodalbtn').text('Close');
                      $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
                      $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
                      $('#msgmodal').modal('show');                      
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