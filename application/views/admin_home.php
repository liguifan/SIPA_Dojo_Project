<div id="container" class="container">
  <div class="row clearfix">
      <span class="btn btn-navy" data-toggle="modal" data-target="#addTypeModal">Create Exam Type</span>
      <span class="btn btn-navy" data-toggle="modal" data-target="#addGoalModal">Create Goal</span>
      <span class="btn btn-navy" data-toggle="modal" data-target="#addExamModal">Add Exam</span>
  </div>
  <br>
  Select Exam Type:&nbsp;&nbsp;<?php echo form_dropdown('', $ExamTypeList, 1, 'class="form-control" id="ExamTypeSelect"'); ?>
  <br >
  <div class="row clearfix">
    <table class="table table-bordered sttable">
        <col width="12%">
        <col width="12%">
        <col width="19%">
        <col width="36%">
        <col width="12%">
        <col width="9%">
        <thead>
            <tr>
                <th>Exam Type</th>
                <th>Grade</th>
                <th>Label</th>
                <th>Goal</th>
                <th class='text-center'>Benchmark</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($ExamsList as $k=>$v) {
                echo "<tr class='ExamTypeAll ExamType".$v["ExamTypeID"]."'>";
                echo "<td>".$v["ExamTypeName"]."</td>";
                echo "<td>".$v["GradeName"]."</td>";
                echo "<td>";
                $LabelName = "";
                switch($v["Label"]){
                    case 1: $LabelName = "Begining of the year"; break;
                    case 2: $LabelName = "Middle of the year"; break;
                    case 3: $LabelName = "End of the year"; break;
                }
                echo $LabelName."</td>";
                echo "<td>".$v["GoalName"];
                if(isset($v["SpecificName"]) && $v["SpecificName"] != "")
                    echo "<br>".$v["SpecificName"];
                echo "</td>";
                echo "<td class='text-center'>".$v["SpecificBenchmark"]."</td>";
                echo "<td class='text-center'><span class='btn btn-default' onclick='javascript:OpenModal(".
                        $k.",".
                        "\"".$v["ExamTypeName"]."\",".
                        "\"".$v["GradeName"]."\",".
                        "\"".$v["GoalName"]."\",".
                        "\"".$v["SpecificName"]."\",".
                        "\"".$LabelName."\",".
                        "\"".(isset($v['SpecificBenchmark'])? trim(str_replace('%','',$v['SpecificBenchmark'])):'').
                        "\");'>Edit</span></td>";
                echo "</tr>";
            } ?>
        </tbody>
    </table>
      
  </div>
    
  
  <!-- /contentWrapper -->
</div>


<!-- Modal -->
<div class="modal fade" id="addTypeModal" tabindex="-1" role="dialog" aria-labelledby="addTypeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="addTypeModalLabel">Create Exam Type</h2>
        <div class="modal-body">
        <table class="frmTable">
            <col width="20%">
            <col width="80%">
            <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
            <tr>
                <td>Exam Type</td>
                <td><input type="text" id="examtype" class="form-control"></td>
            </tr>
        </table>
        </div>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-default" data-dismiss="modal">Cancel</span>
        <span type="button" class="btn btn-success" onclick="javascript:AJAXCreateExamType();">Create Exam Type</span>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addGoalModal" tabindex="-1" role="dialog" aria-labelledby="addGoalModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="addGoalModalLabel">Create Goal</h2>
        <div class="modal-body">
        <table class="frmTable">
            <col width="20%">
            <col width="80%">
            <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
            <tr>
                <td>Goal</td>
                <td><input type="text" id="goalname" class="form-control"></td>
            </tr>
        </table>
        </div>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-default" data-dismiss="modal">Cancel</span>
        <span type="button" class="btn btn-success" onclick="javascript:AJAXCreateGoal();">Create Goal</span>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="addExamModal" tabindex="-1" role="dialog" aria-labelledby="addExamModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="addExamModalLabel">Create Exam</h2>
        <div class="modal-body">
        <table class="frmTable">
            <col width="20%">
            <col width="80%">
            <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
            <tr>
                <td>Exam Type</td>
                <td><?php echo form_dropdown('etype', $ExamTypeList, 1, 'class="form-control" id="etype"'); ?></td>
            </tr>
            <tr>
                <td>Grade</td>
                <td><?php echo form_dropdown('grade', $GradeList, 1, 'class="form-control" id="grade"'); ?></td>
            </tr>
            <tr>
                <td>Goal</td>
                <td><?php echo form_dropdown('goal', $GoalList, 1, 'class="form-control" id="goal"'); ?></td>
            </tr>
            <tr>
                <td>Label</td>
                <td>
                    <select id="label" class="form-control">
                        <option value="1">Begining of the year</option>
                        <option value="2">Middle of the year</option>
                        <option value="3">End of the year</option>
                    </select>                    
                </td>
            </tr>
            <tr>
                <td>Specific Goal</td>
                <td><input type="text" id="spgoalname" class="form-control"></td>
            </tr>
            <tr>
                <td>Benchmark</td>
                <td><input type="text" id="benchmark" class="form-control"></td>
            </tr>
            <tr>
                <td>Percentage</td>
                <td><input type="checkbox" id="percent">&nbsp;Yes, marks in percentage.</td>
            </tr>
        </table>
        </div>
      </div>
      <div class="modal-footer">
        <span type="button" class="btn btn-default" data-dismiss="modal">Cancel</span>
        <span type="button" class="btn btn-success" onclick="javascript:AJAXCreateExam();">Create Exam</span>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editExamModal" tabindex="-1" role="dialog" aria-labelledby="editExamModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h2 class="modal-title" id="editExamModalLabel">Edit Exam</h2>
        <div class="modal-body">
        <table class="frmTable">
            <col width="20%">
            <col width="80%">
            <tr class="text-danger text-center hidden"><td colspan="2" id="errorText"></td></tr>
            <tr>
                <td>Exam Type</td>
                <td id="Exam"></td>
            </tr>
            <tr>
                <td>Grade</td>
                <td id="Grade"></td>
            </tr>
            <tr>
                <td>Goal</td>
                <td id="Goal"></td>
            </tr>
            <tr>
                <td>Label</td>
                <td id="Label"></td>
            </tr>
            <tr>
                <td>Specific Goal</td>
                <td><input type="text" id="spgoalname" class="form-control"></td>
            </tr>
            <tr>
                <td>Benchmark</td>
                <td><input type="text" id="benchmark" class="form-control"></td>
            </tr>
        </table>
        </div>
      </div>
      <div class="modal-footer">
        <input type="hidden" id="ExamID" value="0">
        <span type="button" class="btn btn-default" data-dismiss="modal">Cancel</span>
        <span type="button" class="btn btn-success" onclick="javascript:AJAXEditExam();">Save</span>
      </div>
    </div>
  </div>
</div>

