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

<body class="nav-md" >
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
              <h2>Supplier Accounts </h2>
              <div class="clearfix"></div>

            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-sm-3">
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addadminModal">Add new Supplier</button><p></p>    <!-- Trigger the modal with a button -->
                </div>
                <div class="col-sm-5">
                  
                </div>
                <div class="col-sm-4">
                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Search</span>
                      <input type="text" name="search_text" id="search_text" placeholder="Name of Supplier / Receiver" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>

              <div id="printArea">
                <div class="table-responsive">
                  <table id="itemtable" class="table table-condensed">  <!-- Start of Table -->
                    <thead>
                      <tr>
                        <th class="col-md-1">Supplier ID</th>
                        <th class="col-md-1">Supplier Name</th>
                        <th class="col-md-1">Receiver</th>
                        <th class="col-md-2">Address</th>
                        <th class="col-md-1">Phone</th>
                        <th class="col-md-2">Email</th>
                        <th class="col-md-2">Date Added</th>
                        <th class="col-md-3">Action</th>
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
          <div id="addadminModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Add new Supplier</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="add-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="sname">Supplier Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="sname" placeholder="Enter Supplier Name" name="sname" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="rname">Receiver Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="rname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Receiver Name" name="rname" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="street"> Street:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="street" p placeholder="Enter Street" name="street" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="city"> City:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="city" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter City" name="city" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="province"> Province:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="province" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter  Province" name="province" required="">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-2" for="zipcode"> ZipCode:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="zipcode" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Enter  Zip Code" name="zipcode"  title="Enter a valid zip code" pattern="[0-9]{4}"  required="">
                      </div>
                    </div>
                    
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="contactnumber"> Contact Number:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="contactnumber" title="Enter a valid phone number" pattern="[0-9]{11}" placeholder="Enter  Contact Number" name="contactnumber" required="">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-2" for="email"> Email:</label>
                      <div class="col-sm-10">
                        <input type="email" class="form-control" id="email"  placeholder="Enter Supplier Email" name="email" required="">
                      </div>
                    </div>

                    <input type = "hidden" name = "action" value = "addAdmin">
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
          <div id="updateAdminModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header modal-header-info">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Update Supplier</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="update-form">

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="u_sname">Supplier Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_sname" placeholder="Enter Supplier Name" name="u_sname" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="u_rname">Receiver Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_rname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Receiver Name" name="u_rname" required="">
                      </div>
                    </div>



                    <div class="form-group">
                      <label class="control-label col-sm-2" for="u_street"> Street:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_street" p placeholder="Enter Street" name="u_street" required="">
                      </div>
                    </div>




                    <div class="form-group">
                      <label class="control-label col-sm-2" for="u_city"> City:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_city" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter City" name="u_city" required="">
                      </div>
                    </div>




                    <div class="form-group">
                      <label class="control-label col-sm-2" for="u_province"> Province:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_province" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter  Province" name="u_province" required="">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-2" for="zipcode"> ZipCode:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_zipcode" onkeypress='return event.charCode >= 48 && event.charCode <= 57' placeholder="Enter  Zip Code" name="u_zipcode"  title="Enter a valid zip code" pattern="[0-9]{4}"  required="">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-2" for="u_contactnumber"> Contact Number:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="u_contactnumber" title="Enter a valid phone number" pattern="[0-9]{11}"  placeholder="Enter  Contact Number" name="u_contactnumber" required="">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-2" for="u_email"> Email:</label>
                      <div class="col-sm-10">
                        <input type="u_email" class="form-control" id="u_email"  placeholder="Enter Supplier Email" name="u_email" required="">
                      </div>
                    </div>


                    <input type = "hidden" id = "u_id" name = "u_id" >
                    <input type = "hidden" name = "action" value = "updateAdmin">


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

    //When the Html or Document Loads, Load the datas in table.
    $(document).ready(function(){
      function showData()
      { 
        $.ajax({

          url: 'supacc/adminFunction.php',
          type: 'POST',
          data: {action : 'showAdmins'},
          dataType: 'html',
          success: function(result)
          {
            $('#itemsbody').html(result);
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

      showData();





      var searchreq = null;
      function load_data(query)
      {
        if (searchreq != null) searchreq.abort();
        searchreq = $.ajax({
          url:"supacc/searchadmin.php",
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
          showData();

        }
      });
    });




    //Add Form submit handler
    $('#add-form').submit(function(e){


      e.preventDefault();


      var formData = new FormData(this);

      $.ajax({

        url: 'supacc/adminFunction.php',
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
          $('#addadminModal').modal('toggle');
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

    function deleteAdmin(id)
    {

      $("#deleteModal").modal("show");
      $('.yes').click(function(e){

        $.ajax({

          url : 'supacc/adminFunction.php',
          type : 'POST',
          data : {action : 'deleteAdmin', id : id},
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

    function updateAdmin(id)
    {
      $("#updateAdminModal").modal("show");

      $.ajax({

        url : 'supacc/adminFunction.php',
        type : 'POST',
        data : {id : id, action : 'showUpdateAdmin'},
        dataType: 'json',
        success : function(result)
        {

          $('#u_sname').val(result.sname);
          $('#u_rname').val(result.rname);
          $('#u_email').val(result.email);
          $('#u_street').val(result.street);
          $('#u_city').val(result.city);
          $('#u_province').val(result.province);
          $('#u_zipcode').val(result.zipcode);
          $('#u_contactnumber').val(result.contact);
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

          url: 'supacc/adminFunction.php',
          type: 'POST',
          data: $(this).serialize(),
          dataType: 'html',
          success: function(result)
          {
            $('#itemsbody').html(result);
            $("#updateAdminModal").modal("hide");
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
