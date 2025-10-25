<?php
class Feeling extends ActiveRecord {
    protected static $table = "feelings";

    protected static $columns = [
        "id",
        "user_id",
        "note_id",
    ];

    public $id;
    public $user_id;
    public $note_id;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? NULL;
        $this->user_id = $args["user_id"] ?? "";
        $this->note_id = $args["note_id"] ?? NULL;
    }
}
