<?php if(! defined('BASEPATH')) exit('not direct script allowed !');

class Mweb extends CI_Model{
	function __construct(){
		parent::__construct();
		//reset ALTER TABLE nama_tabel AUTO_INCREMENT = 0;
		/*
		$this->db->select('*');
		$this->db->from('blogs');
		$this->db->join('comments', 'comments.id = blogs.id');
		$query=$this->db->get();
		SELECT * 
FROM information_schema.COLUMNS 
WHERE 
    TABLE_SCHEMA = 'db_name' 
AND TABLE_NAME = 'table_name' 
AND COLUMN_NAME = 'column_name'
		*/
	}
	public function get_menu($arr_idm){
		if (count($arr_idm)===0) {
			$this->db->where_in('idmenu',array('1'));
			$query=$this->db->get('menu');
			
		}else{
			$this->db->where_in('idmenu',$arr_idm);
			$query=$this->db->get('menu');
		}
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return false;
		}
	}
	public function get_page_by_idm($id)
	{
		$qmenuid=$this->db->get_where('pages',array("idmenu"=>$id));
		return $qmenuid->result_array();
	}
	public function get_page($page)
	{
		$query=$this->db->get_where('action',array('idact'=>$page));
		foreach ($query->result() as $row){
			return $row->page;
		}
	}
	public function gettable($tabel)
	{
		if ($this->db->table_exists($tabel)){
			$query=$this->db->get($tabel);
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else{
				return false;
			}
   			
		}else{
			$this->db->query('CREATE TABLE '.$tabel.'(id INTEGER NOT NULL AUTO_INCREMENT,PRIMARY KEY (id)) ENGINE=MyISAM;');
			$query=$this->db->get($tabel);
   			return $query->result_array();			
		}
	}
	public function gettable_by_kol($kol,$tabel,$nyari)
	{
		$query=$this->db->get_where($tabel,array($kol=>$nyari));
		if ($query->num_rows===0) {
			return false;
		}else{
			return $query->result_array();
		}
	}
	public function get_cab($idu,$m,$jabatan)
	{
		$query=$this->db->get_where($jabatan,array(
				"idmenu"=>$m
				,"iduser"=>$idu
			));
		$arr_id=array();
		foreach($query->result() as $isinya){
			 $arr_id[]=$isinya->idact;
		}
		return $arr_id;
	}
	public function get_action($arr_id)
	{
		if (count($arr_id)===0) {
			$this->db->where_in('idact',array('1'));
			$query=$this->db->get('action');
		}else{
			$this->db->where_in('idact',$arr_id);
			$query=$this->db->get('action');
		}
		if ($query->num_rows() > 0) {
			return $query->result_array();
		}else{
			return false;
		}
	}
	public function get_manage()
	{
		$query=$this->db->get("manage");
		return $query->result();
	}
	public function getmanage_by_id($id)
	{
		$query=$this->db->get_where('manage',array('idmng'=>$id));
		if ($query->num_rows() > 0) {
			foreach ($query->result() as $row){
				return $row->table;
			}
		}else{
			return false;
		}
	}
	public function is_cab($id)
	{
		$query=$this->db->get_where('jabatan',array('kdcapab'=>$id));
		foreach ($query->result() as $row){
			return $row->jabatan;
		}
	}
	public function settable($tabel,$data)
	{
		$this->db->insert($tabel,$data);
		return $this->db->insert_id();
	}
	public function get_last_idcus($id,$tabel)
	{
		$this->db->order_by($id,"DESC");
		$this->db->limit(1);
		$query=$this->db->get($tabel);
		foreach ($query->result() as $row) {
			return $row->idcus;
		}
	}
	public function get_last_id($id,$tabel)
	{
		$query=$this->db->get_where($tabel,array('id'=>$id));
		return $query->result_array();
	}
	/*public function last_id_ins($k,$t)
	{
		$this->db->order_by($k,"DESC");
		$this->db->limit(1);
		$query=$this->db->get($t);
		foreach ($query->result() as $value) {
			return $value->$k;
		}
	}
	*/
	public function get_akhir($kol,$tabel)
	{
		$this->db->order_by($kol,"DESC");
		$this->db->limit(1);
		$query=$this->db->get($tabel);
		$idown=getid_own();
		$kdquo=rtrim(cekoptbyid(6),$idown);
		if ($query->num_rows()===0) {
			if ($tabel==='quotation') {
				$idl=(empty($kdquo))? 4330 : $kdquo;
			}else{
				$this->db->query('ALTER TABLE '.$tabel.' AUTO_INCREMENT = 0;');
				$idl=1;
			}
		}else{
			foreach ($query->result() as $val){
				if ($tabel==='quotation') {
					(empty($kdquo))? $idlst=$val->$kol+1 : $idlst=$kdquo;
					$idl=$idlst;
				}else{
					$idl=$val->$kol+1;
				}
			}
		}
		return $idl;
		
	}
	
	public function update_user($ids,$iddata)
	{
		$this->db->where("idcus",$ids);
		$this->db->update("cus",$iddata);
	}
	public function get_barang()
	{
		$query=$this->db->select(array('kdbarang','qty'))
					->get("barang");
		return $query->result();
	}

	public function importxls($dataarray,$idtbl)
	{
		for($i=0;$i<count($dataarray);$i++){
			switch($idtbl){
		             	case '1':
		             		$data = array(                 
								"idcus"=>$dataarray[$i]["idcus"]
								,"user"=>$dataarray[$i]["user"]
								,"nama"=>$dataarray[$i]["nama"]
								,"alamat"=>$dataarray[$i]["alamat"]
								,"kota"=>$dataarray[$i]["kota"]
								,"provinsi"=>$dataarray[$i]["provinsi"]
								,"kdpos"=>$dataarray[$i]["kdpos"]
								,"negara"=>$dataarray[$i]["negara"]
								,"telp"=>$dataarray[$i]["telp"]
								,"fax"=>$dataarray[$i]["fax"]
								,"kontak"=>$dataarray[$i]["kontak"]
								,"norek"=>$dataarray[$i]["norek"]
								,"kontak"=>$dataarray[$i]["kontak"]
								,"an_rek"=>$dataarray[$i]["an_rek"]
								,"bank"=>$dataarray[$i]["bank"]
								,"log"=>$dataarray[$i]["log"]
									);             
							$this->db->insert('cus', $data);         
		             		break;
		             	case '2':
		             	$data = array(
		             			"idsupp"=>$dataarray[$i]["idsupp"]
		             			,"nama"=>$dataarray[$i]["nama"]
								,"alamat"=>$dataarray[$i]["alamat"]
								,"kota"=>$dataarray[$i]["kota"]
								,"provinsi"=>$dataarray[$i]["provinsi"]
								,"kdpos"=>$dataarray[$i]["kdpos"]
								,"negara"=>$dataarray[$i]["negara"]
								,"telp"=>$dataarray[$i]["telp"]
								,"fax"=>$dataarray[$i]["fax"]
								,"kontak"=>$dataarray[$i]["kontak"]
								,"norek"=>$dataarray[$i]["norek"]
								,"kontak"=>$dataarray[$i]["kontak"]
								,"an_rek"=>$dataarray[$i]["an_rek"]
								,"bank"=>$dataarray[$i]["bank"]
								,"ket"=>$dataarray[$i]["ket"]
							);
							$this->db->insert('supplier', $data);
		             		break;
		             	case '3':
		             	$data = array(
		             			"kdbarang"=>$dataarray[$i]["kdbarang"]
								,"Description"=>$dataarray[$i]["Description"]
								,"catbrg"=>$dataarray[$i]["catbrg"]
								,"hrgpokok"=>$dataarray[$i]["hrgpokok"]
								,"hrgjual"=>$dataarray[$i]["hrgjual"]
								,"stock"=>$dataarray[$i]["stock"]
								,"qty"=>$dataarray[$i]["qty"]
							);
							$this->db->insert('barang', $data);
		             		break;
				}             
		}     
	}
	public function get_last_iduser()
	{
		$this->db->order_by("id","DESC");
		$this->db->limit(1);
		$query=$this->db->get("user");
		return $query->result_array();

	}
	public function updatepass($id,$pass)
	{
		$this->db->where("id",$id);
		$this->db->update("user",array('password'=>$pass));
	}
	public function get_id_cus()
	{
		$query=$this->db->get('cus');
		$id_cus=array();
		foreach ($query->result() as $value){
			 $id_cus[]=$value->idcus;
		}
		return $id_cus;
	}
	public function get_id_user()
	{
		$query=$this->db->select('id')
						->get('user');
		foreach ($query->result() as $value){
			 $idu[]=$value->id;
		}
		return $idu;
	}
	public function get_uname_user()
	{
		$query=$this->db->select('username')
					->get('user');
		foreach ($query->result() as $value){
			 $uname[]=$value->username;
		}
		return $uname;
	}
	public function get_name_cus()
	{
		$query=$this->db->get('cus');
		$nmcus=array();
		foreach ($query->result() as $value){
			 $nmcus[]=$value->nama;
		}
		return $nmcus;
	}
	public function getcus_byname($nama)
	{
		$query=$this->db->get_where('cus',array("nama"=>$nama));
		return $query->result_array();
	}
	public function hapuspus($isiid,$tabell,$kollid)
	{
		$this->db->delete($tabell,array($kollid=>$isiid));
	}
	public function get_kodebrg()
		{
			$this->db->where_in('stock',array('a','l'));
			$query=$this->db->get("barang");
			$kdbrg=array();
			foreach ($query->result() as $brg) {
				$kdbrg[]=$brg->kdbarang;
			}
			return $kdbrg;
		}
	public function get_Description()
		{
			$this->db->where_in('stock',array('a','l'));
			$query=$this->db->get("barang");
			$Description=array();
			foreach ($query->result() as $brg) {
				$Description[]=$brg->Description;
			}
			return $Description;
		}	
	public function writelog($log)
	{
		$this->db->insert("log",$log);
	}
	public function setstatus($dtstats)
	{
		$this->db->insert("status",$dtstats);
	}
	public function getlastidst()
	{
		$this->db->order_by("ids","DESC");
		$this->db->limit(1);
		$query=$this->db->get("status");
		foreach ($query->result() as $qlast) {
			return $qlast->ids;
		}
	}
	public function updatestts_brg($kdnya,$qlast,$dataupd)
	{
		$this->db->where(array(
			'ids'=>$qlast,
			'kdbarang'=>$kdnya
			));
		$this->db->update('status',$dataupd);
	}
	public function get_tabelandid($tabel,$iddata)
	{
		$query=$this->db->get_where($tabel,array('id'=>$iddata));
		return $query->result_array();
	}
	public function getcus_byid($idcus)
	{
		$query=$this->db->get_where('cus',array('idcus'=>$idcus));
		if ($query->num_rows()===0) {
			return false;
		}else{
			return $query->result_array();
		}
	}
	public function get_Descriptionbyid($kdb)
	{
		$query=$this->db->get_where('barang',array('kdbarang'=>$kdb));
		foreach ($query->result() as $valuee) {
			return $valuee->Description;
		}
	}
	public function get_stockbrgbyid($kdb)
	{
		$query=$this->db->get_where('barang',array('kdbarang'=>$kdb));
		foreach ($query->result() as $valuee) {
			return $valuee->stock;
		}
	}
	public function get_barangbyid($kdb){
		$query=$this->db->get_where('barang',array('kdbarang'=>$kdb));
		return $query->result_array();
	}
	public function get_idtempbrg($idnya)
	{
		$query=$this->db->get_where('tempbarang',array('idaksi'=>$idnya));
		$hasil=array();
		foreach ($query->result() as $valva) {
			$hasil[]=$valva->id;		
		}
		return $hasil;
	}
	public function get_kota()
	{
		$query=$this->db->query("SELECT * FROM inf_lokasi where lokasi_kabupatenkota=0 and lokasi_kecamatan=0 and lokasi_kelurahan=0 order by lokasi_nama");
		return $query->result_array();
	}
	public function listbrg_sedia()
	{
		$query=$this->db->query("SELECT * FROM barang WHERE stock='r'");
		return $query->result_array();
	}
	public function listbrg_limit()
	{
		$query=$this->db->query("SELECT * FROM barang WHERE stock='l'");
		return $query->result_array();
	}
	public function listbrg_out()
	{
		$query=$this->db->query("SELECT * FROM barang WHERE stock='o'");
		return $query->result_array();
	}
	public function get_tempbrg($ida,$idm)
	{
		$query=$this->db->get_where('tempbarang',array(
				'idaksi'=>$ida,
				'idmng'=>$idm
			));
		$kdb=array();
		foreach ($query->result() as $valtem) {
			$kdb[]=$valtem->kdbarang;
		}
		return $kdb;
	}
