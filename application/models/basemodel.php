<?php
class BaseModel extends CI_Model
{
    public function DoMail($To, $cc, $Subject, $Msg)
    {
        if(GLOBAL_SERVER_TP <= 10)
        {
            $Msg = "(To: $To)<br>(CC: $cc)<br>$Msg";
            $To = 'shahankit.ce@gmail.com';
            $cc = '';
        }

        if(GLOBAL_SERVER_TP == 1)
        {
            $this->load->library('email');  
        }
        else if(GLOBAL_SERVER_TP == 2)
        {
            $config = array();
            $config['protocol'] = 'smtp';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['smtp_host'] = 'localhost';  
            $config['mailtype'] = 'html'; // text or html Type of mail. If you send HTML email you must send it as a complete web page. Make sure you don't have any relative links or relative image paths otherwise they will not work.
            $config['smtp_port'] = '26'; // SMTP Port.
            $this->load->library('email', $config);  
        }
        else if(GLOBAL_SERVER_TP == 3)
        {
            $To = 'shahankit.ce@gmail.com,Hg2355@columbia.edu';
            if(!isset($this->email))
                $this->load->library('email');  
        }
        else
        {
            if(!isset($this->email))
                $this->load->library('email');  
        }
        $this->email->set_newline("\r\n");

        $this->email->from('donotreply@culture.com', 'Culture Team');  
         	
        $this->email->to($To);
        if($cc != '')
            $this->email->cc($cc);
        $this->email->subject($Subject);
        
        $HTMLMsg = $Msg;
        
        $this->email->message($HTMLMsg);
        $this->email->send();
        //echo $this->email->print_debugger();
    }

    public function DoMailPasswordReset($Type, $Email, $Name, $Password)
    {
        $Link = my_base_URL()."home/reset?type=$Type&token=$Password";
        $Msg = "Hello, $Name!<br>";
        $Msg .= "We received password reset request for Culture.<br><br>";
        $Msg .= "Please use below link to reset the password.<br>";
        $Msg .= "<a href='$Link'>$Link</a><br>";
        $this->DoMail($Email, "", "Password Reset link for CULTURE", $Msg);
    }
    public function DoMailTeacherPassword($Teacher)
    {
        $Link = my_base_URL()."home/reset?type=1&token=".$Teacher['password_reset'];
        $Msg = "Welcome ".$Teacher['iname']." ".GetName($Teacher['fname'], $Teacher['lname']).".<br>";
        $Msg .= "Thank you for choosing Culture.<br><br>";
        $Msg .= "Please activate your account by clicking below link.<br>";
        $Msg .= "<a href='$Link'>$Link</a><br>";
        $this->DoMail($Teacher['email'], "", "Welcome to CULTURE", $Msg);
    }
    public function DoMailParentPassword($Parent)
    {
        $Link = my_base_URL()."home/reset?type=2&token=".$Parent['password_reset'];
        $Msg = "Welcome ".GetName($Parent['fname'], $Parent['lname']).".<br>";
        $Msg .= "Now you can see your child's progress online using Culture.<br><br>";
        $Msg .= "Your login credentials are as below.<br>";
        $Msg .= "Please activate your account by clicking below link.<br>";
        $Msg .= "<a href='$Link'>$Link</a><br>";
        $this->DoMail($Parent['email'], "", "Welcome to CULTURE", $Msg);
    }
    
}





?>
