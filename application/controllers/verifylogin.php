<?php if(! defined('BASEPATH')) exit('no direct script allowed');
class Verifylogin extends CI_Controller{
	function __construct(){
		parent::__construct();
		ob_start();
		$this->load->helper('string');
   		$this->load->library('encrypt');
   		$this->load->helper('get_random_password');
   		$this->load->library('form_validation');
		/*if (headers_sent()) {
    		echo("Redirect failed. Please click on this link: <a href='#'>wew</a>");
		}else{
    		exit(header(site_url('gudang')));
		}*/		
	}
	function index()
	{
		
		$this->form_validation->set_rules('uname','username','trim|required|xss_clean');
		$this->form_validation->set_rules('pass','password','trim|required|xss_clean|callback_cek_database');
		if($this->form_validation->run()==false){
			$this->load->view("templates/header-login");
			$this->load->view("pages/loginform");
			$this->load->view("templates/footer");

		}else{
			redirect('gudang','refresh');
		}

	}
	function cek_database($password){
		$uname=$this->input->post("uname");
		$hasil=$this->m_user->cek_login($uname,$password);
		if($hasil){
			$sess_array=array();
			foreach ($hasil as $row){
				$idjbtn=$row->kdcapab;
				$acc=$row->acc;
				$jbntn=$this->m_user->get_jabatan($idjbtn);
				if ($jbntn && $acc==='1'){
					$sess_array=array(
					'id'=>$row->id,
					'username'=>$row->username,
					'jabatan'=>$jbntn
					);
					$this->session->set_userdata('logged_in',$sess_array);
					return true;
				}else{
					$this->form_validation->set_message('cek_database','maaf,akun anda sudah terdaftar,namun belum diterima');
					return false;
				}
			}
		}else{
			$this->form_validation->set_message('cek_database','invalid username or password');
			return false;
		}
	}

	function verifyres()
   	{
   		
   		$this->form_validation->set_rules('uname','username','trim|required|xss_clean');
   		$this->form_validation->set_rules('resemail','email','trim|required|xss_clean|callback_cek_email');
	   	//$this->input->post('resemail');
   		if($this->form_validation->run()==false){
			$this->load->view("templates/header-login");
			$this->load->view("pages/reset");
			$this->load->view("templates/footer");
		}else{ ?>
			<script type="text/javascript">
				alert('cek email ');
			</script>
		<?php 
				redirect('gudang','refresh');
		}
   	}
   	function cek_email($resemail)
   	{
   		$uname=$this->input->post("uname");
   		$cekemail=$this->m_user->cek_email($uname,$resemail);
   		if ($cekemail) {
   			$len=strlen($uname);
   			$str=get_random_password(6,8,true,$len);
   			$hash=sha1($str);
   			$query= $this->db->where('username',$uname)
					->update('user',array('password'=>$hash));
			if ($query) {
				$this->load->library('email');
				$this->email->from('firmawaneiwan@gmail.com', 'jvm system');
				$this->email->to($resemail); 
				$this->email->subject('RESET PASSWORD');
				$this->email->message('silahkan login dengan username = '.$uname.' dan password ='.$str );	
				$this->email->send();
				$log =date('Y-m-d h:i:s')."\n";
				$log .=$this->email->print_debugger();
				$log .="\n";
				$file = 'logemail.txt';
 				$pathfile=APPPATH.'views/'.$file;
        		if(file_exists($pathfile)){
					$current = file_get_contents($pathfile);
					$current .= $log;
					$current .= "\r\n";
					file_put_contents($pathfile, $current);
				}else{
					$handle=fopen($pathfile, 'w') or die('Cannot open file:  '.$pathfile); //implicitly creates file
					fwrite($handle, $log);
				}
				return true;
			}else{ ?>
					<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
			<?php }
   		}else{
   			return false;
   		}

   	}

}
