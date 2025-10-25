<?php
class ActiveRecord{

    // Base DE DATOS
    protected static $db;
    protected static $table = '';
    protected static $columns = [];

    // alerts y Mensajes
    protected static $alerts = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlert($tipe, $message) {
        static::$alerts[$tipe][] = $message;
    }
    // Validación
    public static function getAlerts() {
        return static::$alerts;
    }

    public function validate() {
        static::$alerts = [];
        return static::$alerts;
    }

    // Registros - CRUD
    public function save() {
        $result = '';
        if(!is_null($this->id)) {
            // actualizar
            $result = $this->update();
        } else {
            // Creando un nuevo registro
            $result = $this->make();
        }
        return $result;
    }

    public static function all() {
        $query = "SELECT * FROM " . static::$table;
        $result = self::querySQL($query);
        return $result;
    }

    public static function allByUserId($id) {
        $query = "SELECT * FROM " . static::$table . " where user_id = " . $id;
        $result = self::querySQL($query);
        return $result;
    }

    public static function allByUserIdWithPagination($id, $limit, $offset){
        if (!is_numeric($id) || !is_numeric($limit) || !is_numeric($offset)) {
            return false;
        }
        $query = "SELECT * FROM " . static::$table . " where user_id = " . $id . " LIMIT " . $limit . " OFFSET " . $offset;
        $result = self::querySQL($query);
        return !empty($result) ? $result : [];
    }

    public static function getTotalTableRows($id) {
        if (!is_numeric($id) || $id <= 0) { return 0;}
        $id = self::$db->escape_string($id);

        $query = "SELECT COUNT(*) as total FROM " . static::$table . " WHERE user_id = " . $id;

        try {
            $result = self::$db->query($query);
            if (!$result) { return 0; }
            
            $total_rows = $result->fetch_assoc();
            $count = (int) $total_rows['total'];
            $result->free();
            
            return $count;
        } catch (Exception $e) {
            return false;
        }
    }
    

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$table  ." WHERE id = ${id}";
        $resultado = self::querySQL($query);
        return array_shift( $resultado ) ;
    }

    // Obtener Registro
    public static function get($limit) {
        $query = "SELECT * FROM " . static::$table . " LIMIT ${limit}";
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    public static function getByIdAndUser($id, $user_id) {
        $query = "SELECT * FROM " . static::$table . " WHERE id = ${id} AND user_id = " . $user_id;
        $result = self::querySQL($query);
        return array_shift($result);
    }

    // Busqueda Where con Columna 
    public static function where($column, $value) {
        $query = "SELECT * FROM " . static::$table . " WHERE ${column} = '${value}'";
        $result = self::querySQL($query);
        return array_shift( $result ) ;
    }

    // SQL para Consultas Avanzadas.
    public static function SQL($query) {
        $result = self::querySQL($query);
        return $result;
    }

    // crea un nuevo registro
    public function make() {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Insertar en la base de datos
        $query = " INSERT INTO " . static::$table . " ( ";
        $query .= join(', ', array_keys($attributes));
        $query .= " ) VALUES ('"; 
        $query .= join("', '", array_values($attributes));
        $query .= "') ";

        // Resultado de la consulta

        $result = self::$db->query($query);

        return [
           'ok' =>  $result,
           'id' => self::$db->insert_id
        ];
    }

    public function update() {
        // Sanitizar los datos
        $attributes = $this->sanitizeAttributes();

        // Iterar para ir agregando cada campo de la BD
        $values = [];
        foreach($attributes as $key => $value) {
            $values[] = "{$key}='{$value}'";
        }

        $query = "UPDATE " . static::$table ." SET ";
        $query .=  join(', ', $values );
        $query .= " WHERE id = '" . self::$db->escape_string($this->id) . "' ";
        $query .= " LIMIT 1 "; 

        // debuguear($query);

        $result = self::$db->query($query);
        return $result;
    }

    // Eliminar un registro - Toma el ID de Active Record
    public function delete() {
        $query = "DELETE FROM ". static::$table . " WHERE id = '" . self::$db->escape_string($this->id) . "' LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }

    public function deleteByUser(){
        $query = "DELETE FROM ". static::$table . " WHERE id = '" . self::$db->escape_string($this->id) . "' AND user_id = " . $this->user_id . " LIMIT 1";
        $result = self::$db->query($query);
        return $result;
    }

    public static function querySQL($query) {
        // Consultar la base de datos
        $result = self::$db->query($query);

        // Iterar los resultados
        $array = [];
        while($rows = $result->fetch_assoc()) {
            $array[] = static::createObject($rows);
        }

        // liberar la memoria
        $result->free();

        // retornar los resultados
        return $array;
    }

    protected static function createObject($row) {
        $object = new static; // crea una instancia de la clase que hereda este metodo

        foreach($row as $key => $value ) {
            if(property_exists( $object, $key  )) {
                $object->$key = $value;
            }
        }

        return $object;
    }



    // Identificar y unir los attributes de la BD
    public function attributes() {
        $attributes = [];
        foreach(static::$columns as $column) {
            if($column === 'id') continue;
            $attributes[$column] = $this->$column;
        }
        return $attributes;
    }

    public function sanitizeAttributes() {
        $attributes = $this->attributes();
        $sanitized = [];
        foreach($attributes as $key => $value ) {
            $sanitized[$key] = self::$db->escape_string($value);
        }
        return $sanitized;
    }

    public function sync($args=[]) { 
        foreach($args as $key => $value) {
          if(property_exists($this, $key) && !is_null($value)) {
            $this->$key = $value;
          }
        }
    }
}