<?php

class logowanie extends Controller
{
	public function __construct()
    {
        session_start();
    }
	
    public function index()
    {
        $this->view('logowanie/index');
    }
	
	public function login()
    {
		$login = $_POST['login'];
        $pass = $_POST['pass'];
		$kind = $_POST['kind'];
		if($kind=='admin') {
			$users = $this->model('Users');
			$result = $users->checkData($login);
			if(!empty($result)) {
				if (password_verify($pass, $result[0]['password'])) {
					$_SESSION['admin'] = true;
					$_SESSION['dostawca'] = true;
					header('Location: ../../public/glowna');
				}
				else
					echo 'Bledne dane logowania!';
			}
			else
				echo 'Bledne dane logowania!';
		}
		else {
			$users = $this->model('Users');
			$result = $users->checkSuppliersData($login);
			if(!empty($result)) {
				if (password_verify($pass, $result[0]['password'])) {
					$_SESSION['dostawca'] = true;
					header('Location: ../../public/glowna');
				}
				else {
					echo 'Bledne dane logowania!';
				}
			}
			else
				echo 'Bledne dane logowania!';		
		}
		
    }
	
	public function logout()
    {
		if (isset($_SESSION['admin']) || isset($_SESSION['dostawca'])) {
			session_destroy();
			header('Location: ../../public/');
		}
		else 
			header('Location: ../../public/');
    }
}