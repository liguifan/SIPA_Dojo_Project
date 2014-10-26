<div class="container-fluid" style="max-width: 700px; ">
    <div class="panel panel-default"> 
        <div class="panel-body panel-saffron teacher-panel">
            <span class="ad-image fleft vCenterAlways"><img src="<?php echo my_res_URL(); ?>img/profile.png" alt="" title=""></span>
            <span class="fleft width-270 vCenterAlways">
            <h1><?php echo $Login['Name'];?></h1>
            <?php echo $Teacher['GradeName']." ( ".$Teacher['ExamTypeName'];?> )
            <br><?php echo $Teacher['School']; ?>
            <br><?php echo $Teacher['City'].", ".$Teacher['State']; ?>
            </span>
            <span class="fright ad-buttons vCenterAlways">
                <span onclick="javascript:redirect_url('<?php echo my_base_URL();?>teacher/profile')" class="btn btn-default btn-quick">Edit Profile</span>
                <span onclick="javascript:redirect_url('<?php echo my_base_URL();?>teacher/chgpwd')" class="btn btn-default btn-quick">Change Password</span>
            </span>
        </div>
    </div>
    <div class="panel panel-default"> 
        <div class="panel-body panel-sky teacher-panel">
            <span class="ad-image fleft vCenterAlways"><img src="<?php echo my_res_URL(); ?>img/students.png" alt="" title=""></span>
            <span class="fleft width-270 vCenterAlways">
            <h1>Students</h1>
            <br><?php 
                if($StudentCount == 0)
                    echo 'You have no students in class.<br>Please add students by clicking Students link.'; 
                else
                {
                    echo 'Total: '.$StudentCount.', Active: '.$ActiveCount;
                    echo '<br>Manage students by clicking Students link.';
                }
            ?>
            </span>
            <span class="fright ad-buttons vCenterAlways">
                <span onclick="javascript:redirect_url('<?php echo my_base_URL();?>teacher/aes/1')" class="btn btn-default btn-quick">Students</span>
            </span>
        </div>
    </div>
    <div class="panel panel-default"> 
        <div class="panel-body panel-green teacher-panel">
            <span class="ad-image fleft vCenterAlways"><img src="<?php echo my_res_URL(); ?>img/exam.png" alt="" title=""></span>
            <span class="fleft width-270 vCenterAlways">
            <h1>Exams</h1>
            <?php 
            if($AssessCount > 0) echo '<br>';
            echo $SkillCount.' Skills with '.$ExamCount.' Exams'; 
            ?>
            <br><?php
            if($AssessCount > 0) echo "Assessment for $AssessCount exams are done.";
            else echo "You have not assess any exam.<br>Click on Add Exam to create new exam.";
            ?>
            </span>
            <span class="fright ad-buttons vCenterAlways">
                <span onclick="javascript:redirect_url('<?php echo my_base_URL();?>teacher/addexam')" class="btn btn-default btn-quick">Add Exam</span>
                <span onclick="javascript:redirect_url('<?php echo my_base_URL();?>teacher/assessment')" class="btn btn-default btn-quick">Enter Marks</span>
            </span>
        </div>
    </div>
    <div class="panel panel-default"> 
        <div class="panel-body panel-pink teacher-panel">
            <span class="ad-image fleft vCenterAlways"><img src="<?php echo my_res_URL(); ?>img/result.png" alt="" title=""></span>
            <span class="fleft width-270 vCenterAlways">
            <h1>Result</h1>
            <br>    You can always check and compare marks of students.
            <br>Please click Result to check latest score.
            </span>
            <span class="fright ad-buttons vCenterAlways">
                <span onclick="javascript:redirect_url('<?php echo my_base_URL();?>teacher/home')" class="btn btn-default btn-quick">Result</span>
            </span>
        </div>
    </div>
</div>
