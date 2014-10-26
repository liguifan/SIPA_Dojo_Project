<div class="container-fluid">
  <span class="fleft">
  <span class="hdtext">Assessment</span>
  <span class="hdtext" style="margin-left: 10px;" >( <?php echo $Teacher['GradeName']." - ".$Teacher['ExamTypeName'];?> ) </span>
  <br>
  <span style="margin-left: 10px;" ><h4>Select date to enter marks.</h4></span>
  </span>
  <span class="btn btn-success fleft" style="margin-left: 50px;" onclick="javascript:redirect_url('<?php echo my_base_URL()."teacher/addexam"; ?>');">Add Exam</span>
</div>
<br>
<div class="container-fluid">
    <table style="min-width: 500px;" class="table table-bordered sttable">
        <colgroup>
            <col width="4*">
            <col width="2*"><col width="2*"><col width="2*">
        </colgroup>
        <thead><tr> <th>Skill</th><th class="text-center">Begin</th><th class="text-center">Middle</th><th class="text-center">End</th> </tr></thead>
        <?php  
        $Goals = array();
        foreach ($SkillList as $Label){
            foreach ($Label as $k=>$Skill){
                $Goals[$k]['Name'] = $Skill['Name'];
                $Goals[$k]['SpName'] = $Skill['SpName'];
        }}
        ?>
        
        <tbody>
            <?php foreach($Goals as $gk => $Gaol){ ?>
            <tr>
                <td> <?php echo $Gaol['Name'].'<br>'.$Gaol['SpName']; ?> </td>
                <?php for($i = 1; $i <= 3; $i++){ ?>
                <td class="text-center">
                <?php if(isset($SkillList[$i]) && isset($SkillList[$i][$gk]) && isset($SkillList[$i][$gk]['Exams']) && count($SkillList[$i][$gk]['Exams']) > 0) {
                    $LCounter = 0;
                    foreach($SkillList[$i][$gk]['Exams'] as $Exam){ if($LCounter > 0) echo '<br>'; $LCounter++?>  
                        <div class="btn btn-default clearfix" onclick="javascript:OpenExam( <?php echo $Exam['ExamID']; ?> );">
                        <?php echo $Exam['Date']; ?>
                        </div>
                <?php }}
                else echo '-';
                ?>
                </td>
                <?php } ?>
            </tr>
            <?php } ?>
        </tbody>
    </table> 
</div>
