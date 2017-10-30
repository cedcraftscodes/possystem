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

  <style type="text/css">
    .invoice-title h2, .invoice-title h3 {
      display: inline-block;
    }

    .table > tbody > tr > .no-line {
      border-top: none;
    }

    .table > thead > tr > .no-line {
      border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
      border-top: 2px solid;
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
        <div class="">
          <div class="page-title">
            <div class="title_left">
              <h3>User Profile</h3>
            </div>


          </div>

          <div class="clearfix"></div>

          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="x_panel">
                <div class="x_title">
                  <h2>User Report <small>Activity report</small></h2>

                  <div class="clearfix"></div>
                </div>
                <div class="x_content">
                  <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                    <div class="profile_img">
                      <div id="crop-avatar">
                        <!-- Current avatar -->
                        <img class="img-responsive avatar-view" src="<?php echo $_SESSION['dp']; ?>" alt="Avatar" title="Change the avatar">
                      </div>
                    </div>
                    <h3><?php echo $_SESSION['fullname']; ?></h3>


                    <ul class="list-unstyled user_data">
                      <li><i class="fa fa-map-marker user-profile-icon">  </i>  
                        <?php echo $_SESSION['gender']; ?>
                      </li>

                      <li>
                        <i class="fa fa-briefcase user-profile-icon"></i>  
                        <?php echo $_SESSION['acctypeTemp']; ?>
                      </li>




                    </ul>


                  </div>
                  <div class="col-md-9 col-sm-9 col-xs-12">



                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Profile</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Login History</a>
                        </li>

                      </ul>
                      <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                          <!-- start recent activity -->
    <h2>Personal Information</h2>
                          <hr>

                          <form class="form-horizontal" id="update-form">



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
                            <input type = "hidden" name = "action" value ="updateUserInfo">

                            <hr>
                            <div class="pull-right">
                              <button type="submit" class="btn btn-info">Change Info</button>

                            </div>


                          </form>

                          <h2>Change Password</h2>
                        </hr>

                        <form class="form-horizontal" id="changepass-form">


                          <div class="form-group">
                            <label class="control-label col-sm-2" for="iname">Current Password:</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="iname" placeholder="Enter current password" name="currpass" required="">
                            </div>
                          </div>

                          <div class="form-group">
                            <label class="control-label col-sm-2" for="iname">New Password:</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="iname" placeholder="Enter new password" pattern=".{8,}" required title="Minimum 8 characters required" name="newpass" required="">
                            </div>
                          </div>


                          <div class="form-group">
                            <label class="control-label col-sm-2" for="iname">Confirm Password:</label>
                            <div class="col-sm-10">
                              <input type="password" class="form-control" id="iname" placeholder="Retype password" pattern=".{8,}" required title="Minimum 8 characters required" name="cpass" required="">
                            </div>
                          </div>
                          <input type = "hidden" name = "action" value ="changePassword">
                          <hr>
                          <div class="pull-right">
                            <button type="submit" class="btn btn-info">Change Password</button>
                          </div>
                        </form>

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                          <h2>Login History</h2>
                          <hr>
                          <!-- start user projects -->
                          <table class="data table table-striped no-margin">
                            <thead>
                              <tr>
                                <th>Login ID</th>
                                <th>Date Logged In</th>
                              </tr>
                            </thead>
                            <tbody id="loghistory">

                            </tbody>
                          </table>
                          <!-- end user projects -->

                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
                          

                      </div>
                    </div>
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


<!-- jQuery Sparklines -->
<script src="../vendors/jquery-sparkline/dist/jquery.sparkline.min.js"></script>



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



<div id="msgholder">

</div>


<script type="text/javascript">











  $(document).ready(function(){
    loadUserInfo();
    showLoginHistory();
  });


  function showLoginHistory()
  { 
    $.ajax({

      url: 'userprofile/profilefunction.php',
      type: 'POST',
      data: {action : 'showLoginHistory'},
      dataType: 'html',
      success: function(result)
      {
        $('#loghistory').html(result);
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




  function loadUserInfo(){
    $.ajax({
      url : 'userprofile/profilefunction.php',
      type : 'POST',
      data : {action : 'showUserinfo'},
      dataType: 'json',
      success : function(result)
      {
        $('#u_fname').val(result.fname);
        $('#u_lname').val(result.lname);
        $('#u_mname').val(result.mname);
        //$('#u_email').val(result.email);
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
  }


  $('#update-form').submit(function(e){
    e.preventDefault();
    $.ajax({

      url: 'userprofile/profilefunction.php',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'html',
      success: function(result)
      {
        loadUserInfo();

        $('#msgholder').html(result);
        setTimeout(function(){ location.reload(); }, 3000);

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



  $('#changepass-form').submit(function(e){
    e.preventDefault();
    $.ajax({

      url: 'userprofile/profilefunction.php',
      type: 'POST',
      data: $(this).serialize(),
      dataType: 'html',
      success: function(result)
      {
        loadUserInfo();
        $('#msgholder').html(result);



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





</script>



</body>
</html>
