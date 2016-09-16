<?php
require_once '../dao/PhotoDetailsDAO.php';
class PhotoDetails
{
	private $first_image_tmp;
	private $first_image_target_path;
    private $second_image_tmp;    
    private $second_image_target_path;
	private $third_image_tmp;
    private $third_image_target_path;
	
	private $fourth_image_tmp;
    private $fourth_image_target_path;
	private $fifth_image_tmp;
    private $fifth_image_target_path;
	
    //private $categoryOfPhoto;
    private $postDate;
    private $currentPage;
    private $mobileNo;
	private $alternateNo;	
	
    public function setFirstImageTemporaryName($first_image_tmp) {
        $this->first_image_tmp = $first_image_tmp;
    }    
    public function getFirstImageTemporaryName() {
        return $this->first_image_tmp;
    }    
    public function setSecondImageTemporaryName($second_image_tmp) {
        $this->second_image_tmp = $second_image_tmp;
    }    
    public function getSecondImageTemporaryName() {
        return $this->second_image_tmp;
    }    
    public function setThirdImageTemporaryName($third_image_tmp) {
        $this->third_image_tmp = $third_image_tmp;
    }    
    public function getThirdImageTemporaryName() {
        return $this->third_image_tmp;
    }
    public function setTargetPathOfFirstImage($first_image_target_path) {
        $this->first_image_target_path = $first_image_target_path;
    }    
    public function getTargetPathOfFirstImage() {
        return $this->first_image_target_path;
    }    
    public function setTargetPathOfSecondImage($second_image_target_path) {
        $this->second_image_target_path = $second_image_target_path;
    }    
    public function getTargetPathOfSecondImage() {
        return $this->second_image_target_path;
    }    
    public function setTargetPathOfThirdImage($third_image_target_path) {
        $this->third_image_target_path = $third_image_target_path;
    }    
    public function getTargetPathOfThirdImage() {
        return $this->third_image_target_path;
    }
	////// fourth and fifth
	 public function setFourthImageTemporaryName($fourth_image_tmp) {
        $this->fourth_image_tmp = $fourth_image_tmp;
    }    
    public function getFourthImageTemporaryName() {
        return $this->fourth_image_tmp;
    } 
	
	public function setTargetPathOfFourthImage($fourth_image_target_path) {
        $this->fourth_image_target_path = $fourth_image_target_path;
    }    
    public function getTargetPathOfFourthImage() {
        return $this->fourth_image_target_path;
    }
	public function setFifthImageTemporaryName($fifth_image_tmp) {
        $this->fifth_image_tmp = $fifth_image_tmp;
    }    
    public function getFifthImageTemporaryName() {
        return $this->fifth_image_tmp;
    } 
	public function setTargetPathOfFifthImage($fifth_image_target_path) {
        $this->fifth_image_target_path = $fifth_image_target_path;
    }    
    public function getTargetPathOfFifthImage() {
        return $this->fifth_image_target_path;
    }
	/////////////
    // public function setCategoryOfPhoto($categoryOfPhoto) {
    //     $this->categoryOfPhoto = $categoryOfPhoto;
    // }    
    // public function getCategoryOfPhoto() {
    //     return $this->categoryOfPhoto;
    // }
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }    
    public function getCurrentPage() {
        return $this->currentPage;
    }
    public function setPostDate($postDate) {
        $this->postDate = $postDate;
    }    
    public function getPostDate() {
        return $this->postDate;
    }    
    public function setMobileNo($mobileNo) {
        $this->mobileNo = $mobileNo;
    }
    public function getMobileNo() {
        return $this->mobileNo;
    }	
	public function setAlternateNo($alternateNo) {
        $this->alternateNo = $alternateNo;
    }
    public function getAlternateNo() {
        return $this->alternateNo;
    }
    
	//public function mapIncomingPhotoDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $fourth_image_tmp, $fourth_image_target_path,$fifth_image_tmp, $fifth_image_target_path,$categoryOfPhoto,$postDate, $mobileNo) {
    public function mapIncomingPhotoDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $fourth_image_tmp, $fourth_image_target_path,$fifth_image_tmp, $fifth_image_target_path,$postDate, $mobileNo) {
        $this->setFirstImageTemporaryName($first_image_tmp);
		$this->setTargetPathOfFirstImage($first_image_target_path);		
        $this->setSecondImageTemporaryName($second_image_tmp);
		$this->setTargetPathOfSecondImage($second_image_target_path);		
        $this->setThirdImageTemporaryName($third_image_tmp);               
        $this->setTargetPathOfThirdImage($third_image_target_path);
		
		$this->setFourthImageTemporaryName($fourth_image_tmp);               
        $this->setTargetPathOfFourthImage($fourth_image_target_path);
		
		$this->setFifthImageTemporaryName($fifth_image_tmp);               
        $this->setTargetPathOfFifthImage($fifth_image_target_path);
		
        //$this->setCategoryOfPhoto($categoryOfPhoto);        
		$this->setPostDate($postDate);
        $this->setMobileNo($mobileNo);
    }
	//save photo of users
    public function savingPhotoDetails() {
        $savePetDetailsDAO = new PhotoDetailsDAO();
        $returnPetDetailSaveSuccessMessage = $savePetDetailsDAO->saveDetail($this);
        return $returnPetDetailSaveSuccessMessage;
    }
	//show all users photo
	public function showingPhotoDetails($currentPage,$categoryOfPhoto) {
        $showPhotoDetailsDAO = new PhotoDetailsDAO();
        $this->setCurrentPage($currentPage);
		$this->setCategoryOfPhoto($categoryOfPhoto);
        $returnShowPhotoDetails = $showPhotoDetailsDAO->showDetail($this);
        return $returnShowPhotoDetails;
    }
	//show user voted photo list
	public function showingUserVotedPhoto($mobileNo) {
        $showshowUserVotedPhotoDAO = new PhotoDetailsDAO();
        $this->setMobileNo($mobileNo);
        $returnShowPhotoDetails = $showshowUserVotedPhotoDAO->showUserVotedPhotoList($this);
        return $returnShowPhotoDetails;
    }		       
}
?>