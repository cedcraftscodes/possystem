<div class="profile clearfix">
  <div class="profile_pic">
    <img src="<?php if(isset($_SESSION['dp'])){echo '../admin/'.$_SESSION['dp']; }?>" alt="..." class="img-circle profile_img"
    style="max-width:100%;
		max-height:100%;
		height: 65px;
		width: 65px;"

		>
  </div>
  <div class="profile_info">
    <span>Welcome,</span>
    <h2><?php echo $_SESSION['fullname']; ?></h2>
  </div>
</div>