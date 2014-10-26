<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CULTURE</title>
<link rel="icon" type="image/png" href="<?php echo my_res_URL(); ?>img/logo.png" />
<link href="<?php echo my_res_URL(); ?>css/bootstrap.css" rel="stylesheet">
<link href="<?php echo my_res_URL(); ?>css/main.css" rel="stylesheet">
<script src="<?php echo my_res_URL(); ?>js/respond.min.js"></script>
<?php 
if(isset($css)){ foreach($css as $cssfile){
    
    echo '<link href="'.my_res_URL().'css/'.$cssfile.'" rel="stylesheet">';
    }}
?>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<div id="wrapper">
  <div class="navbar" id="navHeader">
    <div class="navbar-inner">
      <div class="container">
          <a href="<?php echo my_base_URL(); ?>admin" id="logo"></a> 
        <span id="navLinks">
            
            <?php if(isset($Login['UserID']) && isset($Login['UserType']) && $Login['UserType'] == 3) { ?>
                <a href="<?php echo my_base_URL();?>admin/home" class="btn btn-default">Home</a>
                <div class="btn-group">
                  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                      <?php echo $Login['Name'];?>&nbsp;<span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="<?php echo my_base_URL();?>admin/chgpwd">Change Password</a></li>
                    <li><a href="<?php echo my_base_URL();?>admin/logout">Logout</a></li>
                  </ul>
                </div>
            <?php } ?>
        </span>
      </div>
    </div>
  </div>
  <div id="container" class="container">
    <div id="contentWrapper" class="clearfix">
        <?php 
        require $InnerPage.'.php';
        ?>
    </div>
    <!-- /contentWrapper -->
  </div>
  <!-- /container -->
  <div id="navFooter" >
    <div class="row text-center">
        <a href="#">About</a> 
        <span>&nbsp;|&nbsp;</span>
        <a href="#">Privacy Policy</a>
        <span>&nbsp;|&nbsp;</span>
        <a href="#">Terms and Conditions</a>
    </div>
  </div>
</div>
    

<!-- /wrapper -->
<script src="http://code.jquery.com/jquery-1.7.2.min.js"></script>
<script src="<?php echo my_res_URL(); ?>js/bootstrap.js"></script>
<script src="<?php echo my_res_URL(); ?>js/transition.js"></script>
<script src="<?php echo my_res_URL(); ?>js/collapse.js"></script>
<script src="<?php echo my_res_URL(); ?>js/local.js"></script>
<script src="<?php echo my_res_URL(); ?>js/layout.js"></script>
<?php 
//if(file_exists($InnerPage.'_js.php'))
        include $InnerPage.'_js.php';
?>
</body>
</html>
