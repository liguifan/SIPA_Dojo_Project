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
    <?php echo form_open('', 'id="frmteacherprofile"'); ?>
        <table class="frmTable" style="max-width: 500px;">
            <col width="30%">
            <col width="70%">
            <tr>
                <td>Title</td>
                <td><?php echo form_dropdown('title', $TitleOptions,  $CurProfile['IName'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td><?php echo form_input('fname', $CurProfile['FName'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo form_input('lname', $CurProfile['LName'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>School</td>
                <td><?php echo form_input('school', $CurProfile['School'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>Zip</td>
                <td><input type="text" name="zip" style="display: inline" id="zipCode" class="form-control form-control-short" value="<?php echo $CurProfile['Zip']; ?>">
                    <span id="cityData"/></td>
            </tr>
            <tr>
                <td>Contact No</td>
                <td><?php echo form_input('contact', $CurProfile['ContactNo'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button class="btn btn-primary" id="frmteacherprofile_submit" >Save</button></td>
            </tr>
        </table> 
        <?php echo form_hidden('profiledata','1'); ?>
    <?php echo form_close(); ?>
    <?php } ?>
</div>