//-------------------------------------------------------------------------------------------------------------------------------------------
/*	public function gettempbrg($ida,$idm)
	{
		$query=$this->db->select(array('kdbarang','idcus','Model','qty','disc','price','subtotal'))
			->get_where('tempbarang',array(
				'idaksi'=>$ida,
				'idmng'=>$idm
			));
		if ($query->num_rows()===0) {
			return false;
		}else{
			return $query->result_array();
		}
	}*/
//---------------------------------------------------------------------------------------------------------------------------------------------
	public function get_qty_temp($idmng,$idaksi)
	{
		$query=$this->db->query("
			SELECT SUM(qty) 'qty' , kdbarang
			from tempbarang WHERE idaksi='".$idaksi."' AND
			idmng='".$idmng."' GROUP BY kdbarang
			");
		if ($query) {
			$qtyy=array();
			foreach ($query->result() as $vqty) {
				$qtyy[]=$vqty->kdbarang;
				$qtyy[]=$vqty->qty;
			}
			return $qtyy;
		}else{
			return FALSE;
		}
	}
	public function getdetailbrg($kdb)
	{
		$query=$this->db->get_where('tempbarang',array('kdbarang'=>$kdb));
		return $query->result_array();
	}
	public function getdatabykol($tabel,$kol)
	{
		$likol=$this->db->list_fields($tabel);
		$fkol=array_shift(array_slice($likol, 0, 1));
		$this->db->select(array($kol,$fkol));
		$query=$this->db->get($tabel);
		$larik=array();
		foreach ($query->result() as $vquery) {
			$larik[]=$vquery->$fkol;
			$larik[]=$vquery->$kol;
		}
		return $larik;
	}
	public function get_jmlutang($idaksi)
	{
		$query=$this->db->query("select SUM(`status`.`subtotal`) 'utang' FROM `status` WHERE `status`.`idaksi`='".$idaksi."'");
		if ($query) {
			$kirimt=array();
			foreach ($query->result() as $key => $value) {
				$kirimt[]=$value->utang;
			}
			return $kirimt;
		}else{
			return FALSE;
		}
	}
	public function listcus($id)
	{
		$query=$this->db
					->select(array('idcus','nama'))
					->get_where('cus',array('iduser'=>$id));
		if ($query->num_rows()===0) {
			return false;
		}else{
			return $query->result_array();
		}
	}
	public function joinbrg()
	{
		$this->db->select(array('tempbarang.kdbarang','tempbarang.idaksi','tempbarang.qty','tempbarang.idmng'))
				->select_sum('tempbarang.qty');
		$this->db->from('barang');
		$this->db->group_by(array('tempbarang.idmng','tempbarang.kdbarang','tempbarang.idaksi'))
				->join('tempbarang', 'tempbarang.kdbarang = barang.kdbarang');
		$query=$this->db->get();
		return $query->result_array();
	}
	public function getqtybrg()
	{
		$this->db->select(array('tempbarang.kdbarang','tempbarang.qty'))
				->select_sum('tempbarang.qty');
		$this->db->from('barang');
		$this->db->group_by('tempbarang.kdbarang')
				->join('tempbarang', 'tempbarang.kdbarang = barang.kdbarang');
		$query=$this->db->get();
		return $query->result_array();
	}
	public function getjabatan()
	{
		$query=$this->db->get('jabatan');
		return $query->result_array();
	}
	public function getaction()
	{
		$query=$this->db->select(array('idact','act'))
						->get('action');
		if ($query->num_rows()==0) {
			return false;
		}else{
			$kirim=array();
			foreach ($query->result() as $value) {
				$kirim[]=$value->idact;
				$kirim[]=$value->act;
			}
			return $kirim;
		}
	}
	public function getmenu()
	{
		$query=$this->db->select(array('idmenu','menu'))
						->get('menu');
		if ($query->num_rows()==0) {
			return false;
		}else{
			return $query->result_array();
		}
	}
	public function menudash($jabatan,$idu)
	{
		$query=$this->db->select(array('idmenu'))
						//->where('iduser',$idu) 
						->group_by('idmenu')
						->get($jabatan);
		if($query->num_rows===0) {
			return false;
		}else{
			foreach ($query->result() as $value) {
				$arridm[]=$value->idmenu;	
			}
			return $arridm;
		}
	}
	public function setimage($dtimg)
	{
		$query=$this->db->insert('image',$dtimg);
		if ($query) {
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
	public function gettable_byid($kol,$key,$tabel)
	{
		$query=$this->db->get_where($tabel,array($kol=>$key));
		if ($query->num_rows()==0) {
			return FALSE;
		}else{
			return $query->result_array();
		}
	}
	public function tempdata($temp)
	{
		$this->db->insert('temp_data',$temp);
		return $this->db->insert_id();
	}
	
    public function gettemp_data_aksi($kd,$tabel)
    {
    	$query=$this->db->select(array('aksi','iduser'))
    		->get_where('temp_data',array('kd'=>$kd,'tabel'=>$tabel));
    	if ($query->num_rows()===0){
    		return false;
    	}else{
    		foreach ($query->result() as $value) {
    			$an = array(
    				'idu' =>$value->iduser, 
    				'aksi'=>$value->aksi
    				);
    		}
    		return $an;
    	}	
    }
    public function get_notif($idu)
    {
    	if ($idu!==1) {
    		$query=$this->db->get_where('notif',array('iduser'=>$idu));
    		if ($query->num_rows()===0) {
    			return false;
    		}else{
    			return $query->result_array();
    		}
    	}
    }
    public function getpostprodbykd($kdb)
    {
    	$query=$this->db->select(array('id','kdbarang'))
    				->get_where('postprod',array('kdbarang'=>$kdb));
		if ($query->num_rows()===0) {
			return false;
		}else{
			foreach ($query->result() as $value) {
				return $value->id;
			}
		}
    }
  
    public function updatedata($tabel,$kol,$id,$data)
    {
    	$query=$this->db->where($kol,$id)
    					->update($tabel,$data);
    	if ($query) {
    		return $this->db->affected_rows();
    	}else{
    		return false;
    	}
    }
    public function getfirstval($kol,$tabel)
    {
    	$this->db->order_by($kol,'ASC');
    	$this->db->limit(1);
    	$query=$this->db->get($tabel);
    	if ($query->num_rows()>0) {
    		foreach ($query->result() as $value) {
    			return $value->$kol;
    		}
    	}else{
    		return false;
    	}
    }
    public function Follup()
    {
    	$query=$this->db->get_where('purchase',array('hrg_beli'=>'0'));
    	if ($query->num_rows() > 0) {
    		return $query->result_array();
    	}else{
    		return false;
    	}
    }
    public function getbrgquo($id)
    {
    	 $query=$this->db->get_where('quotation',array('id'=>$id));
    	if ($query->num_rows()===0) {
      		return false;
    	}else{
        	return $query->result_array();
    	}
    }
    public function cekmngmenu($m,$mng)
    {
    	$query=$this->db->get_where('pages',array('idmng'=>$mng,'idmenu'=>$m));
    	if ($query->num_rows() > 0) {
    		return true;
    	}else{
    		return false;
    	}
    }
    public function getcusaksi($id,$idtbl)
    {
    	$tabel=$this->getmanage_by_id($idtbl);
    	if ($tabel) {
    		if ($tabel==='quotation' || $tabel==='invoice') {
    			$query=$this->db->get_where($tabel,array('id'=>$id));
    				if ($query->num_rows()===0) {
      					return false;
    				}else{
        				foreach ($query->result() as $value) {
        					return $value->idcus;
        				}
    				}
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
    public function getusraksi($id,$idtbl)
    {
    	$tabel=$this->getmanage_by_id($idtbl);
    	if ($tabel) {
    		if ($tabel==='quotation' || $tabel==='invoice') {
    			$query=$this->db->get_where($tabel,array('id'=>$id));
    				if ($query->num_rows()===0) {
      					return false;
    				}else{
        				foreach ($query->result() as $value) {
        					return $value->iduser;
        				}
    				}
    		}else{
    			return false;
    		}
    	}else{
    		return false;
    	}
    }
    public function getwhere_in($tabel,$kol,$in)
    {
    	if (count($in)>0) {
			$this->db->where_in($kol,$in);
			$query=$this->db->get($tabel);
			if ($query->num_rows() > 0) {
				return $query->result_array();
			}else{
				return false;
			}
		}else{
			return false;
		}
    }
    public function getwherenot_in($tabel,$kol,$in)
    {
    		if (count($in)>0) {
			$this->db->where_not_in($kol,$in);
			$query=$this->db->get($tabel);
			if ($query->num_rows() > 0) {
					return $query->result_array();
				}else{
					return false;
				}
			}else{
				return false;
			}
    }
}
