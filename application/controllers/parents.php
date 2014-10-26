<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Parents extends CI_Controller {
    var $data;
    public function Parents() {
        parent::__construct();
        $this->data['Login']['UserID']   = $this->session->userdata('UserID');
        $this->data['Login']['UserType'] = $this->session->userdata('UserType');
        if($this->data['Login']['UserID'] <= 0 || $this->data['Login']['UserType'] != 2){
            redirect(my_base_URL());
        }
        else{
            $this->load->model('Core');
            $this->Core->FillLogin($this->data['Login']);
            $this->Core->FillParent($this->data['Login']['UserID'], $this->data['Parent']);
        }
    }

    public function index() {
        $this->data['InnerPage'] = "parents_main";
        $this->load->model('Core');
        $this->Core->FillGoals($this->data['GoalList']);
        $this->data['Students'] = array();
        $this->data['SID'] = safeData($_GET['q']);
        foreach($this->data['Parent']['Students'] as $k=>$v)
        {
            $this->data['Students'][$k] = $v['Name'];
            if($this->data['SID'] == 0) $this->data['SID'] = $k;
        }
        
        if($this->data['SID'] > 0)
            $this->Core->FillStudentsForParent($this->data['SID'], $this->data['StudentInfo']);

        $this->load->view('parents_frame', $this->data);
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
        $this->load->view('parents_frame', $this->data);
    }
    public function addobs(){
        if(!$this->data['Parent']['DirParent'])
            redirect(my_base_URL().'parents');;
        
        $this->data['InnerPage'] = "parents_addobs";
        $this->data['RetMsg'] = -1;

        $this->data['CurObs'] = array();
        $Cur = &$this->data['CurObs'];
        $Cur['SID']      = 0;
        $Cur['FName']    = "";
        $Cur['LName']    = "";
        $Cur['Email']    = "";
        $Cur['ContactNo']  = "";
        $Cur['StData'] = array(0 => 'All');
        foreach($this->data['Parent']['Students'] as $k => $v)
            if($v['Dir'])
                $Cur['StData'][$k] = $v['Name'];
        
        if(isset($_POST['obsdata'])){ // data is submitted
            $this->data['RetMsg'] = 1;
            $this->data['Msg'] = '';
        
            $Cur['SID']      = postData("sid");
            $Cur['FName']    = postData("fname");
            $Cur['LName']    = postData("lname");
            $Cur['Email']    = postData("email");
            $Cur['ContactNo']  = postData("contact");
            $PID = $this->Core->GetParent($Cur['Email']);

            if(($PID == 0) && ($Cur['FName'] == "") && ($Cur['LName'] == "")){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] .= "<br>First and Last Name both cannot be empty.";}

            if(($Cur['Email'] == "")){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] .= "<br>Email cannot be empty.";}
            else if(!ValidateEmail($Cur['Email'])){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] .= "<br>Email is not valid.";}

            if(($PID == 0) && ($Cur['ContactNo'] == "")){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] .= "<br>Contact No cannot be empty.";}
                

            if($this->data['RetMsg'])
            {
                $this->load->model('Core');
                $PID = $this->Core->GetParent($Cur['Email']);
                if($PID == 0)
                    $PID = $this->Core->InsertParent($Cur['FName'], $Cur['LName'], $Cur['Email'], $Cur['ContactNo']);
                else
                    $this->data['Msg'] .= "<br>Observer is already connected with TOGETHER.";
                if($Cur['SID'] == 0){
                    foreach($this->data['Parent']['Students'] as $k => $v)
                        if($v['Dir'])
                            $this->Core->AddObserver($PID, $k);
                }
                else
                {
                    if(isset($this->data['Parent']['Students'][$Cur['SID']]) && 
                            $this->data['Parent']['Students'][$Cur['SID']]['Dir'])
                        $this->Core->AddObserver($PID, $Cur['SID']);
                }
                $this->data['Msg'] .= "<br>Observer is allowed for selected students.";
                $this->data['Msg'] .= "<br>Please check under Observers.";
            }
        }
        $this->load->view('parents_frame', $this->data);
    }
    public function profile() {
        $this->data['InnerPage'] = "parents_profile";
        $this->data['RetMsg'] = -1;
        $this->data['CurProfile'] = $this->data['Parent'];
        $Cur = &$this->data['CurProfile'];
        
        if(isset($_POST['profiledata'])){ // data is submitted
            $this->data['RetMsg'] = 1;
            
            $Cur['FName']    = postData("fname");
            $Cur['LName']    = postData("lname");
            $Cur['ContactNo']  = postData("contact");

            if(($Cur['FName'] == "") && ($Cur['LName'] == "")){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] = "<br>First and Last Name both cannot be empty.";}

            if($Cur['ContactNo'] == ""){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] = "<br>Contact No cannot be empty.";}

            if($this->data['RetMsg'])
            {
                $this->load->model('Core');
                $this->Core->UpdateParent($this->data['Login']['UserID'], $Cur['FName'], $Cur['LName'], $Cur['ContactNo']);
                $this->data['Msg'] = "Profile updated successfully.";
                $this->Core->FillLogin($this->data['Login']);
                $this->Core->FillParent($this->data['Login']['UserID'], $this->data['Parent']);
            }
        }
        $this->load->view('parents_frame', $this->data);
    }
    public function obs() {
        $this->data['InnerPage'] = "parents_obs";
        
        $this->Core->FillObservers($this->data['Login']['UserID'], $this->data['Obs']);
        
        $this->load->view('parents_frame', $this->data);
    }
    public function AJAXSetObserver()
    {
        $AJAXData = array();
        $this->load->model('Core');
        
        $this->Core->FillObservers($this->data['Login']['UserID'], $this->data['Obs']);
        
        $PID = postData('PID');
        $SID = postData('SID');
        
        $Valid = false;
        if(isset($this->data['Parent']['Students'][$SID]))
        {
            if($PID != $this->data['Login']['UserID']) $Valid = true;
        }
        
        if($Valid){
            $AJAXData['Data']['Valid'] = 1;
            if(postData('activeStatus') != 1)
                 $this->Core->RemoveObserver($PID, $SID);
            else
                $this->Core->AddObserver($PID, $SID);
        }
        else
        {
            $AJAXData['Data']['Valid'] = 0;
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