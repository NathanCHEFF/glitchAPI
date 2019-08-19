<?php
#comment with debuging
//error_reporting(0);			//for clothe 
//display_errors(false); 		//
#
class api
{
	//const API_ENDPOINT 	 = '';			//ENDPOINT   kill him
	const API_VER_PRFX   = 'version';
	const API_VER_LIST   = 'versionlist.json';
	
	private static $instance;
	

	public static function getApi(){
		//GET or POST
		//
		if (null === static::$instance) {
            static::$instance = new static();
        }

        return static::$instance;
	}

	public function getVerList(){
		return json_decode(file_get_contents(SELF::API_VER_LIST));
	}

	public function getVerApiPath($version){
		if($this->getVerList()->$version ){
			return $_SERVER['REQUEST_URI'].'/'.$this->getVerList()->$version;
		}
		return null;
	}

	public function response($array){
		echo json_encode($array);
	}

	function ifError($error, $exit = false){
		$this->response(array('error'=> $error));
		if($exit)exit();
	}

	function load(){
		
		if(file_exists($_SERVER['REQUEST_URI'].'/'.$this->getVerList()->$_GET[SELF::API_VER_PRFX].$_GET['method']) && api::getApi()->getVerList()->$_GET[API_VER_PRFX]){
			include_once($_SERVER['REQUEST_URI'].'/'.$this->getVerList()->$_GET[SELF::API_VER_PRFX].$_GET['method']);
			return call_user_func( $_GET['method'] );
		}else{
			return 'error code file_method_or_not_exists';
		}
	}

}
//var_dump(api::getApi()->getVerList());
var_dump(api::getApi()->load());


/*site.com/path?v=1&method=space&param1=val1 ...
|--path:
--->inpex.php
	<?php include_once "api.php"; ?>
*/

?>
