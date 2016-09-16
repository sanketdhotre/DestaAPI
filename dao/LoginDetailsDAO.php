<?php
require_once 'BaseDAO.php';
class LoginDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function LoginDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }

    public function loginDetail($LoginDetails) {
        try {
            $sql = "SELECT * FROM userDetails WHERE email='".$LoginDetails->getEmail()."' AND password='".$LoginDetails->getPassword()."'";        
            $isValidating = mysqli_query($this->con, $sql);
            $count=mysqli_num_rows($isValidating);
            if($count==1) {
                $this->data = "LOGIN_SUCCESSFULL";
            } else {
                $this->data = "LOGIN_FAILED";
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

                
}
?>