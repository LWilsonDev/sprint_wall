<?php

class Session {

    private $signed_in = false;
    public $user_id;
    public $message;
    public $count;
    public $sprint_id;

    function __construct(){
        session_start();
        $this->visitor_count();
        $this->check_login();
        $this->check_message();
        $this->sprint_id();
    }

    // getter method: taking a private property ($signed_in) and returning its value in a public property, accessible anywhere.
    public function is_signed_in(){
        return $this->signed_in;
    }

    public function login($user){
        if($user){
            $this->user_id = $_SESSION['user_id'] = $user->id;
            $this->signed_in = true;
        }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($this->user_id);
        $this->signed_in = false;
    }

    private function check_login(){
        if(isset($_SESSION['user_id'])) {
            $this->user_id = $_SESSION['user_id'];
            $this->signed_in = true;

        } else {
            unset($this->user_id);
            $this->signed_in = false;
        }
    }

    public function message($msg=""){
        if(!empty($msg)) {
            $_SESSION['message'] = $msg;
        } else {
            return $this->message;
        }
    }

    public function check_message(){
        if(isset($_SESSION['message'])) {
            $this->message = $_SESSION['message'];
        } else {
            $this->message = "";
        }
    }

    public function sprint_id($sprint_id=""){
        if(!empty($sprint_id)) {
            $_SESSION['sprint_id'] = $sprint_id;
        } else {
            return $this->sprint_id;
        }
    }

    public function visitor_count(){
        if(isset($_SESSION['count'])) {
            return $this->count = $_SESSION['count']++;
        } else {
            return $_SESSION['count'] = 1;
        }
    }

}

$session = new Session();
