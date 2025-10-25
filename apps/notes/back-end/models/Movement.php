<?php
class Movement extends ActiveRecord {
    protected static $table = "movements";

    protected static $columns = [
        "id",
        "user_id",
        "note_id",
        "quantity",
        "create_date",
        "update_date",
        "row_status",
    ];

    public $id;
    public $user_id;
    public $note_id;
    public $quantity;
    public $create_date;
    public $update_date;
    public $row_status;

    public function __construct($args = []) {
        $this->id = $args["id"] ?? NULL;
        $this->user_id = $args["user_id"] ?? "";
        $this->note_id = $args["note_id"] ?? NULL;
        $this->quantity = $args["quantity"] ?? NULL;
        $this->create_date = $args["create_date"] ?? NULL;
        $this->update_date = $args["update_date"] ?? NULL;
        $this->row_status = $args["row_status"] ?? NULL;
    }
}
