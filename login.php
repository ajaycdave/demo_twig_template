<?php
require_once __DIR__ ."/includes/common.php";
require_once __DIR__ ."/models/Users.php";
require_once __DIR__ .'/Adminacess.php';
Adminacess::create('Login', $twig);
class Login {
	public static $twig;
	public function __construct($twig) {
		$this->twig = $twig;

		if (isset($_REQUEST['action']) && $_REQUEST['action'] !== "") {
			$action_method = $_REQUEST['action'];
			$this->$action_method();
		} else {
			$this->index();
		}
	}
	public function index() {
		$data           = array();
		$data['status'] = 'aa';

		echo $this->twig->render('login.html.twig', $data);

	}
	public function do_login() {
		$user  = new Users();
		$email = $_POST['email'];

		$password = md5($_POST['password']);

		$sel_query = "select * from users where email='".$email."' and password='".$password."'";

		$sel_user = $user->selectOne($sel_query);
		if (count($sel_user) > 0) {
			$message['status']      = 'Success';
			$message['message']     = 'Admin login Succefully';
			$_SESSION["user_email"] = $sel_user['email'];
			$_SESSION["user_name"]  = $sel_user['name'];
			header("Location:category.php");
		} else {
			$data['message'] = 'Enter email or password invalid';
			$data['status']  = 'Error';
			echo $this->twig->render('login.html.twig', $data);
		}

	}

}
