<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>CULTURE</title>
<link rel="icon" type="image/png" href="<?php echo my_res_URL(); ?>img/logo.png" />
<link href="<?php echo my_res_URL(); ?>css/bootstrap.css" rel="stylesheet">
<link href="<?php echo my_res_URL(); ?>css/main.css" rel="stylesheet">
<script src="<?php echo my_res_URL(); ?>js/respond.min.js"></script>

<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
</head>
<body>
<div id="wrapper">
  <div class="navbar" id="navHeader">
    <div class="container">
      <a href="<?php echo my_base_URL(); ?>" id="logo"></a> 
    </div>
  </div>
  <div id="container" class="container">
    <div id="tagline"></div>
    <div id="contentWrapper" class="clearfix">
      <div class="row">
          <span class="fleft width-450">
            <div class="panel panel-default"> 
                <div class="panel-body panel-saffron">
                    <div style="row">
                        <div class="fleft width-120">
                        <h1>Culture is fast and free</h1>
                        <br>
                        Sub-paragraph
                        </div>
                        <div class="ad-image fright"><img src="<?php echo my_res_URL(); ?>img/free.png" alt="" title=""></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body panel-blue">
                    <div style="row">
                        <div class="fright width-120">
                        <h1>Culture offers a Reading Log</h1>
                        <br>
                        Sub-paragraph
                        </div>
                        <div class="ad-image fleft"><img src="<?php echo my_res_URL(); ?>img/log.png" alt="" title=""></div>
                    </div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-body panel-green">
                    <div style="row">
                        <div class="fleft width-120">
                        <h1>Culture gives a goal to parent</h1>
                        <br>
                        Sub-paragraph
                        </div>
                        <div class="ad-image fright"><img src="<?php echo my_res_URL(); ?>img/phone.png" alt="" title=""></div>
                    </div>
                </div>
            </div>
          </span>
          <span style="width: 400px;" class="fright">
            <div class="panel-group" id="accordion">
              <div class="panel panel-success">
                <div class="panel-heading unselectable"  onclick="javascript:ShowTab(this);">
                  <h4 class="panel-title">Reset password</h4>
                </div>
                <div id="teacherLogin" class="panel">
                  <div class="panel-body">
                      <table class="frmTable">
                          <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
                          <tr>
                              <td>Password</td>
                              <td><input type="password" class="form-control" id="password"></td>
                          </tr>
                          <tr>
                              <td>Confirm Password</td>
                              <td><input type="password" class="form-control" id="cnfpassword"></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td><span class="btn btn-success fright" onclick="javascript:AJAXChangePassword();">Activate</span></td>
                          </tr>
                      </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- /panel-group -->
          </span>
      </div>
      <!-- /row -->
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
</div>
</div>
    
<!-- Modal -->
<div class="modal fade" id="activateSuccessModal" tabindex="-1" role="dialog" aria-labelledby="activateSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="modal-title" id="activateSuccessModalLabel">Congratulations! Your account is activated successfully.<br>Please login with a new password.</h2>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-success" data-dismiss="modal">OK</span>
      </div>
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
<script type="text/javascript">
function AJAXChangePassword()
{
    var postData = {};
    postData.type = "<?php echo isset($_GET['type'])?$_GET['type']:''; ?>";
    postData.token = "<?php echo isset($_GET['token'])?$_GET['token']:''; ?>";
    postData.password = $("#teacherLogin #password").val();
    var cnfpassword = $("#teacherLogin #cnfpassword").val();
    
    var errorText;
    
    if(cnfpassword != postData.password){
        errorText = "Password and Confirm Password are not same.";
    }
    else{
        errorText = "Could not connect to server.";

        rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'home/AJAXChangePassword', postData);
        if(rtData){
            if(rtData.Valid){
                $('#activateSuccessModal').modal('show');
                return;}
            else if(rtData.Error)
                errorText = rtData.Error;
        }
    }    
    
    $("#teacherLogin #errorText").html(errorText);
    $("#teacherLogin #errorText").parent().removeClass('hidden');
}
$('#activateSuccessModal').on('hidden.bs.modal', function () {
  redirect_url( '<?php echo my_base_URL(); ?>' );
})
</script>
</body>
</html>
