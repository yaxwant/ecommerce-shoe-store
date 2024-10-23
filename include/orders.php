<?php
require_once(LIB_PATH.DS.'database.php');

class Order {
    protected static $tblname = "tblorder";

    function dbfields() {
        global $mydb;
        return $mydb->getFieldsOnOneTable(self::$tblname);
    }

    function listoforders() {
        global $mydb;
        $mydb->setQuery("SELECT * FROM " . self::$tblname);
        return $mydb->loadResultList(); // Fixed: Should return the result
    }

    function single_orders($id="") {
        global $mydb;
        $mydb->setQuery("SELECT * FROM " . self::$tblname . " WHERE ORDERID = '{$id}' LIMIT 1");
        return $mydb->loadSingleResult();
    }

    // Instantiation of Object dynamically
    static function instantiate($record) {
        $object = new self;

        foreach($record as $attribute=>$value) {
            if($object->has_attribute($attribute)) {
                $object->$attribute = $value;
            }
        }
        return $object;
    }

    // Cleaning the raw data before submitting to Database
    private function has_attribute($attribute) {
        return array_key_exists($attribute, $this->attributes());
    }

    protected function attributes() {
        global $mydb;
        $attributes = array();
        foreach($this->dbfields() as $field) {
            if(property_exists($this, $field)) {
                $attributes[$field] = $this->$field;
            }
        }
        return $attributes;
    }

    protected function sanitized_attributes() {
        global $mydb;
        $clean_attributes = array();
        foreach($this->attributes() as $key => $value) {
            $clean_attributes[$key] = $mydb->escape_value($value);
        }
        return $clean_attributes;
    }

    // Create, Update, and Delete methods
    public function save() {
        return isset($this->id) ? $this->update() : $this->create();
    }

    public function create() {
        global $mydb;
        $attributes = $this->sanitized_attributes();
        $sql = "INSERT INTO " . self::$tblname . " (";
        $sql .= join(", ", array_keys($attributes));
        $sql .= ") VALUES ('";
        $sql .= join("', '", array_values($attributes));
        $sql .= "')";

        // Log the query for debugging
        error_log("SQL Query: " . $sql);

        $mydb->setQuery($sql);
        if($mydb->executeQuery()) {
            $this->id = $mydb->insert_id();
            return true;
        } else {
            error_log("Error creating order: " . $mydb->error_msg); // Log the error message
            return false;
        }
    }

    public function pupdate($id=0) {
        global $mydb;
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE " . self::$tblname . " SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE ORDERNUMBER = " . intval($id); // Ensure the ID is properly escaped and is an integer

        // Log the query for debugging
        error_log("SQL Query: " . $sql);

        $mydb->setQuery($sql);
        if(!$mydb->executeQuery()) {
            error_log("Error updating order: " . $mydb->error_msg); // Log the error message
            return false;
        }
        return true;
    }

    public function update($id=0) {
        global $mydb;
        $attributes = $this->sanitized_attributes();
        $attribute_pairs = array();
        foreach($attributes as $key => $value) {
            $attribute_pairs[] = "{$key}='{$value}'";
        }
        $sql = "UPDATE " . self::$tblname . " SET ";
        $sql .= join(", ", $attribute_pairs);
        $sql .= " WHERE ORDERID = " . intval($id); // Ensure the ID is properly escaped and is an integer

        // Log the query for debugging
        error_log("SQL Query: " . $sql);

        $mydb->setQuery($sql);
        if(!$mydb->executeQuery()) {
            error_log("Error updating order: " . $mydb->error_msg); // Log the error message
            return false;
        }
        return true;
    }

    public function pdelete($id=0) {
        global $mydb;
        $sql = "DELETE FROM " . self::$tblname;
        $sql .= " WHERE ORDERNUMBER = " . intval($id); // Ensure the ID is properly escaped and is an integer
        $sql .= " LIMIT 1";

        // Log the query for debugging
        error_log("SQL Query: " . $sql);

        $mydb->setQuery($sql);
        if(!$mydb->executeQuery()) {
            error_log("Error deleting order: " . $mydb->error_msg); // Log the error message
            return false;
        }
        return true;
    }

    public function delete($id=0) {
        global $mydb;
        $sql = "DELETE FROM " . self::$tblname;
        $sql .= " WHERE ORDERID = " . intval($id); // Ensure the ID is properly escaped and is an integer
        $sql .= " LIMIT 1";

        // Log the query for debugging
        error_log("SQL Query: " . $sql);

        $mydb->setQuery($sql);
        if(!$mydb->executeQuery()) {
            error_log("Error deleting order: " . $mydb->error_msg); // Log the error message
            return false;
        }
        return true;
    }
}
?>
