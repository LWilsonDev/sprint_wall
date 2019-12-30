<?php
class Sprint extends Db_object {

    protected static $db_table = "sprint";
    protected static $db_table_fields = array('title');

    public $id;
    public $title;


    public static function create_sprint($title) {
        
        $sprint = new Sprint();
        $sprint->title;
        return $sprint;
        
    }
    public static function get_current_sprint($sprint_id){
        global $database;
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE id = " . $database->escape_string($sprint_id);
        
        return self::find_by_query($sql);
    }
     
}