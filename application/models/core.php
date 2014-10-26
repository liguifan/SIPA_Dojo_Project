<?php
require_once 'basemodel.php';
class Core extends BaseModel
{
    public function Login($Type, $UserName, $Pwd)
    {
        $Table = "";
        if($Type == 1) $Table = "teacher";
        else if($Type == 2) $Table = "parent";
        else if($Type == 3) $Table = "admin";
        else return 0;
        $this->db->where("email = '".strtolower($UserName)."'"); 
        //$this->db->where('password', $Pwd); 
        $query = $this->db->get($Table);
        //echo $this->db->last_query();
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            if(isset($row['password']) && (strlen($row['password']) > 0))
                if($Pwd == $row['password'])
                    return $row['id'];
        }
        return 0;
    }
    public function ActivateAccount($Type, $Token, $Password)
    {
        $ID = 0;
        $this->db->where('password_reset', $Token); 
        $query = $this->db->get(($Type == 1)?'teacher':'parent');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $ID = $row['id'];
        }        
        if($ID > 0){
            $Data = array();
            $Data['password_reset'] = NULL;
            $Data['password'] = $Password;
            $this->db->where('id', $ID); 
            $this->db->update(($Type == 1)?'teacher':'parent', $Data);
            return true;            
        }
        return false;
    }
    public function ResetPassword($Type, $Email)
    {
        $Name = "";
        $this->db->where("email = '".strtolower($Email)."'"); 
        $query = $this->db->get(($Type == 1)?'teacher':'parent');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $Name = GetName($row['fname'], $row['lname']);
        }
        else
            return false;

        $Data = array();
        $Data['password_reset'] = my_generatePassword(15);
        $this->db->where('email', $Email); 
        $this->db->update(($Type == 1)?'teacher':'parent', $Data);
        if($this->db->affected_rows() == 1)
        {
            $this->DoMailPasswordReset($Type, $Email, $Name, $Data['password_reset']);
            return true;
        }
        return false;
    }
    public function InsertSchool($School, $Zip)
    {
        $Data = array();
        $Data['name'] = $School;
        $Data['zip_id'] = $Zip;
        $this->db->insert('school', $Data);
    }
    public function GetSchoolID($School, $Zip)
    {
        $this->db->where('name', $School); 
        $this->db->where('zip_id', $Zip); 
        $query = $this->db->get('school');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row['id'];
        }        
        return 0;
    }
    public function FillStates(&$StateList)
    {
        $query = $this->db->get('state');
        foreach ($query->result_array() as $row)
        {
            $StateList[$row['state_id']] = $row['state_name'];
        }        
    }
    public function FillGrades(&$GradeList)
    {
        $query = $this->db->get('grade');
        foreach ($query->result_array() as $row)
        {
            $GradeList[$row['id']] = $row['name'];
        }        
    }
    public function FillExamTypes(&$ExamTypeList)
    {
        $query = $this->db->get('exam_type');
        foreach ($query->result_array() as $row)
        {
            $ExamTypeList[$row['id']] = $row['name'];
        }        
    }
    public function CreateTeacher($IName, $FName, $LName, $UserName, $School, $Zip, $Grade, $Type, $Contact)
    {
        $Data = array();
        $Data['iname'] = $IName;
        $Data['fname'] = $FName;
        $Data['lname'] = $LName;
        $Data['password_reset'] = my_generatePassword(15);
        $Data['grade_id'] = $Grade;
        $Data['exam_type_id'] = $Type;
        $Data['school_id'] = $this->GetSchoolID($School, $Zip);
        if($Data['school_id'] <= 0)
        {
            $this->InsertSchool($School, $Zip);
            $Data['school_id'] = $this->GetSchoolID($School, $Zip);
        }
        $Data['email'] = strtolower($UserName);
        $Data['contact_no'] = $Contact;
        
        $this->db->insert('teacher', $Data);
        $Ret =  $this->db->insert_id();
        if($Ret > 0)
            $this->DoMailTeacherPassword($Data);
        return $Ret;
    }
    public function ChangePassword($Type, $ID, $Old, $New)
    {
        $Table = "";
        if($Type == 1) $Table = "teacher";
        else if($Type == 2) $Table = "parent";
        else if($Type == 3) $Table = "admin";
        else return 0;
        $Data = array('password' => $New);
        $this->db->where('password', $Old);
        $this->db->where('id', $ID);
        $query = $this->db->update($Table, $Data);
        return ($this->db->affected_rows() == 1);
    }
    public function FillLogin(&$LoginData)
    {
        $Table = "";
        if($LoginData['UserType'] == 1) $Table = "teacher";
        else if($LoginData['UserType'] == 2) $Table = "parent";
        else if($LoginData['UserType'] == 3) $Table = "admin";
        else return 0;
        $this->db->where('id', $LoginData['UserID']);
        $query = $this->db->get($Table);
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $LoginData['Name'] = GetName($row['fname'], $row['lname']);
            if($LoginData['UserType'] == 1)
                $LoginData['Name'] = $row['iname'] . " " .$LoginData['Name'];
        }        
    }

    public function FillGoals(&$GoalList)
    {
        $query = $this->db->get('goal');
        foreach ($query->result_array() as $row)
        {
            $GoalList[$row['id']] = $row['name'];
        }        
    }

    public function FillStudents($TeacherID, &$StudentList)
    {
        $StudentList = array();
        $this->db->where("id IN (select student_id from student_teacher where teacher_id = $TeacherID)"); 
        $query = $this->db->get('v_student');
        foreach ($query->result_array() as $row)
        {
            $StudentList[$row['id']]['Name'] = GetName($row['fname'], $row['lname']);
            $StudentList[$row['id']]['Active'] = $row['active'];
        }        
    }

    public function FillStudentsMarks($TeacherID, $GradeID, &$StudentMarks)
    {
        $this->db->where('teacher_id', $TeacherID); 
        $this->db->where('grade_id', $GradeID);
        $query = $this->db->get('v_student_marks');
        $StudentMarks['Goals'] = array();
        
        foreach ($query->result_array() as $row)
        {
            $StudentMarks[$row['id']][$row['goal_id']][$row['label']]['Score'] = $row['score'];
        }        
    }
    public function FillParent($ParentID, &$ParentData)
    {
        $this->db->where('id', $ParentID); 
        $query = $this->db->get('parent');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $ParentData['ID'] = $row['id'];
            $ParentData['Name'] =  GetName($row['fname'], $row['lname']);
            $ParentData['FName'] =  $row['fname'];
            $ParentData['LName'] =  $row['lname'];
            $ParentData['Email'] = $row['email'];
            $ParentData['ContactNo'] = $row['contact_no'];
        }   
        
        $ParentData['DirParent'] = false;
        $ParentData['Students'] = array();
        
        $this->db->where('observer_id', $ParentID); 
        $query = $this->db->get('v_student_obs');
        foreach ($query->result_array() as $row)
        {
            if($row['observer_id'] == $row['main_parent_id'])
                $ParentData['DirParent'] = true;
            $ParentData['Students'][$row['id']] = array(

                'Name' => GetName($row['fname'], $row['lname']),
                'Dir' => ($row['observer_id'] == $row['main_parent_id'])?true:false);
        }   
        
    }
    public function UpdateTeacher($TeacherID, $IName, $FName, $LName, $School, $Zip, $Contact)
    {
        $Data = array(  'iname' => $IName,
                        'fname' => $FName,
                        'lname' => $LName,
                        'school_id' => $this->GetSchoolID($School, $Zip),
                        'contact_no' => $Contact);
        if($Data['school_id'] <= 0)
        {
            $this->InsertSchool($School, $Zip);
            $Data['school_id'] = $this->GetSchoolID($School, $Zip);
        }
        $this->db->where('id', $TeacherID); 
        $this->db->update('teacher', $Data);
    }
    public function FillTeacher($TeacherID, &$TeacherData)
    {
        $this->db->where('id', $TeacherID); 
        $query = $this->db->get('v_teacher');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $TeacherData['ID'] = $row['id'];
            $TeacherData['Name'] =  GetName($row['fname'], $row['lname']);
            $TeacherData['IName'] =  $row['iname'];
            $TeacherData['FName'] =  $row['fname'];
            $TeacherData['LName'] =  $row['lname'];
            $TeacherData['ExamTypeID'] = $row['exam_type_id'];
            $TeacherData['ExamTypeName'] = $row['exam_type_name'];
            $TeacherData['Email'] = $row['email'];
            $TeacherData['ContactNo'] = $row['contact_no'];
            $TeacherData['SchoolID'] = $row['school_id'];
            $TeacherData['School'] = $row['school_name'];
            $TeacherData['City'] = $row['school_city'];
            $TeacherData['State'] = $row['school_state'];
            $TeacherData['Zip'] = $row['zip_id'];
            $TeacherData['GradeID'] = $row['grade_id'];
            $TeacherData['GradeName'] = $row['grade_name'];
        }   
        if(isset($TeacherData['GradeID']))
        {
            $this->db->where('teacher_id', $TeacherID); 
            $query = $this->db->get('v_teacher_goal');
            $TeacherData['GoalsAssigned'] = array();
            foreach ($query->result_array() as $row)
            {
                $TeacherData['GoalsAssigned'][$row['goal_id']]['SpecificName'] = $row['specific_name'];
                $TeacherData['GoalsAssigned'][$row['goal_id']]['Labels'][$row['label']] = array(
                    'ExamID' =>$row['exam_id'],
                    'DispBenchmark' => ScoreString($row['benchmark'], $row['percent'], $row['specific_benchmark'])
                    );
            }
        }
    }
    public function FillStudentMarksArray($TeacherID, $ExamID, &$StudentMarksArray)
    {
        $this->db->where('teacher_id', $TeacherID); 
        $query = $this->db->get('v_student_marks');
        $Students = array();
        foreach ($query->result_array() as $row)
        {
            if($row['active']){
            $Students[$row['id']]['Name'] = GetName($row['fname'], $row['lname']);
            if($ExamID == $row['exam_teacher_id'])
                $Students[$row['id']]['Score'] = ScoreString($row['score'], $row['percent'], $row['specific_score']);
            }
        }        
        foreach($Students as $k => $v)
            $StudentMarksArray[] = array($k, $v['Name'], isset($v['Score'])? trim(str_replace('%','',$v['Score'])):'');
    }
    public function FillStudentArray($TeacherID, &$FillStudentArray)
    {
        $this->db->where("id IN (select student_id from student_teacher where teacher_id = $TeacherID)"); 
        $query = $this->db->get('v_student');
        foreach ($query->result_array() as $row)
        {
            $FillStudentArray[] = array($row['id'], $row['fname'], $row['lname'], dateConvSQLUSA($row['dob']), $row['parent_fname'], $row['parent_lname'], $row['parent_email'], $row['parent_contact']);
        }        
    }
    public function FillStudentsForParent($SID, &$StudentInfo)
    {
        $StudentInfo['ID'] = $SID;
        $StudentInfo['GradeID'] = 0;
        $this->db->where('id', $SID);
        $query = $this->db->get('v_student');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $StudentInfo['GradeID'] = $row['cur_grade_id'];
            $StudentInfo['GradeName'] = $row['cur_grade_name'];
            $StudentInfo['Name'] = GetName($row['fname'], $row['lname']);
        }
        
        $StudentInfo['ExamData'] = array();
        $ExamData = &$StudentInfo['ExamData'];
        $StudentInfo['RankData'] = array();
        $RankData = &$StudentInfo['RankData'];
        
        if($StudentInfo['GradeID'] <= 0)
            return;
        
        $this->db->where('id', $SID);
        $this->db->where('grade_id', $StudentInfo['GradeID']);
        $query = $this->db->get('v_student_rank');
        foreach ($query->result_array() as $row)
        {
            $RankData[$row['goal_id']][$row['label']] = array('Pass' => $row['pass'], 'ExamID' => $row['exam_id']);
        }   
        
        $this->db->where('grade_id', $StudentInfo['GradeID']);
        $query = $this->db->get('v_exam');
        foreach ($query->result_array() as $row)
        {
            $ExamData[$row['goal_id']] = array('Name' => $row['goal_name'],
                                                        'SpName' => $row['specific_name'],
                                                        'TypeName' => $row['exam_type_name']);
        }   
        
        //print_r($StudentInfo);
    }
    
    public function FillStudent(&$StudentData, $FullInfo = false)
    {
        $this->db->where('id', $StudentData['ID']); 
        $query = $this->db->get('student');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $StudentData['Name'] = $row['name'];
            $StudentData['Dob'] = dateConvSQLUSA($row['dob']);
            $StudentData['Active'] = $row['active'];
        }
        if($FullInfo)
        {
            $sql = "select * from parent where id IN (Select parent_id from student_parent where student_id = ". $StudentData['ID'].")";
            $query = $this->db->query($sql);
            foreach ($query->result_array() as $row)
            {
                $Parent = array();
                $Parent['ID'] = $row['id'];
                $Parent['Name'] = $row['name'];
                $Parent['Email'] = $row['email'];
                $Parent['Contact'] = $row['contact_no'];
                $StudentData['Parent'][] = $Parent;
            }
        }
    }
    public function GetParent($Email)
    {
        $this->db->where("email = '".strtolower($Email)."'"); 
        $query = $this->db->get('parent');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row['id'];
        }
        return 0;
    }
    public function UpdateParent($ID, $FName, $LName, $Contact)
    {
        $Data = array(  'id' => $ID,
                        'fname' => $FName,
                        'lname' => $LName,
                        'contact_no' => $Contact);
        
        $this->db->where('id', $ID); 
        $this->db->update('parent', $Data);
        return ($this->db->affected_rows() == 1);
    }
    public function InsertParent($FName, $LName, $Email, $Contact)
    {
        $Data = array(  'fname' => $FName,
                        'lname' => $LName,
                        'email' => strtolower($Email),
                        'password_reset' => my_generatePassword(15),
                        'contact_no' => $Contact);
        
        $this->db->insert('parent', $Data);
        $Ret =  $this->db->insert_id();
        $this->DoMailParentPassword($Data);
        return $Ret;
    }
    public function InsertStudent($FName, $LName, $Dob, $GradeID, $ParentID, $TeacherID)
    {
        $Data = array(  'fname' => $FName,
                        'lname' => $LName,
                        'dob' => $Dob,
                        'active' => 1,
                        'cur_grade_id' => $GradeID,
                        'parent_id' => $ParentID);
        
        $this->db->insert('student', $Data);
        $StudentID = $this->db->insert_id();

        $Data = array(  'student_id' => $StudentID,
                        'parent_id' => $ParentID);
        $this->db->insert('student_parent', $Data);
        
        $Data = array(  'student_id' => $StudentID,
                        'teacher_id' => $TeacherID);
        $this->db->insert('student_teacher', $Data);

        return $StudentID;
    }
    public function UpdateStudent($StudentID, $FName, $LName, $Dob, $ParentID)
    {
        $OldParentID = 0;
        $this->db->where('id', $StudentID);
        $query = $this->db->get('student');
        if($query->num_rows() > 0){
            $row = $query->row_array();
            $OldParentID = $row['parent_id'];
        }
        
        if($OldParentID != $ParentID){
            $this->db->where('student_id', intval($StudentID)); 
            $this->db->delete('student_parent');
        }
        
        
        $Data = array(  'fname' => $FName,
                        'lname' => $LName,
                        'dob' => $Dob,
                        'parent_id' => $ParentID);
        $this->db->where('id', $StudentID); 
        $this->db->update('student', $Data);
        
        $Data = array(  'student_id' => $StudentID,
                        'parent_id' => $ParentID);
        $this->db->insert('student_parent', $Data);
        
        return true;
    }
    public function ChangeActive($StudentID, $Status)
    {
        $Data = array('active' => ($Status == 1) ? 1 : 0);
        $this->db->where('id', intval($StudentID)); 
        $this->db->update('student', $Data);
        return ($this->db->affected_rows() == 1);
    }
    public function FillObservers($ParentID, &$Obs){
        
        // Fill all parents
        $this->db->where('main_parent_id', $ParentID); 
        $query = $this->db->get('v_student_obs');
        $Obs['Parents']  = array();
        $Obs['Students'] = array();
        foreach ($query->result_array() as $row)
        {
            if($row['observer_id'] != $ParentID)
                $Obs['Parents'][$row['observer_id']] = array('Name' => GetName($row['parent_fname'], $row['parent_lname']));
            $Obs['Students'][$row['id']]['Name'] = GetName($row['fname'], $row['lname']);
            $Obs['Students'][$row['id']]['Map'][] = $row['observer_id'];
        }   
    }
    public function RemoveObserver($PID, $SID){
        $this->db->where('student_id', $SID);
        $this->db->where('parent_id', $PID);
        $this->db->delete('student_parent');
    }
    public function AddObserver($PID, $SID){
        $Data = array('student_id' => $SID, 'parent_id' => $PID);
        $this->db->insert('student_parent', $Data);
    }
    public function FillSkillsForTeacher($TeacherData, &$SkillList, $FillDates = false)
    {
        $SkillList = array();
        $this->db->where('grade_id', $TeacherData['GradeID']); 
        $this->db->where('exam_type_id', $TeacherData['ExamTypeID']); 
        $query = $this->db->get('v_exam');
        foreach ($query->result_array() as $row)
        {
            $SkillList[$row['label']][$row['goal_id']]['ID'] = $row['id'];
            $SkillList[$row['label']][$row['goal_id']]['Name'] = $row['goal_name'];
            $SkillList[$row['label']][$row['goal_id']]['SpName'] = $row['specific_name'];
        }
        if($FillDates)
        foreach($SkillList as &$Label){
            foreach($Label as &$Skill){
                $this->db->where('exam_id', $Skill['ID']); 
                $this->db->where('teacher_id', $TeacherData['ID']); 
                $query = $this->db->get('exam_teacher');
                //echo '<br>'.$this->db->last_query();
                foreach ($query->result_array() as $row){
                    $Skill['Exams'][] = array('ExamID' => $row['id'], 'Date' => dateConvSQLUSA($row['doe']));
        }}}
    }
    public function AddExam($TeacherID, $ExamID, $Date)
    {
        $Data = array('exam_id' => $ExamID, 'teacher_id' => $TeacherID, 'doe' => $Date);
        $this->db->insert('exam_teacher', $Data);
        return $this->db->insert_id();
    }
    public function DeleteMarks($ExamID, $StudentIDs)
    {
        if(isset($StudentIDs) && count($StudentIDs) > 0)
        {
            $this->db->where('exam_teacher_id', $ExamID); 
            $this->db->where('student_id IN ('.implode(",", $StudentIDs).')'); 
            $this->db->delete('exam_marks');
        }
        //echo '<br>'.$this->db->last_query();
    }
    public function SaveMarks($ExamID, $StudentID, $Marks)
    {
        $this->db->insert('exam_marks', array('exam_teacher_id' => $ExamID, 'student_id' => $StudentID, 'score' => $Marks));
        //echo '<br>'.$this->db->last_query();
        return ($this->db->affected_rows() > 0);
    }
    public function FillScoreSpData($ExamID, &$ScoreSpData)
    {
        $ScoreSpData = array();
        $this->db->where('exam_type_id', $ExamID); 
        $query = $this->db->get('score_type_name');
        foreach ($query->result_array() as $row){
            $ScoreSpData[] = array('Score' => $row['score'], 'Name' => strtolower($row['name']));
        }
    }
    public function FillExamSpData($ExamID, &$ExamSpData)
    {
        $ExamMainID = 0;
        $ExamSpData = array();
        $this->db->where('id', $ExamID); 
        $query = $this->db->get('exam_teacher');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $ExamMainID = $row['exam_id'];
            $ExamSpData['ExamMainID'] = $ExamMainID;
            $ExamSpData['Date'] = dateConvSQLUSA($row['doe']);
        }
        $this->db->where('id', $ExamMainID); 
        $query = $this->db->get('v_exam');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $ExamSpData['GradeID'] = $row['grade_id'];
            $ExamSpData['ExamTypeID'] = $row['exam_type_id'];
            $ExamSpData['GoalID'] = $row['goal_id'];
            $ExamSpData['Label'] = $row['label'];
            $ExamSpData['Benchmark'] = $row['benchmark'];
            $ExamSpData['DispBenchmark'] = ScoreString($row['benchmark'], $row['percent'], $row['specific_benchmark']);
            $ExamSpData['Percent'] = $row['percent'];
            $ExamSpData['Description'] = $row['description'];
            $ExamSpData['ExamTypeName'] = $row['exam_type_name'];
            $ExamSpData['GradeName'] = $row['grade_name'];
            $ExamSpData['GoalName'] = $row['goal_name'];
            $ExamSpData['GoalSpName'] = $row['specific_name'];
            if($row['label'] == 1)
                $ExamSpData['LabelName'] = "Begin";
            else if($row['label'] == 2)
                $ExamSpData['LabelName'] = "Middle";
            else if($row['label'] == 3)
                $ExamSpData['LabelName'] = "End";
        }
    }
    
    public function RefreshRank($ExamMainID, $StudentIDs, $ExamSpData)
    {
        $this->db->where('exam_id', $ExamMainID); 
        $this->db->where('student_id IN ('.implode(",", $StudentIDs).')'); 
        $query = $this->db->delete('exam_rank');
        foreach($StudentIDs as $SID)
        {
            $this->db->where('exam_main_id', $ExamMainID); 
            $this->db->where('id', $SID); 
            $query = $this->db->get('v_student_marks');
            $ScoreFinal = NULL;
            foreach ($query->result_array() as $row){
                if(isset($row['score']))
                    $ScoreFinal = $row['score'];
            }
            if(isset($ScoreFinal))
            {
                $this->db->insert('exam_rank', array(
                    'exam_id' => $ExamMainID,
                    'student_id' => $SID,
                    'score' => $ScoreFinal,
                    'pass' => ($ScoreFinal >=  $ExamSpData['Benchmark'])?1:0
                    ));
            }
        }
    }
    public function RefreshRankAll($ExamID){
        if(!$this->GetExamDetail($ExamID, $Detail)) return false;
        
        $this->db->where('exam_id', $ExamID);
        $query = $this->db->delete('exam_rank');
        
        $this->db->where('exam_main_id', $ExamID); 
        $this->db->select('id');
        $this->db->distinct();
        $query1 = $this->db->get('v_student_marks');
        foreach ($query1->result_array() as $row1){
            $SID = $row1['id'];
            $this->db->where('exam_main_id', $ExamID); 
            $this->db->where('id', $SID); 
            $query = $this->db->get('v_student_marks');
            $ScoreFinal = NULL;
            foreach ($query->result_array() as $row){
                if(isset($row['score']))
                    $ScoreFinal = $row['score'];
            }
            if(isset($ScoreFinal))
            {
                $this->db->insert('exam_rank', array(
                    'exam_id' => $ExamID,
                    'student_id' => $SID,
                    'score' => $ScoreFinal,
                    'pass' => ($ScoreFinal >=  $Detail['benchmark'])?1:0
                    ));
            }
        }
    }
    public function FillRank($SID, $GradeID, &$StudentData)
    {
        $StudentData['Rank'] = array();
        $Rank = &$StudentData['Rank'];
        
        $this->db->where('id', $SID); 
        $this->db->where('grade_id', $GradeID); 
        $query = $this->db->get('v_student_rank');
        foreach ($query->result_array() as $row){
            $Rank[$row['goal_id']][$row['label']] = array(
                'Score' => $row['score'],
                'Pass' => $row['pass'],
                'Percent' => $row['percent'],
                'SpScore' => $row['specific_score'],
                'DispScore' => ScoreString($row['score'], $row['percent'], $row['specific_score'])
            );
        }
    }
    public function FillExamDetail($SID, $ExamID, &$Detail){
        $ExamSpData = &$Detail['Exam'];
        $this->db->where('id', $ExamID); 
        $query = $this->db->get('v_exam');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            $ExamSpData['GradeID'] = $row['grade_id'];
            $ExamSpData['ExamTypeID'] = $row['exam_type_id'];
            $ExamSpData['GoalID'] = $row['goal_id'];
            $ExamSpData['Label'] = $row['label'];
            $ExamSpData['Benchmark'] = $row['benchmark'];
            $ExamSpData['DispBenchmark'] = ScoreString($row['benchmark'], $row['percent'], $row['specific_benchmark']);
            $ExamSpData['Percent'] = $row['percent'];
            $ExamSpData['Description'] = $row['description'];
            $ExamSpData['ExamTypeName'] = $row['exam_type_name'];
            $ExamSpData['GradeName'] = $row['grade_name'];
            $ExamSpData['GoalName'] = $row['goal_name'];
            $ExamSpData['GoalSpName'] = $row['specific_name'];
            if($row['label'] == 1)
                $ExamSpData['LabelName'] = "Begin";
            else if($row['label'] == 2)
                $ExamSpData['LabelName'] = "Middle";
            else if($row['label'] == 3)
                $ExamSpData['LabelName'] = "End";
        }
        
        $this->db->where('id', $SID); 
        $this->db->where('exam_main_id', $ExamID);
        $query = $this->db->get('v_student_marks');
        foreach ($query->result_array() as $row){
            $Detail['Marks'][] = array( 'Date' => dateConvSQLUSA($row['doe']), 
                'Score' => ScoreString($row['score'], $ExamSpData['Percent'], $row['specific_score']), 
                'Pass' => ($row['score'] >= $ExamSpData['Benchmark'])?1:0);
        }
        
    }
    public function GetZipData($ZipCode)
    {
        $this->db->where('zip_id', $ZipCode); 
        $query = $this->db->get('zipcodes');
        if($query->num_rows() > 0)
        {
            $row = $query->row_array();
            return $row['city'].", ".$row['state'];
        }      
        return "";
    }
    public function AddExamType($ExamType){
        $Data['name'] = $ExamType;
        $this->db->insert('exam_type', $Data);
        return ($this->db->insert_id() > 0);
    }
    public function AddGoal($Goal){
        $Data['name'] = $Goal;
        $this->db->insert('goal', $Data);
        //echo $this->db->last_query();
        return ($this->db->insert_id() > 0);
    }
    public function AddExamAdmin($ExamType, $Grade, $Goal, $Label, $Description, $Benchmark, $Percent){
        $Data['exam_type_id'] = $ExamType;
        $Data['grade_id'] = $Grade;
        $Data['goal_id'] = $Goal;
        $Data['label'] = $Label;
        $Data['benchmark'] = $Benchmark;
        $Data['percent'] = $Percent;
        $Data['description'] = strval($Description);
        $this->db->insert('exam', $Data);
        $Ret = ($this->db->insert_id() > 0);
        //echo $this->db->last_query();
        $this->UpdateSpecialGoalName($ExamType, $Goal, $Description);
        return $Ret;
    }
    public function FillAllExams(&$Exams){
        $Exams = array();
        $query = $this->db->get('v_exam');
        foreach ($query->result_array() as $row){
            $Exams[$row["id"]] = array(
                "GradeID" => $row["grade_id"],
                "ExamTypeID" => $row["exam_type_id"],
                "GoalID" => $row["goal_id"],
                "Label" => $row["label"],
                "Benchmark" => $row["benchmark"],
                "Percent" => $row["percent"],
                "Description" => $row["description"],
                "ExamTypeName" => $row["exam_type_name"],
                "GradeName" => $row["grade_name"],
                "GoalName" => $row["goal_name"],
                "SpecificName" => $row["specific_name"],
                "SpecificBenchmark" => ScoreString($row['benchmark'], $row['percent'], $row['specific_benchmark']) 
                );
        }
    }
    public function UpdateSpecialGoalName($ExamTypeID, $GoalID, $Name){
        $this->db->where('exam_type_id', $ExamTypeID);
        $this->db->where('goal_id', $GoalID);
        $this->db->delete('exam_type_goalname');
        
        $this->db->insert('exam_type_goalname', array('exam_type_id'=>$ExamTypeID, 'goal_id' => $GoalID, 'Name' => $Name));
    }
    public function EditExamAdmin($ExamID, $Name, $BenchMark){
        if(!$this->GetExamDetail($ExamID, $Detail)) return false;
        $this->UpdateSpecialGoalName($Detail['exam_type_id'], $Detail['goal_id'], $Name);
        $Data = array(
            'description' => '',
            'benchmark' => $BenchMark);
        $this->db->where('id', $ExamID);
        $this->db->update('exam', $Data);
        $this->RefreshRankAll($ExamID);
        return true;
    }
    public function PercentInExam($ExamID){
        if($this->GetExamDetail($ExamID, $Detail))
            return $Detail['percent'];
        return 0;
    }
    public function GetExamDetail($ExamID, &$Detail){
        $this->db->where('id', $ExamID);
        $query = $this->db->get('exam');
        if($query->num_rows() > 0)
        {
            $Detail = $query->row_array();
            return true;
        }
        return false;
    }
}
?>