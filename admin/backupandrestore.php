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
               <div class="container">
                  <div class="col-md-6">
                     <div class="x_panel">
                        <div class="x_title">
                           <h2>Restore Database</h2>
                           <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="row">
                              <form id="restore-form">
                                 <div class="form-group">
                                    <label for="cborestore">Select Database To Restore:</label>
                                    <select class="form-control" id="cborestore" name="cbobackupVal" onchange="cborestore_onchange()">
                                    </select>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="usr">Backup Name:</label>
                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <p id="bckname"></p>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="usr">Backup Date:</label>
                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <p id="bckdate"></p>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="usr">Backup Remarks:</label>
                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <p id="bckremarks"></p>
                                    </div>
                                 </div>
                                 <div class="form-group">
                                    <label for="comment">Restore Remarks:</label>
                                    <textarea class="form-control" rows="5" id="restorerem" placeholder="Input Reason why you want to restore." name="remarks"></textarea>
                                 </div>
                                 <div class="checkbox">
                                    <label><input type="checkbox" id="chkbackup" name="chkbackup" checked="">Backup Database Before Restoring database.</label>
                                 </div>
                                 <div class="form-group">
                                    <label for="pwd">Enter Password to continue:</label>
                                    <input type="password" class="form-control" id="password" name="password">
                                 </div>
                                 <input type = "hidden" name = "action" value = "restoreact">
                                 <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                       <button type="submit" class="btn btn-primary pull-right" id="btnrestore">Restore Database</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="x_panel">
                        <div class="x_title">
                           <h2>Backup Database</h2>
                           <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="row">
                              <form id="backup-form">
                                 <div class="form-group">
                                    <label for="comment">Remarks:</label>
                                    <textarea class="form-control" rows="5" name="txtremarks" placeholder="Input Reason why you want to backup database."></textarea>
                                 </div>

                                 <input type = "hidden" name = "action" value = "startbackup">                               
                                 <div class="form-group">
                                    <div class="col-sm-offset-2 col-sm-10">
                                       <button type="submit" class="btn btn-primary pull-right">Backup Database</button>
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

      <div id="response">
        

      </div>
      <script type="text/javascript">
         $(document).ready(function(){
                  
         $('#restore-form').submit(function(e){
          e.preventDefault();
          $.ajax({
         
            url: 'backuprestore/bckres.php',
            type: 'POST',
            data: $("#restore-form").serialize(),
            dataType: 'html',
            success: function(result)
            {
              $('#response').html(result);
        
              $('#msgtitle').text('Success!');
              $('#modalmsg').text('Database Restored!');
              $('#msgmodalbtn').text('Close');
              $('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
              $('#msgmodalheader').attr('class', 'modal-header modal-header-success');
              $('#msgmodal').modal('show');
              loadBackUps();        
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
         });


        $('#backup-form').submit(function(e){
          e.preventDefault();
          $.ajax({
         
            url: 'backuprestore/bckres.php',
            type: 'POST',
            data: $("#backup-form").serialize(),
            dataType: 'html',
            success: function(result)
            {
              
              $('#msgtitle').text('Success!');
              $('#modalmsg').text('Database backup completed!');
              $('#msgmodalbtn').text('Close');
              $('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
              $('#msgmodalheader').attr('class', 'modal-header modal-header-success');
              $('#msgmodal').modal('show');

              loadBackUps();
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
         });





         



          loadBackUps();
         });
         
         function loadBackUps()
         { 
          $.ajax({
         
           url: 'backuprestore/bckres.php',
           type: 'POST',
           data: {action : 'loadbackups'},
           dataType: 'html',
           success: function(result)
           {
            $('#cborestore').html(result);
            cborestore_onchange();
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
         
         
         function cborestore_onchange(){
         
         $.ajax({
         
          url : 'backuprestore/bckres.php',
          type : 'POST',
          data : {
            id : $("#cborestore").val(), 
            action : 'showBackupInfo'
          },
          dataType: 'json',
          success : function(result)
          {
         
            $('#bckname').text(result.name);
            $('#bckdate').text(result.date);
            $('#bckremarks').text(result.remarks);
         
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