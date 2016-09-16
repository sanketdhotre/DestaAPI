<?php
require_once '../model/PhotoDetails.php';
require_once '../model/UsersDetails.php';
require_once '../model/LoginDetails.php';
require_once '../model/MyListing.php';
require_once '../model/VotingDetails.php';
require_once '../model/ResultDetails.php';
require_once '../model/FirebaseTokenRegister.php';

function deliver_response($format, $api_response, $isSaveQuery) {

    // Define HTTP responses
    $http_response_code = array(200 => 'OK', 400 => 'Bad Request', 401 => 'Unauthorized', 403 => 'Forbidden', 404 => 'Not Found');

    // Set HTTP Response
    header('HTTP/1.1 ' . $api_response['status'] . ' ' . $http_response_code[$api_response['status']]);

    // Process different content types
    if (strcasecmp($format, 'json') == 0) {
		
		ignore_user_abort();
    	ob_start();

        // Set HTTP Response Content Type
        header('Content-Type: application/json; charset=utf-8');

        // Format data into a JSON response
        $json_response = json_encode($api_response);
        
        // Deliver formatted data
        echo $json_response;
		
		ob_flush();

    } elseif (strcasecmp($format, 'xml') == 0) {

        // Set HTTP Response Content Type
        header('Content-Type: application/xml; charset=utf-8');

        // Format data into an XML response (This is only good at handling string data, not arrays)
        $xml_response = '<?xml version="1.0" encoding="UTF-8"?>' . "\n" . '<response>' . "\n" . "\t" . '<code>' . $api_response['code'] . '</code>' . "\n" . "\t" . '<data>' . $api_response['data'] . '</data>' . "\n" . '</response>';

        // Deliver formatted data
        echo $xml_response;

    } else {

        // Set HTTP Response Content Type (This is only good at handling string data, not arrays)
        header('Content-Type: text/html; charset=utf-8');

        // Deliver formatted data
        echo $api_response['data'];

    }

    // End script process
    exit ;

}

// Define whether an HTTPS connection is required
$HTTPS_required = FALSE;

// Define whether user authentication is required
$authentication_required = FALSE;

// Define API response codes and their related HTTP response
$api_response_code = array(0 => array('HTTP Response' => 400, 'Message' => 'Unknown Error'), 1 => array('HTTP Response' => 200, 'Message' => 'Success'), 2 => array('HTTP Response' => 403, 'Message' => 'HTTPS Required'), 3 => array('HTTP Response' => 401, 'Message' => 'Authentication Required'), 4 => array('HTTP Response' => 401, 'Message' => 'Authentication Failed'), 5 => array('HTTP Response' => 404, 'Message' => 'Invalid Request'), 6 => array('HTTP Response' => 400, 'Message' => 'Invalid Response Format'));

// Set default HTTP response of 'ok'
$response['code'] = 0;
$response['status'] = 404;

// --- Step 2: Authorization

// Optionally require connections to be made via HTTPS
if ($HTTPS_required && $_SERVER['HTTPS'] != 'on') {
    $response['code'] = 2;
    $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
    $response['data'] = $api_response_code[$response['code']]['Message'];

    // Return Response to browser. This will exit the script.
    deliver_response($_GET['format'], $response);
}

// Optionally require user authentication
if ($authentication_required) {

    if (empty($_POST['username']) || empty($_POST['password'])) {
        $response['code'] = 3;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $response['data'] = $api_response_code[$response['code']]['Message'];

        // Return Response to browser
        deliver_response($_GET['format'], $response);

    }

    // Return an error response if user fails authentication. This is a very simplistic example
    // that should be modified for security in a production environment
    elseif ($_POST['username'] != 'foo' && $_POST['password'] != 'bar') {
        $response['code'] = 4;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $response['data'] = $api_response_code[$response['code']]['Message'];

        // Return Response to browser
        deliver_response($_GET['format'], $response);

    }
}

// --- Step 3: Process Request

// Switch based on incoming method
$checkmethod = $_SERVER['REQUEST_METHOD'];
$var = file_get_contents("php://input");
$string = json_decode($var, TRUE);
$method = $string['method'];

if (isset($_POST['method']) || $checkmethod == 'POST') {
		
	 if(strcasecmp($method,'userLogin') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objuserDetails = new LoginDetails();
        $email= $string['email'];
        $password= $string['confirmpassword'];
        $response['loginDetailsResponse'] = $objuserDetails ->CheckingUsersDetails($email,$password);
        deliver_response($string['format'],$response,false);
    }	   
	
	if(strcasecmp($method,'userRegistration') == 0) {
		$response['code'] = 1;
		$response['status'] = $api_response_code[$response['code']]['HTTP Response'];
		$objuserDetails = new UsersDetails();
		$name = $string['name'];
		$state = $string['state'];
		$mobileno= $string['mobileNo'];				   
		$objuserDetails->mapIncomingUserDetailsParams($name,$mobileno,$state);	
		$response['saveUsersDetailsResponse'] = $objuserDetails -> SavingUsersDetails();
		
        deliver_response($string['format'],$response,false);
	}
	else if(strcasecmp($method,'editProfile') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objuserDetails = new UsersDetails();
        $name = $string['name'];        
        $mobileno= $string['mobileNo'];
        $oldMobileno= $string['oldMobileNo'];
		$state = $string['state'];     
        $objuserDetails->mapIncomingEditUserDetailsParams($name,$mobileno,$state,$oldMobileno);    
        $response['saveUsersEditDetailsResponse'] = $objuserDetails -> SavingEditUsersDetails();
        deliver_response($string['format'],$response,false);
    }
    else if(strcasecmp($method,'registerFirebaseToken') == 0){
        $response['code'] = 1;  
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objRegisterFirebaseDetails = new FirebaseTokenRegister();
        $android_id = $string['android_id'];
        $token = $string['token'];
        $response['registerFirebaseTokenResponse'] = $objRegisterFirebaseDetails -> firebaseTokenRegistration($android_id, $token);
        deliver_response($string['format'],$response,false);
    }
//voting for photo
	else if(strcasecmp($method,'voteToPhoto') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objphotoVoteDetails = new VotingDetails();
        $photoId=$string['photoId'];        
        $photoCategory= $string['photoCategory'];
		$mobileNo= $string['mobileNo'];
        $response['savevoteResponse'] = $objphotoVoteDetails -> voteForphoto($photoId,$photoCategory,$mobileNo);       
        deliver_response($string['format'],$response,false);
    }
	else if(strcasecmp($_POST['method'], 'savePhotoDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objPhotoDetails = new PhotoDetails();
        $first_image_tmp = "";
        $first_image_target_path = "";
        $second_image_tmp = "";
        $second_image_target_path = "";
        $third_image_tmp = "";
        $third_image_target_path = "";		
		$fourth_image_tmp = "";
        $fourth_image_target_path = "";
		$fifth_image_tmp = "";
        $fifth_image_target_path = "";
        //$categoryOfPhoto = $_POST['categoryOfPhoto'];		
        $mobileNo = $_POST['mobileNo'];
        date_default_timezone_set('Asia/Kolkata');
        $postDate = date("Y-m-d H:i:s");
        if(isset($_FILES['firstImage'])){
            $first_image_tmp = $_FILES['firstImage']['tmp_name'];
            $first_image_name = $_FILES['firstImage']['name'];
            $first_image_target_path = "../images/".basename($first_image_name);
        }
        if(isset($_FILES['secondImage'])){
            $second_image_tmp = $_FILES['secondImage']['tmp_name'];
            $second_image_name = $_FILES['secondImage']['name'];
            $second_image_target_path = "../images/".basename($second_image_name);
        }
        if(isset($_FILES['thirdImage'])){
            $third_image_tmp = $_FILES['thirdImage']['tmp_name'];
            $third_image_name = $_FILES['thirdImage']['name'];
            $third_image_target_path = "../images/".basename($third_image_name);
        }		
		if(isset($_FILES['fourthImage'])){
            $fourth_image_tmp = $_FILES['fourthImage']['tmp_name'];
            $fourth_image_name = $_FILES['fourthImage']['name'];
            $fourth_image_target_path = "../images/".basename($fourth_image_name);
        }
		if(isset($_FILES['fifthImage'])){
            $fifth_image_tmp = $_FILES['fifthImage']['tmp_name'];
            $fifth_image_name = $_FILES['fifthImage']['name'];
            $fifth_image_target_path = "../images/".basename($fifth_image_name);
        }
		//$objPhotoDetails->mapIncomingPhotoDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $fourth_image_tmp, $fourth_image_target_path,$fifth_image_tmp, $fifth_image_target_path,$categoryOfPhoto,$postDate,$mobileNo);
        $objPhotoDetails->mapIncomingPhotoDetailsParams($first_image_tmp, $first_image_target_path, $second_image_tmp, $second_image_target_path, $third_image_tmp, $third_image_target_path, $fourth_image_tmp, $fourth_image_target_path,$fifth_image_tmp, $fifth_image_target_path,$postDate,$mobileNo);
        $response['savePhotoDetailsResponse'] = $objPhotoDetails -> savingPhotoDetails();
        deliver_response($_POST['format'], $response, true);
    }	
}
else if (isset($_GET['method'])) {
    //show photo list of all users
	 if (strcasecmp($_GET['method'], 'showPhotoDetails') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPhotoDetails = new PhotoDetails();		
        $currentPage = $_GET['currentPage'];		
		$mobileNo=$_GET['mobileNo'];
		$categoryOfPhoto=$_GET['categoryOfPhoto'];	
		
		if($currentPage == 1){
			//to show my voting in all photo
			$response['showWishListResponse'] = $fetchPhotoDetails -> showingUserVotedPhoto($mobileNo);
		}	
		$response['showPhotoDetailsResponse'] = $fetchPhotoDetails -> showingPhotoDetails($currentPage,$categoryOfPhoto);
        deliver_response($_GET['format'], $response, false);
    }
	//show phto category wise uploaded by own user
    else if (strcasecmp($_GET['method'], 'showMyPhotoListCategoryWise') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchMyListingPhotoList = new MyListing();
        $currentPage = $_GET['currentPage'];
        $mobileNo=$_GET['mobileNo'];
		//$categoryOfPhoto=$_GET['categoryOfPhoto'];
        //$response['showMyImagesListResponse'] = $fetchMyListingPhotoList -> showingMyCategoryWisePhotoList($currentPage,$mobileNo,$categoryOfPhoto);
        $response['showMyImagesListResponse'] = $fetchMyListingPhotoList -> showingMyCategoryWisePhotoList($currentPage,$mobileNo);
        deliver_response($_GET['format'], $response, false);
    }	
	//delete category wise Photo uploaded by own 
	else if(strcasecmp($_GET['method'],'deleteMyphotoCategoryWise') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objphotoVoteDetails = new MyListing();
        $photoId=$_GET['photoId'];        
        $photoCategory= $_GET['photoCategory'];
		$mobileNo= $_GET['mobileNo'];
        $response['deleteMyListingPhotoResponse'] = $objphotoVoteDetails -> deletePhotoCategoryWise($photoId,$photoCategory,$mobileNo);       
        deliver_response($_GET['format'],$response,false);
    }	
    //show photo voted by own
	else if (strcasecmp($_GET['method'], 'showMyVotingList') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchPhotoVotingDetails = new VotingDetails();
        $mobileNo=$_GET['mobileNo'];
        $currentPage = $_GET['currentPage'];
        $response['showMyVotingListResponse'] = $fetchPhotoVotingDetailss -> showingMyVotiedPhoto($mobileNo,$currentPage);
        deliver_response($_GET['format'], $response, false);
    }
	//delete voting
	else if(strcasecmp($_GET['method'],'unVoteToPhoto') == 0){
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $objphotoVoteDetails = new VotingDetails();
        $photoId=$_GET['photoId'];        
        $photoCategory= $_GET['photoCategory'];
		$mobileNo= $_GET['mobileNo'];
        $response['savevoteResponse'] = $objphotoVoteDetails -> unVoteForphoto($photoId,$photoCategory,$mobileNo);       
        deliver_response($_GET['format'],$response,false);
    }

	//show results category wise
	else if (strcasecmp($_GET['method'], 'showResultsCategoryWise') == 0) {
        $response['code'] = 1;
        $response['status'] = $api_response_code[$response['code']]['HTTP Response'];
        $fetchResultsDetails = new ResultDetails();        
        $photoCategory = $_GET['photoCategory'];
        $response['showResultsResponse'] = $fetchResultsDetails -> ShowingReusltCategoryWise($photoCategory);
        deliver_response($_GET['format'], $response, false);
    }
   
}
?>
