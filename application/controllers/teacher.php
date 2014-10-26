<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Teacher extends CI_Controller {
    var $data;
    public function Teacher() {
        parent::__construct();
        $this->data['Login']['UserID']   = $this->session->userdata('UserID');
        $this->data['Login']['UserType'] = $this->session->userdata('UserType');
        if($this->data['Login']['UserID'] <= 0 || $this->data['Login']['UserType'] != 1){
            redirect(my_base_URL());
        }
        else{
            $this->load->model('Core');
            $this->Core->FillLogin($this->data['Login']);
            $this->Core->FillTeacher($this->data['Login']['UserID'], $this->data['Teacher']);
        }
    }
    public function index() {
        $this->data['InnerPage'] = "teacher_quick";
        $this->load->model('Core');
        $this->Core->FillStudents($this->data['Login']['UserID'], $this->data['StudentList']);
        $this->data['StudentCount'] = count($this->data['StudentList']);
        $this->data['ActiveCount'] = 0;
        foreach($this->data['StudentList'] as &$v)
            if($v['Active'] == 1) $this->data['ActiveCount']++;
            
        $this->Core->FillSkillsForTeacher($this->data['Teacher'], $this->data['SkillList'], true);
        $this->data['SkillCount'] = count($this->data['SkillList']);
        $this->data['ExamCount'] = 0;
        $this->data['AssessCount'] = 0;
        
        foreach($this->data['SkillList'] as $v)
        {
            $this->data['ExamCount'] += count($v);
            foreach($v as $v1)
                if(isset($v1['Exams'])) $this->data['AssessCount']++;
        }

        $this->load->view('teacher_frame', $this->data);
    }
    public function home() {
        $this->data['InnerPage'] = "teacher_main";
        $this->load->model('Core');
        $this->Core->FillGoals($this->data['GoalList']);
        $this->Core->FillStudents($this->data['Login']['UserID'], $this->data['StudentList']);
        $this->data['SortedStudentList'] = array();
        foreach($this->data['StudentList'] as $k=>&$v)
        {
            $this->Core->FillRank($k, $this->data['Teacher']['GradeID'], $v);
            if($v['Active'] == 1) $this->data['SortedStudentList'][] = $k;
        }
        foreach($this->data['StudentList'] as $k=>&$v)
            if($v['Active'] != 1) $this->data['SortedStudentList'][] = $k;
        //print_r($this->data);

        $this->load->view('teacher_frame', $this->data);
    }
    public function logout() {
        $this->session->unset_userdata('UserID');
        $this->session->unset_userdata('UserType');
        $this->session->sess_destroy();
        redirect(my_base_URL());
    }
    public function chgpwd(){
        $this->data['InnerPage'] = "teacher_pwd";
        $this->data['RetMsg'] = -1;
        if(isset($_POST['pwddata'])){ // data is submitted
            $this->data['RetMsg'] = 1;
            $CurPwd = postData('curpwd', FALSE);
            $NewPwd = postData('newpwd', FALSE);
            $NewPwdCnf = postData('newpwdcnf', FALSE);
            
            if(strlen($NewPwd) < 6)
            {
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] = "New Password should contain atleast 6 characters.";
            }
            else if($NewPwd != $NewPwdCnf)
            {
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] = "New Password and Confirm Password are not same.";
            }
            
            if($this->data['RetMsg'] > 0)
            {
                $this->load->model('Core');
                if(!$this->Core->ChangePassword($this->data['Login']['UserType'], $this->data['Login']['UserID'], $CurPwd, $NewPwd))
                {
                    $this->data['RetMsg'] = 0;
                    $this->data['Msg'] = "Current Password is not correct.";
                }
                else
                {
                    $this->data['Msg'] = "Password updated successfully.";
                }
            }
        }
        $this->load->view('teacher_frame', $this->data);
    }
    public function profile() {
        $this->data['InnerPage'] = "teacher_profile";
        $this->data['RetMsg'] = -1;
        $this->data['TitleOptions'] = array(1 => 'Mr.', 2 => 'Ms.', 3 => 'Mrs.');
        $this->data['CurProfile'] = $this->data['Teacher'];
        $Cur = &$this->data['CurProfile'];
        $Cur['IName'] = array_search($Cur['IName'], $this->data['TitleOptions']);
        
        if(isset($_POST['profiledata'])){ // data is submitted
            $this->data['RetMsg'] = 1;
            
            $Cur['IName']    = postData("title");
            $Cur['FName']    = postData("fname");
            $Cur['LName']    = postData("lname");
            $Cur['School']   = postData("school");
            $Cur['Zip']      = postData("zip");
            $Cur['ContactNo']  = postData("contact");

            if($Cur['FName'] == "" && $Cur['LName'] == ""){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] = "<br>First name and Last Name both cannot be empty.";}

            if($Cur['School'] == ""){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] = "<br>School cannot be empty.";}

            if($this->Core->GetZipData($Cur['Zip']) == ""){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] = "<br>Zip is invalid.";}

            if($this->data['RetMsg'])
            {
                switch($Cur['IName'])
                {
                    case 1: $Cur['INameFull'] = 'Mr.'; break;
                    case 2: $Cur['INameFull'] = 'Ms.'; break;
                    case 3: $Cur['INameFull'] = 'Mrs.'; break;
                }

                $this->load->model('Core');
                $this->Core->UpdateTeacher($this->data['Login']['UserID'], $Cur['INameFull'], $Cur['FName'], $Cur['LName'], $Cur['School'], $Cur['Zip'], $Cur['ContactNo']);
                $this->data['Msg'] = "Profile updated successfully.";
                $this->Core->FillLogin($this->data['Login']);
                $this->Core->FillTeacher($this->data['Login']['UserID'], $this->data['Teacher']);
            }                
        }
        $this->load->view('teacher_frame', $this->data);
    }
    public function addexam() {
        $this->data['InnerPage'] = "teacher_addexam";
        $this->data['css'][] = "jquery-ui.css";
        $this->load->model('Core');
        $this->Core->FillSkillsForTeacher($this->data['Teacher'], $this->data['SkillList']);
        $this->load->view('teacher_frame', $this->data);
    }
    
    public function aes($Type=0) {
        $this->data['InnerPage'] = "teacher_aes";
        $this->data['css'][] = "jquery.handsontable.full.css";
        
        $this->load->model('Core');
        $this->data['StudentArray'] = array();
        $this->Core->FillStudentArray($this->data['Login']['UserID'], $this->data['StudentArray']);
        
        $this->data['StartType'] = $Type;
        
        $this->load->view('teacher_frame', $this->data);
    }
    public function marks($ExamID)
    {
        if(!isset($ExamID) && $ExamID <= 0)
        {
            redirect(my_base_URL()."teacher");
            return;
        }
        
        $this->data['InnerPage'] = "teacher_marks";
        $this->data['css'][] = "jquery.handsontable.full.css";
        
        $this->load->model('Core');
        $this->data['StudentArray'] = array();
        $this->Core->FillStudentMarksArray($this->data['Login']['UserID'], $ExamID, $this->data['StudentMarksArray']);
        $this->Core->FillExamSpData($ExamID, $this->data['ExamSpData']);
        $this->data['ExamID'] = $ExamID;
        $this->load->view('teacher_frame', $this->data);
    }
    public function assessment()
    {
        $this->data['InnerPage'] = "teacher_assessment";
        
        $this->load->model('Core');
        $this->Core->FillSkillsForTeacher($this->data['Teacher'], $this->data['SkillList'], true);
        $this->load->view('teacher_frame', $this->data);
    }
    public function AJAXActiveStudent()
    {
        $AJAXData = array();
        $this->load->model('Core');
        $AJAXData['Data']['Valid'] = $this->Core->ChangeActive(postData('activeID'), postData('activeStatus'));
        $this->load->view('ajax', $AJAXData);
    }
    public function AJAXEditStudents() {
        $AJAXData = array();
        $AJAXData['Data']['Valid'] = true;
        $AJAXData['Data']['Error'] = array();
        if(!$_POST['stdata']){
            $AJAXData['Data']['Valid'] = false;
            $AJAXData['Data']['Error'][] = array("", "Data not provided.");
        }
        else {
            $ActualData = json_decode($_POST['stdata']);
            $rowID = 1;
            if(isset($ActualData) && count($ActualData)){
                foreach($ActualData as $row)
                {
                    $AllBlank = true;
                    foreach($row as $col)
                    {
                        if(strlen(safeData($col)) > 0)
                        {
                            $AllBlank = false;
                            break;
                        }
                    }
                    
                    $ErrorText = "";
                    if(!$AllBlank)
                    {
                        $StudentData['ID'] = safeData($row[0]);
                        $StudentData['FName'] = safeData($row[1]);
                        $StudentData['LName'] = safeData($row[2]);
                        $StudentData['DOB'] = safeData($row[3]);
                        $StudentData['FPName'] = safeData($row[4]);
                        $StudentData['LPName'] = safeData($row[5]);
                        $StudentData['PEmail'] = safeData($row[6]);
                        $StudentData['PContact'] = safeData($row[7]);
                        
                        if( (strlen($StudentData['FName']) == 0) && (strlen($StudentData['LName']) == 0) )
                            $ErrorText .= "<br>Student's both First and Last Name cannot be blank.";

                        if( (strlen($StudentData['DOB']) == 0))
                            $ErrorText .= "<br>Date of Birth cannot be blank.";
                        else if(!ValidateUSADate($StudentData['DOB']))
                            $ErrorText .= "<br>Date of Birth Format is not valid.";

                        if( (strlen($StudentData['FPName']) == 0) && (strlen($StudentData['LPName']) == 0) )
                            $ErrorText .= "<br>Parent's both First and Last Name cannot be blank.";
                        
                        if(strlen($StudentData['PEmail']) == 0)
                            $ErrorText .= "<br>Parent's Email cannot be blank.";
                        else if(!ValidateEmail($StudentData['PEmail']))
                            $ErrorText .= "<br>Email is not valid.";

                        if(strlen($StudentData['PContact']) == 0)
                            $ErrorText .= "<br>Parent's Contact cannot be blank.";
                        
                        if(strlen($ErrorText) > 0)
                        {
                            $AJAXData['Data']['Valid'] = false;
                            $AJAXData['Data']['Error'][] = array($rowID, substr($ErrorText, 4));
                        }
                    }
                    $rowID++;
                }
                if($AJAXData['Data']['Valid']){
                    foreach($ActualData as $row){
                        $AllBlank = true;
                        foreach($row as $col){
                            if(strlen(safeData($col)) > 0){
                                $AllBlank = false;
                                break;
                            }
                        }

                        if(!$AllBlank){
                            $StudentData['ID'] = safeData($row[0]);
                            $StudentData['FName'] = safeData($row[1]);
                            $StudentData['LName'] = safeData($row[2]);
                            $StudentData['DOB'] = dateConvUSASQL(safeData($row[3]));
                            $StudentData['FPName'] = safeData($row[4]);
                            $StudentData['LPName'] = safeData($row[5]);
                            $StudentData['PEmail'] = safeData($row[6]);
                            $StudentData['PContact'] = safeData($row[7]);

                            
                            $this->load->model('Core');
                            $StudentData['PID'] = $this->Core->GetParent($StudentData['PEmail']);
                            if($StudentData['PID'] > 0)
                                $this->Core->UpdateParent($StudentData['PID'], $StudentData['FPName'], $StudentData['LPName'], $StudentData['PContact']);
                            else
                                $StudentData['PID'] = $this->Core->InsertParent($StudentData['FPName'], $StudentData['LPName'], $StudentData['PEmail'], $StudentData['PContact']);
                            
                            if($StudentData['ID'] > 0)
                                $this->Core->UpdateStudent($StudentData['ID'], $StudentData['FName'], $StudentData['LName'], $StudentData['DOB'], $StudentData['PID']);
                            else
                                $this->Core->InsertStudent($StudentData['FName'], $StudentData['LName'], $StudentData['DOB'], 
                                        $this->data['Teacher']['GradeID'], $StudentData['PID'], $this->data['Login']['UserID']);
                        }
                    }
                }
            }else{
                $AJAXData['Data']['Valid'] = false;
                $AJAXData['Data']['Error'][] = array("", "Invalid data provided.");
            }
        }
        $this->load->view('ajax', $AJAXData);
    }

    public function AJAXAddExam() {
        $AJAXData = array();
        $AJAXData['Data']['Valid'] = true;
        $AJAXData['Data']['Error'] = "Error:";

        $ExamID = postData("id");
        $Date   = postData("date");

        if(intval($ExamID) <= 0){
            $AJAXData['Data']['Valid'] = false;
            $AJAXData['Data']['Error'] .= "<br>Invalid exam selected.";}
            
        if((strlen($Date) == 0) || !ValidateUSADate($Date)){
            $AJAXData['Data']['Valid'] = false;
            $AJAXData['Data']['Error'] .= "<br>Invalid date selected.";}

        if($AJAXData['Data']['Valid'])
        {
            $this->load->model('Core');
            $AJAXData['Data']['NewExamID'] = $this->Core->AddExam($this->data['Login']['UserID'], $ExamID, dateConvUSASQL($Date));
            if($AJAXData['Data']['NewExamID'] <= 0){
            $AJAXData['Data']['Valid'] = false;
            $AJAXData['Data']['Error'] .= "<br>Error while adding exam. You might have already added exam for same date.<br>Please contact Admin for any query.";}
        }
        $this->load->view('ajax', $AJAXData);
    }
    public function AJAXSaveMarks() {
        $AJAXData = array();
        $AJAXData['Data']['Valid'] = true;
        $AJAXData['Data']['Error'] = array();
        $ExamID = postData("id");
        if(!$_POST['stdata']){
            $AJAXData['Data']['Valid'] = false;
            $AJAXData['Data']['Error'][] = array("", "", "Data not provided.");}
        else if(intval($ExamID) <= 0){
            $AJAXData['Data']['Valid'] = false;
            $AJAXData['Data']['Error'][] = array("", "", "Invalid exam selected.");}
        else {
            $this->load->model('Core');
            $this->Core->FillScoreSpData($this->data['Teacher']['ExamTypeID'], $ScoreSpData);
            $this->Core->FillExamSpData($ExamID, $ExamSpData);
               
            $ActualData = json_decode($_POST['stdata']);
            $rowID = 1;
            if(isset($ActualData) && count($ActualData)){
                
                $FinalMarks = array();
                $FinalIDs = array();
                
                foreach($ActualData as $row){
                    $ErrorText = "";
                    $SID   = safeData($row[0]);
                    $Marks = safeData($row[2]);

                    if(strlen($Marks) > 0){
                        if(count($ScoreSpData)){
                            foreach($ScoreSpData as $v){
                                if(strtolower($Marks) == $v['Name'])
                                {
                                    $Marks = $v['Score'];
                                    break;
                                }}}

                        if($ExamSpData['Percent']){
                            if(strval(doubleval($Marks)) != $Marks)
                                $ErrorText .= "<br>Invalid Marks in percentage.";
                            else
                                $Marks = intval($Marks * 100);}
                        else{
                            if(strval(doubleval($Marks)) != $Marks)
                                $ErrorText .= "<br>Invalid Marks.";}

                        if(strlen($ErrorText) > 0)
                        {
                            $AJAXData['Data']['Valid'] = false;
                            $AJAXData['Data']['Error'][] = array($rowID, safeData($row[1]), substr($ErrorText, 4));
                        }
                        $FinalMarks[$SID] = $Marks;
                    }
                    $FinalIDs[] = $SID;
                    $rowID++;
                }
                if($AJAXData['Data']['Valid']){
                    $this->Core->DeleteMarks($ExamID, $FinalIDs);
                    foreach($FinalMarks as $k => $v){
                        $this->Core->SaveMarks(intval($ExamID), intval($k), intval($v));
                    }
                    $this->Core->RefreshRank($ExamSpData['ExamMainID'], $FinalIDs, $ExamSpData);
                }
            }else{
                $AJAXData['Data']['Valid'] = false;
                $AJAXData['Data']['Error'][] = array("", "", "Invalid data provided.");
            }
        }
        $this->load->view('ajax', $AJAXData);
    }
    public function AJAXGetExamDetail() {
        $AJAXData = array();
        $AJAXData['Data']['Valid'] = false;
        
        $ExamID = postData("eid");
        $StudentID = postData("sid");
        
        if($ExamID > 0 && $StudentID > 0)
        {
            $this->load->model('Core');
            $this->Core->FillExamDetail($StudentID, $ExamID, $AJAXData['Data']['Detail']);
            $AJAXData['Data']['Valid'] = true;
        }
        $this->load->view('ajax', $AJAXData);
    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */