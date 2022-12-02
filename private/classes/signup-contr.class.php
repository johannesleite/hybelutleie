<?php
//database related stuff here, e.g. change something in the database
class SignupContr extends Signup {

    private $user_name; 
    private $user_phone;
    private $user_email;
    private $user_password;
    private $user_check_password;

    public function __construct($user_name, $user_phone, $user_email, $user_password, $user_check_password) {
        $this->user_name = $user_name;
        $this->user_phone = $user_phone;
        $this->user_email = $user_email;
        $this->user_password = $user_password;
        $this->user_check_password = $user_check_password;
    }

    public function signup_user(){
        if ($this->empty_input() == false) {
            // echo "Empty input!";
            header("Location: ../../public/pages/signup.php?error=empty_input"); exit();
        }

        if ($this->invalid_input() == false) {
            // echo "Navn kan kun inneholde norske bokstaver og mellomrom";
            header("Location: ../../public/pages/signup.php?error=username"); exit();
        }

        if ($this->invalid_phone() == false) {
            // echo "Telefonnummer kan bare inneholde tall";
            header("Location: ../../public/pages/signup.php?error=invalid_phone"); exit();
        }

        if ($this->invalid_email() == false) {
            // echo "Epostadressen har ugyldig format";
            header("Location: ../../public/pages/signup.php?error=invalid_email"); exit();
        }

        if ($this->password_match() == false) {
            // echo "Passord og gjentatt passord er ikke like";
            header("Location: ../../public/pages/signup.php?error=password_match"); exit();
        }

        if ($this->password_requirements() == false) {
            // echo "Passordet må være minst 8 tegn og ha minst én stor bokstav, én liten bokstav og ett tall";
            header("Location: ../../public/pages/signup.php?error=password_requirements"); exit();
        }

        if ($this->email_taken_check() == false) {
            // echo "En bruker med denne eposten eksisterer allerede";
            header("Location: ../../public/pages/signup.php?error=username_taken_check"); exit();
        }

        $this->set_user($this->user_name, $this->user_phone, $this->user_email, $this->user_password);
    }

    private function empty_input(){
        if (empty($this->user_name) || empty($this->user_phone) || empty($this->user_email) || empty($this->user_password) || empty($this->user_check_password))
            $result = false;
        else 
            $result = true;
        return $result;
    }

    private function invalid_input(){
        if (!preg_match("/^[a-zA-ZæÆøØåÅéÉ' -]*$/", $this->user_name))
            $result = false;
        else 
            $result = true;
        return $result;
    }

    private function invalid_phone(){
        if (!is_numeric($this->user_phone))
            $result = false;
        else 
            $result = true;
        return $result;
    }
    
    private function invalid_email(){
        if (!filter_var($this->user_email, FILTER_VALIDATE_EMAIL))
            $result = false;
        else 
            $result = true;
        return $result;
    }

    private function password_match(){
        if ($this->user_password !== $this->user_check_password)
            $result = false;
        else 
            $result = true;
        return $result;
    }

    private function password_requirements(){
        if (!preg_match("/^(?=.*[A-ZÆØÅÉ])(?=.*[a-zæøåé])(?=.*\d).{8,}$/", $this->user_password))
            $result = false;
        else 
            $result = true;
        return $result;
    }

    private function email_taken_check(){
        if (!$this->check_user($this->user_email))
            $result = false;
        else 
            $result = true;
        return $result;
    }
}
?>