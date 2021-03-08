<?php
class AdminController extends Controller
{
    private $UserModel = NULL;
    public function __construct()
    {
        $this->UserModel = $this->model('User');
    }


    public function adminLogin($email, $password)
    {
        if (!empty($email) && !empty($password)) {
            $email = htmlspecialchars($email);
            $password = htmlspecialchars($password);
            $email = $this->UserModel->connect()->real_escape_string($email);
            $password = $this->UserModel->connect()->real_escape_string($password);
            $getuserResult = $this->UserModel->getUserByEmail($email);
            if ($getuserResult->num_rows != 0) {  //check if email exists
                $row = $getuserResult->fetch_assoc();
                if (password_verify($password, $row["password"]) && $row["isAdmin"] == '1') {
                    $_SESSION["isLogged"] = true;
                    $_SESSION["userID"] = $row["user_id"];
                    $_SESSION["user-name"] = $row["name"];
                    $this->view('adminDashboard');
                } else $this->view("adminlogin", "<script type=text/javascript>alert('Invalid email or password');</script>");
            } else {
                $this->view("adminlogin", "<script type=text/javascript>alert('Invalid email or password');</script>");
            }
        } else $this->view("adminlogin", "<script type=text/javascript>alert('Empty fields');</script>");
    }

    public function displayAdmins($args = [])
    {
        $adminInfo = array();
        $data = $this->UserModel->getUsers('1');

        while ($row = $data->fetch_assoc()) {
            $adminInfo[] = $row;
        }
        $_SESSION["adminInfo"] = $adminInfo;
        if (count($args) == 1)
            $this->view('AdminsList', $args[0]);
        else $this->view('AdminsList');
    }

    public function adminRegister($nameAdmin, $emailAdmin, $passwordAdmin, $dob)
    {
        $nameAdmin = htmlspecialchars($_POST["nameAdmin"]);
        $emailAdmin = htmlspecialchars($_POST["emailAdmin"]);
        $passwordAdmin = htmlspecialchars($_POST["passwordAdmin"]);
        $dob = htmlspecialchars($_POST["dob"]);
        $confirm_password = htmlspecialchars($_POST["confirmpasswordAdmin"]);
        
        if (isset($nameAdmin)  && isset($emailAdmin) && isset($passwordAdmin) && isset($dob)) {
            if (!empty($nameAdmin) && !empty($emailAdmin) && !empty($passwordAdmin) && !empty($dob)) {
                $nameAdmin = $this->UserModel->connect()->real_escape_string($nameAdmin);
                $emailAdmin = $this->UserModel->connect()->real_escape_string($emailAdmin);
                $passwordAdmin = $this->UserModel->connect()->real_escape_string($passwordAdmin);
                $dob = $this->UserModel->connect()->real_escape_string($dob);
                $confirm_password = $this->UserModel->connect()->real_escape_string($confirm_password);
                if ($passwordAdmin != $confirm_password || !preg_match('/[_\-!\"@;,.:$%#&*()^]/', $passwordAdmin)) {
                    $this->view('adminRegForm', "<script type=text/javascript>alert('Cannot register user');</script>");
                } else if ($this->UserModel->getUserByEmail($emailAdmin)->num_rows != 0) {
                    $this->view('adminRegForm', "<script type=text/javascript>alert('Email already used');</script>");
                } else if (!$this->validate_email($emailAdmin)) {
                    $this->view('adminRegForm', "<script type=text/javascript>alert('Invalid Email');</script>");
                } else {
                    $hashed_password = password_hash($passwordAdmin, PASSWORD_BCRYPT); //CRYPT_BLOWFISH algorithm (60 char string)
                    $insert = $this->UserModel->insertUser($nameAdmin, $emailAdmin, $hashed_password, $dob, '1');
                    if ($insert) {
                        $this->displayAdmins(["<script type=text/javascript>alert('Admin successfully added');</script>"]);
                    } else $this->view('adminRegForm', "<script type=text/javascript>alert('Cannot register user');</script>");
                }
            } else {
                $this->view('adminRegForm', "<script type=text/javascript>alert('Fields empty');</script>");
            }
        }
    }

    public function removeAdmin($adminID)
    {
        $adminID = $this->UserModel->connect()->real_escape_string($adminID);
        $result = $this->UserModel->deleteUser($adminID);
        if ($result) {
            $_SESSION["nbrOfAdmins"] = $this->UserModel->getUsers('1')->num_rows;
            $this->displayAdmins(["<script> alert('Admin successfully deleted');</script>"]);
        } else $this->displayAdmins(["<script> alert('Could not delete admin');</script>"]);
    }

    public function editAdmin($oldPasswordAdmin, $newPasswordAdmin)
    {
        $idAdmin = $_SESSION["userID"]; //got the users_id to know which row to update
        $idAdmin = $this->UserModel->connect()->real_escape_string($idAdmin);
        $passwordAdmin = $this->UserModel->getUserPassword($idAdmin);
        $rowpass = $passwordAdmin->fetch_assoc();
        $passAdmin = $rowpass["password"];  //got the pass of that user to check if the entered old password is valid
        $oldPasswordAdmin = $this->UserModel->connect()->real_escape_string($oldPasswordAdmin);
        $newPasswordAdmin =  $this->UserModel->connect()->real_escape_string($newPasswordAdmin);
        if (password_verify($oldPasswordAdmin, $passAdmin)) {  //checking if current password is valid
            $newPasswordAdmin = password_hash($newPasswordAdmin, PASSWORD_BCRYPT);
            $update = $this->UserModel->updateUserPassword($idAdmin, $newPasswordAdmin);
            if ($update) {
                $this->displayAdmins(["<script> alert('Password successfully updated');</script>"]);
            } else $this->view("UpdateAdmin", "<script> alert('Update Failed');</script>");
        } else $this->view("UpdateAdmin", "<script> alert('Wrong password');</script>");
    }

    public function logOut()
    {
        session_start();
        session_destroy();
        $_SESSION = array();
        $this->view('adminlogin');
    }
    
    public function index($loc = 'adminlogin')
    {
        $this->view($loc);
    }
}
?>