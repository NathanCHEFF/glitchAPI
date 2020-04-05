<?php
#comment with debuging
//error_reporting(E_ALL);			//for clothe
//display_errors(1); 		//
#
class api
{

	const API_VER_PRFX   = 'v';
	const API_MTD_PRFX   = 'method';
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
		//echo $this->getEndPoint(). $this->getVerList()->$_GET[SELF::API_VER_PRFX].$_GET[SELF::API_MTD_PRFX].'.php';\
		$API_VER_PRFX = $_GET[SELF::API_VER_PRFX];
		//var_dump( $this->getVerList()->$API_VER_PRFX . $_GET[SELF::API_MTD_PRFX].'.php');
		//echo "\n";
		if( file_exists( $this->getVerList()->$API_VER_PRFX . $_GET[SELF::API_MTD_PRFX].'.php')){
			include_once( $this->getVerList()->$API_VER_PRFX .$_GET[SELF::API_MTD_PRFX].'.php');   // ЦЫМЕС
		}else{
			return $this->ifError('error code -1 : [method name] method_file_not_exists');
		}
	}


	private function getEndPoint(){
		//вернет  путь относительно директории этого файла
		return str_replace( basename( __FILE__ ) , '' , $_SERVER['SERVER_NAME']. $_SERVER['PHP_SELF'] );///!!!ATENTION
	}

	protected function idempothyRequest($delete = true){
		//https://www.w3.org/Protocols/rfc2616/rfc2616-sec9.html
		if($_GET and !$_POST) {
			$_POST = $_GET;
			if($delete)$_GET = null;
		}
		else { return 0; }
	}



}


//var_dump(api::getApi()->getVerList());
api::getApi()->load();


/*site.com/path?v=1&method=space&param1=val1 ...
|--path:
--->inpex.php
	<?php include_once "api.php";

	?>
*/



?>
