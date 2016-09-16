<?php
require_once 'BaseDAO.php';
class UsersDetailsDAO
{
    
    private $con;
    private $msg;
    private $data;
    
    // Attempts to initialize the database connection using the supplied info.
    public function UsersDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
    }
    
   
    public function insertUserDetails($UsersDetail) {
        try {
            $sql = "SELECT * FROM  userdetails WHERE mobileNo='".$UsersDetail->getMobileno()."'";

            $isValidating = mysqli_query($this->con, $sql);
            $count=mysqli_num_rows($isValidating);
            if($count==1) {         
                $this->data = "No_Is_Already_Registered";
            }else{      
                $sql = "INSERT INTO userdetails(name,state,mobileno)
                        VALUES ('".$UsersDetail->getName()."','".$UsersDetail->getState()."', '".$UsersDetail->getMobileno()."')";
                
                $isInserted = mysqli_query($this->con, $sql);				
                if ($isInserted) {					
					$this->data = "USERS_DETAILS_SAVED";                                      
                } else {
                    $this->data = "ERROR";
                }
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }

    

    public function saveEditDetail($EditUsersDetail) {
        try {                    
				$sql="UPDATE userdetails SET name='".$EditUsersDetail->getName()."',mobileNo='".$EditUsersDetail->getMobileno()."', state='".$EditUsersDetail->getState()."' WHERE mobileNo='".$EditUsersDetail->getOldMobileno()."'";
                $isEdited = mysqli_query($this->con, $sql);
                if ($isEdited) {
                    $this->data = "USERS_DETAILS_EDITED";
                } else {
                    $this->data = "ERROR";
                }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }      
}
?>