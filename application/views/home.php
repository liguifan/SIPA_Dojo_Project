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
      <span id="navLinks">
        <span class="btn btn-navy" data-toggle="modal" data-target="#signupModal">Sign up</span>
        <span class="btn btn-red">How it works</span>
      </span>
    </div>
  </div>
  <div id="container" class="container">
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
                  <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#teacherLogin">I am a Teacher</a></h4>
                </div>
                <div id="teacherLogin" class="panel-collapse collapse in">
                  <div class="panel-body">
                      <table class="frmTable">
                          <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
                          <tr>
                              <td>Teacher Email</td>
                              <td><input type="text" class="form-control" id="username"></td>
                          </tr>
                          <tr>
                              <td>Password</td>
                              <td><input type="password" class="form-control" id="password"></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td>
                                  <span class="btn btn-default fleft" data-toggle="modal" onclick="OpenForgetPassword(1);" data-target="#forgotPasswordModal">Forgot Password</span>
                                  <span class="btn btn-success fright" onclick="javascript:AJAXLogin(1);">Log in</span>
                              </td>
                          </tr>
                      </table>
                  </div>
                </div>
              </div>
              <div class="panel panel-primary">
                  <div class="panel-heading unselectable" onclick="javascript:ShowTab(this);">
                  <h4 class="panel-title"><a data-toggle="collapse" data-parent="#accordion" href="#parentLogin">I am a Parent</a></h4>
                </div>
                <div id="parentLogin" class="panel-collapse collapse">
                  <div class="panel-body">
                      <table class="frmTable">
                          <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
                          <tr>
                              <td>Parent Email</td>
                              <td><input type="text" class="form-control" id="username"></td>
                          </tr>
                          <tr>
                              <td>Password</td>
                              <td><input type="password" class="form-control" id="password"></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td>
                                  <span class="btn btn-default fleft" data-toggle="modal" onclick="OpenForgetPassword(2);" data-target="#forgotPasswordModal">Forgot Password</span>
                                  <span class="btn btn-primary fright" onclick="AJAXLogin(2);">Log in</span>
                              </td>
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
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog" aria-labelledby="signupModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="signupModalLabel">Welcome Teacher</h2>
      </div>
      <div class="modal-body">
        <table class="frmTable">
            <col width="30%">
            <col width="70%">
            <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
            <tr>
                <td>Title</td>
                <td><select id="title" class="form-control">
                        <option value="1">Mr.</option>
                        <option value="2">Ms.</option>
                        <option value="3">Mrs.</option>
                </select></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td><input type="text" id="fname" class="form-control"></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><input type="text" id="lname" class="form-control"></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" id="username" class="form-control"></td>
            </tr>
            <tr>
                <td>School</td>
                <td><input type="text" id="school" class="form-control"></td>
            </tr>
            <tr>
                <td>Zip</td>
                <td><input type="text" id="zipCode" class="form-control form-control-short"><span id="cityData"/></td>
            </tr>
            <tr>
                <td>Grade</td>
                <td><?php echo form_dropdown('grade', $GradeList, 1, 'class="form-control" id="grade"'); ?></td>
            </tr>
            <tr>
                <td>Exam Type</td>
                <td><?php echo form_dropdown('etype', $ExamTypeList, 1, 'class="form-control" id="etype"'); ?></td>
            </tr>
            <tr>
                <td>Contact No</td>
                <td><input type="text" id="contact" class="form-control"></td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-default" data-dismiss="modal">Cancel</span>
        <span type="button" class="btn btn-success" onclick="javascript:AJAXCreateTeacher();">Create Account</span>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="signupSuccessModal" tabindex="-1" role="dialog" aria-labelledby="signupSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="signupSuccessModalLabel">Congratulations! New teacher is created successfully.<br>Login credentials are sent to your email address.<br>Please login as a teacher.</h2>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-success" data-dismiss="modal">OK</span>
      </div>
    </div>
  </div>
</div>
    
<!-- Modal -->
<div class="modal fade" id="forgotPasswordModal" tabindex="-1" role="dialog" aria-labelledby="forgotPasswordModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="forgotPasswordModalLabel">Tell us your registered Email</h2>
      </div>
      <div class="modal-body">
        <table class="frmTable">
            <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
            <tr>
                <td>&nbsp;</td>
                <td>
                    <div class="buttons-radio">
                    <div class="btn-group">
                        <button type="button" value="1" class="btn" data-toggle="button">I am a Teacher</button>
                        <button type="button" value="2" class="btn" data-toggle="button">I am a Parent</button>
                    </div>
                    <input type="hidden" id="forgotType" value="1" />
                    </div>
                </td>
            </tr>
            <tr>
                <td>Email</td>
                <td><input type="text" id="email" class="form-control"></td>
            </tr>
        </table>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-default" data-dismiss="modal">Cancel</span>
        <span type="button" class="btn btn-primary" onclick="javascript:AJAXReset();">Reset Password</span>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="forgotPasswordSuccessModal" tabindex="-1" role="dialog" aria-labelledby="signupSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="signupSuccessModalLabel">A link for password reset is sent to email.<br>Please activate your account through the link mentioned in mail.</h2>
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
$(function() {
    $('.carousel').carousel({
            interval: 8000												
    });
});

