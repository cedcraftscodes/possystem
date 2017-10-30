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

  <link rel="stylesheet" type="text/css" href="../vendors/jquery/dist/jquery-ui.css">



  <style type="text/css">
  body { padding-right: 0 !important }

  figure {
    display: inline-block;
  }
  figure img {
    //vertical-align: top;
  }
  figure figcaption {
    text-align: center;
  }

  #addProdStockModal { overflow-y:scroll }

  .ui-autocomplete {
    z-index: 10000000;
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

        <div class="container">

          <div class="x_panel">
            <div class="x_title">
              <h2>Product Management </h2>
              <div class="clearfix"></div>

            </div>
            <div class="x_content">


              <div class="row">
                <div class="col-sm-5">
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addProductModal">Add new Product</button> <!-- Trigger the modal with a button -->


                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" id="addprodbtn" data-target="#addProdStockModal">Add new Product with Stock</button><p></p>  



                </div>
                <div class="col-sm-3">

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
                        <th>Brand</th>
                        <th>Description</th>
                        <th>Flooring</th>
                        <th>Ceiling</th>
                        <th>Unit</th>
                        <th>Markup %</th>
                        <th class="col-md-2">Action</th>
                      </tr>

                    </thead>
                    <tbody id="itemsbody"></tbody>
                  </table>
                </div>
              </div>
            </div>

          </div>
          <!-- End of Table -->

          <!-- Add Item Modal -->
          <div id="addProdStockModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Add new Product with Stock</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="addprodstock-form" enctype="multipart/form-data">


                    <h4><strong>Product Information</strong></h4>
                    <div class="form-group">
                      <label class="control-label col-sm-3" for="us_pname">Product Name:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="us_pname"  name="us_pname" required="">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-3" for="us_brand">Brand:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="us_brand"  name="us_brand" required="">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-3" for="us_desc">Description:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="us_desc"  name="us_desc" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="us_flooring">Flooring:</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="us_flooring" name="us_flooring" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="us_ceiling">Ceiling:</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="us_ceiling"  name="us_ceiling" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                      </div>
                    </div>

                    <div class="ui-widget">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_cbounit">Unit:</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="us_unit"  name="us_unit" >
                        </div>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="us_cbocategory">Category:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="us_category"  name="us_category" >
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="us_markuppercent">Markup Percentage:</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="us_markuppercent"  name="us_markuppercent" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  onchange="validity.valid||(value=10);" value=10 min=10 max=20 required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="us_pcode">Product Code:</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input type="text" class="form-control" id="us_pcode" name="us_pcode" readonly="" required="">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-toggle="modal"  data-target="#us_inputbarcodemodal">Scan Code</button>
                          </span>
                        </div>
                      </div>
                    </div>






                    <h4><strong>Supplier Information</strong></h4>
                    <div class="form-group">
                      <label class="control-label col-sm-3" for="chkuseold">Supplier Option:</label>
                      <div class="col-sm-9">
                        <div class="checkbox">
                          <label><input type="checkbox" checked="" name="chkuseold" id="chkuseold">Use old Supplier?</label>
                        </div>
                      </div>
                    </div>

                    <div id="div_useoldsupplier">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_suppliername">Supplier Name:</label>
                        <div class="col-sm-9">
                          <select class="form-control" id="us_suppliername" name="us_suppliername">
                          </select>
                        </div>
                      </div>
                    </div>


                    <div id="div_supplierdiv">
                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_sname">Supplier Name:</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="us_sname" placeholder="Enter Supplier Name" name="us_sname" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_rname">Receiver Name:</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="us_rname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Receiver Name" name="us_rname" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_street"> Street:</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="us_street" placeholder="Enter Street" name="us_street" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_city"> City:</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="us_city" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter City" name="us_city" required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_province"> Province:</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="us_province" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter  Province" name="us_province" required="">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_zipcode"> ZipCode:</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="us_zipcode" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Enter  Zip Code" name="us_zipcode"  title="Enter a valid zip code" pattern="[0-9]{4}"  required="">
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_contactnumber"> Contact Number:</label>
                        <div class="col-sm-9">
                          <input type="text" class="form-control" id="us_contactnumber" title="Enter a valid phone number" pattern="[0-9]{11}" placeholder="Enter  Contact Number" name="us_contactnumber" required="">
                        </div>
                      </div>


                      <div class="form-group">
                        <label class="control-label col-sm-3" for="us_email"> Email:</label>
                        <div class="col-sm-9">
                          <input type="email" class="form-control" id="us_email"  placeholder="Enter Supplier Email" name="us_email" required="">
                        </div>
                      </div>
                    </div>



                    <h4><strong>Supplier Price and Quantity</strong></h4>


                    <div class="form-group">
                      <label class="control-label col-sm-3" for="us_supplierprice">Supplier Price:</label>
                      <div class="col-sm-9">
                       <input type="number" class="form-control" id="us_supplierprice"  title="Currency" pattern="^\d+(?:\.\d{1,2})?$" onkeyup="setTwoNumberDecimal();" min="0" step="0.01" onchange="validity.valid||(value=0.00);" value="0.00" name="us_supplierprice">
                     </div>
                   </div>

                   <div class="form-group">
                     <label class="control-label col-sm-3" for="us_sellingprice">Selling Price:</label>
                     <div class="col-sm-9">
                      <label class="control-label" id="us_sellingprice">0</label>
                    </div>
                  </div>

                  <div class="form-group">
                   <label class="control-label col-sm-3" for="us_stockqty">Quantity:</label>
                   <div class="col-sm-9">
                    <input type="number" class="form-control" id="us_stockqty"  min=1 name="us_stockqty" onchange="validity.valid||(value=1);"  value=1 onkeypress='return event.charCode >= 48 && event.charCode <= 57'>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="us_totalprice">Total:</label>
                  <div class="col-sm-9">
                    <label class="control-label" id="us_totalprice">0.00</label>
                  </div>
                </div>

                <input type = "hidden" name = "action" value = "addStockProduct">

              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <!-- Add Item Modal -->
      <div id="addProductModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header modal-header-info">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Add new Product</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="add-form" enctype="multipart/form-data">
                <div class="form-group">
                  <label class="control-label col-sm-3" for="pname">Product Name:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="pname"  name="pname" required="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="brand">Brand:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="brand"  name="brand" required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="desc">Description:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" id="desc"  name="desc" >
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="flooring">Flooring:</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="flooring" name="flooring" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                  </div>
                </div>
                <div class="form-group">
                  <label class="control-label col-sm-3" for="ceiling">Ceiling:</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="ceiling"  name="ceiling" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="cbounit">Unit:</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="cbounit" name="cbounit">

                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="cbocategory">Category:</label>
                  <div class="col-sm-9">
                    <select class="form-control" id="cbocategory" name="cbocategory">
                    </select>
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="quantity_sup">Markup Percentage:</label>
                  <div class="col-sm-9">
                    <input type="number" class="form-control" id="markuppercent"  name="markuppercent" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  onchange="validity.valid||(value=10);" value=10 min=10 max=20 required="">
                  </div>
                </div>

                <div class="form-group">
                  <label class="control-label col-sm-3" for="pcode">Product Code:</label>
                  <div class="col-sm-9">
                    <div class="input-group">
                      <input type="text" class="form-control" id="pcode" name="pcode" readonly="" required="">
                      <span class="input-group-btn">
                        <button class="btn btn-default" type="button" data-toggle="modal"  data-target="#inputbarcodemodal">Scan Code</button>
                      </span>
                    </div>
                  </div>
                </div>

                <input type = "hidden" name = "action" value = "addProduct">
              </div>
              <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
              </div>
            </form>
          </div>
        </div>
      </div>


      <!-- Update Modal -->
      <div id="updateProductModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header modal-header-info">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Update Product</h4>
            </div>
            <div class="modal-body">
              <form class="form-horizontal" id="update-form">

               <div class="form-group">
                <label class="control-label col-sm-3" for="u_pname">Product Name:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="u_pname"  name="u_pname" required="">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-3" for="u_brand">Brand:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="u_brand"  name="u_brand" >
                </div>
              </div>
              <div class="form-group">
                <label class="control-label col-sm-3" for="u_desc">Description:</label>
                <div class="col-sm-9">
                  <input type="text" class="form-control" id="u_desc"  name="u_desc">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-3" for="u_flooring">Flooring:</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="u_flooring" name="u_flooring" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-3" for="u_ceiling">Ceiling:</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="u_ceiling"  name="u_ceiling" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-3" for="u_cbounit">Unit:</label>
                <div class="col-sm-9">
                  <select class="form-control" id="u_cbounit" name="u_cbounit" required="">

                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-3" for="u_cbocategory">Category:</label>
                <div class="col-sm-9">
                  <select class="form-control" id="u_cbocategory" name="u_cbocategory">
                  </select>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-sm-3" for="quantity_sup">Markup Price:</label>
                <div class="col-sm-9">
                  <input type="number" class="form-control" id="u_markuppercent"  name="u_markuppercent" onkeypress='return event.charCode >= 48 && event.charCode <= 57'  onchange="validity.valid||(value=10);" value=10 min=10 max=20 required="">
                </div>
              </div>


              <div class="form-group">
                <label class="control-label col-sm-3" for="u_pcode">Product Code:</label>
                <div class="col-sm-9">
                  <div class="input-group">
                    <input type="text" class="form-control" id="u_pcode" name="u_pcode" readonly="" required="">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button" data-toggle="modal" data-target="#u_inputbarcodemodal">Scan Code</button>
                    </span>
                  </div>
                </div>
              </div>

              <input type = "hidden" id = "u_id" name = "u_id" >
              <input type = "hidden" name = "action" value = "updateProduct">

            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Submit</button>
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
            <h4 class="modal-title">Delete Item</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete this item?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger yes" >Yes</button>
            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>


        <div id="addmoremodal" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header modal-header-info">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add new Product Using Same Supplier?</h4>
          </div>
          <div class="modal-body">
            <p>Do you want to add new product using the same supplier?</p>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary yes" id="addmorebtn" >Yes</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
  </div>  <!-- End of container -->
</div>
</div>
<!-- /page content -->
<?php include('templates/admin.footer.php'); ?>
</div>
</div>




<!-- jQuery -->
<script src="../vendors/jquery/dist/jquery.min.js"></script>
<script src="../vendors/jquery/dist/jquery-ui.js"></script>



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




<div id="us_inputbarcodemodal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-header-info">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Scan / Input Barcode</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="us_changebc-form">
          <div class="form-group">
            <label class="control-label col-sm-2" for="us_barcode_scan">Barcode:</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="us_barcode_scan" placeholder="Scan Barcode" name="us_barcode_scan" required="">
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
  function setTwoNumberDecimal(event) {
    this.value = parseFloat(this.value).toFixed(2);
  }


// Select your input element.
var number = document.getElementById('us_stockqty');
number.onkeydown = function(e) {
  if(!((e.keyCode > 95 && e.keyCode < 106)
    || (e.keyCode > 47 && e.keyCode < 58) 
    || e.keyCode == 8)) {
    return false;
}
}

$(document).ready(function(){
  loadUnit();
  loadCategories();
  loadProducts();
  loadSuppliers();

  loadUnitAutoComplete();
  loadCategoryAutoComplete();

  $('#us_suppliername').removeAttr('required');
  $('#us_sname').removeAttr('required');
  $('#us_rname').removeAttr('required');
  $('#us_street').removeAttr('required');
  $('#us_city').removeAttr('required');
  $('#us_province').removeAttr('required');
  $('#us_zipcode').removeAttr('required');
  $('#us_contactnumber').removeAttr('required');
  $('#us_email').removeAttr('required');




  $('#addmorebtn').click(function(e){

    //disable the freaking dropdown
    $('#us_suppliername').prop('disabled',true);
    //show the product modal

    $('#addmoremodal').modal('hide');
    $('#addProdStockModal').modal('show');





  });







  $( "#us_pname" ).keyup(function(e) {
    var product_name = $('#us_pname').val();
    $.ajax({
      url : 'product/prodmgtfunc.php',
      type : 'POST',
      data : {pname : product_name, action : 'showExistingProduct'},
      dataType: 'json',
      success : function(result)
      {
          //alert(JSON.stringify(result));
          //$('#us_pname').val(result.pname);
          $('#us_desc').val(result.desc);
          $('#us_brand').val(result.pbrand);
          $('#us_pcode').val(result.pcode);
          $('#us_flooring').val(result.flooring);
          $('#us_ceiling').val(result.ceiling);
          $('#us_unit').val(result.unitname);
          $('#us_category').val(result.cat);
          $('#us_markuppercent').val(result.markup);
          //$('#us_id').val(id);

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


  $('#us_pname').bind('input', function(){ 

    var product_name = $('#us_pname').val();

    $.ajax({

      url : 'product/prodmgtfunc.php',
      type : 'POST',
      data : {pname : product_name, action : 'showExistingProduct'},
      dataType: 'json',
      success : function(result)
      {
          //alert(JSON.stringify(result));
          //$('#us_pname').val(result.pname);
          $('#us_desc').val(result.desc);
          $('#us_brand').val(result.pbrand);
          $('#us_pcode').val(result.pcode);
          $('#us_flooring').val(result.flooring);
          $('#us_ceiling').val(result.ceiling);
          $('#us_unit').val(result.unitname);
          $('#us_category').val(result.cat);
          $('#us_markuppercent').val(result.markup);
          //$('#us_id').val(id);

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


  $( "#us_sname" ).keyup(function(e) {
    e.preventDefault();
    var supplier_name = $('#us_sname').val();

    $.ajax({

      url : 'product/prodmgtfunc.php',
      type : 'POST',
      data : {sname : supplier_name, action : 'showExistingSupplier'},
      dataType: 'json',
      success : function(result)
      {
        $('#us_rname').val(result.rname);
        $('#us_email').val(result.email);
        $('#us_street').val(result.street);
        $('#us_city').val(result.city);
        $('#us_province').val(result.province);
        $('#us_zipcode').val(result.zipcode);
        $('#us_contactnumber').val(result.contact);
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




  $("#addprodbtn").click(function(){
    $('#us_suppliername').prop('disabled',false);
  }); 







  $("#us_markuppercent").change(function(){
    computeTotalPrice();
  });

  $("#us_stockqty").keyup(function(){
    computeTotalPrice();
  });

  $("#us_supplierprice").change(function(){

    computeTotalPrice();
  });

  $("#us_supplierprice").keyup(function(){
    computeTotalPrice();
  });
  function computeTotalPrice(){
    var supplier_price = parseFloat($("#us_supplierprice").val());
    var quantity = parseInt($("#us_stockqty").val());
    var markup =  parseFloat($("#us_markuppercent").val()) / 100;
    var individualprice = (supplier_price + (supplier_price * markup)) || 0;
    $("#us_sellingprice").html("₱ " + individualprice.toFixed(2) );


    var total = (quantity * individualprice) || 0;
    $("#us_totalprice").text("₱ " + total.toFixed(2));
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
     $('#us_suppliername').html(result);
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

 $("#div_supplierdiv").hide(); 
 $('#chkuseold').change(function() {
  if(this.checked) {
    $("#div_useoldsupplier").show(); 
    $("#div_supplierdiv").hide();   


    $('#us_suppliername').removeAttr('required');
    $('#us_sname').removeAttr('required');
    $('#us_rname').removeAttr('required');
    $('#us_street').removeAttr('required');
    $('#us_city').removeAttr('required');
    $('#us_province').removeAttr('required');
    $('#us_zipcode').removeAttr('required');
    $('#us_contactnumber').removeAttr('required');
    $('#us_email').removeAttr('required');


  }else{
    $("#div_supplierdiv").show(); 
    $("#div_useoldsupplier").hide();    

    $('#us_sname').val("");
    $('#us_rname').val("");
    $('#us_email').val("");
    $('#us_street').val("");
    $('#us_city').val("");
    $('#us_province').val("");
    $('#us_zipcode').val("");
    $('#us_contactnumber').val("");      

    $('#us_suppliername').prop('required',true);
    $('#us_sname').prop('required',true);
    $('#us_rname').prop('required',true);
    $('#us_street').prop('required',true);
    $('#us_city').prop('required',true);
    $('#us_province').prop('required',true);
    $('#us_zipcode').prop('required',true);
    $('#us_contactnumber').prop('required',true);
    $('#us_email').prop('required',true);


  }
});

 /* Focus on barcode scanner in scanning barcode*/
 $('#inputbarcodemodal').on('shown.bs.modal', function () {
  $('#barcode_scan').focus();
});


 $('#u_inputbarcodemodal').on('shown.bs.modal', function () {
  $('#u_barcode_scan').focus();
});


 $('#us_inputbarcodemodal').on('shown.bs.modal', function () {
  $('#us_barcode_scan').focus();
});


 $('#changebc-form').submit(function(e){
  e.preventDefault();
  $('#pcode').val($('#barcode_scan').val());

  $('#inputbarcodemodal').modal('hide');
}); 


 $('#u_changebc-form').submit(function(e){
  e.preventDefault();
  $('#u_pcode').val($('#u_barcode_scan').val());

  $('#u_inputbarcodemodal').modal('hide');
}); 


 $('#us_changebc-form').submit(function(e){
  e.preventDefault();
  $('#us_pcode').val($('#us_barcode_scan').val());

  $('#us_inputbarcodemodal').modal('hide');
}); 




 $('#add-form').submit(function(e){


  e.preventDefault();

  var formData = new FormData(this);

  $.ajax({
    url: 'product/prodmgtfunc.php',
    type: 'POST',
    cache: false,
    data: formData,
    async: false,
    processData: false,
    contentType: false,
    dataType: 'html',
    success: function(result)
    {
      $('#itemsbody').html(result);
      $('#addProductModal').modal('toggle');
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
});


 $('#addprodstock-form').submit(function(e){

  e.preventDefault();
  $('#us_suppliername').prop('disabled',false);


  var formData = new FormData(this);

  $.ajax({
    url: 'product/prodmgtfunc.php',
    type: 'POST',
    cache: false,
    data: formData,
    async: false,
    processData: false,
    contentType: false,
    dataType: 'html',
    success: function(result)
    {
      $('#itemsbody').html(result);
      $('#addProdStockModal').modal('toggle');
      $('#addmoremodal').modal('show');
      $('#us_suppliername').prop('disabled',true);
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
});




 var searchreq = null;
 function load_data(query)
 {
  if (searchreq != null) searchreq.abort();
  searchreq = $.ajax({
    url:"product/searchproduct.php",
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
    loadProducts();

  }
});
});

function loadUnitAutoComplete(){

  $.ajax({

    url : 'product/prodmgtfunc.php',
    type : 'POST',
    data : {action : 'showUnitAutoComplete'},
    dataType: 'json',
    success : function(result)
    {

      $("#us_unit").autocomplete({
        source: result
      });

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


function loadCategoryAutoComplete(){

  $.ajax({

    url : 'product/prodmgtfunc.php',
    type : 'POST',
    data : {action : 'showCategoryAutoComplete'},
    dataType: 'json',
    success : function(result)
    {
      $("#us_category").autocomplete({
        source: result
      });

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





function loadUnit()
{ 
  $.ajax({

   url: 'product/prodmgtfunc.php',
   type: 'POST',
   data: {action : 'loadUnit'},
   dataType: 'html',
   success: function(result)
   {
    $('#cbounit').html(result);
    $('#u_cbounit').html(result);
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





function loadCategories()
{ 
  $.ajax({

   url: 'product/prodmgtfunc.php',
   type: 'POST',
   data: {action : 'loadCategories'},
   dataType: 'html',
   success: function(result)
   {
    $('#cbocategory').html(result);
    $('#u_cbocategory').html(result);
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



function loadProducts()
{ 
  $.ajax({

   url: 'product/prodmgtfunc.php',
   type: 'POST',
   data: {action : 'loadProducts'},
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


function deleteProduct(id)
{

  $("#deleteModal").modal("show");
  $('.yes').click(function(e){

    $.ajax({

      url : 'product/prodmgtfunc.php',
      type : 'POST',
      data : {action : 'deleteProduct', id : id},
      dataType: 'html',

      success: function(result)
      {
        $('#itemsbody').html(result);
        $("#deleteModal").modal("hide");
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


function updateProduct(id)
{
  $("#updateProductModal").modal("show");
  $.ajax({
    url : 'product/prodmgtfunc.php',
    type : 'POST',
    data : {id : id, action : 'showUpdateProduct'},
    dataType: 'json',
    success : function(result)
    {
      $('#u_pname').val(result.pname);
      $('#u_desc').val(result.desc);
      $('#u_brand').val(result.pbrand);
      $('#u_pcode').val(result.pcode);
      $('#u_flooring').val(result.flooring);
      $('#u_ceiling').val(result.ceiling);
      $('#u_cbounit').val(result.unitname);
      $('#u_cbocategory').val(result.cat);
      $('#u_markuppercent').val(result.markup);
      $('#u_id').val(id);

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

  $('#update-form').submit(function(e){
    e.preventDefault();
    $.ajax({

      url: 'product/prodmgtfunc.php',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'html',
      success: function(result)
      {
        $('#itemsbody').html(result);
        $("#updateProductModal").modal("hide");
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
  }); 
} 
</script>
</body>
</html>


