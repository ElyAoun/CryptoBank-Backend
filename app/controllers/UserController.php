<?php
class UserController extends Controller
{
    private $UserModel = NULL;
    public function __construct()
    {
        $this->UserModel = $this->model('User');
    }
    public function createUser($name, $password, $email, $birthdate)
    {
        $result_json = [];
        if (!empty($name) && !empty($email) && !empty($password) && !empty($birthdate)) {
            $name = htmlspecialchars($name);
            $email = htmlspecialchars($email);
            $password = htmlspecialchars($password);
            $birthdate = htmlspecialchars($birthdate);
            $name = $this->UserModel->connect()->real_escape_string($name);
            $password = $this->UserModel->connect()->real_escape_string($password);
            $email = $this->UserModel->connect()->real_escape_string($email);
            $birthdate = $this->UserModel->connect()->real_escape_string($birthdate);
            if (!$this->validate_email($email)) {
                $result_json["error_type"] = "Invalid Email";
            } else if (!$this->validate_password($password)) {
                $result_json["error_type"] = "Invalid Password";
            } else if ($this->UserModel->getUserbyEmail($email)->num_rows != 0) {
                $result_json["error_type"] = "Already Exists";
            } else {
                $timestamp = strtotime($birthdate);
                $mysqldate =  date("Y-m-d", $timestamp);
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $resultInsert = $this->UserModel->insertUser($name, $email, $hashed_password, $mysqldate, '0');
                if ($resultInsert) {
                    $row = $this->UserModel->getUserID($email);
                    $datas = $row->fetch_assoc();
                    $_SESSION["user_id"] = $datas["user_id"];
                    $result_json["session_id"] = session_id();
                    $result_json["error_type"] = "true";
                } else $result_json["error_type"] = "false";
            }
        } else
            $result_json["error_type"] = "Missing Field";
        return json_encode($result_json);
    }

    public function LogIn($email, $password)
    {
        $result_json = [];
        $error = false;
        if (!empty($email) && !empty($password)) {
            $email = htmlspecialchars($email);
            $password = htmlspecialchars($password);
            $email = $this->UserModel->connect()->real_escape_string($email);
            $password = $this->UserModel->connect()->real_escape_string($password);
            $getuserResult = $this->UserModel->getUserByEmail($email);
            if ($getuserResult->num_rows != 0) {
                $row = $getuserResult->fetch_assoc();
                if (password_verify($password, $row["password"]) && $row["isAdmin"] == '0') {
                    foreach ($row as $key => $value) {
                        $_SESSION[$key] = $value;
                    }
                    $result_json["session_id"] = session_id();
                    $result_json["error_type"] = "true";
                } else $error = true;
            } else $error = true;
        } else $error = true;
        if ($error) {
            $result_json["error_type"] = "false";
        }
        return json_encode($result_json);
    }
    public function logOut()
    {
        session_destroy();
        $_SESSION = array();
    }

    public function displayUsers($args = [])
    {
        $userInfo = array();
        $data = $this->UserModel->getUsers('0');

        while ($row = $data->fetch_assoc()) {
            $userInfo[] = $row;
        }
        $_SESSION["userInfo"] = $userInfo;
        if (count($args) == 1)
            $this->view('UsersList', $args[0]);
        else $this->view('UsersList');
    }

    public function banUser($userId)
    {
        $userId = $this->UserModel->connect()->real_escape_string($userId);
        $result = $this->UserModel->deleteUser($userId);
        if ($result) {
            $_SESSION["nbrOfUsers"] = $this->UserModel->getUsers('0')->num_rows;
            $this->displayUsers(["<script type=text/javascript>alert('User successfully banned');</script>"]);
        } else
            $this->displayUsers(["<script type=text/javascript>alert('Cannot ban user');</script>"]);
    }
}
?>