<?php if(! defined('BASEPATH')) exit('no direct script allowed');
class Login extends CI_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->dbutil();
		$this->load->library('form_validation');
		$this->load->helper('to_excel');
		
	}
	public function index()
	{
		if($this->session->userdata('logged_in')){
			redirect('gudang');
		}else{			
			$this->load->view("templates/header-login");
			if ($this->dbutil->database_exists('toko')){
				$this->load->view("pages/loginform");
				$this->load->view("templates/footer");
			}else{
				$this->load->view("pages/create");
			}
		}
	}
	public function resetpass()
   	{
		$this->load->view("templates/header-login");
		$this->load->view("pages/reset");
		$this->load->view("templates/footer");
   	}
   	public function reg(){
   		$this->form_validation->set_rules('email','email','trim|required|xss_clean');
   		$this->form_validation->set_rules('uname','username','trim|required|xss_clean');
		$this->form_validation->set_rules('pass','password','trim|required|xss_clean');
   		if($this->form_validation->run()==false){
   			$this->form_validation->set_message('cek_database','isikan semua field');
   			redirect('login?reg');
   		}else{
   			$email=rtrim($this->input->post('email'));
   			$uname=rtrim($this->input->post('uname'));
   			$pass=rtrim($this->input->post('pass'));
   			$ubaru = array(
   				'email' => $email, 
   				'username'=>$uname,
   				'password'=>sha1($pass)
   				);
   			$idbaru=$this->mweb->settable('user',$ubaru);
   			if ($idbaru) {
   				$notif = array(
   					'from' =>getid_own() ,
   					'iduser'=>getid_min(),
   					'aksi'=>'register user',
   					'msg'=>'ada member baru dengan nama user <strong>'.getuname($idbaru).'</strong><br/>
   					<a href="'.site_url('gudang/slug/4/4/5?id='.$idbaru.'&tbl=5').'">details</a>',
   					'time'=>date('d-m-Y h:i:s')
   				 );
   				$this->mweb->settable('notif',$notif);
   				redirect('login?u='.$idbaru,'refresh');
   			}
   		}
   	}
   	
}