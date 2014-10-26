<div class="container-fluid">
  <?php if($RetMsg != 1) { ?> <span class="hdtext fleft">Add Observer</span> <?php } ?>
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
    <?php echo form_open('', 'id="frmobsdata"'); ?>
        <table class="frmTable" style="max-width: 500px;">
            <tr>
                <td>Students</td>
                <td><?php echo form_dropdown('sid', $CurObs['StData'], $CurObs['SID'],'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>Email</td>
                <td><?php echo form_input('email', $CurObs['Email'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>First Name</td>
                <td><?php echo form_input('fname', $CurObs['FName'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>Last Name</td>
                <td><?php echo form_input('lname', $CurObs['LName'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td>Contact No</td>
                <td><?php echo form_input('contact', $CurObs['ContactNo'], 'class="form-control"'); ?></td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <button class="btn btn-primary" id="frmobsdata_submit" >Add</button></td>
            </tr>
        </table> 
        <?php echo form_hidden('obsdata','1'); ?>
    <?php echo form_close(); ?>
    <?php } ?>
</div>
