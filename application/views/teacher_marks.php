<div id="contentWrapperHeader" class="clearfix">
  <span class="fleft">
    <span class="hdtext">Enter Marks</span>
    <span class="hdtext" style="margin-left: 10px;" >( <?php echo $Teacher['GradeName']." - ".$Teacher['ExamTypeName'];?> ) </span>
  </span>
  <span class="btn btn-success" style="margin-left: 20px;" onclick="javascript:SaveStudents();">Save</span>
  <span class="btn btn-danger" style="margin-left: 10px;" onclick="javascript:redirect_url('<?php echo my_base_URL(); ?>teacher/assessment');">Cancel</span>
</div>
<br>
<div class="row">
    <span class="fleft" style="display: inline">
                <div class="container-fluid hidden" id="errdiv">
                    <table class="table stdtltable text-danger" style="width: 400px; overflow: visible;">
                        <col width="15%"><col width="30%"><col width="55%">
                        <thead>
                            <tr><th colspan="3">Student detail cannot be saved.<br>Please resolve the error below.</th></tr>
                            <tr><th>Row</th><th>Name</th><th>Error</th></tr>
                        </thead>
                        <tbody id="errtblbody"></tbody>
                    </table>
                </div>
                <div class="container-fluid">
                    <div class="handsoncontainer" style="width: 400px; overflow: visible;">
                        <div id="tblstudent" ></div>
                    </div>
                 </div>
    </span>
    <span class="fleft" style="display: inline">
                <div class="container-fluid">Date: <span class="highlight-text"><?php echo $ExamSpData['Date']; ?></span></div>
                <div class="container-fluid ">Skill: <?php echo $ExamSpData['GoalName']; ?> </div>
                <div class="container-fluid ">Level: <?php echo $ExamSpData['LabelName']; ?> of the year</div>
                <div class="container-fluid ">Benchmark: <span class="highlight-text"> <?php echo $ExamSpData['DispBenchmark']; ?> (<?php echo ($ExamSpData['Percent'] == 1)?'Percentage marks':'Absolute marks'; ?>)</span></div>
                <div class="container-fluid ">Description: <?php echo $ExamSpData['GoalSpName']; ?> </div>
    </span>
</div>
    
<!-- Modal -->
<div class="modal fade" id="saveStudentSuccessModal" tabindex="-1" role="dialog" aria-labelledby="signupSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="signupSuccessModalLabel">Student data is saved successfully.</h4>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-success" data-dismiss="modal">OK</span>
      </div>
    </div>
  </div>
</div>
