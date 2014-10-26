<div class="container-fluid">
  <?php if($RetMsg != 1) { ?> <span class="hdtext fleft">Edit Profile</span> <?php } ?>
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
    <?php echo form_open('', 'id="frmparentprofile"'); ?>
        <table class="frmTable" style="max-width: 500px;">
            <tr>
                <td>First Name</td>
                <td><?php echo form_input('fname', $CurProfile['FName'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo form_input('lname', $CurProfile['LName'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>Contact No</td>
                <td><?php echo form_input('contact', $CurProfile['ContactNo'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button class="btn btn-primary" id="frmparentprofile_submit" >Save</button></td>
            </tr>
        </table> 
        <?php echo form_hidden('profiledata','1'); ?>
    <?php echo form_close(); ?>
    <?php } ?>
</div>
