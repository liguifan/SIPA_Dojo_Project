<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

session_start();

class Home extends CI_Controller {

    public function index() {
        $Data = array();
        $this->load->model('Core');
        $this->Core->FillStates($Data['StateList']);
        $this->Core->FillGrades($Data['GradeList']);
        $this->Core->FillExamTypes($Data['ExamTypeList']);
        $this->load->view('home', $Data);
    }
    public function reset(){
        
        $this->load->view('home_reset');
    }
    public function AJAXChangePassword() {
        $AJAXData = array();
        $AJAXData['Data']['Valid'] = true;
        $AJAXData['Data']['Error'] = "";
        
        $Password    = postData("password");
        $Type        = postData("type");
        $Token       = postData("token");
        
        if($Type != 1 && $Type != 2){
            $AJAXData['Data']['Error'] .= "<br>Invalid Type entered.";
            $AJAXData['Data']['Valid'] = false;}
            
        if(strlen($Password) < 6){
            $AJAXData['Data']['Error'] .= "<br>Password should contain atleast 6 characters.";
            $AJAXData['Data']['Valid'] = false;}
            
        if($AJAXData['Data']['Valid'])
        {
            $this->load->model('Core');
            if(!$this->Core->ActivateAccount($Type, $Token, $Password)){
                $AJAXData['Data']['Error'] .= "Invalid token used. Please contact administrator.";
                $AJAXData['Data']['Valid'] = false;}
        }
        else
        {
            $AJAXData['Data']['Error'] = substr($AJAXData['Data']['Error'], 4);
        }
        $this->load->view('ajax', $AJAXData);            
    }
    public function AJAXCreateTeacher() {
        $AJAXData = array();
        $AJAXData['Data']['Valid'] = true;
        $AJAXData['Data']['Error'] = "";
        
        $this->load->model('Core');
        
        $frmIName    = postData("title");
        $frmFName    = postData("fname");
        $frmLName    = postData("lname");
        $frmUserName = postData("username");
        $frmSchool  = postData("school");
        $frmZip     = postData("zip");
        $frmType    = postData("type");
        $frmGrade   = postData("grade");
        $frmContact   = postData("contact");
        
        if($frmFName == ""){
            $AJAXData['Data']['Error'] .= "<br>First Name cannot be empty.";
            $AJAXData['Data']['Valid'] = false;}
            
        if($frmLName == ""){
            $AJAXData['Data']['Error'] .= "<br>Last Name cannot be empty.";
            $AJAXData['Data']['Valid'] = false;}
        
        if($frmUserName == ""){
            $AJAXData['Data']['Error'] .= "<br>Email cannot be empty.";
            $AJAXData['Data']['Valid'] = false;}
        else if(!ValidateEmail($frmUserName)){
            $AJAXData['Data']['Error'] .= "<br>Email is not valid.";
            $AJAXData['Data']['Valid'] = false;}
        
        if($frmSchool == ""){
            $AJAXData['Data']['Error'] .= "<br>School cannot be empty.";
            $AJAXData['Data']['Valid'] = false;}
        
        if($this->Core->GetZipData($frmZip) == ""){
            $AJAXData['Data']['Error'] .= "<br>Zip is invalid.";
            $AJAXData['Data']['Valid'] = false;}
        
        if($frmGrade < 1 || $frmGrade > 4){
            $AJAXData['Data']['Error'] .= "<br>Grade is invalid.";
            $AJAXData['Data']['Valid'] = false;}

        if($frmType < 1 || $frmType > 6){
            $AJAXData['Data']['Error'] .= "<br>Exam Type is invalid.";
            $AJAXData['Data']['Valid'] = false;}

        if($AJAXData['Data']['Valid'])
        {
            switch($frmIName)
            {
                case 1: $frmIName = 'Mr.'; break;
                case 2: $frmIName = 'Ms.'; break;
                case 3: $frmIName = 'Mrs.'; break;
            }
            
            
            $AJAXData['Data']['NewUserID'] = $this->Core->CreateTeacher($frmIName, $frmFName, $frmLName, $frmUserName, $frmSchool, $frmZip, $frmGrade, $frmType, $frmContact);
            if($AJAXData['Data']['NewUserID'] <= 0){
                $AJAXData['Data']['Error'] .= "Email already registered with us.<br>Please enter another email.";
                $AJAXData['Data']['Valid'] = false;}
        }
        else
        {
            $AJAXData['Data']['Error'] = substr($AJAXData['Data']['Error'], 4);
        }
        $this->load->view('ajax', $AJAXData);
    }
    
    public function AJAXLogin() {
        $this->load->model('Core');
        $AJAXLoginData = array();
        $AJAXLoginData['Data']['UserID'] = $this->Core->Login(postData("type"), postData("username"), postData("password"));
        if($AJAXLoginData['Data']['UserID'] > 0) {
            $ses['UserID'] = $AJAXLoginData['Data']['UserID'];
            $ses['UserType'] = postData("type");
            $this->session->set_userdata($ses);
            if(postData("type") == 1)   $AJAXLoginData['Data']['Redirect'] = my_base_URL()."teacher";
            else                        $AJAXLoginData['Data']['Redirect'] = my_base_URL()."parents";
        }
        $this->load->view('ajax', $AJAXLoginData);
    }
    public function AJAXReset() {
        $AJAXData = array();
        $AJAXData['Data']['Valid'] = true;
        $AJAXData['Data']['Error'] = "";
        
        $Type = postData("type");
        $Email = postData("email");

        if($Type != 1 && $Type != 2){
            $AJAXData['Data']['Error'] .= "Please select Teacher or Parent.";
            $AJAXData['Data']['Valid'] = false;}
        else{

            $this->load->model('Core');
            if(!$this->Core->ResetPassword($Type, $Email)) {
                $AJAXData['Data']['Error'] = "Email is not registered with us.";
                $AJAXData['Data']['Valid'] = false;}
        }
        $this->load->view('ajax', $AJAXData);
    }
    public function AJAXGetZipData() {
        $AJAXData = array();
        $AJAXData['Data']['Valid'] = true;
        $this->load->model('Core');
        $AJAXData['Data']['City'] = $this->Core->GetZipData(postData("zip"));
        $this->load->view('ajax', $AJAXData);
    }
    
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */