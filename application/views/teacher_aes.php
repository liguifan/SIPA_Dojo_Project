<div id="contentWrapperHeader" class="clearfix">
  <span class="fleft">
    <span class="hdtext">All Students</span>
    <span class="hdtext" style="margin-left: 10px;" >( <?php echo $Teacher['GradeName']." - ".$Teacher['ExamTypeName'];?> ) </span>
  </span>
  <span class="btn btn-success" style="margin-left: 50px;" id="btnEdit" onclick="javascript:ShowEdit();">Edit</span>
  <span class="btn btn-success hidden" style="margin-left: 50px;" id="btnSave" onclick="javascript:SaveStudents();">Save</span>
  <span class="btn btn-danger hidden" style="margin-left: 10px;" id="btnCancel" onclick="javascript:redirect_url('<?php echo my_base_URL(); ?>teacher/aes');">Cancel</span>
</div>
<div class="container-fluid hidden" id="errdiv">
    <table class="table stdtltable text-danger">
        <colgroup><col width="1*"><col width="10*"></colgroup>
        <thead>
            <tr><th colspan="2">Student detail cannot be saved. Please resolve below errors.</th></tr>
            <tr><th>Row</th><th>Error</th></tr>
        </thead>
        <tbody id="errtblbody"></tbody>
    </table>
</div>
<div class="container-fluid" id="dispData">
    <table class="table table-bordered sttable">
        <col width="5%">
        <col width="20%">
        <col width="12%">
        <col width="20%">
        <col width="30%">
        <col width="13%">
        <thead><tr>
            <th>No.</th>
            <th>Student Name</th>
            <th>Date of Birth</th>
            <th>Parent Name</th>
            <th>Parent Email</th>
            <th>Parent Contact</th>
        </tr></thead>
        <tbody>
            <?php $Counter = 1; foreach($StudentArray as $row) {?>
            <tr>
                <td> <?php echo $Counter; $Counter++; ?> </td>
                <td> <?php echo GetName($row[1], $row[2]); ?> </td>
                <td> <?php echo $row[3]; ?> </td>
                <td> <?php echo GetName($row[4], $row[5]); ?> </td>
                <td> <?php echo $row[6]; ?> </td>
                <td> <?php echo $row[7]; ?> </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<div class="container-fluid hidden" id="editData">
    <div class="handsoncontainer" style="width: 700px; overflow: visible;">
        <div id="tblstudent" ></div>
    </div>
</div>
    
<!-- Modal -->
<div class="modal fade" id="saveStudentSuccessModal" tabindex="-1" role="dialog" aria-labelledby="signupSuccessModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="signupSuccessModalLabel">Student data is saved successfully.</h2>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-success" data-dismiss="modal">OK</span>
      </div>
    </div>
  </div>
</div>
