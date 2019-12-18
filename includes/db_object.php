<?php

class Db_object {

    public $errors = array();
    public $upload_errors = array(
        UPLOAD_ERR_OK           => 'Success',
        UPLOAD_ERR_INI_SIZE     => 'File too big',
        UPLOAD_ERR_FORM_SIZE    => 'File too big',
        UPLOAD_ERR_PARTIAL      => 'File only partially uploaded',
        UPLOAD_ERR_NO_FILE      => 'No file',
        UPLOAD_ERR_NO_TMP_DIR   => 'missing temp folder',
        UPLOAD_ERR_CANT_WRITE   => 'Failed to write file to disk',
        UPLOAD_ERR_EXTENSION    => 'A PHP extension stopped file upload.'

    );



    public static function find_all(){
        return static::find_by_query("SELECT * FROM " . static::$db_table ." ");

    }

    public static function find_by_id($id){

        $result = static::find_by_query("SELECT * FROM " . static::$db_table ." WHERE id=$id LIMIT 1");
        // check result is not empty, and return first result.
        // Array shift takes first result off array and returns it
        return !empty($result) ? array_shift($result) : false;
    }


    public static function find_by_query($sql){
        global $database;
        $result_set = $database->query($sql);
        $object_array = array();

        while($row = mysqli_fetch_array($result_set)){
            $object_array[] = static::instantiate($row);
        }
        return $object_array;
    }



    public static function instantiate($the_record) {

        $calling_class = get_called_class();
        $object = new $calling_class;

        foreach($the_record as $attribute => $value) {
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;

    }

    private function has_attribute($attribute){
        $object_properties = get_object_vars($this);

        return array_key_exists($attribute, $object_properties);
    }

    protected function properties(){
        $properties = array();

        foreach (static::$db_table_fields as $db_field){
            if(property_exists($this, $db_field)) {
                $properties[$db_field] = $this->$db_field;
            }
        }
        return $properties;
    }



    protected function clean_properties(){
        global $database;
        $clean_properties = array();

        foreach ($this->properties() as $key => $value){
            $clean_properties[$key] = $database->escape_string($value);
        }
        return $clean_properties;
    }


    public function save(){
        return isset($this->id) ? $this->update() : $this->create();
    }


    public function create(){
        global $database;
        $properties = $this->clean_properties();

        $sql = "INSERT INTO " . static::$db_table ." (". implode(", ", array_keys($properties))  .") ";
        $sql .= "VALUES ('". implode("', '", array_values($properties)) ."')";


        if($database->query($sql)){
            $this->id = $database->insert_id();

            return true;
        } else {
            return false;
        }

    }

    public function update(){
        global $database;

        $properties = $this->properties();

        $properties_pairs = array();

        foreach ($properties as $key => $value){
            $properties_pairs[] = "{$key}='{$value}'";
        }

        $sql = "UPDATE " . static::$db_table ." SET ";
        $sql .= implode(", ", $properties_pairs);
        $sql .= " WHERE id= " . $database->escape_string($this->id);

        $database->query($sql);

        return (mysqli_affected_rows($database->connection) == 1) ? true : false;

    }


    public function delete(){
        global $database;

        $sql = "DELETE FROM ". static::$db_table ." WHERE id= " . $database->escape_string($this->id);
        $sql .= " LIMIT 1";

        $database->query($sql);
    }

    public static function count_all() {
        global $database;

        $sql = "SELECT COUNT(*) FROM " . static::$db_table;
        $result_set = $database->query($sql);
        $row = mysqli_fetch_array($result_set);

        return array_shift($row);
    }
}
