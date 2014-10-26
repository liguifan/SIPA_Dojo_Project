<div class="container-fluid">
  <?php if($RetMsg != 1) { ?> <span class="hdtext fleft">Change Password</span> <?php } ?>
</div>
<div class="container-fluid">
  <?php if($RetMsg == 1) { ?> 
    <div class="container-fluid text-success"><?php echo $Msg; ?></div>
  <?php } ?>
  <?php if($RetMsg == 0) { ?> 
    <div class="container-fluid text-danger"><?php echo $Msg; ?></div>
  <?php } ?>
</div>
<div class="container-fluid">
    <?php if($RetMsg != 1) { ?> 
    <?php echo form_open('', 'id="frmteacherpwd"'); ?>
        <table class="frmTable" style="max-width: 500px;">
            <tr>
                <td>Current Password</td>
                <td><?php echo form_password('curpwd', '', 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>New Password</td>
                <td><?php echo form_password('newpwd', '','class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>New Confirm Password</td>
                <td><?php echo form_password('newpwdcnf', '', 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button class="btn btn-primary" id="frmteacherpwd_submit" >Change</button></td>
            </tr>
        </table> 
        <?php echo form_hidden('pwddata','1'); ?>
    <?php echo form_close(); ?>
    <?php } ?>
</div>
