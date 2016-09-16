<?php
require_once 'BaseDAO.php';
class PhotoDetailsDAO
{
    private $con;
    private $msg;
    private $data;
    private $googleAPIKey;
    
    // Attempts to initialize the database connection using the supplied info.
    public function PhotoDetailsDAO() {
        $baseDAO = new BaseDAO();
        $this->con = $baseDAO->getConnection();
        $this->googleAPIKey = $baseDAO->getGoogleAPIKey();
    }
    public function saveDetail($photoDetail) {
        try {
				$status = 0;
				$photosTempNames = array($photoDetail->getFirstImageTemporaryName(), $photoDetail->getSecondImageTemporaryName(), $photoDetail->getThirdImageTemporaryName(), $photoDetail->getFourthImageTemporaryName(), $photoDetail->getFifthImageTemporaryName());
				$photosTargetPaths = array($photoDetail->getTargetPathOfFirstImage(), $photoDetail->getTargetPathOfSecondImage(), $photoDetail->getTargetPathOfThirdImage(), $photoDetail->getTargetPathOfFourthImage(), $photoDetail->getTargetPathOfFifthImage());
				foreach ($photosTempNames as $index => $photosTempName) {
					if(move_uploaded_file($photosTempName, $photosTargetPaths[$index])) {
						$photopath = $photosTargetPaths[$index];						
						$this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
						/*$sql = "INSERT INTO photodetails(mobileNo,photoPath,photoCategory, post_date)
								VALUES('".$photoDetail->getMobileNo()."','$photopath','".$photoDetail->getCategoryOfPhoto()."','".$photoDetail->getPostDate()."')";	*/
                        $sql = "INSERT INTO photodetails(mobileNo,photoPath,post_date)
                                VALUES('".$photoDetail->getMobileNo()."','$photopath','".$photoDetail->getPostDate()."')";			
								
						$isInserted = mysqli_query($this->con, $sql);
						if ($isInserted) {	
							$status = 1;
						}else{
							$status=0;
						}						
					}
				}
				if($status = 1) {															
					$this->data = "PHOTO_SUCCESSFULLY_UPLOADED";																	
				} else {
					$this->data = "ERROR";
				}
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data;
    }
	//show user Voted Photo
	public function showUserVotedPhotoList($userVotedPhoto) {
        try {
			$sql ="SELECT * FROM votedetails WHERE mobileNo= '".$userVotedPhoto->getMobileNo()."' ";
            $result = mysqli_query($this->con, $sql);			
            $this->data=array();
            while ($rowdata = mysqli_fetch_assoc($result)) {
                $this->data[]=$rowdata;
            }
            return $this->data;
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data=array();
    }	
	//show all uploaded photo by each user
	public function showDetail($pageWiseData) {
        try {
			$sql = "SELECT * FROM photodetails";
            $result = mysqli_query($this->con, $sql);
            $numOfRows = mysqli_num_rows($result);
            $rowsPerPage = 10;
            $totalPages = ceil($numOfRows / $rowsPerPage);
            $this->con->options(MYSQLI_OPT_CONNECT_TIMEOUT, 500);
            if (is_numeric($pageWiseData->getCurrentPage())) {
                $currentPage = (int) $pageWiseData->getCurrentPage();
            }
            if ($currentPage >= 1 && $currentPage <= $totalPages) {
                $offset = ($currentPage - 1) * $rowsPerPage;
						$sql="SELECT * FROM photoDetails WHERE photoCategory='".$pageWiseData->getCategoryOfPhoto()."'
								 ORDER BY post_date DESC LIMIT $offset, $rowsPerPage";
                $result = mysqli_query($this->con, $sql);				
                $this->data=array();
                while ($rowdata = mysqli_fetch_assoc($result)) {
                    $this->data[]=$rowdata;
                }			
               return $this->data;				
            }
        } catch(Exception $e) {
            echo 'SQL Exception: ' .$e->getMessage();
        }
        return $this->data=array();		
    }
}
?>