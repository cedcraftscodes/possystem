<?php include 'auth.php'; ?> 
<?php include 'accountinfo.php'; ?>
<?php 
   function secure($str){
     return strip_tags(trim(htmlspecialchars($str)));
   }
   
   if(isset($_GET['poid'])){
     $id = secure($_GET['poid']);
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
                                            <form id="delivery-form" >
            <div class="right_col" role="main">
               <div class="container">
                  <div class="col-md-8">
                     <div class="x_panel">
                        <div class="x_title">
                           <h2>Delivery Items</h2>
                           <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="row">
                              <div class="col-sm-3">
                                 <a href="purchaseorders.php" class="btn btn-info btn-md" > <i class="fa fa-arrow-left" aria-hidden="true"></i> Back</a>
                                 <p></p>
                                 <!-- Trigger the modal with a button -->
                              </div>
                              <div class="col-sm-6">
                              </div>
                              <div class="col-sm-3">
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
                                                <th>Requested</th>
                                                <th>Delivered</th>
                                                <th>Supplier Price</th>
                                                <th>Quantity To Deliver</th>
                                             </tr>
                                          </thead>
                                          <tbody id="delitems">
                                             <?php 
                                                include 'config/config.php';
                                                
                                                $stmt = $conn->prepare("SELECT
                                                  pr.id,
                                                  pr.Product_name,
                                                  poi.`Quantity_Requested`,
                                                  (
                                                  SELECT
                                                  SUM(`Quantity_Delivered`)
                                                  FROM
                                                  tblpodel_items AS podi
                                                  WHERE
                                                  `ProductId` = poi.`ProductId` AND pod.Po_id = :pid
                                                  ) AS Delivered,
                                                  (
                                                  SELECT
                                                  st.`SupplierPrice`
                                                  FROM
                                                  tblstocks AS st
                                                  WHERE
                                                  st.ProductId = poi.`ProductId`
                                                  ORDER BY
                                                  st.StockId
                                                  DESC
                                                  LIMIT 1
                                                  ) AS 'LatestPrice'
                                                  FROM
                                                  `tblpo_items` AS poi
                                                  LEFT JOIN tblpodeliveries AS pod
                                                  ON
                                                  pod.Po_id = poi.`Po_id`
                                                  INNER JOIN tblproducts AS pr
                                                  ON
                                                  pr.id = poi.`ProductId`
                                                  WHERE
                                                  poi.`Po_id` = :pid
                                                  GROUP BY
                                                  pr.id,
                                                  poi.`Po_id`
                                                  ORDER BY Delivered");
                                                
                                                
                                                
                                                if ($stmt->execute(array(':pid' => $id))) {
                                                  $step = 1;
                                                  while ($r = $stmt->fetch()) {
                                                
                                                    $delivered = (int)$r['Delivered'];
                                                    $requested = (int)$r['Quantity_Requested'];
                                                    echo "<tr>";
                                                    echo "<td>".$step."</td>";
                                                    echo "<td>".$r['Product_name']."</td>";
                                                    echo "<td>".$requested."</td>";
                                                    echo "<td>".$delivered."</td>"; 
                                                
                                                    if($requested == $delivered){
                                                
                                                      echo "<td>₱ <input type='number' disabled='' title='Currency' pattern='^\d+(?:\.\d{1,2})?$' onkeyup='setTwoNumberDecimal()' min='0' step='0.01' style='width: 7em' name='prices[".$r['id']."]' value='".number_format((double)$r['LatestPrice'], 2, '.', '')."'></td>";

                                                      echo "<td><input type='number' disabled='' onkeypress='return event.charCode >= 48 && event.charCode <= 57' style='width:100%' min='0' max='".($requested - $delivered)."' name='quantities[".$r['id']."]' placeholder='Max = ".($requested - $delivered)."'></td>";
                                                
                                                    }else{
                                                
                                                      echo "<td>₱ <input type='number' title='Currency' pattern='^\d+(?:\.\d{1,2})?$' onkeyup='setTwoNumberDecimal()' min='0' step='0.01' style='width: 7em' name='prices[".$r['id']."]' value='".number_format((double)$r['LatestPrice'], 2, '.', '')."'></td>";

                                                      echo "<td><input type='number' onkeypress='return event.charCode >= 48 && event.charCode <= 57' style='width:100%' min='0' max='".($requested - $delivered)."' name='quantities[".$r['id']."]' placeholder='Max = ".($requested - $delivered)."'></td>";
                                                
                                                    }
                                                    echo "</tr>";
                                                    $step++;
                                                  }
                                                }
                                                ?>
                                          </tbody>
                                       </table>
                                    </div>
                                    <input type = "hidden" name = "action" value ="deliverProducts" id="action">
                                    <input type = "hidden" name = "poid" value ="<?php echo $id; ?>" id="poid">
 

                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <?php 
                     include 'config/config.php';
                     
                     $stmt = $conn->prepare("SELECT
                       `Po_number`,
                       sp.Supplier_name
                     
                       FROM
                       `tblpurchaseorders` as po
                       INNER JOIN tblsuppliers as sp 
                       on sp.Supplier_id = po.`Supplier_id`
                       WHERE `Po_id`=:id");
                     $stmt->bindParam(':id',$id);
                     $stmt->execute(); 
                     $row = $stmt->fetch();
                     $pon = $row['Po_number'];
                     $supplier = $row['Supplier_name'];
                     ?>
                  <div class="col-md-4">
                     <div class="x_panel">
                        <div class="x_title">
                           <h2>Delivery Information</h2>
                           <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="row">
                              <div style="margin-left: 20px">
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="delnum">Delivery Identification:</label>
                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <input type="text" class="form-control" id="delnum" name="delnum" placeholder="Delivery Identification" required="">
                                    </div>
                                 </div>
                                 <br>
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
                                          <label for="usr">Supplier:</label>
                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <p id="bckdate"> <?php echo $supplier; ?></p>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-4">
                                       <div class="form-group">
                                          <label for="usr">Received By:</label>
                                       </div>
                                    </div>
                                    <div class="col-md-8">
                                       <p id="bckdate"> <?php echo $_SESSION['fullname']; ?></p>
                                    </div>
                                 </div>

                                                                    <div class="form-group">
                                       <div class="col-sm-offset-2 col-sm-10">
                                          <button type="submit" class="btn btn-primary pull-right">Deliver</button>
                                       </div>
                                    </div>
                                    
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

                                             </form>
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

        function setTwoNumberDecimal(event) {
          this.value = parseFloat(this.value).toFixed(2);
        }



         $(document).ready(function(){
         
         
          $('#delivery-form').submit(function(e){
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
             url: 'deliveries/delfunctions.php',
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
                $('#msgtitle').text('Success!');
                $('#modalmsg').text(response.message + " You will be redirected shortly!");
                $('#msgmodalbtn').text('Close');
                $('#msgmodalbtn').attr('class', 'btn btn-success pull-right');
                $('#msgmodalheader').attr('class', 'modal-header modal-header-success');
                $('#msgmodal').modal('show');
         
                setTimeout(function () {
                 window.location.href = "deliveries.php"; 
               }, 2000); 
         
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
         
      </script>
   </body>
</html>