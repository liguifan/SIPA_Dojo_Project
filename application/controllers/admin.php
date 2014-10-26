<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {
    var $data;
    public function Admin() {
        parent::__construct();
        $this->data['Login']['UserID']   = $this->session->userdata('UserID');
        $this->data['Login']['UserType'] = $this->session->userdata('UserType');
    }
    public function _checkLogin()
    {
        if($this->data['Login']['UserID'] <= 0 || $this->data['Login']['UserType'] != 3){
            redirect(my_base_URL()."admin/login");
            return false;
        }
        $this->load->model('Core');
        $this->Core->FillLogin($this->data['Login']);
        return true;
    }
    public function login() {
        $this->data['InnerPage'] = "admin_login";
        $this->load->view('admin_frame', $this->data);
    }
    public function home() {
        $this->index();
    }
    public function index() {
        if(!$this->_checkLogin()) return;
        $this->data['InnerPage'] = "admin_home";
        
        $this->load->model('Core');
        $this->Core->FillGrades($this->data['GradeList']);
        $this->Core->FillExamTypes($this->data['ExamTypeList']);
        $this->Core->FillAllExams($this->data['ExamsList']);
        $this->Core->FillGoals($this->data['GoalList']);
        
        $this->load->view('admin_frame', $this->data);
    }
    public function logout() {
        if(!$this->_checkLogin()) return;
        $this->session->unset_userdata('UserID');
        $this->session->unset_userdata('UserType');
        $this->session->sess_destroy();
        redirect(my_base_URL()."admin/login");
    }
    public function chgpwd(){
        if(!$this->_checkLogin()) return;
        $this->data['InnerPage'] = "teacher_pwd";
        $this->data['RetMsg'] = -1;        
        if(isset($_POST['pwddata'])){ // data is submitted
            $this->data['RetMsg'] = 1;
            $CurPwd = postData('curpwd', FALSE);
            $NewPwd = postData('newpwd', FALSE);
            $NewPwdCnf = postData('newpwdcnf', FALSE);
            
            if(strlen($NewPwd) < 6){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] = "New Password should contain atleast 6 characters.";
            }
            else if($NewPwd != $NewPwdCnf){
                $this->data['RetMsg'] = 0;
                $this->data['Msg'] = "New Password and Confirm Password are not same.";
            }
            if($this->data['RetMsg'] > 0){
                $this->load->model('Core');
                if(!$this->Core->ChangePassword($this->data['Login']['UserType'], $this->data['Login']['UserID'], $CurPwd, $NewPwd)){
                    $this->data['RetMsg'] = 0;
                    $this->data['Msg'] = "Current Password is not correct.";
                }else{
                    $this->data['Msg'] = "Password updated successfully.";
                }
            }
        }
        $this->load->view('admin_frame', $this->data);
    }
    public function AJAXLogin() {
        $this->load->model('Core');
        $AJAXLoginData = array();
        $AJAXLoginData['Data']['UserID'] =  $this->Core->Login(3, postData("username"), postData("password"));
        if($AJAXLoginData['Data']['UserID'] > 0) {
            $ses['UserID'] = $AJAXLoginData['Data']['UserID'];
            $ses['UserType'] = 3;
            $this->session->set_userdata($ses);
            $AJAXLoginData['Data']['Redirect'] = my_base_URL()."admin";
        }
        $this->load->view('ajax', $AJAXLoginData);
    }
    public function AJAXCreateExamType(){
        if(!$this->_checkLogin()) return;
        $this->load->model('Core');
        $AJAXLoginData['Data']['Valid'] = $this->Core->AddExamType(postData("examtype"));
        $this->load->view('ajax', $AJAXLoginData);
    }
    public function AJAXCreateGoal(){
        if(!$this->_checkLogin()) return;
        $this->load->model('Core');
        $AJAXLoginData['Data']['Valid'] = $this->Core->AddGoal(postData("goal"));
        $this->load->view('ajax', $AJAXLoginData);
    }
    public function AJAXCreateExam(){
        if(!$this->_checkLogin()) return;
        $this->load->model('Core');
        $this->Core->FillScoreSpData(postData("etype"), $ScoreSpData);
        $Percent = (postData("percent") == 1)?1:0;
        $Marks = postData("benchmark");
        $AJAXLoginData['Data']['Valid'] = true;
        $AJAXLoginData['Data']['Error'] = "";
        if(strlen($Marks) > 0){
            if(count($ScoreSpData)){
                foreach($ScoreSpData as $v){
                    if(strtolower($Marks) == $v['Name'])
                    {
                        $Marks = $v['Score'];
                        break;
            }}}
            if($Percent > 0){
                if(strval(doubleval($Marks)) != $Marks)
                {
                    $AJAXLoginData['Data']['Error'] = "Invalid Marks in percentage.";
                }
                else
                    $Marks = intval($Marks * 100);}
            else{
                if(strval(doubleval($Marks)) != $Marks)
                    $AJAXLoginData['Data']['Error'] = "Invalid Marks.";
            }
            
        }
        else
            $AJAXLoginData['Data']['Error'] = "Invalid marks in benchmark.";

        $AJAXLoginData['Data']['Valid'] = (strlen($AJAXLoginData['Data']['Error']) == 0);
        if($AJAXLoginData['Data']['Valid'])
        {
             if(!$this->Core->AddExamAdmin(postData("etype"), postData("grade"), postData("goal"), postData("label"), postData("name"), $Marks, $Percent))
            {
                $AJAXLoginData['Data']['Valid'] = false;
                $AJAXLoginData['Data']['Error'] = "Error while updating data.";
            }
        }
        $this->load->view('ajax', $AJAXLoginData);
    }
    public function AJAXEditExam(){
        if(!$this->_checkLogin()) return;
        $this->load->model('Core');
        $this->Core->FillScoreSpData(postData("examID"), $ScoreSpData);
        $Percent = $this->Core->PercentInExam(postData("examID"));;
        $Marks = postData("benchmark");
        $AJAXLoginData['Data']['Valid'] = true;
        $AJAXLoginData['Data']['Error'] = "";
        
        if(strlen($Marks) > 0){
            if(count($ScoreSpData)){
                foreach($ScoreSpData as $v){
                    if(strtolower($Marks) == $v['Name'])
                    {
                        $Marks = $v['Score'];
                        break;
            }}}
            if($Percent > 0){
                if(strval(doubleval($Marks)) != $Marks)
                {
                    $AJAXLoginData['Data']['Error'] = "Invalid Marks in percentage.";
                }
                else
                    $Marks = intval($Marks * 100);}
            else{
                if(strval(doubleval($Marks)) != $Marks)
                    $AJAXLoginData['Data']['Error'] = "Invalid Marks.";
            }
            
        }
        else
            $AJAXLoginData['Data']['Error'] = "Invalid marks in benchmark.";

        $AJAXLoginData['Data']['Valid'] = (strlen($AJAXLoginData['Data']['Error']) == 0);
        if($AJAXLoginData['Data']['Valid'])
        {
            if(!$this->Core->EditExamAdmin(postData("examID"), postData("name"), $Marks))
            {
                $AJAXLoginData['Data']['Valid'] = false;
                $AJAXLoginData['Data']['Error'] = "Error while updating data.";
            }
        }
        $this->load->view('ajax', $AJAXLoginData);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */