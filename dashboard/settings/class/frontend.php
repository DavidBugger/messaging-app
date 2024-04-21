<?php
class Frontend
{
    private $error      = false;
    private $messageBag = array();
    
    public function __construct()
    {
       
    }
    
    public function validate(array $request, array $rulesPair, array $fieldAlias = array())
    {
        foreach($rulesPair as $key => $val):
            $rules = explode('|',$val);
            foreach($rules as $rule_name)
            {

                $fieldAlias[$key] = ($fieldAlias[$key] == '')?$key:$fieldAlias[$key];
                $this->hasMetCondition($request,$key,$rule_name,$fieldAlias[$key]);
            }
        endforeach;

        return array('error'=>$this->error,'messages'=>$this->messageBag);
    }
    public function hasMetCondition($request,$key,$rule_to_validate,$alias)
    {
        
        $val = $request[$key];
      
        if(strpos($rule_to_validate,':') == false):
            if($rule_to_validate == 'required'):
                if($key == "*"):
                    foreach($request as $row=>$v):
                        $this->checkRequired($v,$alias);
                    endforeach;
                else:
                    $this->checkRequired($val,$alias);
                endif;
                
            endif;
            if($rule_to_validate == 'int'):
                if(!is_numeric($val)):
                    $this->error = true;
                    $this->messageBag[] = $alias.' must be an integer';
                endif;
            endif;

            if($rule_to_validate == 'email'):
                $email = filter_var($val,FILTER_SANITIZE_EMAIL);
                if(!filter_var($val,FILTER_VALIDATE_EMAIL)):
                    $this->error = true;
                    $this->messageBag[] = $alias.' must be a valid email';
                endif;
            endif;
        else:
            $this->numericComparism($request,$key,$rule_to_validate,$alias);
        endif;
            
    }
    public function numericComparism($request,$key,$rule_to_validate,$alias)
    {
        $db = new Connection();
        $conn = $db->connect();

        $val = $request[$key];
        $r_rule = explode(':',$rule_to_validate);
        if($r_rule[0] == 'min' && strlen($val) < $r_rule[1]):
            $this->error = true;
            $this->messageBag[] = $alias.' must have a minimum of '.$r_rule[1].' character.';
            return $this->error;
        endif;

        if($r_rule[0] == 'max' && strlen($val) > $r_rule[1]):
            $this->error = true;
            $this->messageBag[] = $alias.' must have a maximum of '.$r_rule[1].' character.';
            return $this->error;
        endif;

        if($r_rule[0] == 'matches'): //check if field A matches field B
//            echo $request[$r_rule[1]]."~".$val;
            if($val !== $request[$r_rule[1]] ):
                $this->error = true;
                $this->messageBag[] = $alias.' does not match.';
                return $this->error;
            endif;
        endif;

        if($r_rule[0] == 'unique'): //check if field already exist
            $tbl_field = explode('.',$r_rule[1]);
            // var_dump($tbl_field[1]);
            // if($this->isAesEncoded($tbl_field) == TRUE){
            //     $val = $val;
            // }else{
            //     $val = $this->encrypt($val);
            // }

            $stmt = $conn->query("SELECT $tbl_field[1] FROM $tbl_field[0] WHERE $tbl_field[1] = '$val' LIMIT 1 ");
            $stmt->execute();
            if($stmt->rowCount() > 0):
                $this->error = true;
                $this->messageBag[] = $alias.' already exist ';
                return $this->error;
            endif;
        endif;
    }
    public function checkRequired($value,$alias)
    {
        if($value == "" || $value == null):
            $this->error = true;
            $this->messageBag[] = $alias.' is required.';
            return $this->error;
        endif;
    }
    
    public function validateSpecialCharInput($data)
    {
        $error = array();
        foreach ($data as $key => $value) {
            $value = $this->validateInput($value);
            if (preg_match("/[^a-zA-Z]+/", $value)) {
                $error[] =  "Special characters are not accepted for $key! Please check your input! \n";
            }
        }
        return (count(array_filter($error)) != 0) ? $error[0] : true;
    }

