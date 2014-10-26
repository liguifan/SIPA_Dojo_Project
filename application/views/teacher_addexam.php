<div class="container-fluid">
  <span class="hdtext fleft">Add Exam</span>
</div>
<div class="container-fluid">
</div>
<div class="container-fluid">
    <table class="frmTable" style="width: 500px;">
        <tr class="hidden" id="AddExamError"><td colspan="2" class="text-danger"></td></tr>
        <tr>
            <td>Date</td>
            <td><?php echo form_input('date', date("m/d/Y"), 'class="form-control" id="datepicker"'); ?></td>
        </tr>
        <tr>
            <td>Label</td>
            <td>
                <div class="btn-group">
                    <button type="button" id="btn_lbl_1" onclick="javascript:ShowTab(1);"  class="btn btn-default">Begin</button>
                    <button type="button" id="btn_lbl_2" onclick="javascript:ShowTab(2);"  class="btn btn-default">Middle</button>
                    <button type="button" id="btn_lbl_3" onclick="javascript:ShowTab(3);"  class="btn btn-default">End</button>
                </div>
            </td>
        </tr> 
    </table> 
        <?php $Counter = 0; while($Counter < 3){ $Counter++; ?>
        <div id="skill_<?php echo $Counter; ?>" class="hidden clearfix">
            <?php  
            if(isset($SkillList[$Counter])) { ?>
            <div class="panel panel-default">    
                <?php foreach($SkillList[$Counter] as $k=>$v) {?>
                <div class="panel-body">
                    <span style="margin-right: 10px; margin-top: 5px;" class="fleft"><button type="button" onclick="javascript:AddExam(<?php echo $v['ID']; ?>);"  class="btn btn-primary">Create</button></span>
                    <span class="fleft"><?php echo $v['Name']; ?><br><?php echo $v['SpName']; ?></span>
                </div>
            <?php } ?>
            </div>
            <?php } else{ ?>
                No skills for assessment.
            <?php  } ?>
        </div>
        <?php  } ?>
</div>

<!-- Modal -->
<div class="modal fade" id="addExamSuccessModal" tabindex="-1" role="dialog" aria-labelledby="signupSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="signupSuccessModalLabel">Exam is created successfully.<br>Now you can enter marks for it.</h4>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-success" data-dismiss="modal">OK</span>
      </div>
    </div>
  </div>
</div>
