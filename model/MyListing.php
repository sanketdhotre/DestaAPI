<?php
require_once '../dao/MyListingDAO.php';
class MyListing
{
    private $currentPage;
	private $mobileNo;
	private $photoId;
	//private $categoryOfPhoto;
	
    
    public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }    
    public function getCurrentPage() {
        return $this->currentPage;
    }
	
	public function setMobileNo($mobileNo) {
        $this->mobileNo = $mobileNo;
    }    
    public function getMobileNo() {
        return $this->mobileNo;
    }
	
	public function setPhotoId($photoId) {
        $this->photoId = $photoId;
    }    
    public function getPhotoId() {
        return $this->photoId;
    }
	
	// public function setCategoryOfPhoto($categoryOfPhoto) {
	// 	$this -> categoryOfPhoto = $categoryOfPhoto;
	// }

	// public function getCategoryOfPhoto() {
	// 	return $this -> categoryOfPhoto;
	// }

  // show  category wise all photo uplaoded by me
 	//public function showingMyCategoryWisePhotoList($currentPage,$mobileNo,$categoryOfPhoto) {
    public function showingMyCategoryWisePhotoList($currentPage,$mobileNo) {
        $showMyListingPhotoListDAO = new MyListingDAO();
        $this->setCurrentPage($currentPage);
		$this->setMobileNo($mobileNo);
		//$this->setCategoryOfPhoto($categoryOfPhoto);
        $returnShowMyListingPhotoListDetails = $showMyListingPhotoListDAO->showMyListingPhotoList($this);
        return $returnShowMyListingPhotoListDetails;
    }
		
	// delete category wise photo uploaded by me
	public function deletePhotoCategoryWise($photoId,$categoryOfPhoto,$mobileNo) {
        $deleteMyListingPhotoListDAO = new MyListingDAO();
        $this->setPhotoId($photoId);
		$this->setMobileNo($mobileNo);
		$this->setCategoryOfPhoto($categoryOfPhoto);
        $returnDeleteMyListingPhotoListDetails = $deleteMyListingPhotoListDAO->deleteMyListingPhotoCategoryWise($this);
        return $returnDeleteMyListingPhotoListDetails;
    }
		
}
?>