$('#forgotPasswordModal').on('show.bs.modal', function (e) {
    $("#forgotPasswordModal #errorText").parent().addClass('hidden');
    $("#forgotPasswordModal #email").val('');
});

$('#signupModal').on('show.bs.modal', function (e) {
    $("#signupModal #errorText").parent().addClass('hidden');
    $("#signupModal #title").val(1);
    $("#signupModal #fname").val('');
    $("#signupModal #lname").val('');
    $("#signupModal #username").val('');
    $("#signupModal #school").val('');
    $("#signupModal #zipCode").val('');
    $("#signupModal #grade").val(1);
    $("#signupModal #etype").val(1);
    $("#signupModal #contact").val('');
});

function AJAXReset(){
    var postData = {};
    postData.type  = $("#forgotPasswordModal #forgotType").val();
    postData.email = $("#forgotPasswordModal #email").val();

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'home/AJAXReset', postData);
    if(rtData){
        if(rtData.Valid){
            $('#forgotPasswordModal').modal('hide');
            $('#forgotPasswordSuccessModal').modal('show');
        }
        else{
            $("#forgotPasswordModal #errorText").html(rtData.Error);
            $("#forgotPasswordModal #errorText").parent().removeClass('hidden');
        }
        return;
    }
    alert("Error while connecting server.");
}
function AJAXCreateTeacher()
{
    var postData = {};
    postData.title          = $("#signupModal #title").val();
    postData.fname          = $("#signupModal #fname").val();
    postData.lname          = $("#signupModal #lname").val();
    postData.username       = $("#signupModal #username").val();
    postData.school         = $("#signupModal #school").val();
    postData.zip            = $("#signupModal #zipCode").val();
    postData.grade          = $("#signupModal #grade").val();
    postData.type           = $("#signupModal #etype").val();
    postData.contact        = $("#signupModal #contact").val();

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'home/AJAXCreateTeacher', postData);
    if(rtData)
    {
        if(rtData.Valid)
        {
            $('#signupModal').modal('hide');
            $('#signupSuccessModal').modal('show');
        }
        else
        {
            $("#signupModal #errorText").html(rtData.Error);
            $("#signupModal #errorText").parent().removeClass('hidden');
        }
        return;
    }
    alert("Error while connecting server.");
}

function AJAXLogin(type)
{
    var postData = {};
    postData.username = (type == 1)?$("#teacherLogin #username").val():$("#parentLogin #username").val();
    postData.password = (type == 1)?$("#teacherLogin #password").val():$("#parentLogin #password").val();
    postData.type = type;

    var errorText = "";

    rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'home/AJAXLogin', postData);
    if(rtData)
    {
        //console.log(rtData);
        if(rtData.UserID > 0){
            redirect_url(rtData.Redirect);
            return;}
        else
            errorText = "Invalid username or password.";
    }
    else
        errorText = "Could not connect to server.";
    
    if(type == 1){
        $("#teacherLogin #errorText").html(errorText);
        $("#teacherLogin #errorText").parent().removeClass('hidden');}
    else{
        $("#parentLogin #errorText").html(errorText);
        $("#parentLogin #errorText").parent().removeClass('hidden');}
}
function ShowTab(el)
{
    var curTabID = $(el).find("a").attr("href");
    if(curTabID == "#teacherLogin")
    {
        if(!$("#teacherLogin").hasClass('in'))
        {
            $("#teacherLogin").collapse('show');
            $("#parentLogin").collapse('hide');
        }
    }
    else if(curTabID == "#parentLogin")
    {
        if(!$("#parentLogin").hasClass('in'))
        {
            $("#teacherLogin").collapse('hide');
            $("#parentLogin").collapse('show');
        }
    }
}
function OpenForgetPassword(type)
{
    RefreshButtonsRadio($("#forgotPasswordModal .buttons-radio"), type, false);
}
var last_zip = 'x';
function RefreshCity()
{
    var postData = {};
    postData.zip = $('#zipCode').val();
    
    if(last_zip == postData.zip)
        return;
    
    if(postData.zip.length == 5)
    {
        rtData = DoAJAXJason("<?php echo my_base_URL();?>"+'home/AJAXGetZipData', postData);
        if(rtData && rtData.Valid && rtData.City.length > 0)
        {
            $('#cityData').html(rtData.City);
            $('#cityData').addClass('text-success');
            $('#cityData').removeClass('text-danger');
            return;
        }
    }
    $('#cityData').html("Please enter valid Zip");
    $('#cityData').removeClass('text-success');
    $('#cityData').addClass('text-danger');
}
$("#zipCode").on("change keyup paste click", function(){
    RefreshCity();
});
$(RefreshCity());
$(RefreshButtonsRadio($("#forgotPasswordModal .buttons-radio"), 1, false));

</script>
</body>
</html>
