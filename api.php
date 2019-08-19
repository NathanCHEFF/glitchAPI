<?php
#comment with debuging
error_reporting(0);			//for clothe 
display_errors(false); 		//
#
class api
{
	const API_ENDPOINT 	 = '';			//ENDPOINT
	const API_POINT_VERS = array('1' => 'version/1/');			//path to version
	const API_METHODS    = array('')

	public static function getApi(){
		//GET or POST
		//
	}

	public function getVerApiPath($version){
		if(isset(SELF::API_POINT_VERS[$version])){
			return SELF::API_ENDPOINT.'/'.SELF::API_POINT_VERS[$version];
		}
	}

	public function response($array){
		echo json_encode($array);
	}

	function ifError($error, $exit = false){
		$this->response(array('error'=> $error));
		if($exit)exit();
	}

	function load(){
		/*
		*
		*
		*/
		if(file_exists(SELF::API_ENDPOINT.'/'.SELF::API_POINT_VERS[$version].$_GET['method']){
			include_once(SELF::API_ENDPOINT.'/'.SELF::API_POINT_VERS[$version].$_GET['method']);
			return call_user_func( $_GET['method'] );
		}else{
			return 'error code file_not_exists';
		}
	}

}



/*site.com/path?v=1&method=space&param1=val1 ...
|--path:
--->inpex.php
	<?php include_once "api.php"; ?>
*/

?>
