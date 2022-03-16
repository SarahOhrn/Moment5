<?php

class Course {
    private $db;
    private $id;
    private $name;
    private $code;
    private $progression;
    private $courseplan;

    //Constructor
    public function __construct() {
        //MySQLi connection
        $this->db = new mysqli(DBHOST, DBUSER, DBPASS, DBDATABASE);

    //Check connection
    if ($this->db->connect_error){
        die ('Fel vid anslutning '. $this->db->connect_error);
    }
}

/** Get all courses 
     * @return array
    */
    public function getCourses() : array {
        $sql = "SELECT * FROM courses ORDER BY id;";
        $result = $this->db->query($sql);

        //Return as associative array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

/**
     * Get course by id
     * @param int @id
     * @return array
     */
    public function getCourseById(int $id) : array {
        $id = intval($id);

        $sql = "SELECT * FROM courses WHERE id=$id;";
        $result = $this->db->query($sql);

        //Return as associative array
        return $result->fetch_all(MYSQLI_ASSOC);
    }

 /**
    * Lägg till kurs
    * @param string $name
    * @param string $code
    * @param string $progression
    * @param string $courseplan
    * @return boolean
    */
    public function addCourse(string $name, string $code, string $progression, string $courseplan): bool{
        $this->name=$name;
        $this->code=$code;
        $this->progression=$progression;
        $this->courseplan=$courseplan;

        //Prepare statement 
        $stmt = $this->db->prepare("INSERT INTO courses (name, code, progression, courseplan) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $this->name, $this->code, $this->progression, $this->courseplan);

        //Execute statement
        if($stmt->execute()){
            return true;
        }else{
            return false;
        }

        //Close statement
        $stmt->close();
    }

    /**
     * Update course
     * @param int $id
     * @param string $name
     * @param string $code
     * @param string $progression
     * @param string $courseplan
     * @return boolean
     */
    public function updateCourse(int $id, string $name, string $code, string $progression, string $courseplan) :bool {
        $this->name = $name;
        $this->code = $code;
        $this->progression = $progression;
        $this->courseplan = $courseplan;
        $id = intval($id);

        //Prepare statement
        $stmt = $this->db->prepare("UPDATE courses SET name=?, code=?, progression=?, courseplan=? WHERE id=$id;");
        $stmt->bind_param("ssss", $this->name, $this->code, $this->progression, $this->courseplan);

        //Execute statement
        if ($stmt->execute()) {
        return true;
        } else {
        return false;
    }

    //Close statement
    $stmt->close();
    }

    /**
     * Delete course by id
     * @param int $id
     * @return boolean
     */
    public function deleteCourse(int $id) : bool {
        $id = intval($id);

        $sql = "DELETE FROM courses WHERE id=$id;";
        $result = $this->db->query($sql);

        return $result;
    }

 }

?>