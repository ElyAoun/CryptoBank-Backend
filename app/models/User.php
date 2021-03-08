<?php
require_once("dbh.class.php");
class User extends Dbh
{
    public function getUser($email, $password)
    {
        $getUserQuery = "SELECT * FROM user WHERE email= " . '\'' . $email . '\'' . " AND password=" . '\'' . $password . '\'';
        $stmt = $this->connect()->query($getUserQuery);
        $this->closeConnection();
        return $stmt;
    }
    public function getUserbyEmail($email)
    {
        $getUserQuery = "SELECT * FROM user WHERE email= " . '\'' . $email . '\'';
        $stmt = $this->connect()->query($getUserQuery);
        $this->closeConnection();
        return $stmt;
    }
    public function getUserID($email)
    {
        $getIdQuery = "SELECT user_id FROM user WHERE email=" . '\'' . $email . '\'';
        $stmt = $this->connect()->query($getIdQuery);
        $this->closeConnection();
        return $stmt;
    }
    
    public function getUserPassword($userID)
    {
        $getPasswordQuery = "SELECT password from user WHERE user_id=" . '\'' . $userID . '\'';
        $stmt = $this->connect()->query($getPasswordQuery);
        $this->closeConnection();
        return $stmt;
    }
    public function getUsers($isAdmin)
    {
        $select_sql = "SELECT * FROM user WHERE isAdmin=".'\''.$isAdmin.'\'';
        $stmt = $this->connect()->query($select_sql);
        $this->closeConnection();
        return $stmt;
    }
    public function insertUser($name, $email, $password, $birthdate,$isAdmin)
    {
        $insertUserQuery = "INSERT INTO user (name,email,password,birthdate,isAdmin) VALUES(" . '\'' . $name . '\'' . "," . '\'' . $email . '\'' . "," . '\'' . $password . '\'' . "," . '\'' . $birthdate . '\'' . ",".'\''.$isAdmin.'\''.")";
        $stmt = $this->connect()->query($insertUserQuery);
        $this->closeConnection();
        return $stmt;
    }


    public function deleteUser($userID)
    {
        $deleteUserQuery = "DELETE FROM user WHERE user_id=" . '\'' . $userID . '\'';
        $stmt = $this->connect()->query($deleteUserQuery);
        $this->closeConnection();
        return $stmt;
    }

    public function updateUserPassword($userID, $password)
    {
        $updateUserQuery = "UPDATE user SET password=" . '\'' . $password . '\'' . "WHERE user_id=" . '\'' . $userID . '\'';
        $stmt = $this->connect()->query($updateUserQuery);
        $this->closeConnection();
        return $stmt;
    }
}
?>