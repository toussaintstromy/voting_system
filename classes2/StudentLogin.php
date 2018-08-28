<?php

/**
 * Created by PhpStorm.
 * User: faintedbrain63
 * Date: 11/07/2017
 * Time: 8:11 AM
 */
 
class StudentLogin
{
    private $_stud_id;

    public function __construct($c_stud_id) {
        $this->_stud_id = $c_stud_id;
    }

    public function StudLogin() {
        global $DatabaseConfig;

        //Start session
        session_start();

        //Array to store error message
        $error_msg_array = array();

        //Error messages
        $error_msg = FALSE;

        if($this->_stud_id == "") {
            $error_msg_array[] = "Please input your ID number.";
            $error_msg = TRUE;
        }

        if($error_msg) {
            $_SESSION['ERROR_MSG_ARRAY'] = $error_msg_array;
          
            exit();
        }

        $sql = "SELECT * FROM voters WHERE stud_id = ? LIMIT 1";
        if(!$stmt =$DatabaseConfig;->prepare($sql)) {
            echo $stmt->error;
        } else {
            $stmt->bind_param("s", $this->_stud_id);
            $stmt->execute();
            $result = $stmt->get_result();
        }

        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            //Create session
            session_regenerate_id();
            $_SESSION['ID']      = $row['id'];
            $_SESSION['NAME']    = $row['name'];
            $_SESSION['COURSE']  = $row['course'];
            $_SESSION['YEAR']    = $row['year'];
            $_SESSION['STUD_ID'] = $row['stud_id'];
			$_SESSION['PASSWORD'] = $row['password'];
			
            session_write_close();

            

        } else {
            $error_msg_array[] = "Sorry the ID number you entered is not in the database.";
            $error_msg = TRUE;

            if($error_msg) {
                $_SESSION['ERROR_MSG_ARRAY'] = $error_msg_array;
               
                exit();
            }
            $stmt->free_result();
        }
        $result->free();
        return $result;
    }

}