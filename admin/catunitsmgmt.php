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
      <!-- My Modal Stylesheet -->
      <link rel="stylesheet" type="text/css" href="../build/css/modalstyle.css">

      <style type="text/css">
        body { padding-right: 0 !important ;}
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
                  <div class="col-md-6">
                     <div class="x_panel">
                        <div class="x_title">
                           <h2>Category Management</h2>
                           <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="row">
                            <div class="row">
                              <div class="col-sm-4">
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addCategoryModal">Add new Category</button><p></p>    <!-- Trigger the modal with a button -->
                              </div>
                              <div class="col-sm-8">

                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon">Search</span>
                                    <input type="text" name="search_text" id="search_text" placeholder="Category" class="form-control" />
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="table-responsive">
                              <table id="categorytable" class="table table-condensed">  <!-- Start of Table -->
                                <thead>
                                  <tr>
                                    <th >Category ID</th>
                                    <th >Category</th>
                                    <th >Action</th>
 
                                  </tr>
                                </thead>
                                <tbody id="categorybody"></tbody>
                              </table>
                            </div>                              
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="x_panel">
                        <div class="x_title">
                           <h2>Units Management </h2>
                           <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                           <div class="row">

                          <div class="row">
                              <div class="col-sm-3">
                                <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addUnitModal">Add new Unit</button><p></p>    <!-- Trigger the modal with a button -->
                              </div>
                              <div class="col-sm-9">

                                <div class="form-group">
                                  <div class="input-group">
                                    <span class="input-group-addon">Search</span>
                                    <input type="text" name="search_unit" id="search_unit" placeholder="Unit" class="form-control" />
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="table-responsive">
                              <table id="unitstable" class="table table-condensed">  <!-- Start of Table -->
                                <thead>
                                  <tr>
                                    <th >Unit ID</th>
                                    <th >Unit Name</th>
                                    <th >Action</th>
                                  </tr>
                                </thead>
                                <tbody id="unitsbody"></tbody>
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





          <!-- Add Item Modal -->
          <div id="addCategoryModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Add new Category</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="addCategory-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="cname">Category Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="cname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Category Name" name="cname" required="">
                      </div>
                    </div>

                    <input type = "hidden" name = "action" value = "addCategory">
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
          <div id="addUnitModal" class="modal fade" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Add new Unit</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="addUnit-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="cname">Unit Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="uname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Unit Name" name="uname" required="">
                      </div>
                    </div>

                    <input type = "hidden" name = "action" value = "addUnit">
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
          <div id="updateCategoryModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Update Category</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="updateCategory-form">

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="u_cname">Category Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_cname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Category Name" name="u_cname" required="">
                      </div>
                    </div>


                    <input type = "hidden" id = "u_id" name = "u_id" >
                    <input type = "hidden" name = "action" value = "updateCategory">


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
          <div id="updateUnitModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Update Unit</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="updateUnit-form">

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="u_uname">Unit Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_uname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Unit Name" name="u_uname" required="">
                      </div>
                    </div>


                    <input type = "hidden" id = "u_uid" name = "u_uid" >
                    <input type = "hidden" name = "action" value = "updateUnit">


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

    //When the Html or Document Loads, Load the datas in table.
    $(document).ready(function(){
      function showCategories()
      { 
        $.ajax({

          url: 'unitscateg/ucfunction.php',
          type: 'POST',
          data: {action : 'showCategories'},
          dataType: 'html',
          success: function(result)
          {
            $('#categorybody').html(result);
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

      showCategories();



      function showUnits()
      { 
        $.ajax({

          url: 'unitscateg/ucfunction.php',
          type: 'POST',
          data: {action : 'showUnits'},
          dataType: 'html',
          success: function(result)
          {
            $('#unitsbody').html(result);
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

      showUnits();





      var searchreq = null;
      function load_data(query)
      {
        if (searchreq != null) searchreq.abort();
        searchreq = $.ajax({
          url:"unitscateg/searchunit.php",
          method:"GET",
          data:{query:query},
          success:function(data)
          {
            $('#unitsbody').html(data);
          }
        });
      }
      $('#search_unit').keyup(function(){
        var search = $(this).val();
        if(search != '')
        {
          load_data(search);
        }
        else
        {
          showUnits();

        }
      });



      var searchreq = null;
      function load_category(query)
      {
        if (searchreq != null) searchreq.abort();
        searchreq = $.ajax({
          url:"unitscateg/searchcategory.php",
          method:"GET",
          data:{query:query},
          success:function(data)
          {
            $('#categorybody').html(data);
          }
        });
      }
      $('#search_text').keyup(function(){
        var search = $(this).val();
        if(search != '')
        {
          load_category(search);
        }
        else
        {
          showCategories();

        }
      });



    });













    //Add Category Form submit handler
    $('#addCategory-form').submit(function(e){
      e.preventDefault();
      var formData = new FormData(this);

      $.ajax({

        url: 'unitscateg/ucfunction.php',
        type: 'POST',
        cache: false,
        data: formData,
        async: false,
        processData: false,
        contentType: false,
        dataType: 'html',
        success: function(result)
        {
          $('#categorybody').html(result);
          $('#addCategoryModal').modal('toggle');


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

        //Add Unit Form submit handler
    $('#addUnit-form').submit(function(e){
      e.preventDefault();
      var formData = new FormData(this);

      $.ajax({

        url: 'unitscateg/ucfunction.php',
        type: 'POST',
        cache: false,
        data: formData,
        async: false,
        processData: false,
        contentType: false,
        dataType: 'html',
        success: function(result)
        {
          $('#unitsbody').html(result);
          $('#addUnitModal').modal('toggle');


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




    function deleteCategory(id)
    {

      $("#deleteModal").modal("show");
      $('.yes').click(function(e){

        $.ajax({
          url : 'unitscateg/ucfunction.php',
          type : 'POST',
          data : {action : 'deleteCategory', id : id},
          dataType: 'html',

          success: function(result)
          {
            $('#categorybody').html(result);
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

    function deleteUnit(id)
    {

      $("#deleteModal").modal("show");
      $('.yes').click(function(e){

        $.ajax({
          url : 'unitscateg/ucfunction.php',
          type : 'POST',
          data : {action : 'deleteUnit', id : id},
          dataType: 'html',

          success: function(result)
          {
            $('#unitsbody').html(result);
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




    function updateCategory(id)
    {
      $("#updateCategoryModal").modal("show");

      $.ajax({

        url : 'unitscateg/ucfunction.php',
        type : 'POST',
        data : {id : id, action : 'showUpdateCategory'},
        dataType: 'json',
        success : function(result)
        {

          $('#u_cname').val(result.cname);
          $('#u_id').val(id);
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          alert(jqXHR.responseText);
          $('#msgtitle').text('Something Went Wrong!');
          $('#modalmsg').text('Please contant administrator for assistance!');
          $('#msgmodalbtn').text('Close');
          $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
          $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
          $('#msgmodal').modal('show');

        }
      });

      $('#updateCategory-form').submit(function(e){
        e.preventDefault();
        $.ajax({

          url: 'unitscateg/ucfunction.php',
          type: 'POST',
          data: $(this).serialize(),
          dataType: 'html',
          success: function(result)
          {
            $('#categorybody').html(result);
            $("#updateCategoryModal").modal("hide");
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



function updateUnit(id)
    {
      $("#updateUnitModal").modal("show");

      $.ajax({

        url : 'unitscateg/ucfunction.php',
        type : 'POST',
        data : {id : id, action : 'showUpdateUnit'},
        dataType: 'json',
        success : function(result)
        {
          $('#u_uname').val(result.uname);
          $('#u_uid').val(id);
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
          console.log(jqXHR);
          $('#msgtitle').text('Something Went Wrong!');
          $('#modalmsg').text('Please contant administrator for assistance!');
          $('#msgmodalbtn').text('Close');
          $('#msgmodalbtn').attr('class', 'btn btn-danger pull-right');
          $('#msgmodalheader').attr('class', 'modal-header modal-header-danger');
          $('#msgmodal').modal('show');

        }
      });

      $('#updateUnit-form').submit(function(e){
        e.preventDefault();
        $.ajax({

          url: 'unitscateg/ucfunction.php',
          type: 'POST',
          data: $(this).serialize(),
          dataType: 'html',
          success: function(result)
          {
            $('#unitsbody').html(result);
            $("#updateUnitModal").modal("hide");
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