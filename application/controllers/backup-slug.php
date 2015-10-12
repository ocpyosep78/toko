//ada semua
     		if (isset($_GET['page'])) {
				$offset=htmlspecialchars($_GET['page']);
			}else{
				$offset=0;
			}
     		$data['curmenu']=$m;
			$data['idmnge']=$slug;
			$tabel=$this->mweb->getmanage_by_id($slug);	
			$session_data = $this->session->userdata('logged_in');
			$num_rows=$this->db->count_all($tabel);
			$config['base_url'] = base_url().'index.php/gudang/slug/'.$m.'/'.$page.'/'.$slug.'?a';
			$config['total_rows'] = $num_rows;
			$config['per_page'] = 15;
			$this->pagination->initialize($config);
     		$jabatan=$session_data['jabatan'];
     		$idu=$session_data['id'];
     		$arr_idm=$this->mweb->menudash($jabatan,$idu);
			$arr_idact=$this->mweb->get_cab($idu,$m,$jabatan);
			$data['action']=$this->mweb->get_action($arr_idact);
			$data['notifs']=$this->mweb->gettable_by_kol('iduser','notif',$idu);
     		$data['menu']=$this->mweb->get_menu($arr_idm,$data);
				$data['mng']=$this->mweb->getmenu();
				$data['cab']=$this->mweb->getjabatan();
				$this->load->view("templates/header");
				$this->load->view("templates/menu",$data);
				$dftrkol=$this->db->list_fields($tabel);
				$fkol=array_shift(array_slice($dftrkol, 0, 1));
				$wowo=$this->mweb->get_akhir($fkol,$tabel);
				$data['lastid']=intval($wowo);
				$page=$this->mweb->get_page($page);
				$data['kodeaksi']=$page;
				switch($slug){
					case '1':
						$exclude=array("idcus", "user","log");
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
						$excl_kol=array("id","idmng","waktu","idcus","idaksi","acc");
						$wewlist=create_statement('tempbarang', $excl_kol);
						$data['koltempbrg']=explode(',',$wewlist);
						$exclude=array("iduser","acc","id","qty","disc","price","subtotal","amount","total");
						break;
					case '7':
						$excl_kol=array("id","idmng","waktu","idcus","idaksi","acc");
						$wewlist=create_statement('tempbarang', $excl_kol);
						$data['koltempbrg']=explode(',',$wewlist);
						$exclude=array("iduser","acc","id","qty","disc","price","subtotal","amount","total");
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
				if ($tabel==='notif') {
						$isi=$this->db->get_where($tabel,array('iduser'=>$idu),$config['per_page'],$offset);
				}else{
					$isi=$this->db->get($tabel,$config['per_page'],$offset);
				}
				$dfkol=$this->db->list_fields($tabel);
				$fkolm=array_shift(array_slice($dfkol, 0, 1));
				$send=array();
				foreach ($isi->result() as $isine) {
					$cektemp=$this->mweb->gettemp_data($isine->$fkolm,$tabel);
					if ($cektemp) {
						$links ='<span class="'.$cektemp['klas'].'" data-toggle="tooltip" data-placement="top" title="'.$cektemp['toolstip'].'"></span >';
						if (is_admin()) {
							$links .='<div class="btn-group" role="group" >';
							$links .='<a href="'.site_url('gudang/deltempdata/'.$isine->$fkolm.'/'.$tabel).'" class="btn btn-primary btn-sm" >Acc</a>';
							$links .='<a href="'.site_url('gudang/deltdata/'.$isine->$fkolm.'/'.$tabel).'" class="btn btn-sm btn-danger">rejected</a>';
							$links .='</div>';
						}
					}else{
						$links  ='<div class="btn-group" role="group" >';
						if ($tabel!=='notif' && $tabel!=='antrian') {
							$links  .= anchor('gudang/edit/'.$isine->$fkolm.'/'.$slug.'/'.$fkolm ,'Edit', array('class' => 'btn btn-sm btn-primary'));
						}
      					$links .= anchor('gudang/delete/'.$isine->$fkolm.'/'.$slug.'/'.$fkolm , 'Delete', array('class' => 'btn btn-sm btn-primary'));
      					switch ($slug) {
      						case '3':
      							$cekbrg=$this->mweb->getpostprodbykd($isine->$fkolm); 
      							$cekbrosur=$this->mweb->getbrosurbykd($isine->$fkolm); 
      							if (empty($cekbrg)) {
      								$links .= anchor('gudang/profile?tab=5&isi2='.$isine->$fkolm , 'post', array('class' => 'btn btn-sm btn-primary'));
      							}else{
      								$links .= anchor(current_url().'/wew?id='.$cekbrg.'&tbl=17', 'posted', array('class' => 'btn btn-sm btn-success'));
      							}
      							if (count($cekbrosur)===0 || empty($cekbrosur)) {
      								$btnbrosur=anchor('gudang/reqbrosur/'.$isine->$fkolm , 'request', array('class' => 'btn btn-sm btn-primary'));
      							}else{
      								foreach ($cekbrosur as $valbro) {
      									switch ($valbro['status']) {
      										case 'p':
      											$btnbrosur='pending';
      											break;
      										case 'op':
      											$btnbrosur='On process';
      											break;
      										default:
      											$btnbrosur=anchor(current_url().'/wew?id='.$valbro['id'].'&tbl=20', 'available', array('class' => 'btn btn-sm btn-success'));
      											break;
      									}
      								}
      							}
      							
      							break;
      						case '6':
      							$links .= anchor('gudang/createpdf/'.$slug.'/'.$isine->$fkolm , 'preview', array('class' => 'btn btn-sm btn-primary'));
      							if (is_admin() || is_mimin()) {
      								$krmemail = anchor('gudang/sendemail/'.$isine->$fkolm.'/'.$slug , 'approval', array('class' => 'btn btn-sm btn-success'));
      								$krmemail .=anchor('gudang/rejectedsend/'.$isine->$fkolm.'/'.$slug , 'rejected', array('class' => 'btn btn-sm btn-danger'));
      							}
      							break;
      						case '7':
      							$links .= anchor('gudang/createpdf/'.$slug.'/'.$isine->$fkolm , 'preview', array('class' => 'btn btn-sm btn-primary'));
      							$links .=anchor('gudang/createinv/'.$isine->$fkolm.'/'.$slug , 'create invoice', array('class' => 'btn btn-sm btn-primary'));
      							if (is_admin() || is_mimin()) {		
      								$krmemail = anchor('gudang/sendemail/'.$isine->$fkolm.'/'.$slug , 'approval', array('class' => 'btn btn-sm btn-primary'));
      								$krmemail .=anchor('gudang/rejectedsend/'.$isine->$fkolm.'/'.$slug , 'rejected', array('class' => 'btn btn-sm btn-danger'));
      							}
      							break;
      						case '16':
      							if (is_admin()) {
      								$purc=anchor('gudang/sethrgj/'.$isine->idreq , 'set price', array('class' => 'btn btn-sm btn-primary'));
      							}
      							if (is_mimin()) {
      								$purc=anchor('gudang/slug/1/1/16?req='.$isine->idreq , 'search', array('class' => 'btn btn-sm btn-primary'));
      							}
      						    break;      							
      						case '20':
      							if (isset($_GET['b'])) {
      								$idbnya=htmlspecialchars($_GET['b']);
      								$upstop=$this->db->where('id',$idbnya)
      										->update('brosur',array('status'=>'op'));
      								if ($upstop) {
      									unset($_GET['b']);
      									redirect('gudang/slug/16/4/20','refresh');
      								}else{
      									unset($_GET['b']);
      									redirect('gudang?e=1','refresh');
      								}

      							}
      							switch ($isine->status) {
      								case 'op':
      									$cekprog ='<div class="text-center"><i class="fa fa-clock-o" data-toggle="tooltip" data-placement="top" title="sedang dalam proses"></i></div>';
      									break;
      								case 's':
      									$cekprog ='<div class="text-center"><span class="glyphicon glyphicon-ok"></span></div>';
      									break;
      								default:
      									$url="'".current_url()."?b=".$isine->$fkolm."'";
      									$cekprog ='<div class="text-center">
      									<div class="checkbox">
      										<input type="checkbox" id="cekprogg" onclick="window.location.href='.$url.'"/>
      									</div></div>';
      									break;
      							}
      							break;
      					}
						$links .='</div>';
					}
      				if ($slug==='3') {
      					$send[]=$links;
      					$send[]=$btnbrosur;
      				}else if ($slug==='16') {
      					$send[]=$links;
      					if (is_admin() || is_mimin()) {
      						$send[]=$purc;
      					}
      				}else if($slug==='20'){
      					$send[]=$links;
      					$send[]=$cekprog;
      				}else if($slug==='6' || $slug==='7'){
      					$send[]=$links;
      					/*if (is_admin() || is_mimin()) {
      						$send[]=$krmemail;
      					}*/
      				}else{
      					$send[]=$links;
      				}
      				foreach ($dfkol as $vkol) {
      					$send[]=$isine->$vkol;
      				}
				}
				$header=$this->db->list_fields($tabel);
				if ($slug==='3') {
      				array_unshift($header, 'Aksi','Brosur');
      			}else if ($slug==='16') {
      				if (is_admin() || is_mimin()) {
      					array_unshift($header, 'Aksi','tindakan');
      				}else{
      					array_unshift($header, 'Aksi');
      				}
      			}else if($slug==='20'){
      				array_unshift($header, 'Aksi','progress');
      			}else if($slug==='6' || $slug==='7'){
      				if (is_admin() || is_mimin()){
      					array_unshift($header, 'Aksi');
      				}else{
      					array_unshift($header, 'Aksi');
      				}
      			}else{
      				array_unshift($header, 'Aksi');
      			}
				$jkol=count($header);
				$data['tabel']=$this->table->make_columns($send,$jkol);
				$tmpl = array(
					'table_open' => '<table class="table table-bordered table-striped table-condensed">',
					'table_close'=> '</table>'
					);
				$this->table->set_template($tmpl);
				$this->table->set_heading($header); // apply a heading with a header that was created
				if ($slug==='11' || $slug==='12' || $slug==='13' || $slug==='14') {
					$this->load->view("pages/uconstruction",$data);
				}else{
					$this->load->view("pages/".$page,$data);
				}
				$this->load->view("templates/footer");