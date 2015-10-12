<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Gudang extends CI_Controller{
	function __construct(){
		ob_start();
		date_default_timezone_set("Asia/Jakarta");
		parent::__construct();
		$this->load->library('session');
		$this->load->helper('kolom_helper');
		$this->load->library('form_validation');
		$config['allowed_types'] ='xls';
		$config['upload_path'] ='./temp_upload/';
		
		$this->load->library('upload', $config);
		$this->load->library('excel_reader'); 
		$this->load->library('Excel');//load PHPExcel library
		
		$this->load->helper('to_excel');
		$this->load->config('pdf_config');
        $this->load->library('fpdf');
        $this->load->library('PDF_Quotation');
        //$this->load->library('jquery');
        $this->load->library('javascript');
        $this->config->load('pagination');
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        
		/*
		ALTER TABLE table_name ADD column_name datatype
		*/
	}
	public function index(){
	   if(!$this->session->userdata('logged_in')){
     		//If no session, redirect to login page
     		redirect('login','refresh');
		}else{
		$session_data = $this->session->userdata('logged_in');
     	$this->load->view("templates/header");
   			$idu=$session_data['id'];
     		$jabatan=$session_data['jabatan'];
     		$arr_idm=$this->mweb->menudash($jabatan,$idu);	
     		$data['notifs']=$this->mweb->gettable_by_kol('iduser','notif',$idu);
     		$data['menu']=$this->mweb->get_menu($arr_idm);
			if (is_admin() || is_mimin() ){
				$data['antrian']=$this->mweb->gettable('antrian');
				$data['follap']=$this->mweb->Follup();
			}
			$this->load->view("templates/menu",$data);
			$this->load->view("pages/beranda",$data);
			$this->load->view("templates/footer");
   		}	
	}
	public function profile()
	{
		if(!$this->session->userdata('logged_in')){
     		//If no session, redirect to login page
     		redirect('login','refresh');
		}else{
			$session_data = $this->session->userdata('logged_in');
     		$idu=$session_data['id']; //$this->mweb->gettable_byid('iduser',$idu,'postprod');
     		$jabatan=$session_data['jabatan'];
     		$arr_idm=$this->mweb->menudash($jabatan,$idu);
     		$data['notifs']=$this->mweb->gettable_by_kol('iduser','notif',$idu);	
     		$data['menu']=$this->mweb->get_menu($arr_idm);
     		$data['website']=$this->mweb->gettable_byid('iduser',$idu,'website');
     		$data['postprod']=$this->mweb->gettable_byid('iduser',$idu,'postprod');
     		$data['reqbrg']=$this->mweb->gettable_byid('iduser',$idu,'request');
			$data['listcus']=$this->mweb->listcus($session_data['id']);
			$this->load->view("templates/header");
			$this->load->view("templates/menu",$data);
			$this->load->view("pages/profile",$data);
			$this->load->view("templates/footer",$data);
   		}

	}
	
	public function slug($m='',$page='4',$slug='')
	{
		if($this->session->userdata('logged_in')){
			$session_data = $this->session->userdata('logged_in');
			$jabatan=$session_data['jabatan'];
			$cekmng=cekurlid('manage','idmng');
			$cekmenu=cekurlid($jabatan,'idmenu');
			$cekact=cekurlid($jabatan,'idact');
     		if ((empty($m)) || (empty($page)) || (empty($slug)) || (strlen($m)===0) || (strlen($page)===0) || (strlen($slug)===0)) {
//param kosong     			   		
     			redirect(site_url('gudang'),'refresh');
     		}else if ((!in_array($slug, $cekmng)) || (!in_array($m, $cekmenu)) || (!in_array($page, $cekact))) {
     				echo('tidak terdaftar');
     		}elseif (($this->mweb->cekmngmenu($m,$slug)) || ((is_mimin()) || (is_admin()) && $m==='17' && $slug==='16')) {
     			

     			$data['curmenu']=$m;
				$data['idmnge']=$slug;
				$tabel=$this->mweb->getmanage_by_id($slug);	
     			$idu=$session_data['id'];
     			$arr_idm=$this->mweb->menudash($jabatan,$idu);
				$arr_idact=$this->mweb->get_cab($idu,$m,$jabatan);
				$page=$this->mweb->get_page($page);
				$data['kodeaksi']=$page;
				switch($slug){
					case '1':
						$exclude=array("idcus", "iduser","log");
						break;
					case '2':
						$exclude=array("idsupp");
						break;
					case '3':
						$exclude=array("kdbarang");
						break;
					case '5':
						$exclude=array("id","log");
						break;
					case '6':
						$excl_kol=array("id","idmng","waktu","idcus","idaksi","acc","sent");
						$wewlist=create_statement('tempbarang', $excl_kol);
						$data['koltempbrg']=explode(',',$wewlist);
						$exclude=array("iduser","acc","id","qty","disc","price","subtotal","amount","total","sent");
						break;
					case '7':
						$excl_kol=array("id","idmng","waktu","idcus","idaksi","acc","sent");
						$wewlist=create_statement('tempbarang', $excl_kol);
						$data['koltempbrg']=explode(',',$wewlist);
						$exclude=array("iduser","acc","id","qty","disc","price","subtotal","amount","total","sent");
						break;
					case '11':
						$excl_kol=array("id","idmng","waktu","idcus","idaksi","acc");
						$wewlist=create_statement('tempbarang', $excl_kol);
						$data['koltempbrg']=explode(',',$wewlist);
						$exclude=array('ids','subtotal','bayar','kdbarang');
						break;
					case '12':
						$excl_kol=array("id","idmng","waktu","idcus","idaksi","acc");
						$wewlist=create_statement('tempbarang', $excl_kol);
						$data['koltempbrg']=explode(',',$wewlist);
						$exclude=array('idbeli','time');
						break;
					case '13':
						$excl_kol=array("id","idmng","waktu","idcus","idaksi","acc");
						$wewlist=create_statement('tempbarang', $excl_kol);
						$data['koltempbrg']=explode(',',$wewlist);
						$exclude=array('idjual','time','iduser');
						break;
					case '16':
						$exclude=array('id','time');
						break;
					case '20':
						$exclude=array('id','time','status','iduser');
						break;
					default:
						$exclude=array("");
						break;
				}
				$stmt_list=create_statement($tabel, $exclude);
				$data['kol']=explode(',',$stmt_list);
				$data['kolom']=$this->db->list_fields($tabel);
				$data['idtbl']=$slug;
				$data['website']=$this->mweb->gettable_byid('iduser',$idu,'website');
				$data['idact']=$this->mweb->get_cab($idu,$m,$jabatan);
				$data['lmenu']=$this->mweb->gettable('menu');
				$data['action']=$this->mweb->get_action($arr_idact);
				$data['notifs']=$this->mweb->gettable_by_kol('iduser','notif',$idu);
     			$data['menu']=$this->mweb->get_menu($arr_idm,$data);
				$data['mng']=$this->mweb->getmenu();
				$data['cab']=$this->mweb->getjabatan();
				$data['kolom']=$this->db->list_fields($tabel);
				$dftrkol=$this->db->list_fields($tabel);
				$fkol=array_shift(array_slice($dftrkol, 0, 1));
				$wowo=$this->mweb->get_akhir($fkol,$tabel);
				$data['lastid']=intval($wowo);

//pagination
				if (isset($_GET['page'])) {
					$offset=htmlspecialchars($_GET['page']);
				}else{
					$offset=0;
				}
				$dfkol=$this->db->list_fields($tabel);
				$data['mng']=$slug;
				$data['fkolm']=array_shift(array_slice($dfkol, 0, 1));
				$num_rows=$this->db->count_all($tabel);
				$config['base_url'] = current_url().'?a';
				$config['total_rows'] = $num_rows;
				$config['per_page'] = 100;
				$this->pagination->initialize($config);
				switch ($tabel) {
					case 'notif':
						$dataq=$this->db->where('iduser',$idu)->get($tabel,$config['per_page'],$offset);
						break;
					case 'cus':
						$dataq=$this->db->where('iduser',$idu)->get($tabel,$config['per_page'],$offset);
						break;
					case 'invoice':
						if (is_admin() || is_mimin()) {
							$dataq=$this->db->get($tabel,$config['per_page'],$offset);	
						}else{
							$dataq=$this->db->where('iduser',$idu)->get($tabel,$config['per_page'],$offset);
						}
						break;
					case 'quotation':
					if (is_admin() || is_mimin()) {
						$dataq=$this->db->get($tabel,$config['per_page'],$offset);	
					}else{
						$dataq=$this->db->where('iduser',$idu)->get($tabel,$config['per_page'],$offset);
					}
						break;
					default:
						$dataq=$this->db->get($tabel,$config['per_page'],$offset);
						break;
				}
                $data['namatbl']=$tabel;
                $data['data']=$dataq->result_array();

//cara biasa	//$data['data']=$this->mweb->gettable($tabel);
				$this->load->view("templates/header");
				$this->load->view("templates/menu",$data);
				$this->load->view("pages/".$page,$data);
     			$this->load->view("templates/footer");


     		}else{
//ada semua
     			echo('not allowed');
			}
		}else{
     		redirect('login','refresh');
   		}
	}
 	function logout(){
   		$this->session->unset_userdata('logged_in');
   		$this->session->sess_destroy();
   		redirect('login', 'refresh');
 	}



//insert data



function insert(){
 	if($this->session->userdata('logged_in')){
 		$session_data = $this->session->userdata('logged_in');
		$idu=$session_data['id'];
 		$idtbl=$this->input->post('tabel');
 		$tabel=$this->mweb->getmanage_by_id($idtbl);
 		switch ($idtbl) {
 			case '1':
 				$exclude=array('user','log');
 				break;
 			case '6':
 				$exclude=array('acc');
 				break;
 			case '7':
 				$exclude=array('acc');
 				break;
 			case '15':
 				$exclude=array('idreq','idimg','desc');
 				break;
 			case '17':
 				$exclude=array('id');
 				break;
 			default:
 				$exclude=array('');
 				break;
 		}

		$stmt_list=create_statement($tabel,$exclude);
 		$query=explode(',',$stmt_list);
 		$data=array();
 		$kolom=array();
 		$ttempb=array();
 		$liskol=$this->db->list_fields($tabel);
		$fkolm=array_shift(array_slice($liskol, 0, 1));
		$lid=$this->mweb->get_akhir($fkolm,$tabel);
		$gettempb=$this->mweb->get_tempbrg($lid,$idtbl);
 		foreach($query as $row){
 			$kolom[]=$row;
 				switch ($row) {
 					case 'id':
 							$idnee=$this->input->post($row);
 							$idnee=$lid;
 							$data[]=$idnee;
 						break;
 					case 'time':
 						$data[]=date('d-m-Y h:i:s');
 						break;
 					case 'iduser':
 						$data[]=$session_data['id'];
 						break;
 					case 'Kenaikan_Harga':
 						$hbru=$this->input->post('Harga_Baru');
 						$hlma=$this->input->post('Harga_Lama');
 						if ((!empty($hbru)) && (!empty($hlma)) && ($hbru>$hlma)) {
 							$data[]=intval($hbru-$hlma);
 						}else{
 							$data[]=0;
 						}
 						break;
 					case 'Description':
 						$set=$this->input->post('set');
 						$nmprod=$this->input->post('namaprod');
 						if ((!empty($set)) && (!empty($nmprod))) {
 							$kdbl=$this->mweb->get_akhir('kdbarang','barang');
 							$this->db->set('a.status', 'success');
							$this->db->set('b.kdbarang', $kdbl);
							$this->db->where('a.idreq',$set);
							$this->db->where('a.idreq = b.idreq');
							$this->db->update('antrian as a, request as b');

 							$imm =$nmprod.'+';
 						$imm .=$this->input->post($row);
 							$data[]=$imm;
 						}else{
 							$data[]=$this->input->post($row);
 						}
 						break;
 					case 'kdbarang':
 						if ($tabel==='postprod') {
 							$data[]=$this->input->post($row);
 						}else{
 							$data[]=implode('|', $gettempb);
 						}
 						break;
 					default:
 						$data[]=$this->input->post($row); 					
 						break;
 				}
 		}

		$setdata=array_combine($kolom, $data);
		
		$idlastt=$this->mweb->settable($tabel,$setdata);
		$isi=implode(',',$data);
 		//-----------------------------------------
 		$file = 'log.txt';
 		$pathfile=APPPATH.'views/'.$file;
 		$tulislog=$session_data['id'].','.date('Y-m-d h:i:s').','.$tabel.','.$isi."\n";
        if(file_exists($pathfile)){
			$current = file_get_contents($pathfile);
			// Append a new person to the file
			$current .= $tulislog;
			$current .= "\r\n";
			// Write the contents back to the file
			file_put_contents($pathfile, $current);
		}else{
			$handle=fopen($pathfile, 'w') or die('Cannot open file:  '.$pathfile); //implicitly creates file

			fwrite($handle, $tulislog);
		}
	if ($idlastt) {
	switch($idtbl) {
			case '1':
			$this->db->where('idcus',$idlastt);
			$this->db->update('cus',array('iduser'=>$session_data['id']));
			break;
			case '3':
				$sett=$this->input->post('set');
				$kdbl=$this->mweb->get_akhir('kdbarang','barang');
 				if (getusereq($sett)){
 						$idpeng=getusereq($sett);
 						$notifh=array(
 							'from'=>$idu,
 							'iduser'=>$idpeng,
 							'msg'=>'request barang dengan kode <strong>'.$sett.
 							'</strong> success dengan harga jual Rp.<strong>'.gethrgbrg($idlastt).'</strong>'
 							,
 							'time'=>date('d-m-Y h:i:s')

 							);
						$settnotif=$this->mweb->settable('notif',$notifh); 					
						if (!$settnotif) { ?>
							<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
						<?php 
						redirect('login','refresh');
						}
				}
			break;
			case '5':
			$qqlast=$this->mweb->get_last_id($idlastt,$tabel);
			foreach ($qqlast as $record) {
				$pass=$record['password'];
			}
			$passbaru=sha1($pass);
			$this->mweb->updatepass($idlastt,$passbaru);
			break;
			case '15':
			$config['upload_path']=FCPATH.'uploads/';					
			$config['allowed_types'] = 'gif|jpg|png';
			//load the upload library
			
			$this->upload->initialize($config);
			$this->upload->set_allowed_types('*');
			$data['upload_data'] = '';
			//if not successful, set the error message
			if (!$this->upload->do_upload('userfile')){
					redirect(site_url('gudang/profile?tab=3&e=1'),'refresh');
			}else{ //else, set the success message
				//$idlastt=$this->mweb->last_id_ins('idreq','request');
				$data = array('msg' => "Upload success!");
				$dataimg=$this->upload->data();
				$postkdb=$this->input->post('kdbarang');
				$desck=$this->input->post('namaprod');
				if (empty($postkdb)) {
					$descc=$desck;
				}else{
					$descc=$this->input->post('kdbarang');
				}
				$dtimg = array(
							'idimg' =>'',
							'src'=>$dataimg['full_path'],
							'desc'=>$descc
							 );
						$set=$this->mweb->setimage($dtimg);
						$setupd=array(
							'idimg'=>$set,
							'desc'=>$desck
						);
						$this->db->where('idreq',$idlastt);
						$this->db->update('request',$setupd);
						$setantri = array(
							'idreq' =>$idlastt , 
							'time'=>date('d-m-Y h:i:s')
						);
						$idant=$this->mweb->settable('antrian',$setantri);
						if ($idant) {
							if (!is_mimin()) {
								$notifmin=array(
									'from'=>$idu,
									'iduser'=>getid_min(),
									'msg'=>'ada permintaan barang dengan kode <strong><a href="'.site_url('gudang/slug/17/4/21/a?id='.$idlastt.'&tbl=15').'">'.$idlastt.'</a></strong>',
									'aksi'=>'request',
									'time'=>date('d-m-Y h:i:s')
								);
								$this->mweb->settable('notif',$notifmin);
							}	
						}
			}
			break;
			case '6':
				if (!is_admin()) {
					$msginv=array(
						'from'=>$idu,
						'iduser'=>getid_own(),
						'aksi'=>'invoice',
						'time'=>date('d-m-Y h:i:s'),
						'msg'=>'invoice kode <a href="'.site_url('gudang/slug/5/4/6/a?id='.$idlastt.'&tbl=6').'"><strong>'.$idlastt.'</strong></a>'
					);
					$this->mweb->settable('notif',$msginv);
				}
				break;
			case '7':
				if (!is_admin()) {
					$msginv=array(
						'from'=>$idu,
						'iduser'=>getid_own(),
						'aksi'=>'quotation',
						'time'=>date('d-m-Y h:i:s'),
						'msg'=>'quotation kode <a href="'.site_url('gudang/slug/5/4/7/a?id='.$idlastt.'&tbl=7').'"><strong>'.$idlastt.'</strong></a>'
					);
					$this->mweb->settable('notif',$msginv);
				}
			break;
			case '16':
				$purc=$this->mweb->gettable_byid($fkolm,$idlastt,$tabel);
				if (count($purc) > 0) {
					foreach ($purc as $vpurc) {
						$lb=rtrim($vpurc['linkbeli']);
						$hb=rtrim($vpurc['hrg_beli']);
					}
					if((empty($lb)) && (empty($hb)) || ($hb==='0')){
						$this->db->where('id',$idlastt);
						$this->db->update('purchase',array('status'=>'p'));
					}else if ((strlen($lb) > 0) && (empty($hb)) || ($hb==='0')) {
						$this->db->where('id',$idlastt);
						$this->db->update('purchase',array('status'=>'w'));
					}else{
						$this->db->where('id',$idlastt);
						$this->db->update('purchase',array('status'=>'wp'));
					}
				}else{
					redirect('gudang?ep='.$idlastt,'refresh');
				}
				break;
		}
	redirect('gudang','refresh');
}else{
	redirect('gudang?e=i','refresh');
}



 		}else{
    	 //If no session, redirect to login page
     	redirect('login','refresh');
   		}

 	}






 	/*public function do_upload()
 	{
 		$f=$_REQUEST['f'];
 		$config['upload_path'] = './temp_upload/'; 
			$config['allowed_types'] ='gif|jpg|png';
			$this->load->library('upload', $config);  
		if(!$this->upload->do_upload()){
			$data = array('error' => $this->upload->display_errors());
		}else{             
			$data=array('error' => false); 
			$upload_data = $this->upload->data();             
			var_dump($upload_data);
		} 
		
 	}*/

 	
	
	function edit($idnya='',$idmng='',$kolid=''){
		if($this->session->userdata('logged_in')){
			$cekmng=cekurlid('manage','idmng');
     		if ((empty($idnya)) || (empty($idmng)) || (empty($kolid)) || (strlen($idnya)===0) || (strlen($idmng)===0) || (strlen($kolid)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     		}else if (!in_array($idmng, $cekmng)) {
     					echo('tidak terdaftar');
     		}else{
     			$tabel=$this->mweb->getmanage_by_id($idmng);
     			$listf=$this->db->list_fields($tabel);
     			$fkol=array_shift(array_slice($listf, 0, 1));
     			$cekurid=cekurlid($tabel,$fkol);
     			if (in_array($idnya, $cekurid)) {
//--ada--edit-------------------------------------------------------------------------------------------------------
				$session_data = $this->session->userdata('logged_in');
     			$idu=$session_data['id'];
     			$jabatan=$session_data['jabatan'];
     			$arr_idm=$this->mweb->menudash($jabatan,$idu);
     			$data['notifs']=$this->mweb->gettable_by_kol('iduser','notif',$idu);	
     			$data['menu']=$this->mweb->get_menu($arr_idm);
				$this->load->view("templates/header");
				$this->load->view("templates/menu",$data);
				$tabel=$this->mweb->getmanage_by_id($idmng);
				$data['namatbl']=$tabel;
				$data["idtbl"]=$idmng;
				switch ($idmng) {
				case '1':
					$exclude=array('iduser');
					break;
				case '6':
					$pathe=FCPATH.'uploads/'.$tabel.'-'.$idnya.'.pdf';
					if (file_exists($pathe)) {
						unlink($pathe);
					}
					$exclude=array('id','kdinv','iduser','acc');
					$idusere=$this->mweb->getusraksi($idnya,$idmng);
					$data['website']=$this->mweb->gettable_byid('iduser',$idusere,'website');
					break;
				case '7':
					$pathe=FCPATH.'uploads/'.$tabel.'-'.$idnya.'.pdf';
					if (file_exists($pathe)) {
						unlink($pathe);
					}
					$exclude=array('id','kdquo','iduser','acc');
					$idusere=$this->mweb->getusraksi($idnya,$idmng);
					$data['website']=$this->mweb->gettable_byid('iduser',$idusere,'website');
					break;
				case '5':
					$exclude=array('kdcapab','website');
					break;
				case '16':
					$exclude=array('idreq','time');
					break;
				case '18':
					$exclude=array('iduser');
					break;
				case '20':
					$exclude=array('time','status','iduser');
					break;
				default:
					$data['website']=$this->mweb->gettable_byid('iduser',$idu,'website');
					$exclude=array('');
					break;
			}
			$stmt_list=create_statement($tabel, $exclude);
			$data["kolom"]=explode(',',$stmt_list);
			$daftarkol=explode(',',$stmt_list);
			$data["fkolom"]=array_shift(array_slice($daftarkol, 0, 1));
			//$this->db->list_fields($tabel);
			$data['idtemp']=$this->mweb->get_idtempbrg($idnya);
			$dtprod=$this->mweb->gettable_by_kol($kolid,$tabel,$idnya);
			if ($idmng==7 || $idmng==6) {
				$tangkpnmp=array();
				foreach ($dtprod as $valdtprod) {
					$pisahnmp=explode('|', $valdtprod['produk']);
					$nmp=count($pisahnmp);
					for ($nmpr=0; $nmpr < $nmp; $nmpr++) { 
						$tangkpnmp[]=$this->mweb->get_Descriptionbyid($pisahnmp[$nmpr]);
					}
				}
			$data["nmprod"]=$tangkpnmp;
			}

			
			$data["urld"]=$idnya.','.$idmng.','.$kolid;
			$data["tabel"]=$this->mweb->gettable_by_kol($kolid,$tabel,$idnya);
			$this->load->view("pages/formedit",$data);
			$this->load->view("templates/footer");

//--ada--edit-------------------------------------------------------------------------------------------------------
     			}else{
     				echo('ga ada');
     			}
			}
		}else{
     		redirect('login','refresh');
   		}
	}


	
public function update(){
		if(!$this->session->userdata('logged_in')){
     		redirect('login','refresh');
		}else{
			$session_data = $this->session->userdata('logged_in');
			$idu=$session_data['id'];
			$idtbl=$this->input->post("idtabel");
			$tabel=$this->mweb->getmanage_by_id($idtbl);
			switch ($tabel) {
			case 'invoice':
				$exclude=array('iduser','kdinv','produk','qty','price','disc','subtotal','total','amount','acc');
				$stmt_list=create_statement($tabel, $exclude);
				$likol=explode(',', $stmt_list);
				break;
			case 'website':
				$exclude=array('iduser');
				$stmt_list=create_statement($tabel, $exclude);
				$likol=explode(',', $stmt_list);
				break;
			case 'cus':
				$exclude=array('user');
				$stmt_list=create_statement($tabel, $exclude);
				$likol=explode(',', $stmt_list);
				break;
			case 'user':
				$exclude=array('kdcapab','website');
				$stmt_list=create_statement($tabel, $exclude);
				$likol=explode(',', $stmt_list);
				break;
			case 'brosur':
				$exclude=array('time','status','iduser');
				$stmt_list=create_statement($tabel, $exclude);
				$likol=explode(',', $stmt_list);
				break;
			case 'quotation':
				$exclude=array('iduser','kdquo','produk','qty','price','disc','subtotal','total','amount','acc');
				$stmt_list=create_statement($tabel, $exclude);
				$likol=explode(',', $stmt_list);
				break;
			case 'purchase':
				$exclude=array('idreq');
				$stmt_list=create_statement($tabel, $exclude);
				$likol=explode(',', $stmt_list);
				break;
			default:
				$likol=$this->db->list_fields($tabel);
				break;
			}
			if (count($likol) > 0) {
				$fkol=array_shift(array_slice($likol, 0, 1));
				$idnye=$this->input->post($fkol);
				if(($kunci = array_search($fkol, $likol)) !== false) {
    					unset($likol[$kunci]);
				}
				foreach ($likol as $valkol) {
					switch ($valkol) {
						case 'time':
							$cekin=$this->input->post($valkol);
							if ($cekin) {
								$isi[]=$cekin;
							}else{
								$iniw=date('d-m-Y h:i:s');
								$cekin=$iniw;
								$isi[]=$cekin;
							}
							break;
						case 'password':
							$cekpass=$this->input->post($valkol);
							if ($cekpass) {
								$isi[]=$cekpass;
							}else{
								$detuser=getdetuser($idnye);
								foreach ($detuser as $vdetu) {
									$pwd=$vdetu['password'];
								}
								$cekpass=$pwd;
								$isi[]=$cekpass;
							}
							break;
						case 'idimg':
							$idimgny=$this->input->post($valkol);
							$config['upload_path']=FCPATH.'uploads/';					
							$config['allowed_types'] = 'gif|jpg|png';
							
							$this->upload->initialize($config);
							$this->upload->set_allowed_types('*');
							$data['upload_data'] = '';
							if (!$this->upload->do_upload('userfile')){
								redirect(site_url('gudang/profile?tab=3&e=1'),'refresh');
							}else{
								$data = array('msg' => "Upload success!");
								$dataimg=$this->upload->data();
								$postkdb=$this->input->post('kdbarang');
								$descc='brosur--'.getnamabrg($postkdb);
								$dtimg = array(
										'idimg' =>'',
										'src'=>$dataimg['full_path'],
										'desc'=>$descc
							 			);
								$set=$this->mweb->setimage($dtimg);
								if ($set) {
									$siu=getuserbrosur($idnye);
									$msgnot=array(
										'from'=>getid_design(),
										'iduser'=>$siu['iduser'],
										'msg'=>'brosur kode barang <a href="'.site_url('gudang/slug/2/4/3/a?id='.$siu['kdbarang'].'&tbl=3').'"><strong>'.$siu['kdbarang'].'</strong></a> berhasil dibuat :)',
										'time'=>date('d-m-Y h:i:s')
										);
									$this->mweb->settable('notif',$msgnot);
									if ($tabel==='brosur') {										
										$this->db->where('id',$idnye)
											->update('brosur',array('status'=>'s'));
									}
									$idimgny=$set;
									$isi[]=$idimgny;
								}
							}
							break;
							case 'iduser':
								$isi[]=$idu;
								break;
							case 'cust_telp':
								$intelp=$this->input->post($valkol);
								$idc=$this->input->post('idcus');
								if((is_null($intelp)) || (strlen($intelp)===0) || (empty($intelp))){
									$detcus=getdatacus($idc);
									$intelp=$detcus['telp'];
								}
								$isi[]=$intelp;
								break;
						default:
							$isi[]=$this->input->post($valkol);
							break;
					}
				}
				$larikdata=array_combine($likol, $isi);
				$cekupdate=$this->mweb->updatedata($tabel,$fkol,$idnye,$larikdata);	
				if ($cekupdate) {
					switch ($tabel) {
						case 'purchase':
							$purc=$this->mweb->gettable_byid($fkol,$idnye,$tabel);
							if (count($purc) > 0) {
								foreach ($purc as $vpurc) {
									$lb=rtrim($vpurc['linkbeli']);
									$hb=rtrim($vpurc['hrg_beli']);
								}
								if((empty($lb)) && ($hb==='0')){
									$this->db->where('id',$idnye);
									$this->db->update('purchase',array('status'=>'p'));
								}else if ((strlen($lb) > 0) && ($hb==='0')) {
									$this->db->where('id',$idnye);
									$this->db->update('purchase',array('status'=>'w'));
								}else{
									$this->db->where('id',$idnye);
									$this->db->update('purchase',array('status'=>'wp'));
								}
								redirect('gudang?m=success','refresh');
							}else{
								redirect('gudang?ep='.$idnye,'refresh');
							}
							break;
						default:
							redirect('gudang?m=success','refresh');
							break;
					}
				}else{
					redirect('login','refresh');
				}
			}
		}
	}



	function delete($isiid,$idtbll,$kollid){
		if($this->session->userdata('logged_in')){
     		$cekmng=cekurlid('manage','idmng');
     		if ((empty($kollid)) || (empty($idtbll)) || (empty($isiid)) || (strlen($kollid)===0) || (strlen($idtbll)===0) || (strlen($isiid)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     		}else if (!in_array($idtbll, $cekmng)) {
     				echo('tidak terdaftar');
     		}else{
     			$tabel=$this->mweb->getmanage_by_id($idtbll);
     			$listf=$this->db->list_fields($tabel);
     			$fkol=array_shift(array_slice($listf, 0, 1));
     			$cekurid=cekurlid($tabel,$fkol);
     			if (in_array($isiid, $cekurid)) {
//delete data------------------------------------
     	$session_data = $this->session->userdata('logged_in');
     	$idu=$session_data['id'];
		$tabel=$this->mweb->getmanage_by_id($idtbll);	
		if (is_admin()) {
			if ($tabel==='quotation' || $tabel==='invoice') {
				$this->mweb->hapuspus($isiid,'tempbarang','idaksi');
			}
			$this->mweb->hapuspus($isiid,$tabel,$kollid);

		}else{
			if ($tabel==='notif') {
				$this->mweb->hapuspus($isiid,$tabel,$kollid);
			}else{
							$temp = array(
				'iduser'=>$idu,
				'aksi' =>'delete', 
				'tabel'=>$tabel,
				'kd'=>$isiid,
				'kolid'=>$kollid
				);
			$this->mweb->tempdata($temp);
			}
		}
		$file = 'log.txt';
 				$pathfile=APPPATH.'views/'.$file;
 				$tulislog=$session_data['id'].','.date('Y-m-d h:i:s').', delete Data <b>'.$tabel.'</b> , id=<b>'.$kollid.'</b>';
        		if(file_exists($pathfile)){
				$current = file_get_contents($pathfile);
					$current .= $tulislog;
					$current .= "\r\n";
					file_put_contents($pathfile, $current);
		}?>
			<script type="text/javascript">alert("data berhasil di delete :)");</script>
		<?php 	redirect('login','refresh');
//----end-del------------------------------------
     			}else{
     				echo('ga ada');
     			}
     		}
		}else{
     		redirect('login','refresh');
   		}
	}
	function selectauto(){
		$data['idcus']=$this->mweb->get_id_cus();
		$data['namacus']=$this->mweb->get_name_cus();
		$this->load->view('selectauto',$data);
	}


	/*function accept_inv($kdnya,$qlast)
	{
		$dataupd=array(
				'status'=>'1',
				'ket'=>'sudah dibaca'
			);		
		$this->mweb->updatestts_brg($kdnya,$qlast,$dataupd);

		//redirect('login','refresh');	
	}*/

	
	function createpdf($idtbl,$iddata,$idu){
			$cekmng=cekurlid('manage','idmng');
     		if ((empty($idtbl)) || (empty($iddata)) || (strlen($idtbl)===0) || (strlen($iddata)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     		}else if (!in_array($idtbl, $cekmng)) {
     					echo('tidak terdaftar');
     		}else{
     			$tabel=$this->mweb->getmanage_by_id($idtbl);
     			$listf=$this->db->list_fields($tabel);
     			$fkol=array_shift(array_slice($listf, 0, 1));
     			$cekurid=cekurlid($tabel,$fkol);
     			if (in_array($iddata, $cekurid)) {

//--pdf-----------------------------------------------------------------------------

$result=$this->mweb->get_tabelandid($tabel,$iddata);
	$kolom=$this->db->list_fields($tabel);
	foreach ($result as $isidata) {
		foreach ($kolom as $kol) {
			switch ($kol){
				case 'id':
					$id=$isidata[$kol];	
					break;
				case 'kdquo':
					$kdquo=$isidata[$kol];	
					break;
				case 'iduser':
					$iduser=$isidata[$kol];
					break;
				case 'tgl':
					$tgl=$isidata[$kol];	
					break;
				case 'idcus':
					$idcus=$isidata[$kol];
					$qcuss=$this->mweb->getcus_byid($idcus);
					foreach ($qcuss as $isicus) {
						$namacuss=$isicus['nama'];
						$kota=$isicus['kota'];

					}
					break;
				case 'address':
					$address=$isidata[$kol];	
					break;
				case 'attn':
					$attn=$isidata[$kol];	
					break;
				case 'cc':
					$cc=$isidata[$kol];	
					break;
				case 'telp':
					$telp=$isidata[$kol];	
					break;
				case 'fax':
					$fax=$isidata[$kol];	
					break;
				case 'email':
					$email=$isidata[$kol];	
					break;
				case 'produk':
					$produk=$isidata[$kol];	
					break;
				case 'Model':
					$model=$isidata[$kol];	
					break;
				case 'qty':
					$qty=$isidata[$kol];	
					break;
				case 'disc':
					$disc=$isidata[$kol];	
					break;
				case 'price':
					$price=$isidata[$kol];	
					break;
				case 'subtotal':
					$subtotal=$isidata[$kol];	
					break;
				case 'amount':
					$amount=$isidata[$kol];	
					break;
				case 'total':
					$total=$isidata[$kol];	
					break;
				case 'kdinv':
					$kdinv=$isidata[$kol];	
					break;
				case 'ship_method':
					$ship_method=$isidata[$kol];	
					break;
				case 'pay_stat':
					$pay_stat=$isidata[$kol];	
					break;
				case 'note_pay':
					$note_pay=$isidata[$kol];	
					break;
				case 'cust_address':
					$cust_address=$isidata[$kol];	
					break;
				case 'cust_telp':
					$cust_telp=$isidata[$kol];	
					break;
				case 'bill_name':
					$bill_name=$isidata[$kol];	
					break;
				case 'bill_address':
					$bill_address=$isidata[$kol];	
					break;
				case 'bill_telp':
					$bill_telp=$isidata[$kol];	
					break;
				case 'ship_name':
					$ship_name=$isidata[$kol];	
					break;
				case 'ship_address':
					$ship_address=$isidata[$kol];	
					break;
				case 'ship_telp':
					$ship_telp=$isidata[$kol];	
					break;
				case 'ship_cost':
					$ship_cost=$isidata[$kol];	
					break;
				case 'pay_method':
					$pay_method=$isidata[$kol];	
					break;
				case 'catatan':
					$catatan=$isidata[$kol];	
					break;
				case 'website':
					$website=geturlweb($isidata[$kol]);
					break;
				case 'total':
					$total=$isidata[$kol];
					break;
				default:
					$isidata[$kol];	
					break;
			}
			
		}
	}
	$detailu=getdetuser($idu);
	foreach ($detailu as $valur) {
		$namaur=$valur['nama'];$telpur=$valur['telp'];
		$nohpur=$valur['nohp'];$pinbbur=$valur['pinbb'];
		$ttdur=$valur['ttd'];
	}
	$pdf = new PDF_Quotation( 'P', 'mm', 'A4' );
	$pdf->cMargin = 0;
	$pdf->AddPage();
	$pdf->cMargin = 0;
	switch ($tabel) {
		case 'invoice':
    		
			$pdf->Header(); 
			$pdf->jdlinv();
			$pdf->Line(15,32,200,32);
			$pdf->lefttopinv();
			$pdf->Kdinv($kdinv);
			
			$pdf->rsideinv($tgl,$pay_method,$ship_method,$pay_stat,$note_pay);
			$pdf->jdl_cusside();
			$pdf->isi_cusside((!empty($namacuss))? $namacuss : $namacuss='-',$cust_address,(!empty($kota))? $kota : $kota='-',(!empty($cust_telp))? $cust_telp : $cust_telp='-');
			$pdf->jdl_billside();
			$pdf->isi_billside((!empty($bill_name))? $bill_name : $bill_name='-',(!empty($bill_address))? $bill_address : $bill_address='-',(!empty($bill_telp))? $bill_telp : $bill_telp='-');
			$pdf->jdl_shipside();
			$pdf->isi_shipside((!empty($ship_name))? $ship_name : $ship_name='-',(!empty($ship_address))? $ship_address : $ship_address='-',(!empty($ship_telp))? $ship_telp : $ship_telp='-');
			$pdf->Ln(15);
			$kdbrgg=explode('|', $produk);
			$jml=explode('|', $qty);
			$hrg=explode('|', $price);
			$potong=explode('|', $disc);
			$subhrg=explode('|', $subtotal);
			$n=count($kdbrgg);
			//SetFillColor(int r [, int g, int b])
			//$pdf->theadinv();
			$pdf->SetX(14);
			$html ='<table border="1">';
			$html .='<tr><td width="348" align="center"><b> Product</b></td>';
			$html .='<td width="28"><b> Qty </b></td>';
			$html .='<td width="140"><b>  Unit Price </b></td>';
			$html .='<td width="40"><b>  disc </b></td>';
			$html .='<td width="160"><b>  Subtotal</b></td>';
			$html .='</tr></table>';

			$pdf->WriteHTML($html);
			for ($i=0; $i < $n; $i++){ 

				$pdf->SetX(14);
				$nmmbrg=$this->mweb->get_Descriptionbyid($kdbrgg[$i]);
				$pdf->Cell(87,7,'  '.$nmmbrg,1,0,'L');
				$pdf->Cell(7,7,$jml[$i],1,0,'C');
				$pdf->Cell(35,7,$hrg[$i],1,0,'C');
				$pdf->Cell(10,7,$potong[$i],1,0,'C');
				$pdf->Cell(40,7,$subhrg[$i].' ',1,0,'R');
				$pdf->Ln();
			}
			$pdf->totalinv($total);
			break;
		case 'quotation':
			$pdf->addlogo("");
			$pdf->addjvm("");
			($idtbl=='7') ? $titlle="QUOTATION " : $titlle="INVOICE ";
			$pdf->fact_dev( $titlle , " ");
			$pdf->temporaire( "CV. Java Multi Mandiri" );
			$pdf->descr("");
			$pdf->addHeadAlamat(": Jl. Raya Baturaden Timur KM 7 No. 17 Rempoah, Baturaden - Jawa Tengah - 53100");
			$pdf->addHeadTelp(": 0281-6572222 / 0281-6572606, Email : info@jvm.co.id, Website : http://www.jvm.co.id");
			$pdf->addTabelDate($tgl); 
			$pdf->addTabelAttn((!empty($attn))? $attn : $attn='-'); 
			$pdf->addTabelQuNo($kdquo); 
			$pdf->addTabelCc("-"); // cc
			$pdf->addTabelTo((!empty($namacuss))? $namacuss : $namacuss='-' ); //penerima
			$pdf->addTabelTelp((!empty($telp))? $telp : $telp='-'); // telp
			$pdf->addTabelAddress(); //alamat
			$pdf->addressisi((!empty($address))? $address : $address='-'); //alamat
			$pdf->addTabelFaks((!empty($fax))? $fax : $fax='-'); // faks
			$pdf->addEmail((!empty($email))? $email : $email='-'); // email
			$pdf->AddWeAre("");
			$pdf->Ln();
			$pdf->Ln();
			$kdbrgg=explode('|', $produk);
			$jml=explode('|', $qty);
			$hrg=explode('|', $price);
			$potong=explode('|', $disc);
			$subhrg=explode('|', $subtotal);
			$n=count($kdbrgg);
			//SetFillColor(int r [, int g, int b])
			//$pdf->theadinv();
			$pdf->SetX(14);
			$html ='<table border="1">';
			$html .='<tr><td width="360"><b> Product </b></td>';
			$html .='<td width="48"><b> Qty </b></td>';
			$html .='<td width="140"><b> Unit Price </b></td>';
			$html .='<td width="48"><b> Disc </b></td>';
			$html .='<td width="140"><b> Subtotal </b></td>';
			$html .='</tr></table>';
			$pdf->WriteHTML($html);
			for ($i=0; $i < $n; $i++){ 

				$pdf->SetX(14);
				$nmmbrg=$this->mweb->get_Descriptionbyid($kdbrgg[$i]);
				$pdf->Cell(90,7,' '.$nmmbrg,1,0,'L');
				$pdf->Cell(12,7,' '.$jml[$i],1,0,'C');
				$pdf->Cell(35,7,' '.$hrg[$i],1,0,'C');
				$pdf->Cell(12,7,' '.$potong[$i],1,0,'C');
				$pdf->Cell(35,7,' '.$subhrg[$i],1,0,'R');
				$pdf->Ln();
			}
			$pdf->addGrandTotal(array_sum($subhrg));
			$pdf->addExVAT("");
			$pdf->addPriceStok("");
			$pdf->addTerm("DP 50% with order balances 50% before delivery (Full Amount)");
			$pdf->addDeliv("1 Day After Payment"); // bisa ganti
			$pdf->addwarranty("");
			$pdf->addwarrantyy("1st Month (Replacement)");
			$pdf->addwarrantyyy("12nd Month (Repair / Service Hardware & Software)");
				break;
		default:
			$pdf->Cell(40,5,"No Result !",0,0,'L');
			break;
	}
	

	$pdf->addBank("");
	$pdf->addBCA("");
	$pdf->addMDR("");
	$pdf->addBNI("");
	if ($tabel=='quotation') {
		$pdf->addThk("");
		if ((empty($ttdur)) || (strlen($ttdur)===0) || ($ttdur==='0')) {
			$src='asset/img/ttd.jpg';
		}else{
			$path=geturl_img($ttdur);
			$src=substr($path, 21);
		}
		$pdf->addttd($src);
		$pdf->addstamp("");
		$pdf->addCv("");
		if ((empty($namaur)) || (empty($nohpur)) || (empty($pinbbur))) {
			$pdf->addFootTelp("Eka Setiawati Irawan", "0281-5755222/087837160608/Pin BB 29433756");
		}else{
			$pdf->addFootTelp($namaur, $telpur."/".$nohpur."/Pin BB ".$pinbbur); 
		}
	}
	$detuser=getdetuser($iduser);
	if (($detuser)) {
		foreach ($detuser as $valuser) {
			$namau=$valuser['nama'];
			$pinbbu=$valuser['pinbb'];
			$emailu=$valuser['email'];
			$nohpu=$valuser['nohp'];
		}
	}else{
		$detown=getdetuser(1);
		foreach ($detown as $valuser) {
			$namau=$valuser['nama'];
			$pinbbu=$valuser['pinbb'];
			$emailu=$valuser['email'];
			$nohpu=$valuser['nohp'];
		}
	}
	$pdf->SetXY(15,235);
	$pdf->SetFont('Arial','B',14);
	$pdf->WriteHTML("<a  href='".$website."'>".$website."</a>");
	//$pdf->Contactus($namau,$pinbbu,$emailu,$nohpu);
	$pdf->hcatatn();
	$pdf->catatan($catatan);
	$pdf->Output();


//--pdf-----------------------------------------------------------------------------
     				echo('ada');
     			}else{
     				echo('tidak ada');
     			}
     		}

	}	
//------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
//phpexcel
	public function createxls($idtbl){
			if ($this->session->userdata('logged_in')){
				$cekmng=cekurlid('manage','idmng');
     			if ((empty($idtbl)) || (strlen($idtbl)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     			}else if (!in_array($idtbl, $cekmng)) {
     					echo('tidak terdaftar');
     			}else{
     				$session_data = $this->session->userdata('logged_in');
//export-xls----------------------------------------------------------------------

$tabel=$this->mweb->getmanage_by_id($idtbl);
		// Create new PHPExcel object  
		$objPHPExcel = new PHPExcel();  
		// Set document properties  
		$filename='Laporan_'.$tabel;
		$objPHPExcel->getProperties()->setCreator($session_data['username'])  
        	->setLastModifiedBy($session_data['username'])  
        	->setTitle('Office 2007 XLSX '.$tabel.' Document')  
        	->setSubject('Office 2007 XLSX '.$tabel.' Document')  
        	->setDescription($tabel.' document for Office 2007 XLSX, generated by PHP classes')  
        	->setKeywords("office 2007 openxml php")  
        	->setCategory('Laporan data'.$tabel);  
			
			$databrg=$this->mweb->gettable($tabel);
			$kolbrg=$this->db->list_fields($tabel);
			$alfa='A';
			foreach ($kolbrg as $kolomxls){
					$objPHPExcel->setActiveSheetIndex(0)->setCellValue($alfa.'1', $kolomxls);  
					$alfa++;
			}
			$jml=count($databrg);
			$jmlkol=count($kolbrg);
			$row = 0; // 1-based index
			for ($i=0; $i < $jmlkol; $i++) { 
				$col = 2;
				foreach ($databrg as $isinya) {
					$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($row,$col,$isinya[$kolbrg[$i]]);
					//var_dump($row."|".$col."|");
					$col++;
				}
				$row++;
			}
   			// Rename worksheet (worksheet, not filename)  
			$objPHPExcel->getActiveSheet()->setTitle('Sheet data '.$tabel);  
			// Set active sheet index to the first sheet, so Excel opens this as the first sheet  
			$objPHPExcel->setActiveSheetIndex(0);  
			// Redirect output to a client's web browser (Excel2007)  
			//clean the output buffer  
			ob_end_clean();  
			//this is the header given from PHPExcel examples.   
			//but the output seems somewhat corrupted in some cases.  
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');  
			//so, we use this header instead.  
			header('Content-type: application/vnd.ms-excel');  
			header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');  
			header('Cache-Control: max-age=0');  
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');  
			$objWriter->save('php://output');
				$file = 'log.txt';
 				$pathfile=APPPATH.'views/'.$file;
 				$tulislog=$session_data['id'].','.date('Y-m-d h:i:s').', Export Data <b>'.$tabel.'</b>';
        		if(file_exists($pathfile)){
				$current = file_get_contents($pathfile);
					$current .= $tulislog;
					$current .= "\r\n";
					file_put_contents($pathfile, $current);
		 		}


//export-xls----------------------------------------------------------------------
		 			redirect(site_url('gudang'),'refresh');
     			}
			}else{
     			redirect('login','refresh');
   			}
    }
   


public function readexcel($idtbl)
    {
    		if ($this->session->userdata('logged_in')){
				$cekmng=cekurlid('manage','idmng');
     			if ((empty($idtbl)) || (strlen($idtbl)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     			}else if (!in_array($idtbl, $cekmng)) {
     					echo('tidak terdaftar');
     			}else{
//import-----------------------------------------------------------------------------------------
					if (empty($_FILES['userfile']['name'])){ ?>
						<script type="text/javascript">alert('tolong upload filenya ');</script>
						<?php
						redirect('login','refresh');
     				}else{
     					    $session_data = $this->session->userdata('logged_in');
     					    $idu=$session_data['id'];
    						$tabel=$this->mweb->getmanage_by_id($idtbl);
 							$target_path=APPPATH.'file_temp/';
							$target_path=$target_path.basename($_FILES['userfile']['name']);
							$filetype = pathinfo($target_path,PATHINFO_EXTENSION);
						if ($filetype=='xlsx' || $filetype=='xls') {
							$objPHPExcel = new PHPExcel();  
							$objReader = PHPExcel_IOFactory::createReader('Excel2007');
							$objReader->setReadDataOnly(true);
							$objPHPExcel = $objReader->load($_FILES['userfile']['tmp_name']);
							$objWorksheet = $objPHPExcel->getActiveSheet();
							$bariss=array();$koolom=array();
							$highestcoll=$objWorksheet->getHighestColumn();
							$highestRow = $objWorksheet->getHighestRow(); 
							$hcoll=toNum(strtolower($highestcoll))+1;
							for ($i=1; $i <= $highestRow; $i++) { 
									$row=$objWorksheet->getRowIterator($i)->current();
									$cellIterator = $row->getCellIterator();
									$cellIterator->setIterateOnlyExistingCells(false);
									$isi=0;
									if ($i==1) {
										foreach($cellIterator as $cell){
    										$koolom[]=preg_replace('/\s+/','_',$cell->getValue());
										}
									}else{
										foreach($cellIterator as $cell){
											$isi++;
												if ($isi==$hcoll) {
													$bariss[]=$cell->getValue()."#";
												}else{
													$bariss[]=$cell->getValue();
												}
										}
									}
							}
							switch ($tabel) {
								case 'barang':
									$exclude=array('kdbarang');
									break;
								case 'cus':
									$exclude=array('idcus');
									break;
								case 'supplier':
									$exclude=array('idsupp');
									break;
								default:
									$exclude=array();
									break;
							}
							$stmt_list=create_statement($tabel, $exclude);
							$kolomdb=explode(',',$stmt_list);
							$per=implode("^", $bariss);
							$arrDelimiters = array('#,','#');
							$uniformText = str_replace($arrDelimiters, "-|-", $per);
							$arrdata= explode("-|-", $uniformText);
							$jmlkoll=count($koolom);
							$listkolex=array_diff($koolom,array(''));
							$harusadd=array_diff($listkolex,$kolomdb);
							if (count($harusadd) > 0) {
								foreach ($harusadd as $k => $valadd) {
									$rtrimstr=rtrim($valadd);
									if (!empty($rtrimstr)) {
										$hrsadd=preg_replace('/\s+/', '_', $valadd);
										$this->db->query('ALTER TABLE '.$tabel.' ADD '.$hrsadd.' varchar(100)');
									}else{
										?>
											<script type="text/javascript">alert("kolom pada excel tidak boleh kosong !");</script>;
										<?php 
										redirect(site_url('gudang'),'refresh');
									}
								}
							}
							$jmlbaris=count($arrdata);
							for ($y=0; $y < $jmlbaris ; $y++) { 
								$isidata=explode("^", $arrdata[$y]);
								$isiasli=array_diff($isidata,array(''));
								if ($tabel==='cus') {
									array_push($kolomdb, 'iduser');
									array_push($isiasli, $idu);
								}
								$nb=count($isiasli);$nk=count($kolomdb);
								$datanya='';
								if ($nb===$nk) {
									$datanya=array_combine($kolomdb,$isiasli);
								}
								if (!empty($datanya)) {
									$this->mweb->settable($tabel,$datanya);
								}
							} ?>
								<script type="text/javascript">alert("import data berhasil :)");</script>;
							<?php 	
								redirect(site_url('gudang'),'refresh');
						}else{ ?>
							<script type="text/javascript">alert("silahkan import file yang berextensi xlsx atau xls");</script>;
						<?php 	
							redirect(site_url('gudang'),'refresh');
						}
					}

//import-----------------------------------------------------------------------------------------
     			}
			}else{
    	 		//If no session, redirect to login page
     			redirect('login','refresh');
   			}		
    }



    public function get_namacus()
    	{
    		
    		$query=$this->mweb->get_name_cus();
    		$idcuss=$this->mweb->get_id_cus();
    		// get the q parameter from URL
    		$q = $_REQUEST["q"];
    		$hint = "";
    		if ($q !== "") {
    			$q = strtolower($q);
    			$len=strlen($q);
    			$jmlr=count($query);
    			$similar=array();
    			for ($rr=0; $rr < $jmlr; $rr++) { 
    				if (stristr($q, substr($query[$rr], 0, $len))) {
                		$similar[]=$query[$rr].','.$idcuss[$rr];
            			$hint =implode(',', $similar);
            		
        			}
    			}
    		}
    		if($hint==="") {
    			echo "no suggestion";
    		}else{
    			echo '<ul id="hasilul">';
    			foreach ($similar as $value) { 
    				echo '<li >';
    				$pisah=explode(',', $value);
    				echo '<a href="'.$pisah[1].'" onclick="return doalert(this);">'.$pisah[0].'</a>';
    				echo '</li>';
    		}
    			echo '</ul>';
    		}
    	}
    	public function getproduk()
    	{
    		if(!$this->session->userdata('logged_in')){
     		//If no session, redirect to login page
     		redirect('login','refresh');
		}else{
			$session_data = $this->session->userdata('logged_in');
     		$idu=$session_data['id']; //
			$query=$this->mweb->get_Description();
			$idbrg=$this->mweb->get_kodebrg();
			$p =htmlspecialchars($_REQUEST["p"]);
    		$hint = "";
    		if ($p !== "") {
    			$p = strtolower($p);
    			$len=strlen($p);
    			$jmlr=count($query);
    			$similar=array();
    			for ($rr=0; $rr < $jmlr; $rr++) { 
    				if (stristr($p, substr($query[$rr], 0, $len))) {
                		$similar[]=$query[$rr].'|'.$idbrg[$rr];
            			$hint =implode('|', $similar);
            		
        			}
    			}
    		}
    		if($hint==="") {
    			echo "no suggestion";
    		}else{
    			echo '<ul id="hasilbrg">';
    			foreach ($similar as $value) { 
    				echo '<li >';
    				$pisah=explode('|', $value);
    				echo '<a href="'.$pisah[1].'" onclick="return detailprod(this);">'.$pisah[0].'</a>';
    				echo '</li>';
    		}
    			echo '</ul>';
    		}
    	}
    	}
    	public function setemail($id,$idtbl)
    	{
    		if($this->session->userdata('logged_in')){
    			$cekmng=cekurlid('manage','idmng');
     			if ((empty($idtbl)) || (empty($id)) || (strlen($idtbl)===0) || (strlen($id)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     			}else if (!in_array($idtbl, $cekmng)) {
     					echo('tidak terdaftar');
     			}else{
					
     				$tabel=$this->mweb->getmanage_by_id($idtbl);
     				$listf=$this->db->list_fields($tabel);
     				$fkol=array_shift(array_slice($listf, 0, 1));
     				$cekurid=cekurlid($tabel,$fkol);
     				if (in_array($id, $cekurid)) {
//sendemail------------------------------------------------------------------------------------
					$isine=$this->mweb->gettable($tabel);
					$e='firmawaneiwan@gmail.com';
					foreach($isine as $valisine){
							switch($tabel){
								case 'invoice':
									$listprod=explode('|', $valisine['produk']);
									$e=$valisine['email'];
									$s='Invoice kode '.$valisine['kdinv'];
									$cusee=$this->mweb->getcusaksi($id,$idtbl);
									$m ='<html><head></head>
									<body>
									Yth. Bapak/Ibu '.getnamacus($cusee);
									$m .="<br/>berikut kami lampirkan penagihan produk, di antaranya : \n";
									$m .='<ul>';
									$cpd=count($listprod);
									$no=1;
									for ($pd=0; $pd < $cpd; $pd++) { 
										$m .='<li>'.$no.' '.getnamabrg($listprod[$pd]).'</li>';
										$no++;
									}
									$m .='</ul></body></html>';
								break;
								case 'quotation';
									$e=$valisine['email'];
									$s='Quotation kode '.$valisine['kdquo'];
									$listprod=explode('|', $valisine['produk']);
									$cusee=$this->mweb->getcusaksi($id,$idtbl);
									// Always set content-type when sending HTML email
									$m ='<html><head></head>
									<body>
									Yth. Bapak/Ibu '.getnamacus($cusee);
									$m .="<br/>berikut kami lampirkan penagihan produk,di antaranya : 
									";
									$m .='<ul>';
									$cpd=count($listprod);
									$no=1;
									for ($pd=0; $pd < $cpd; $pd++) { 
										$m .='<li>'.$no.' '.getnamabrg($listprod[$pd]).'</li>';
										$no++;
									}
									$m .='</ul></body></html>';
								break;
								default:
								$m='salah';
								$s='no subject';
								break;
							}
					}
					$idur=$this->mweb->getusraksi($id,$idtbl);
					$this->sendEmail($e,$s,$m,$idtbl,$id,$idur);
					///echo('proses kirim ke user');
					//
					//kirimemail_att($id,$tabel,$email);
					//redirect('login','refresh');


//sendemail------------------------------------------------------------------------------------
     				}else{
     					echo('tidak ada');
     				}
     			}
     			
    		}else{
     			redirect('login','refresh');
   			}
    	}
    
    	
    	public function getkeyword($kol,$tb)
    	{
    		$tabel=$this->mweb->getmanage_by_id($tb);
    		$likol=$this->db->list_fields($tabel);
			$fkol=array_shift(array_slice($likol, 0, 1));
    		$query=$this->mweb->getdatabykol($tabel,$kol);
    		$q=htmlspecialchars($_REQUEST['kw']);
			if (count($query)!==0) {
    			$len=strlen($q);
    			$jmlr=count($query);
    			$similar=array();
    			$pk=array();
    			for ($rr=0; $rr < $jmlr; $rr++) { 
    				if (stristr($q, substr($query[$rr], 0, $len))) {
    					$pk[]=$query[$rr-1];
                		$similar[]=$query[$rr];
        			}
    			}
			}
			if (count($similar)===0) {
				echo('no suggestion');
			}else{ ?>
			<table class="table table-bordered">
				<thead>
					<td>Aksi</td>
					<td>hasil cari</td>
				</thead>
				<tbody>
				<?php 
				$nu=count($similar);
				for ($u=0; $u < $nu; $u++) { ?>
										<tr>
						<td>
							<a href="<?php echo(site_url('gudang/edit/'.$pk[$u].'/'.$tb.'/'.$fkol));?>">edit</a> || <a href="<?php echo(site_url('gudang/delete/'.$pk[$u].'/'.$tb.'/'.$fkol));?>">delete</a>
						</td>		
						<td>
							<?php 
							echo($similar[$u]);
							?>
						</td>
					</tr>
				<?php }?>
				</tbody>
				</table>
			<?php }
    	}
    	public function getuser()
    	{
    		$query=$this->mweb->get_uname_user();
    		$idu=$this->mweb->get_id_user();
    		// get the q parameter from URL
    		$q = $_REQUEST["q"];
    		$hint = "";
    		if ($q !== "") {
    			$q = strtolower($q);
    			$len=strlen($q);
    			$jmlr=count($query);
    			$similar=array();
    			for ($rr=0; $rr < $jmlr; $rr++) { 
    				if (stristr($q, substr($query[$rr], 0, $len))) {
                		$similar[]=$query[$rr].','.$idu[$rr];
            			$hint =implode(',', $similar);
            		
        			}
    			}
    		}
    		if($hint==="") {
    			echo "no suggestion";
    		}else{
    			echo '<ul id="hasilul">';
    			foreach ($similar as $value) { 
    				echo '<li >';
    				$pisah=explode(',', $value);
    				echo '<a href="'.$pisah[1].'" onclick="return doalert(this);">'.$pisah[0].'</a>';
    				echo '</li>';
    		}
    			echo '</ul>';

    		}
    	}
    	
    	public function deltempdata($kd,$table)
    	{
    		if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
     			$cekmng=cekurlid('manage','table');
     			if ((empty($table)) || (empty($kd)) || (strlen($table)===0) || (strlen($kd)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     			}else if (!in_array($table, $cekmng)) {
     					echo('tidak terdaftar');
     			}else{
     				$listf=$this->db->list_fields($table);
     				$fkol=array_shift(array_slice($listf, 0, 1));
     				$cekurid=cekurlid($table,$fkol);
     				if (in_array($kd, $cekurid)) {
//deltempdata----------------------------------------------------------------------------------------

                $session_data = $this->session->userdata('logged_in');
                $idu=$session_data['id'];
    			$query=$this->db->get_where('temp_data',array('kd'=>$kd,'tabel'=>$table));
    			if ($query->num_rows===0) {
    				return false;
    			}else{
    				foreach ($query->result() as $value) {
					switch ($value->aksi) {
    					case 'update':
    					$query=$this->db->query("UPDATE ".$value->tabel." set ".$value->set." WHERE ".$value->kolid."='".$value->kd."'");
    					if ($query) {
    						$dnotif = array(
    							'from'=>$idu,
    							'iduser' => $value->iduser,
    							'msg'=>'selamat :) , update data '.$value->tabel.' dengan kode =<b>'.$value->kd.'</b> berhasil diterima admin',
    							'time'=>date('d-m-Y h:i:s')
    						 );
    						$this->mweb->settable('notif',$dnotif);
    						$idtemp=$this->db->affected_rows();
    						$this->db->delete('temp_data',array('id'=>$idtemp));
    					 ?>
    						<script type="text/javascript"> alert("data berhasil update ,terima kasih");</script>
    					<?php 
    				redirect('login','refresh');				
    					}else{?>
    						<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
    					<?php }
  	 					break;
    				case 'delete':
    					$qdel=$this->mweb->hapuspus($value->kd,$value->tabel,$value->kolid);
    					if ($qdel===NULL){
								if ($value->tabel==='quotation' || $value->tabel==='invoice') {
									$this->mweb->hapuspus($value->kd,'tempbarang','idaksi');
								}
								$dnotif = array(
								'from'=>$idu,
    							'iduser' => $value->iduser,
    							'msg'=>'selamat :) , delete data '.$value->tabel.' dengan kode =<b>'.$value->kd.'</b> berhasil diterima admin',
    							'time'=>date('d-m-Y h:i:s')
    						 );
    						$this->mweb->settable('notif',$dnotif);
							$idtemp=$this->db->affected_rows();
    						$this->db->delete('temp_data',array('id'=>$idtemp)); ?>
    						<script type="text/javascript"> alert("data berhasil terhapus ,terima kasih");</script>
    					<?php 
    					redirect('login','refresh');
    					}else{?>
    						<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
    					<?php } 	
    					break;
    				default:
    					redirect('login','refresh');	
    					break;
    				}
    			}
    		}


//deltempdata------------------------------------------------------------------------------------------
	     			}else{
    	 				echo('tidak ada');
     				}
     			}
    		}
    	}
    	public function deltdata($id,$tabel)
    	{
			if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{	
			$session_data = $this->session->userdata('logged_in');
			$idu=$session_data['id'];
				if (is_admin()) {
					$cekmng=cekurlid('manage','table');
     				if ((empty($tabel)) || (empty($id)) || (strlen($tabel)===0) || (strlen($id)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     				}else if (!in_array($tabel, $cekmng)) {
     					echo('tidak terdaftar');
     				}else{
	     				$listf=$this->db->list_fields($tabel);
     					$fkol=array_shift(array_slice($listf, 0, 1));
     					$cekurid=cekurlid($tabel,$fkol);
     					if (in_array($id, $cekurid)) {
//deltdata-reject------------------------------------------------------------------------


$cek=$this->mweb->gettemp_data_aksi($id,$tabel);
    		if ($cek) {

				switch ($cek['aksi']) {
    			case 'update':
				$dnotif = array(
								'from'=>$idu,
    							'iduser' => $cek['idu'],
    							'msg'=>'maaf :( , update data '.$tabel.' dengan kode =<b>'.$id.'</b>tidak diterima admin',
    							'time'=>date('d-m-Y h:i:s')
				);
					
    				break;
    			case 'delete':
					$dnotif = array(
								'from'=>$idu,
    							'iduser' => $cek['idu'],
    							'msg'=>'maaf :( , delete data '.$tabel.' dengan kode =<b>'.$id.'</b>tidak diterima admin',
    							'time'=>date('d-m-Y h:i:s')
					);
    				break;
    			default: ?>
    				<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
    				<?php 
    				redirect('login','refresh');
    				break;
    		}
    		$this->mweb->settable('notif',$dnotif);
    		$query=$this->db->delete('temp_data',array('kd'=>$id,'tabel'=>$tabel));
    		if ($query) {
    		 ?>
    		 <script type="text/javascript">alert('terima kasih , system akan mengkonfirmasi kepada user yang bersangkutan');</script>
    		<?php 
    		redirect('login','refresh');
    		}
    		}


//deltdata-reject------------------------------------------------------------------------
	     				}else{
    	 					echo('tidak ada');
     					}
     				}
				}else{
					$this->session->unset_userdata('logged_in');
   					$this->session->sess_destroy();
   						redirect('login', 'refresh');
				}
    		}
    	}
    	public function delnotif($id)
    	{
			if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
				$cekmng=cekurlid('notif','id');
     			if ((empty($id)) || (strlen($id)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     				}else if (!in_array($id, $cekmng)) {
     					echo('tidak terdaftar');
     				}else{
//notif---------------------------------------------------------------------

    			$query=$this->mweb->hapuspus($id,'notif','id');
    			if($query===NULL){
    				redirect('login','refresh');
    			}else{ ?>
					<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
    				<?php redirect('login','refresh');
    			}


//notif---------------------------------------------------------------------
     				}
    		}
    	}
    	public function createinv($id,$mng)
    	{
    		if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
				$cekmng=cekurlid('manage','idmng');
     			if ((empty($mng)) || (empty($id)) || (strlen($mng)===0) || (strlen($id)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     			}else if (!in_array($mng, $cekmng)) {
     					echo('tidak terdaftar');
     			}else{
     				$tabel=$this->mweb->getmanage_by_id($mng);
     				$listf=$this->db->list_fields($tabel);
     				$fkol=array_shift(array_slice($listf, 0, 1));
     				$cekurid=cekurlid($tabel,$fkol);
     				if (in_array($id, $cekurid)) {
//buat-invoice-------------------------------------------------------------------


				$session_data = $this->session->userdata('logged_in');
				$idu=$session_data['id'];
     			$jabatan=$session_data['jabatan'];
				$exclude=array("acc","id","qty","disc","price","subtotal","amount","total");
				$stmt_list=create_statement('invoice', $exclude);
				$data['idtbl']=6;
				//$data['lastid']=$this->mweb->get_akhir('id','invoice');
				$data['lastid']=$id;
				$data['kolinv']=array(explode(',',$stmt_list));
     			$arr_idm=$this->mweb->menudash($jabatan,$idu);	
     			$data['notifs']=$this->mweb->gettable_by_kol('iduser','notif',$idu);
     			$data['menu']=$this->mweb->get_menu($arr_idm);
     			//cuss
     			$data['user']=getdetuser($idu);
     			$data['barang']=$this->mweb->getbrgquo($id);
     			$idcust=$this->mweb->getcusaksi($id,$mng);
     			$data['cus']=$this->mweb->getcus_byid($idcust);
     			//$data['barang']=$this->mweb->gettempbrg($id,$mng);
    			$this->load->view("templates/header");
				$this->load->view("templates/menu",$data);
				$this->load->view("pages/invoice",$data);
				$this->load->view("templates/footer");


//buat-invoice-------------------------------------------------------------------     					
	     			}else{
    	 				echo('tidak ada');
     				}
     			}
			}
    	}
    	public function getimage($idimg)
    	{
    		if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
    			$cekmng=cekurlid('image','idimg');
     			if ((empty($idimg)) || (strlen($idimg)===0) ) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     			}else if (!in_array($idimg, $cekmng)) {
     					echo('tidak terdaftar');
     			}else{
//getimage-----------------------------------------------------------

            $query=$this->db->get_where('image',array('idimg'=>$idimg));
    		if ($query->num_rows()===0) {
    				return false;
    			}else{
    				foreach ($query->result() as $value) {
    					$data=$value->src;
    					$pecah=explode('/', $value->src);
    					$filename=end($pecah);
    					force_download($filename, $data);
    					redirect('login','refresh');
    				}
    			}

//getimage-------------------------------------------------------------
     			}
    		}
    	}
    	public function sethrgj($id='')
    	{
    		if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
    			$cekmng=cekurlid('barang','kdbarang');
     			if ((empty($id)) || (strlen($id)===0) ) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     			}else if (!in_array($id, $cekmng)) {
     					echo('tidak terdaftar');
     			}else{
//set-harga-jual-----------------------------------------------------


					$session_data = $this->session->userdata('logged_in');
					$idu=$session_data['id'];
     				$jabatan=$session_data['jabatan'];
    				$exclude=array('id','idreq','nama','perusahaan','alamat','telp','faks','mobile','email','time');
 					$stmt_list=create_statement('purchase', $exclude);
 					$likol=$this->db->list_fields('purchase');
 					$data['fkol']=array_shift(array_slice($likol, 0, 1));
					$data['tbkol']=explode(',',$stmt_list);
					$arr_idm=$this->mweb->menudash($jabatan,$idu);	
					$data['notifs']=$this->mweb->gettable_by_kol('iduser','notif',$idu);
     				$data['menu']=$this->mweb->get_menu($arr_idm);
     				$data['purchase']=$this->mweb->gettable_byid('idreq',$id,'purchase');
					$this->load->view("templates/header");
					$this->load->view("templates/menu",$data);
					$this->load->view("pages/setjual",$data);
					$this->load->view("templates/footer");



//set-harga-jual-----------------------------------------------------
     			}
			}
    	}
    	public function editprof()
    	{
    		if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
				$session_data = $this->session->userdata('logged_in');
				$idu=$session_data['id'];
				$kol=$this->db->list_fields('user');
				$exckosong=array();
				$nk=count($kol);
				for ($x=0; $x < $nk; $x++) { 
					$input=$this->input->post($kol[$x]);
					$cekin=rtrim($input);
					if ((!$cekin) || (empty($cekin)) || (strlen($cekin)===0)) {
						$exckosong[]=$kol[$x];
					}
				}
				$gettd=getttduser($idu);
				$trttd=rtrim($gettd);
				if ((!empty($trttd)) && (strlen($trttd)>0) && ($trttd!=='0')) {
					array_push($exckosong, 'ttd');
				}
				
				$listkosong=create_statement('user', $exckosong);
				$field=explode(',', $listkosong);
				$n=count($field);
				$isif=array();
				for ($t=0; $t < $n; $t++) { 
					switch ($field[$t]) {
						case 'password':
							$isif[]=sha1($this->input->post($field[$t]));
							break;
						case 'ttd':
							$settd=$this->input->post($field[$t]);
							if ($settd) {
								$config['upload_path']=FCPATH.'uploads/';					
								$config['allowed_types'] = 'gif|jpg|png';
								//load the upload library
								$this->upload->initialize($config);
								$this->upload->set_allowed_types('*');
								$data['upload_data'] = '';
								//if not successful, set the error message
								if (!$this->upload->do_upload('userfile')){
									redirect(site_url('gudang/profile?tab=3&e=1'),'refresh');
								}else{ //else, set the success message
									$dataimg=$this->upload->data();
									$dtimg = array(
										'idimg' =>'',
										'src'=>$dataimg['full_path'],
										'desc'=>'ttd|'.$idu
							 		);
									$setimg=$this->mweb->setimage($dtimg);
									$settd=$setimg;
								}
							}else{
								$settd='0';
							}
							
							$isif[]=$settd;
							break;
						default:
							$isif[]=$this->input->post($field[$t]);
							break;
						}
				}
					$data=array_combine($field,$isif);
					$query=$this->db->where('id',$idu)
						->update('user',$data);
						if ($query) {?>
					<script type="text/javascript">
						alert("update profil anda berhasil :)");
					</script>
					<?php 
						redirect(site_url('gudang/profile?tab=1'),'refresh');
					}else{ ?>
					<script type="text/javascript">
						alert("maaf terjadi kesalahan pada system :(");
					</script>
					<?php 
						redirect('login','refresh');
					}
			}
    	}
    	public function addweb()
    	{
    		if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
				$session_data = $this->session->userdata('logged_in');
				$idu=$session_data['id'];
    			$namaweb=$this->input->post('namaweb');	
    			$webbya=$this->input->post('website');
    			if ((!empty($namaweb)) && (!empty($webbya))) {
    				$data = array(
    					'id'=>'',
    					'iduser' =>$idu,
    					'namaweb'=>$namaweb,
    					'website'=>$webbya
    					);
    				$query=$this->mweb->settable('website',$data);
    				$w=array();
    				if($query){     					
    					$idweb=$this->db->insert_id();
    					$datauser=getdetuser($idu);
    					if($datauser){
							foreach ($datauser as $vu){
    							if (!empty($vu['website'])) {
    								$w[]=$vu['website'];
    								$w[]=$idweb;
    							}else{
    								$w[]=$idweb;
    							}
    						}
							$isiw=implode(',', $w);
							$q2=$this->db->where('id',$idu)
								->update('user',array('website'=>$isiw));
							if ($q2) {?>
								<script type="text/javascript">
                        			alert("Data berhasil ditambahkan :) ");
                        		</script>

							<?php 
							redirect(site_url('gudang/profile?tab=1'),'refresh');
							}else{  ?>
    				 	 			<script type="text/javascript">
                        			alert("maaf terjadi kesalahan pada system :( ");
                        			</script>
    							<?php
    							redirect('login','refresh'); 
    						}
    					}else{  ?>
    				 	 <script type="text/javascript">
                        alert("maaf terjadi kesalahan pada system :( ");
                        </script>
    				<?php 
    				redirect('login','refresh');
    			}
    				}else{  ?>
    				 	 <script type="text/javascript">
                        alert("maaf terjadi kesalahan pada system :( ");
                        </script>
    				<?php 
    				redirect('login','refresh');
    			}
    			}
    		}
    	}
    	public function reqbrosur($kdb)
    	{
    		if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
				$cekmng=cekurlid('barang','kdbarang');
     			if ((empty($kdb)) || (strlen($kdb)===0) ) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     			}else if (!in_array($kdb, $cekmng)) {
     					echo('tidak terdaftar');
     			}else{
//req-brosur--------------------------------------------------------------



				$session_data = $this->session->userdata('logged_in');
				$idu=$session_data['id'];
				$data = array(
					'kdbarang' => $kdb, 
					'iduser'=>$idu,
					'time'=>date('d-m-Y h:i:s'),
					'status'=>'p'
					);
				$query=$this->mweb->settable('brosur',$data);
				if ($query) { 
					$msginv=array(
						'from'=>$idu,
						'iduser'=>getid_design(),
						'aksi'=>'brosur',
						'time'=>date('d-m-Y h:i:s'),
						'msg'=>'permintaan brosur kode <a href="'.site_url('gudang/slug/16/4/20/a?id='.$query.'&tbl=20').'"><strong>'.$query.'</strong></a>'
					);
					$this->mweb->settable('notif',$msginv);
					?>
					<script type="text/javascript">
					alert('request brosur berhasil . tunggu konfirmasi berikutnya :)');
					</script>
				<?php 
					redirect(site_url('gudang/slug/2/4/3'),'refresh');
				}else{ ?>
					<script type="text/javascript">
					alert('request brosur gagal ,terjadi kesalahan pada system :( ');
					</script>
				<?php 
					redirect(site_url('gudang/slug/2/4/3?e=1'),'refresh');
				}



//req-brosur---------------------------------------------------------------
     			}
			}
    	}
    	public function rejectedsend($id,$tbl)
    	{
    	    if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{   			
				if (is_admin()) {
					$cekmng=cekurlid('manage','idmng');
     			if ((empty($tbl)) || (empty($id)) || (strlen($tbl)===0) || (strlen($id)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     			}else if (!in_array($tbl, $cekmng)) {
     					echo('tidak terdaftar');
     			}else{
     				$session_data = $this->session->userdata('logged_in');
					$idu=$session_data['id'];
     				$tabel=$this->mweb->getmanage_by_id($tbl);
     				$listf=$this->db->list_fields($tabel);
     				$fkol=array_shift(array_slice($listf, 0, 1));
     				$cekurid=cekurlid($tabel,$fkol);
     				if (in_array($id, $cekurid)) {
//rejected-send----------------------------------------------------------------------------------------

        $tabel=$this->mweb->getmanage_by_id($tbl);
    		switch ($tabel) {
    			case 'quotation':
    				$this->db->where('id',$id);
    				$this->db->update($tabel,array('acc'=>'0'));
    				$pesan=array(
    					'from'=>$idu,
    					'iduser'=>getcusaksi($id,$tabel),
						'msg'=>'maaf quotation dengan kode digit terakhir '.$id.' tidak disetujui',
						'aksi'=>'quotation'
    					);
    				$this->mweb->settable('notif',$pesan);
    				redirect('gudang/slug/5/4/7','refresh');
    				break;
    			case 'invoice':
					$this->db->where('id',$id);
    				$this->db->update($tabel,array('acc'=>'0'));
    				$pesan=array(
    					'from'=>$idu,
    					'iduser'=>getcusaksi($id,$tabel),
						'msg'=>'maaf invoice dengan kode digit terakhir '.$id.' tidak disetujui',
						'aksi'=>'invoice'
    					);
    				redirect('gudang/slug/5/4/6','refresh');
    				break;
    			default:
    				redirect('login','refresh');
    				break;
    	}


//rejected-send----------------------------------------------------------------------------------------
     				}else{
     					echo('tidak ada');
     				}
     			}
				}else{
					redirect('login','refresh');
				}
			}
    	}

		
//send email---------------------------------------------------------
		public function sendEmail($email,$subject,$message,$idmng,$id,$idne)
		{
			if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
			$session_data = $this->session->userdata('logged_in');
     		$idu=$session_data['id'];
     		$st_user=rtrim(cekoptbyid(1));
     		$st_port=rtrim(cekoptbyid(5));
     		$st_pass=rtrim(cekoptbyid(3));
     		$st_host=rtrim(cekoptbyid(2));
			$config['protocol'] = "smtp";
			$config['smtp_host'] =(empty($st_host))? 'smtp.mandrillapp.com' : $st_host;
			$config['smtp_port'] =(empty($st_port))? '587': $st_port;
			$config['smtp_user'] =(empty($st_user))? 'pangkalanbun16@gmail.com' : $st_user; 
			$config['smtp_pass'] =(empty($st_pass))? 'DQilYcLI5D9Ldn0DydSudA' : $st_pass;
			$config['charset'] = "utf-8";
			$config['newline'] = "\r\n";
			$this->email->initialize($config);
			$this->email->set_newline("\r\n");
			$this->email->set_mailtype('html');
			$emailu=getemailuser($idne);
			$tabel=$this->mweb->getmanage_by_id($idmng);
			$pathe=FCPATH.'uploads/'.$tabel.'-'.$id.'.pdf';
			(empty($emailu))? $frome='pangkalanbun16@gmail.com' : $frome=$emailu;
			$this->email->from($frome);
			$this->email->to($email);
			$this->email->subject($subject);
			$this->email->message($message);
			$this->email->attach($pathe);
			if (file_exists($pathe)) {
			if($this->email->send()){ 
				$this->db->where('id',$id);
    			$query=$this->db->update($tabel,array('sent'=>'1'));
				$loge=$this->email->print_debugger();
				$this->logemail($loge);?>
				<script type="text/javascript">alert('terima kasih , email berhasil terkirim :)');
				</script>
				<?php 
				redirect('login','refresh');
			}else{?>
				<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>						<?php 
				$file = 'logerror.txt';
				$pathfile=APPPATH.'views/'.$file;
				$tulislog=$this->email->print_debugger();
				if(file_exists($pathfile)){
					$current = file_get_contents($pathfile);
					$current .= $tulislog;
					$current .= "\r\n";
					// Write the contents back to the file
					file_put_contents($pathfile, $current);
				}else{
					$handle=fopen($pathfile, 'w') or die('Cannot open file:  '.$pathfile); 
					fwrite($handle, $tulislog);
				}
				redirect('login','refresh');
				}
			}else{
						$pdfe = $this->curl->simple_get(site_url('gudang/createpdf/'.$idmng.'/'.$id.'/'.$idne));
    					$writepdf=write_file($pathe, $pdfe); 
    					if ($writepdf) {
    						if ($this->email->send()) {
    							$this->db->where('id',$id);
    							$query=$this->db->update($tabel,array('sent'=>'1'));
    							$loge=$this->email->print_debugger();
								$this->logemail($loge);
    								$this->db->where('id',$id);
									switch($idmng){
									case '6':

										$this->db->update('invoice',array('acc'=>'1'));
									break;
									case '7':

									$this->db->update('quotation',array('acc'=>'1'));
									break;
									}
									
    							?>
								<script type="text/javascript">alert('terima kasih , email berhasil terkirim :)');</script>
								<?php 
									redirect('login','refresh');
    						}else{
    							$loge=$this->email->print_debugger();
								$this->logemail($loge);
    						}
    					}else{ ?>
    					<script type="text/javascript">
    					alert('maaf terjadi kesalahan pada system');
    					</script>
    					<?php }
    			}

			}

    }
    function onprocsess($id=''){
    	if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
    			$rtrim=rtrim($id);
    			$cekurid=cekurlid('brosur','id');
    			if (empty($rtrim)) {
    				redirect('login','refresh');
    			}else if (in_array($id, $cekurid)) {
    				$siuser=datauser();
        			if ($siuser['jabatan']==='designer') { 
        				$this->db->where('id',$id);
        				$query=$this->db->update('brosur',array('status'=>'op'));
        				if ($query) { 
        					redirect(site_url('gudang/slug/16/4/20'),'refresh');	
        				}else{ ?>
							<script type="text/javascript">
							alert('maaf  ,terjadi kesalahan pada system :( ');
							</script>
        		<?php 
        			redirect('login','refresh');
        		}
        	}
    	}else{
    		?><script type="text/javascript">
					alert('not allowed');
					</script>
        		<?php 
    		redirect('login','refresh');
    	}
    }
    }
    function viewpdf($idtbl,$id){
    		$tabel=$this->mweb->getmanage_by_id($idtbl);
     		$listf=$this->db->list_fields($tabel);
     		$fkol=array_shift(array_slice($listf, 0, 1));
     		$cekurid=cekurlid($tabel,$fkol);
    		$cekmng=array('6','7');
     		if ((empty($idtbl)) || (empty($id)) || (strlen($idtbl)===0) || (strlen($id)===0)) {
     			   		$this->session->unset_userdata('logged_in');
   						$this->session->sess_destroy();
   						redirect('login', 'refresh');
     		}else if ((in_array($idtbl, $cekmng)) && (in_array($id, $cekurid))) {
     			   $pathe=FCPATH.'uploads/'.$tabel.'-'.$id.'.pdf';
    				if(file_exists($pathe)){
    					$substre=substr($pathe,21);
    				 ?>
    				 	<iframe class="frmpdf" title="<?php echo($tabel.'-'.$id.'.pdf');?>" src="<?php echo(base_url().$substre);?>" frameborder="0" width="100%" height="100%" allowfullscreen></iframe>
    				<?php }else{
    					$pdfe = $this->curl->simple_get(site_url('gudang/createpdf/'.$idtbl.'/'.$id));
    					$writepdf=write_file($pathe, $pdfe);
    					if ($writepdf) {
    						redirect('gudang/viewpdf/'.$idtbl.'/'.$id,'refresh');

    					}
    				}
     		}else{
     			echo('tidak terdaftar');
     		}


    }
    public function captcha()
    {
    	$vals = array(
      			'img_path'  => './captcha/',
     			'img_url'  => base_url().'/captcha/',
     			'img_width' => 150,
     			'img_height' => '50',
     			'expiration' => 7200
     	);
 		$cap = create_captcha($vals);
 		print_r($cap['word']);
 		echo $cap['image'];
    }
   /* public function generatevpdf()
    {
    	$this->pdf->load_view('welcome');
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }*/

    public function createquo()
    {
     //$this->pdf->load_view('pdf/quo');
     //var_dump($this->pdf->render());
     //if you want to write it to disk and/or send it as an attachment
    	//$this->load->view('pdf/quo');
    }
    public function setopt()
    {
    	if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
				$session_data = $this->session->userdata('logged_in');
     			$idu=$session_data['id'];
				$this->form_validation->set_rules('val','val','trim|required|xss_clean');
				$this->form_validation->set_rules('idset','idset','trim|required|xss_clean');
				if($this->form_validation->run()==false){ 
					redirect('gudang/slug/15/4/14?er=1','refresh');
				}else{
					$idset=$this->input->post('idset');
					$val=$this->input->post('val');
					$data=array(
						'idset'=>$idset,
						'val'=>$val,
						'iduser'=>$idu
					);
					$set=$this->mweb->settable('options',$data);
					if ($set) {
						redirect('gudang/slug/15/4/14?s','refresh');	
					}else{?>
							<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
						<?php 
						redirect('login','refresh');
					}
				}
    		}
    }
    public function updtopt()
    {
    	if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
				$session_data = $this->session->userdata('logged_in');
     			$idu=$session_data['id'];
				$this->form_validation->set_rules('val','val','trim|required|xss_clean');
				$this->form_validation->set_rules('idset','idset','trim|required|xss_clean');
				if($this->form_validation->run()==false){ 
					redirect('gudang/slug/15/4/14?er=1','refresh');
				}else{
					$idset=$this->input->post('idset');
					$val=$this->input->post('val');
					$data=array('val'=>$val);
					$this->db->where('idset',$idset);
					$this->db->where('iduser',$idu);
					$update=$this->db->update('options',$data);
					if ($update) {
						redirect('gudang/slug/15/4/14?s','refresh');	
					}else{?>
							<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
						<?php 
						redirect('login','refresh');
					}
				}
    		}
    }
    function logemail($msg){
    	if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{

    			$file = 'logemail.txt';
    			$pathfile=APPPATH.'views/'.$file;
				$tulislog=$msg;
				if(file_exists($pathfile)){
					$current = file_get_contents($pathfile);
					$current .= $tulislog;
					$current .= "\r\n";
					// Write the contents back to the file
					file_put_contents($pathfile, $current);
				}else{
					$handle=fopen($pathfile, 'w') or die('Cannot open file:  '.$pathfile); 
					fwrite($handle, $tulislog);
				}
			}
    }
    function setacc($idmng='',$id=''){
    	if(!$this->session->userdata('logged_in')){
     			redirect('login','refresh');
			}else{
				$session_data = $this->session->userdata('logged_in');
     			$idu=$session_data['id'];
    			if ((empty($idmng)) || (empty($id))) {
    				echo('tidak terdaftar '.anchor('gudang','beranda'));
    			}else{
    				$tabel=$this->mweb->getmanage_by_id($idmng);
    				$listf=$this->db->list_fields($tabel);
    				$fkol=array_shift(array_slice($listf, 0, 1));
     				$cekurid=cekurlid($tabel,$fkol);
    				if (in_array($id, $cekurid)) {
    					$idne=getusraksi($id,$tabel);
    					$this->db->where('id',$id);
						switch($idmng){
							case '6':
								$notifq=array(
 										'from'=>$idu,
 										'iduser'=>$idne,
 										'msg'=>'Invoice dengan kode <strong>'.$id.'</strong> telah <u>disetujui</u> owner id='.$idu
 										,'time'=>date('d-m-Y h:i:s'));
								$query=$this->db->update('invoice',array('acc'=>'1'));
							break;
							case '7':
								$notifq=array(
 										'from'=>$idu,
 										'iduser'=>$idne,
 										'msg'=>'Quotation dengan kode <strong>'.$id.'</strong> telah <u>disetujui</u> owner id='.$idu
 										,'time'=>date('d-m-Y h:i:s'));
								$query=$this->db->update('quotation',array('acc'=>'1'));

							break;
							default:?>
							<script type="text/javascript">alert('maaf terjadi kesalahan pada system :(');</script>
							<?php 
							redirect('login','refresh');
							break;

						}
						$settnotif=$this->mweb->settable('notif',$notifq);
						if ($query) {
							redirect('gudang/slug/5/4/'.$idmng,'refresh');
						}

    				}else{
    					echo('not allowed '.anchor('gudang','beranda'));
    				}
    			}
    	}
    
    }
    function viewinv(){
    	$this->load->view('pdf/inv');
    }
}
