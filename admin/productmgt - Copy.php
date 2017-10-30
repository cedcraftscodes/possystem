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
            <a href="index.php" class="site_title"><i class="fa fa-paw"></i> <span>Sales | Inventory</span></a>
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
                <div class="col-sm-3">
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addProductModal">Add new Product</button><p></p>    <!-- Trigger the modal with a button -->
                </div>
                <div class="col-sm-6">
                  <input type="button"  class='btn btn-primary pull-right' onclick="printDiv('printArea')" value="Print Report!" />
                </div>
                <div class="col-sm-3">

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
                        <th>Supplier</th>
                        <th>Flooring</th>
                        <th>Ceiling</th>
                        <th>Unit</th>
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
                        <input type="text" class="form-control" id="pname"  name="pname">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="brand">Brand:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="brand"  name="brand">
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="control-label col-sm-3" for="desc">Description:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="desc"  name="desc">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="flooring">Flooring:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="flooring" name="flooring">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-3" for="ceiling">Ceiling:</label>
                      <div class="col-sm-9">
                        <input type="text" class="form-control" id="ceiling"  name="ceiling">
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
                      <label class="control-label col-sm-3" for="supplier">Supplier:</label>
                      <div class="col-sm-9">
                        <select class="form-control" id="cbosuppliers" name="cbosuppliers">

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
                      <label class="control-label col-sm-3" for="pcode">Product Code:</label>
                      <div class="col-sm-9">
                        <div class="input-group">
                          <input type="text" class="form-control" id="pcode" name="pcode" readonly="">
                          <span class="input-group-btn">
                            <button class="btn btn-default" type="button" data-toggle="modal" data-target="#inputbarcodemodal">Scan Code</button>
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
                      <input type="text" class="form-control" id="u_pname"  name="u_pname">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="u_brand">Brand:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="u_brand"  name="u_brand">
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
                      <input type="text" class="form-control" id="u_flooring" name="u_flooring">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="u_ceiling">Ceiling:</label>
                    <div class="col-sm-9">
                      <input type="text" class="form-control" id="u_ceiling"  name="u_ceiling">
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="u_cbounit">Unit:</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="u_cbounit" name="u_cbounit">

                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-3" for="u_cbosupplier">Supplier:</label>
                    <div class="col-sm-9">
                      <select class="form-control" id="u_cbosuppliers" name="u_cbosuppliers">

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
                    <label class="control-label col-sm-3" for="u_pcode">Product Code:</label>
                    <div class="col-sm-9">
                      <div class="input-group">
                        <input type="text" class="form-control" id="u_pcode" name="u_pcode" readonly="">
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

  function printDiv(divName) {


    var newWindow = window.open();
    var doc  = newWindow.document;
    doc.write("<html><head>" +
      "<title>Report</title>" + 
      "<link rel=\'stylesheet\' type=\'text/css\' href=\'../css/bootstrap.min.css\' >" + "<style type=\'text/css\'>" + 
      "@media print {table td:last-child {display:none}table th:last-child {display:none} html, body { display: block; }  }"+
      "</style>"+
      "</head><body>" +
      "<h1>Products</h1><br>"  +document.getElementById(divName).innerHTML  + "</body></html>");


    setTimeout(function(){newWindow.print(); newWindow.close(); }, 100);

  }
</script>


<script type="text/javascript">

  $(document).ready(function(){
    loadSuppliers();
    loadUnit();
    loadCategories();
    loadProducts();

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




  });

  function loadSuppliers()
  { 
    $.ajax({

     url: 'product/prodmgtfunc.php',
     type: 'POST',
     data: {action : 'loadSuppliers'},
     dataType: 'html',
     success: function(result)
     {
      $('#cbosuppliers').html(result);
      $('#u_cbosuppliers').html(result);
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
        $('#u_cbosuppliers').val(result.supname);
        $('#u_cbocategory').val(result.cat);
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
