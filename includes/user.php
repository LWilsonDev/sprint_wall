<?php

class User extends Db_object {

    protected static $db_table = "users";
    protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'user_image');

    public $id;
    public $user_image;
    public $username;
    public $first_name;
    public $last_name;
    public $password;
    public $upload_directory = "images";
    public $image_placeholder = "https://imgplaceholder.com/420x320/ff7f7f/333333/fa-image";


    public function upload_photo() {
        
        return empty($this->user_image) ? $this->image_placeholder : $this->upload_directory.DS.$this->user_image;
    }

    public static function verify_user($username, $password){
        global $database;

        $username = $database->escape_string($username);
        $password = $database->escape_string($password);

        $sql = "SELECT * FROM " . self::$db_table ." WHERE username = '{$username}' AND password = '{$password}' LIMIT 1 ";
        $the_result_array = self::find_by_query($sql);
        return !empty($the_result_array) ? array_shift($the_result_array) : false;
    }

    public function set_file($file){

        if(empty($file) || !$file || !is_array($file)) {
            $this->errors[] = 'No file uploaded';
            return false;

        } elseif($file['error'] !=0) {

            $this->errors[] = $this->upload_errors[$file['error']];
            echo($this->upload_errors[$file['error']]);
            return false;

        } else {

            $this->user_image = basename($file['name']);
            $this->tmp_path = $file['tmp_name'];
            $this->type     = $file['type'];
            $this->size     = $file['size'];
        }
    }

    public function save_user_and_image() {


        if(!empty($this->errors)) {
            return false;
        }

        if(empty($this->user_image)  || empty($this->tmp_path)) {
            $this->errors[] = "the file was not available";
            return false;
        }

        $target_path = SITE_ROOT . DS . $this->upload_directory . DS . $this->user_image;
    

        if(file_exists($target_path)) {
            $this->errors[] = "{$this->user_image} already exists";
            return false;
        }

        if(move_uploaded_file($this->tmp_path, $target_path)) {

            if($this->create()) {
                unset($this->tmp_path);
                return true;
            }

        } else {

            $this->errors[] = 'file directory does not have permission';
            return false;

        }

    }

    public function ajax_save_user_image($user_image, $user_id){
echo('hi from ajax_function');
        global $database;

        $user_image = $database->escape_string($user_image);
        $user_id = $database->escape_string($user_id);

        $this->user_image = $user_image;
        $this->id = $user_id;

        $sql = "UPDATE " . self::$db_table . " SET user_image = '{$this->user_image}'";
        $sql .= " WHERE id = {$this->id} ";
        $update_image = $database->query($sql);
        echo('hello');

        echo $this->upload_photo();
    }



} // end of User class
