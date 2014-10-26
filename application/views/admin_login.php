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
                <h4 class="panel-title">Admin Login</h4>
              </div>
              <div id="adminLogin" class="panel">
                <div class="panel-body">
                    <table class="frmTable">
                          <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
                          <tr>
                              <td>Admin Email</td>
                              <td><input type="text" class="form-control" id="username"></td>
                          </tr>
                          <tr>
                              <td>Password</td>
                              <td><input type="password" class="form-control" id="password"></td>
                          </tr>
                          <tr>
                              <td>&nbsp;</td>
                              <td>
                                  <span class="btn btn-success fright" onclick="AJAXLogin();">Log in</span>
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
