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
              <h2>Defective Products </h2>
              <div class="clearfix"></div>
            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-sm-8">
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#returnfromcust">Return Product from Customer</button>

                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#returntosupplier">Return Product from Stock</button><p></p>    <!-- Trigger the modal with a button -->
                </div>

                <div class="col-sm-4">

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Search</span>
                      <input type="text" name="search_text" id="search_text" placeholder="Product Name / Supplier" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>

              <div id="printArea">
                <div class="table-responsive">
                  <table id="itemtable" class="table table-condensed">  <!-- Start of Table -->
                    <thead>
                      <tr>
                        <th>Bad Order Id</th>
                        <th>Product Name</th>
                        <th>Supplier Name</th>
                        <th>Supplier Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remarks</th>
                        <th>Prepared By</th>
                        <th>Date Prepared</th>
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

          <!-- Update Modal -->
          <div id="replacebomodal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Replace Defective Product</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="replaceproduct-form">

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Product Name:</label>
                      <div class="col-sm-9">
                        <p id="replace_prodname">------</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Supplier Name:</label>
                      <div class="col-sm-9">
                        <p id="replace_suppname">------</p>
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Supplier Price:</label>
                      <div class="col-sm-9">
                        <p id="replace_supprice">------</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Product Count:</label>
                      <div class="col-sm-9">
                        <p id="replace_quantity">0</p>
                      </div>
                    </div>


             <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Prepared By: :</label>
                      <div class="col-sm-9">
                        <p id="replace_prepare">--------</p>
                      </div>
                    </div>



                    <div class="form-group">
                                 <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Remarks:</label>
                      <div class="col-sm-9">
                        <p id="replace_remarks">--------</p>
                      </div>
                    </div>





                      <label class="control-label col-sm-3" for="quantity_sup">Quantity:</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="replace_quantityin"  name="replace_quantityin" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                      </div>
                    </div>


                  <input type = "hidden" id = "u_bid" name = "u_bid" >
                  <input type = "hidden" name = "action" value = "replaceboproduct">

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
          <div id="returntosupplier" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Return Product from Stock</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="ownerret-form" enctype="multipart/form-data">

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbostockid">Stock Id:</label>
                      <div class="col-sm-9">
                        <select class="form-control" id="cbostockid" name="cbostockid">
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Product Name:</label>
                      <div class="col-sm-9">
                        <p id="prodname_sup">------</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Supplier Name:</label>
                      <div class="col-sm-9">
                        <p id="supname_sup">------</p>
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Supplier Price:</label>
                      <div class="col-sm-9">
                        <p id="supprice_price">------</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Product Count:</label>
                      <div class="col-sm-9">
                        <p id="productcount_sup">0</p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="quantity_sup">Quantity:</label>
                      <div class="col-sm-9">
                        <input type="number" class="form-control" id="quantity_sup"  name="quantity_sup" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                      </div>
                    </div>



                    <div class="form-group">
                      <label class="control-label col-sm-3" for="cbocategory">Remarks:</label>
                      <div class="col-sm-9">
                        <input type="text" name="remarks_sup" class="form-control" placeholder="Enter reason for returning product">
                      </div>
                    </div>



                    <div class="form-group">
                      <label class="control-label col-sm-3" for="u_pname">Password:</label>
                      <div class="col-sm-9">
                        <input type="password" class="form-control" id="password_sup"  name="password_sup" required="" placeholder="Enter password to continue">
                      </div>
                    </div>
                    <input type = "hidden" name = "action" value = "returnownertosup">
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
          <div id="returnfromcust" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Return Stock From Customer</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="custret-form" enctype="multipart/form-data">
                   <div class="form-group">
                    <label class="control-label col-sm-3" for="pcode">Transaction Number:</label>
                    <div class="col-sm-9">
                      <div class="input-group">
                        <input type="text" class="form-control" id="tnum" name="tnum" required="">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button" id="btnload">Load</button>
                        </span>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="cbocategory">Product:</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="cboprodcust" name="cboprodcust">
                      </select>
                    </div>
                  </div>



                  <div class="form-group">
                    <label class="control-label col-sm-3" for="cbocategory">Supplier Name:</label>
                    <div class="col-sm-9">
                      <p id="supname_cust">------</p>
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-sm-3" for="cbocategory">Supplier Price:</label>
                    <div class="col-sm-9">
                      <p id="supprice_cust">------</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="cbocategory">Selling Price:</label>
                    <div class="col-sm-9">
                      <p id="selling_cust">------</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="cbocategory">Product Count:</label>
                    <div class="col-sm-9">
                      <p id="quantity_cust">0</p>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="ceiling">Quantity:</label>
                    <div class="col-sm-9">
                      <input type="number" class="form-control" id="cust_quantity"  name="cust_quantity" onkeypress='return event.charCode >= 48 && event.charCode <= 57' required="">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-sm-3" for="cust_remarks">Remarks:</label>
                    <div class="col-sm-9">
                      <input type="text" name="cust_remarks" class="form-control" placeholder="Enter reason for returning product">
                    </div>
                  </div>




                  <div class="form-group">
                    <label class="control-label col-sm-3" for="u_desc">Action:</label>
                    <div class="col-sm-9">

                      <div class="radio">
                        <label><input type="radio" checked="" name="refund_replace" value="refund" id="refund_cust">Refund</label>
                      </div>

                      <div class="radio">
                        <label><input type="radio" name="refund_replace" value="replace" id="replace_cust">Product Replacement</label>
                      </div>

                      <div id="replacementdiv" hidden=""> 
                        <div class="form-group">
                          <label class="control-label col-sm-3" for="cbocategory">Stock Out Id:</label>
                          <div class="col-sm-9">
                            <p id="cust_repsoid">------</p>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="control-label col-sm-3" for="cbocategory">Product Name:</label>
                          <div class="col-sm-9">
                            <p id="cust_repprodname">------</p>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="cust_pass">Password:</label>
                    <div class="col-sm-9">
                      <input type="password" class="form-control" id="cust_pass"  name="cust_pass" required="" placeholder="Enter password to continue">
                    </div>
                  </div>
                  <input type = "hidden" name = "action" value = "returnprodcust">
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

