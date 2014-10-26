<div id="contentWrapperHeader" class="clearfix">
  <span class="hdtext fleft">Students</span>
</div>
<div class="container-fluid">
    <table class="frmTable" style="max-width: 500px;">
        <thead>
            <tr>
                <th>Name</th>
                <th><?php echo form_dropdown('stid', $Students, safeData($StudentInfo['ID']), 'class="form-control" id="stID"'); ?></th>
            </tr>
        </thead>
    </table>
</div>
<?php if(isset($StudentInfo['ID']) && $StudentInfo['ID'] > 0) { ?>
<div class="container-fluid">
    <table class="table table-bordered sttable">
        <colgroup>
          <col width="5*">
          <col width="2*">
          <col width="2*">
          <col width="2*">
        </colgroup>
        <thead>
            <tr><th class="text-left" colspan="4">
                    <?php 
                        echo $StudentInfo['Name']; 
                        echo isset($StudentInfo['GradeName'])?(" (".$StudentInfo['GradeName'].")"):""; 
                    ?>
            </th></tr>
            <tr><th>&nbsp;</th>
                <th class="text-center">Beginning of the Year</th>
                <th class="text-center">Middle of the Year</th>
                <th class="text-center">End of the Year</th>
            </tr>
        </thead>
        <?php foreach($StudentInfo['RankData'] as $GoalID => $GoalData) { ?>
        <tr><td><?php 
            echo $StudentInfo['ExamData'][$GoalID]['Name']." (".$StudentInfo['ExamData'][$GoalID]['TypeName'].")";
            if(isset($StudentInfo['ExamData'][$GoalID]['SpName']))
                echo "<br>".$StudentInfo['ExamData'][$GoalID]['SpName'];
        ?></td>
            <?php for($Label = 1; $Label <= 3; $Label++){ ?>
            <td class="text-center">
                <?php if(isset($GoalData[$Label])) { ?>
                    <span class="btn <?php echo $GoalData[$Label]['Pass']?"btn-success":"btn-danger" ?>" 
                          onclick="javascript:ShowExamDetail( <?php echo "'".$StudentInfo['Name']."',".$StudentInfo['ID'].",".$GoalData[$Label]['ExamID']; ?> )" >
                    <?php  echo $GoalData[$Label]['Pass']?"On Target":"Below Target"; ?>
                    </span>
                    <?php
                }else echo "-"; ?>
            </td>
            <?php } ?>
        </tr>
        <?php } ?>
    </table>
</div>
<!-- /contentMainCol -->
<!-- Modal -->
<div class="modal fade" id="examDetailModal" tabindex="-1" role="dialog" aria-labelledby="examDetailModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="examDetailModalLabel">Exam Details</h2>
      </div>
      <div class="modal-body" id="bodyModal">
      
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-success" data-dismiss="modal">OK</span>
      </div>
    </div>
  </div>
</div>
<?php } ?>