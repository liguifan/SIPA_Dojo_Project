<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('my_base_URL'))
{
    function my_base_URL(){                 return base_url('index.php').'/';}
    function my_res_URL(){                  return base_url('res').'/';}
    function get_admin_email(){             return 'shahankit.ce@gmail.com';}
    function getProfileURL($UserID = ''){   return my_base_URL().'Profile/'.$UserID;}
    function postData($arg, $trim = true){  return safeData($_POST[$arg], $trim);}
    function safeData(&$arg, $trim = true){
        if(isset($arg)) 
            if($trim)   return trim($arg);
            else        return $arg;
        return "";
    }
    function dateConvUSASQL($USADate)
    {
        if (!preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $USADate, $matches))
            return "";
        return $matches[3]."-".$matches[1]."-".$matches[2];
    }
    function dateConvSQLUSA($SQLDate)
    {
        if(isset($SQLDate))
        {
            $SQLTime = strtotime($SQLDate);
            if($SQLTime != FALSE)
            {
                return date("m/d/Y", $SQLTime);
            }
        }
        return "";
    }
    function ScoreString($Marks, $Percent, $Spceific)
    {
        if(isset($Spceific) && strlen($Spceific) > 0) return $Spceific;
        if($Percent == 1) return strval (doubleval ($Marks) / 100).' %';
        return $Marks;
    }
    function GetName($FName, $LName)
    {
        if(!isset($FName)) $FName = "";
        if(!isset($LName)) $LName = "";
        if((strlen($FName) > 0) && (strlen($LName) > 0))
            return $LName . ", " . $FName;
        else if((strlen($FName) > 0))
            return $FName;
        else if((strlen($LName) > 0))
            return $LName;
        return "";
    }
}

if ( ! function_exists('my_generatePassword'))
{
    function my_generatePassword($length = 8)
    {
        // start with a blank password
        $password = date('YmdHis')."_";

        // define possible characters - any character in this string can be
        // picked for use in the password, so if you want to put vowels back in
        // or add special characters such as exclamation marks, this is where
        // you should do it
        $possible = "12346789bcdfghjkmnpqrtvwxyzBCDFGHJKLMNPQRTVWXYZ";

        // we refer to the length of $possible a few times, so let's grab it now
        $maxlength = strlen($possible);

        // check for length overflow and truncate if necessary
        if ($length > $maxlength) {
            $length = $maxlength;
        }

        // set up a counter for how many characters are in the password so far
        $i = 0;

        // add random characters to $password until $length is reached
        while ($i < $length) {

            // pick a random character from the possible ones
            $char = substr($possible, mt_rand(0, $maxlength-1), 1);
            // have we already used this character in $password?
            if (!strstr($password, $char)) {
            // no, so it's OK to add it onto the end of whatever we've already got...
            $password .= $char;
            // ... and increase the counter by one
            $i++;
            }
        }
        // done!
        return $password;
    }
}

if ( ! function_exists('AddMessage'))
{
    function UnknownErr()
    {
        return 'Unknown error occured. Please try later.';
    }
    function AddMessage($Msg, &$data)
    {
        if(!isset($data))
            $data = '';
        $data .= '<div>'.$Msg.'</div>';
    }
    function ValidateUSADate($value)
    {
        if (!preg_match("/([0-9]{2})\/([0-9]{2})\/([0-9]{4})/", $value, $matches))
            return false;
        //print_r($matches);
        if (!checkdate($matches[1], $matches[2], $matches[3]))
            return false;
        return true;
    }
    function ValidateEmail($value)
    {
        return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $value);
    }
    function ValidateUserName($value)
    {
        return preg_match("/^[A-Za-z0-9_]+$/", $value);
    }
    function ValidateDisplayName($value)
    {
        return preg_match("/^[ A-Za-z0-9_]+$/", $value);
    }

    function ValidateDate($value, &$valid, &$data, $id)
    {
        if(strtotime($value) == false)
        {
            if($valid) $valid = false;
            AddMessage($id.' is not valid.', $data);
            return;
        }
    }

    function ValidateName($value, &$valid, &$data, $id)
    {
        $value = trim($value);
        if($value == '')
        {
            if($valid) $valid = false;
            AddMessage($id.' cannot be empty.', $data);
            return;
        }
    }
    function ValidatePassword($value, $value2, &$valid, &$data)
    {
        if(strlen($value) < 6)
        {
            if($valid) $valid = false;
            AddMessage('Password should contain atleast 6 characters.', $data);
            return;
        }

        if($value != $value2)
        {
            if($valid) $valid = false;
            AddMessage('New Password and Confirm Password did not match.', $data);
            return;
        }
    }
    function ConvertForLocationText($string)
    {
        $string = preg_replace("/[^a-zA-Z 0-9]+/", "", $string);
        return str_replace(' ', '-', $string);
    }
}