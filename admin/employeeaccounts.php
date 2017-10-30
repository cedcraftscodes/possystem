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
              <h2>Cashier Accounts </h2>
              <div class="clearfix"></div>

            </div>
            <div class="x_content">
              <div class="row">
                <div class="col-sm-3">
                  <button type="button" class="btn btn-info btn-md" data-toggle="modal" data-target="#addadminModal">Add new Cashier</button><p></p>    <!-- Trigger the modal with a button -->
                </div>
                <div class="col-sm-6">

                </div>
                <div class="col-sm-3">

                  <div class="form-group">
                    <div class="input-group">
                      <span class="input-group-addon">Search</span>
                      <input type="text" name="search_text" id="search_text" placeholder="Name of Employee" class="form-control" />
                    </div>
                  </div>
                </div>
              </div>


              <div id="printArea">
                <div class="table-responsive">
                  <table id="itemtable" class="table table-condensed">  <!-- Start of Table -->
                    <thead>
                      <tr>
                        <th class="col-md-1">User ID</th>
                        <th class="col-md-3">Full Name</th>
                        <th class="col-md-1">Gender</th>
                        <th class="col-md-1" >Birthday</th>
                        <th class="col-md-3">Date Added</th>
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
                  <h4 class="modal-title">Add new Cashier</h4>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" id="add-form" enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="iname">First Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="iname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter First Name" name="fname" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="iname">Middle Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="mname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Middle Name" name="mname" required="">
                      </div>
                    </div>


                    <div class="form-group">
                      <label class="control-label col-sm-2" for="iname">Last Name:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" id="iname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Last Name" name="lname" required="">
                      </div>
                    </div>

                    <div class="form-group">
                      <label class="control-label col-sm-2" for="iname">Gender:</label>
                      <div class="col-sm-10">
                        <select  class="form-control selectpicker" name="gender" >
                          <option value="male">Male</option>
                          <option value="female">Female</option>


                        </select>
                      </div>
                    </div>


                    <!--
                    <div class="form-group">
                      <label class="control-label col-sm-2" for="iname">Address:</label>
                      <div class="col-sm-10">
                        <input type="text" class="form-control" placeholder="Enter address" name="address" id="address">
                      </div>
                    </div>

                  -->

                  <div class="form-group">
                    <label class="control-label col-sm-2" for="iname">Date of Birth:</label>
                    <div class="col-sm-10">
                      <input type="date" class="form-control" id="iname" name="bday" required>
                    </div>
                  </div>

                  <div class="form-group">
                    <div class="main-img-preview">
                      <img class="thumbnail img-preview" src="https://cdn2.iconfinder.com/data/icons/real-flat-security/512/admin-512.png" title="Preview Logo">
                    </div>
                    <div class="input-group">
                      <input id="fakeUploadLogo" class="form-control fake-shadow" placeholder="Choose File" disabled="disabled">
                      <div class="input-group-btn">
                        <div class="fileUpload btn btn-danger fake-shadow">
                          <span><i class="glyphicon glyphicon-upload"></i> Upload Picture</span>
                          <input id="logo-id" name="userpic" type="file" class="attachment_upload">
                        </div>
                      </div>
                    </div>
                    <p class="help-block">* Upload cashier profile picture.</p>
                  </div>


                  <style type="text/css">


  
                    .form-control, .thumbnail {
                      border-radius: 2px;
                    }
                    .btn-danger {
                      background-color: #B73333;
                    }

                    /* File Upload */
                    .fake-shadow {
                      box-shadow: 0 1px 2px rgba(0, 0, 0, 0.2);
                    }
                    .fileUpload {
                      position: relative;
                      overflow: hidden;
                    }
                    .fileUpload #logo-id {
                      position: absolute;
                      top: 0;
                      right: 0;
                      margin: 0;
                      padding: 0;
                      font-size: 33px;
                      cursor: pointer;
                      opacity: 0;
                      filter: alpha(opacity=0);
                    }
                    .img-preview {
                      max-width: 100%;
                      margin: 0 auto;

                    }
                  </style>

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
                <h4 class="modal-title">Update Employee</h4>
              </div>
              <div class="modal-body">
                <form class="form-horizontal" id="update-form">


                  <div class="form-group">
                    <label class="control-label col-sm-2" for="u_username">Username:</label>
                    <div class="col-sm-10">
                      <label id="u_username"> </label>
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="control-label col-sm-2" for="iname">First Name:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter First Name" name="u_fname" id="u_fname">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-sm-2" for="iname">Middle Name:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="u_mname" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Middle Name" name="u_mname" required="">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-sm-2" for="iname">Last Name:</label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control" pattern="[a-zA-Z\s]{1,}" title="Letters only!" placeholder="Enter Last Name" name="u_lname" id="u_lname">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-sm-2" for="iname">Gender:</label>
                    <div class="col-sm-10">
                      <select  class="form-control selectpicker" name="u_gender" id="u_gender">
                        <option value="male">Male</option>
                        <option value="female">Female</option>

                      </select>
                    </div>
                  </div>

                  <div class="form-group">
                    <label class="control-label col-sm-2" for="iname">Date of Birth:</label>
                    <div class="col-sm-10">
                      <input type="date" class="form-control" name="u_bday" id="u_bday">
                    </div>
                  </div>


                  <div class="form-group">
                    <label class="control-label col-sm-2" for="iname">Password:</label>
                    <div class="col-sm-10">
                      <a class="btn btn-danger" onclick="resetPassword(document.getElementById('u_id').value)" >Reset Password</a>
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


        <div id="resetModal" class="modal fade" role="dialog">
          <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
              <div class="modal-header modal-header-danger">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Reset Password</h4>
              </div>
              <div class="modal-body">
                <p>Are you sure you want to reset the password?</p>
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

  $(document).ready(function() {
    var brand = document.getElementById('logo-id');
    brand.className = 'attachment_upload';
    brand.onchange = function() {
      document.getElementById('fakeUploadLogo').value = this.value.substring(12);
    };

    // Source: http://stackoverflow.com/a/4459419/6396981
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('.img-preview').attr('src', e.target.result);
        };
        reader.readAsDataURL(input.files[0]);
      }
    }
    $("#logo-id").change(function() {
      readURL(this);
    });
  });



</script>







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
      function showData()
      { 
        $.ajax({

          url: 'empacc/adminFunction.php',
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
          url:"empacc/searchadmin.php",
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
        url: 'empacc/adminFunction.php',
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

    function resetPassword(id)
    {

      $("#resetModal").modal("show");
      $('.yes').click(function(e){

        $.ajax({

          url : 'empacc/adminFunction.php',
          type : 'POST',
          data : {action : 'resetPass', id : id},
          dataType: 'html',

          success: function(result)
          {
            $('#itemsbody').html(result);
            $("#resetModal").modal("hide");

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






    function deleteAdmin(id)
    {

      $("#deleteModal").modal("show");
      $('.yes').click(function(e){

        $.ajax({

          url : 'empacc/adminFunction.php',
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

        url : 'empacc/adminFunction.php',
        type : 'POST',
        data : {id : id, action : 'showUpdateAdmin'},
        dataType: 'json',
        success : function(result)
        {

          $('#u_fname').val(result.fname);
          $('#u_lname').val(result.lname);
          $('#u_mname').val(result.mname);

          $('#u_username').text(result.username);



          $('#u_gender').val(result.gender);
          $('#u_bday').val(result.birthday);
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

          url: 'empacc/adminFunction.php',
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