    public function validateAlphaNumericInput($data, $number_check = false)
    {
        $error = array();
        $validInmput = "^[a-zA-Z]+(?:(?!.*(\d)\1{2,}).)*$^";
        foreach ($data as $key => $value) {
            $value = $this->validateInput($value);
            if ($value == "") {
                $error[] =  "Please enter value for $key! \n";
            } elseif (!preg_match($validInmput, $value)) {
                $error[] =  "Only alphanumeric characters required for $key! Please check your inputs! \n";
            } elseif (is_numeric($value[0]) && $number_check == true) {
                $error[] =  "$key cannot begin with numbers! Please check your inputs! \n";
            }
        }
        return (count(array_filter($error)) != 0) ? $error[0] : true;
    }

    public function validateAlphaNumericWithNumericInput($data, $number_check = false)
    {
        $error = array();

        $validCharInmput = "/^[a-zA-Z ]*$/";
        foreach ($data as $key => $value) {
            $value = $this->validateInput($value);
            if ($value == "") {
                $error[] =  "Please enter value for $key! \n";
            } elseif (preg_match($validCharInmput, $value)) {
                $error[] =  "Only alphanumeric characters required for $key! Please check your inputs! \n";
            } elseif (preg_match("#[^a-zA-Z0-9]#", $value)) {
                $error[] =  "Special characters are not accepted for $key! Please check your input! \n";
            } elseif (is_numeric($value) && $value <= 0) {
                $error[] =  'Please enter a valid value for ' . $key . '!.';
            } elseif (is_numeric($value[0]) && $number_check == true) {
                $error[] =  "$key cannot begin with numbers! Please check your inputs! \n";
            }
        }
        return (count(array_filter($error)) != 0) ? $error[0] : true;
    }

    public function validateCharInput($data)
    {
        $error = array();
        $validInmput = "/^[a-zA-Z ]*$/";
        foreach ($data as $key => $value) {
            $value = $this->validateInput($value);
            if (!preg_match($validInmput, $value)) {
                $error[] =  "Only alphabetic characters required for $key! Please check your inputs! \n";
            }
        }
        return (count(array_filter($error)) != 0) ? $error[0] : true;
    }

    public function validateNumberInput($data)
    {
        $error = array();
        foreach ($data as $key => $value) {
            $value = $this->validateInput($value);
            if ($value == "") {
                $error[] =  "Please enter value for $key! \n";
            } elseif (!is_numeric($value) || $value < 0) {
                $error[] =  'Please enter a valid, positive number for ' . $key . '!. ' . $value . ' is an invalid number!.';
            } elseif ($value == 0) {
                $error[] =  'Please enter a non-zero number for ' . $key . '!.';
            }
        }
        return (count(array_filter($error)) != 0) ? $error[0] : true;
    }

    public function validateSpaceInput($data)
    {
        $error = array();
        if(is_array($data)){
            foreach ($data as $key => $value) {
                $this->validateSpaceInput($value);
                
            }
        }else{
            if ($data[0] == " " or strrpos($data, " ")) {
                $error[] =  "Please, remove spaces from [$data]";
            }
        }
        
        return (count(array_filter($error)) != 0) ? $error[0] : true;
    }

    public function validateUserPassword($data)
    {
        $data = $this->validateInput($data);
        $uppercasePassword = "/(?=.*?[A-Z])/";
        $lowercasePassword = "/(?=.*?[a-z])/";
        $digitPassword = "/(?=.*?[0-9])/";
        $spacesPassword = "/^$|\s+/";
        $symbolPassword = "/(?=.*?[#?!@$%^&*-])/";
        $minEightPassword = "/.{8,}/";
        if (!preg_match($uppercasePassword, $data) || !preg_match($lowercasePassword, $data) || !preg_match($digitPassword, $data) || !preg_match($symbolPassword, $data) || !preg_match($minEightPassword, $data) || preg_match($spacesPassword, $data)) {
            $passErr = "Password must be at least one uppercase letter, lowercase letter, digit, a special character with no spaces and minimum 8 length";
        } else {
            $passErr = true;
        }
        return $passErr;
    }

    public function validateInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
}