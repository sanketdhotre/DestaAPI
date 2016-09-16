<?php
require_once '../dao/VotingDetailsDAO.php';
class VotingDetails
{
	private $mobileNo;
	private $photoCategory;
	private $photoId;
	private $currentPage;
	

public function setPhotoCategory($photoCategory) {
        $this->photoCategory = $photoCategory;
    }   
    public function getPhotoCategory() {
        return $this->photoCategory;
    }	
		
	public function setMobileNo($mobileNo) {
        $this->mobileNo = $mobileNo;
    }   
    public function getMobileNo() {
        return $this->mobileNo;
    }	
	
	public function setCurrentPage($currentPage) {
        $this->currentPage = $currentPage;
    }   
    public function getCurrentPage() {
        return $this->currentPage;
    }
	
	public function setPhotoId($photoId) {
        $this->photoId = $photoId;
    }   
    public function getPhotoId() {
        return $this->photoId;
    }
	  
     public function voteForphoto($photoId,$photoCategory,$mobileNo) {
        $showVotingDetailsDAO = new VotingDetailsDAO();    
		$this->setmobileNo($mobileNo);
		$this->setphotoId($photoId);
		$this->setPhotoCategory($photoCategory);
        $returnSaveVotingDetailsDAO = $showVotingDetailsDAO->voting($this);
        return $returnSaveVotingDetailsDAO;
    }
	
	public function unVoteForphoto($photoId,$photoCategory,$mobileNo) {
        $showUnVotingDetailsDAO = new VotingDetailsDAO();
        $this->setphotoId($photoId);
		$this->setmobileNo($mobileNo);
		$this->setPhotoCategory($photoCategory);
        $returnSaveUnVotingDetailsDAO = $showUnVotingDetailsDAO->unVoting($this);
        return $returnSaveUnVotingDetailsDAO;
    }
	public function showingMyVotiedPhoto($mobileNo,$currentPage) {
        $showUnVotingDetailsDAO = new VotingDetailsDAO();        
		$this->setmobileNo($mobileNo);
		$this->setCurrentPage($currentPage);
        $returnSaveUnVotingDetailsDAO = $showUnVotingDetailsDAO->showMyVotingList($this);
        return $returnSaveUnVotingDetailsDAO;
    }
		
}
?>