<script type="text/javascript">

  $(document).ready(function(){
    loadBadOrders();
    loadStockidToCbo();


    $('#refund_cust').click(function(){
      $("#refund_cust").prop('checked', true);
      $("#replace_cust").prop('checked', false);
    });

    $('#replace_cust').click(function(){
      $("#replace_cust").prop('checked', true);
      $("#refund_cust").prop('checked', false);
      checkForReplacement();
    });


    $('#refund_cust').change(function() {
      if(this.checked) {
        $("#replacementdiv").hide();    
      }else{
        $("#replacementdiv").show();
        //$("#refund_cust").prop('checked', false);
      }
    });



    $('#replace_cust').change(function() {
      if(this.checked) {
        $("#replacementdiv").show(); 
      }else{
        $("#replacementdiv").hide();
        $(this).prop('checked', false);             
      }
    });




    $( "#cboprodcust" ).change(function() {
      var transid = $('#tnum').val();
      var prodi = $('#cboprodcust').val();

      $.ajax({
        url : 'badorders/badordersfunc.php',
        type : 'POST',
        data : {tid : transid, pid:prodi, action : 'showreplaceinfo'},
        dataType: 'json',
        success : function(result)
        {
          $('#supname_cust').text(result.supname);
          $('#supprice_cust').text(result.supprice);
          $('#selling_cust').text(result.selling);
          $('#quantity_cust').text(result.quantity);

          $("#cust_quantity").attr({
           "max" : result.quantity,
           "min" : 1          
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
    });



    $( "#cbostockid" ).change(function() {
      var sid = $('#cbostockid').val();
      $.ajax({
        url : 'badorders/badordersfunc.php',
        type : 'POST',
        data : {action : 'showownertosupplier', stockid:sid},
        dataType: 'json',
        success : function(result)
        {
          $('#prodname_sup').text(result.Product_name);
          $('#supname_sup').text(result.Supplier_name);
          $('#supprice_price').text(result.SupplierPrice);
          $('#productcount_sup').text(result.No_Of_Items);

          $("#quantity_sup").attr({
           "max" : result.No_Of_Items,
           "min" : 1          
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
    });




    $( "#tnum" ).keyup(function() {
      loadProductsToCbo();
    });

    $( "#btnload" ).click(function() {
      loadProductsToCbo();

    });


    $('#ownerret-form').submit(function(e){
      e.preventDefault();
      var formData = new FormData(this);
      $.ajax({
        url: 'badorders/badordersfunc.php',
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
          $('#returntosupplier').modal('toggle');
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




    $('#custret-form').submit(function(e){
      e.preventDefault();
      var formData = new FormData(this);
      $.ajax({
        url: 'badorders/badordersfunc.php',
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
          $('#returnfromcust').modal('toggle');
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
        url:"badorders/searchbo.php",
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
        loadBadOrders();

      }
    });
  });

  function checkForReplacement(){
    var transid = $('#tnum').val();
    var prodi = $('#cboprodcust').val();
    var quantity = $('#cust_quantity').val();
    
    $.ajax({
      url : 'badorders/badordersfunc.php',
      type : 'POST',
      data : {tid : transid, pid:prodi, qty:quantity,action : 'checkForReplacement'},
      dataType: 'json',
      success : function(result)
      {
        if(result.hasReplacement){
          $('#cust_repprodname').text(result.prodname);
          $('#cust_repsoid').text(result.soid);

        }
        else
        {
          $('#msgtitle').text('No replacement!');
          $('#modalmsg').text('Product has no replacement in stocks outside!');
          $('#msgmodalbtn').text('Close');
          $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
          $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
          $('#msgmodal').modal('show');
          $("#refund_cust").prop('checked', true);
          $("#replace_cust").prop('checked', false);
          $("#replacementdiv").hide();
        }
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


  
  function loadStockidToCbo()
  { 
    $.ajax({
     url: 'badorders/badordersfunc.php',
     type: 'POST',
     data: {action : 'loadStockidToCbo'},
     dataType: 'html',
     success: function(result)
     {
      $('#cbostockid').html(result);
      $( "#cbostockid" ).change();
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



  function loadProductsToCbo()
  { 
    var tidno = $('#tnum').val();
    $.ajax({

     url: 'badorders/badordersfunc.php',
     type: 'POST',
     data: {action : 'loadProductsToCbo', tid: tidno},
     dataType: 'html',
     success: function(result)
     {
      $('#cboprodcust').html(result);
      $( "#cboprodcust" ).change();

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

  function loadBadOrders()
  { 
    $.ajax({

     url: 'badorders/badordersfunc.php',
     type: 'POST',
     data: {action : 'loadBadOrders'},
     dataType: 'html',
     success: function(result)
     {
      $('#itemsbody').html(result);
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

  function replaceproduct(id)
  {
    $("#replacebomodal").modal("show");
    $.ajax({
      url : 'badorders/badordersfunc.php',
      type : 'POST',
      data : {bid:id, action : 'showUpdateBadOrders'},
      dataType: 'json',
      success : function(result)
      {

        $('#replace_prodname').text(result.Product_name);
        $('#replace_remarks').text(result.remarks);
        $('#replace_suppname').text(result.Supplier_name);
        $('#replace_supprice').text(result.supplier_price);
        $('#replace_quantity').text(result.quantity);
        $('#replace_prepare').text(result.Prepared);
        $('#u_bid').val(id);

        $("#replace_quantityin").attr({
           "max" : result.quantity,
           "min" : 1          
         });

      },
      error: function(a, b, c)
      {
        $('#msgtitle').text('Something Went Wrong!');
        $('#modalmsg').text('Please contant administrator for assistance!');

        $('#msgmodalbtn').text('Close');
        $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');

        $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');

        $('#msgmodal').modal('show');

      }
    });

    $('#replaceproduct-form').submit(function(e){
      e.preventDefault();
      $.ajax({
        url: 'badorders/badordersfunc.php',
        type: 'POST',
        data: $(this).serialize(),
        dataType: 'html',
        success: function(result)
        {
          $('#itemsbody').html(result);
          $("#replacebomodal").modal("hide");
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
