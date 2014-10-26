<div id="contentWrapperHeader" class="clearfix">
  <span class="fleft">
    <span class="hdtext">Students' Latest Marks</span>
    <span class="hdtext" style="margin-left: 10px;" >( <?php echo $Teacher['GradeName']." - ".$Teacher['ExamTypeName'];?> ) </span>
  </span>
</div>
<div class="container-fluid">
    <table class="table table-bordered" style="width: 100%">
        <col width="25%">
        <col width="15%">
        <col width="15%">
        <col width="15%">
        <col width="15%">
        <thead>
            <tr>
                <th rowspan="2" colspan="2" class="text-left">
                    Students
                </th>
                <th class="text-center" colspan="3">
                    <span class="row">
                    <?php $SkillCount = count($Teacher['GoalsAssigned']); ?>
                    <?php if($SkillCount > 0) { ?>
                    <span class="fleft"><span class="btn btn-primary btn-xs" onclick="javascript:PrevSkill();">Prev</span></span>
                    <?php } ?>
                    <span class="">Skills (<?php echo $Teacher['ExamTypeName']; ?>)</span>
                    <?php if($SkillCount > 0) { ?>
                    <span class="fright"><span class="btn btn-primary btn-xs" onclick="javascript:NextSkill();">Next</span></span>
                    <?php } ?>
                    </span>
                </th>
            </tr>
            <tr>
                <?php 
                $SkillCounter = 0;
                foreach($Teacher['GoalsAssigned'] as $GoalID=>$GoalData) { $SkillCounter++;?>
                <th class="text-center skillCol skillCol_<?php echo $SkillCounter; ?>" colspan=" <?php echo /*count($GoalData['Labels'])*/"3"; ?> ">
                    
                    <?php 
                    echo $GoalList[$GoalID];
                    if(isset($GoalData['SpecificName']))
                        echo "<br><small>".$GoalData['SpecificName']."</small>";
                    ?>
                </th>
                <?php } ?>
            </tr>
            <tr>
                <th>Name</th>  <th class="text-center">Active</th>
                <?php $SkillCounter = 0;
                foreach($Teacher['GoalsAssigned'] as $GoalID=>$GoalData) { 
                        $SkillCounter++;
                        //foreach($GoalData['Labels'] as $LabelID=>$LabelData) {
                        for($LabelID = 1; $LabelID <= 3; $LabelID++) {
                            $LabelData = isset($GoalData['Labels'][$LabelID])?$GoalData['Labels'][$LabelID]:NULL;
                            echo '<th class="text-center skillCol skillCol_'.$SkillCounter.'">';
                            if($LabelID == 1) echo "Beginning of the Year";
                            else if($LabelID == 2) echo "Middle of the Year";
                            else if($LabelID == 3) echo "End of the Year";
                            if(isset($LabelData['DispBenchmark']))
                                echo "<br><small>Benchmark : ".$LabelData['DispBenchmark']."</small>";
                            else
                                echo "<br>&nbsp;";
                            echo "</th>";
                 }} ?>
            </tr>
        </thead>
        <?php foreach($SortedStudentList as $SID) { $Student = &$StudentList[$SID]?>
        <tr><td><?php echo $Student['Name']; ?></td>
            <td class="text-center zeropad">
                <div class="btn-group">
                    <button type="button" id="btn_yes_<?php echo $SID;?>" onclick="javascript:SetActive(true, <?php echo ($Student['Active'])?0:$SID;?>);"  class="btn btn-sm <?php echo $Student['Active']?"btn-success":"btn-default"; ?>">&#10004;</button>
                    <button type="button" id="btn_no_<?php echo $SID;?>"  onclick="javascript:SetActive(false, <?php echo ($Student['Active'])?$SID:0;?>);" class="btn btn-sm <?php echo $Student['Active']?"btn-default":"btn-danger"; ?>">&#10006;</button>
                </div>
            </td>
            <?php   $SkillCounter = 0;
                    foreach($Teacher['GoalsAssigned'] as $GoalID=>$GoalData) { 
                    $SkillCounter++;
                    //foreach($GoalData['Labels'] as $LabelID=>$LabelData) {
                    for($LabelID = 1; $LabelID <= 3; $LabelID++) {
                        $LabelData = isset($GoalData['Labels'][$LabelID])?$GoalData['Labels'][$LabelID]:NULL;
                    ?>
            <td class="text-center zeropad skillCol skillCol_<?php echo $SkillCounter; ?>">
                <?php 
                if(isset($LabelData) && isset($Student['Rank'][$GoalID][$LabelID]))
                {
                    ?>
                    <span class="btn btn-sm <?php echo $Student['Rank'][$GoalID][$LabelID]['Pass']?"btn-success":"btn-danger" ?>" 
                          onclick="javascript:ShowExamDetail( <?php echo "'".$Student['Name']."',".$SID.",".$LabelData['ExamID']; ?> )" >
                    <?php  echo $Student['Rank'][$GoalID][$LabelID]['Pass']?"On Target":"Below Target"; ?>
                    </span>
                    <?php
                }else echo "-"; ?>
            </td>
            <?php }} ?>
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
