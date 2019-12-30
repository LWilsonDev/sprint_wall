<?php
class Comment extends Db_object {
    protected static $db_table = "comments";
    protected static $db_table_fields = array('post_id', 'author_id', 'body');
    public $id;
    public $post_id;
    public $author_id;
    public $body;
    public $date_entered;
    public static function create_comment($post_id, $author_id, $body="") {
        if(!empty($post_id) && !empty($author_id) && !empty($body)){
            $comment = new Comment();
            $comment->post_id = (int)$post_id;
            $comment->author_id = (int)$author_id;
            $comment->body = $body;
            return $comment;
        } else {
            return false;
        }
    }
    public static function find_the_comments($post_id=0){
        global $database;
        $sql = "SELECT * FROM " . self::$db_table;
        $sql .= " WHERE photo_id = " . $database->escape_string($post_id);
        $sql .= " ORDER BY post_id ASC";
        return self::find_by_query($sql);
    }
} // end of Comment class
