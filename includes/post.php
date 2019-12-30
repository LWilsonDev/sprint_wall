<?php
class Post extends Db_object {

    protected static $db_table = "posts";
    protected static $db_table_fields = array('author_id', 'title', 'extra_text', 'category', 'sprint_id');

    public $id;
    public $user_id;
    public $author_id;
    public $title;
    public $extra_text;
    public $date_entered;
    public $category;
    public $sprint_id;


    // public static function create_post($title, $extra_text, $category, $sprint_id) {
        
    //     echo ('hi...'.$title . $extra_text . $category . $sprint_id);

    //     $post = new Post();
    //     $post->author_id = $_SESSION['user_id'];
    //     $post->title = $title;
    //     $post->extra_text = $extra_text;
    //     $post->date_entered = new DateTime();
    //     $post->category = $category; 
    //     $post->sprint_id = $sprint_id;
    //     return $post;
        
    // }
    public static function find_the_posts($sprint_id){
        global $database;
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE sprint_id = " . $database->escape_string($sprint_id);
    
        return self::find_by_query($sql);
    }
     
}