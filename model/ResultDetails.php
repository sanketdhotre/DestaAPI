<?php
require_once '../dao/ResultDetailsDAO.php';
class ResultDetails
{
	private $categoryOfPhoto;
	
	public function setCategoryOfPhoto($categoryOfPhoto) {
		$this -> categoryOfPhoto = $categoryOfPhoto;
	}

	public function getCategoryOfPhoto() {
		return $this -> categoryOfPhoto;
	}

  // show Results category wise
 	public function ShowingReusltCategoryWise($categoryOfPhoto) {
        $showResultsDAO = new ResultDetailsDAO();
		$this->setCategoryOfPhoto($categoryOfPhoto);
        $returnShowResultsDetails = $showResultsDAO->showResults($this);
        return $returnShowResultsDetails;
    }	
		
}
?>