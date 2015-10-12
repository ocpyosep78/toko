<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
function to_excel($query, $filename='xlsoutput') 
{ 
     $headers = ''; // variable untuk menampung header 
     $data = ''; // variable untuk menampung data 
 
     //$obj =& get_instance(); 
 
     $fields = $query->field_data(); 
     if ($query->num_rows() == 0) { 
          echo 'The table appears to have no data.'; 
     } else { 
          foreach ($fields as $field) { 
             $headers .= $field->name . "\t"; 
          } 
 
          foreach ($query->result() as $row) { 
               $line = ''; 
               foreach($row as $value){ 
                    if ((!isset($value)) OR ($value == "")) { 
                         $value = "\t"; 
                    } else { 
                         $value = str_replace('"', '""', $value); 
                         $value = '"' . $value . '"' . "\t"; 
                    } 
                    $line .= $value; 
               } 
               $data .= trim($line)."\n"; 
          } 
 
          $data = str_replace("\r","",$data); 
 
          header("Content-type: application/x-msdownload"); 
          header("Content-Disposition: attachment; filename=$filename.xls"); 
          echo "$headers\n$data"; 
     } 
} 
 
function array_to_excel($array, $filename='xlsoutput') 
{ 
     $headers = ''; // variable untuk menampung header 
     $data = ''; // variable untuk menampung data 
 
     //$obj =& get_instance(); 
 
     //$fields = $query->field_data(); 
     if(sizeof($array) == 0){ 
          echo 'The table appears to have no data.'; 
     }else{ 
          foreach($array as $row){ 
               $line = '';
               if(is_array($row)){
                    foreach($row as $value) { 
                    if ((!isset($value)) OR ($value == "")) { 
                         $value = "\t"; 
                    } else { 
                         $value = str_replace('"', '""', $value); 
                         $value = '"' . $value . '"' . "\t"; 
                    } 
                    $line .= $value; 
                    }
                } 
               $data .= trim($line)."\n"; 
          } 
        $data = str_replace("\r","",$data); 
        ob_start();
        
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$filename.xls"); 
        echo $data; 
     } 
}

function curPageURL(){
               $pageURL = 'http';
               //if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
               $pageURL .= "://";
               if ($_SERVER["SERVER_PORT"] != "80") {
                    $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
               }else{
                    $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
               }
     return $pageURL;
     }

function get_content($url){
     $data = curl_init();
     curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($data, CURLOPT_URL, $url);
     $hasil = curl_exec($data);
     curl_close($data);
     return $hasil;
}

function kirimemail_att($id,$tabel,$email)
{
   // setting nama file attachment
  $token=md5(uniqid($id, true));
  $idmng='';
  switch ($tabel) {
    case 'invoice':
      $pile='invoice.pdf';
      $idmng=6;
      $kata='Silahkan dilihat dengan seksama ,Mohon klik <a href="'.site_url('gudang/kofirm?token='.$token).'">disini</a> untuk konfirmasi';
      $subject='Invoice JVM '.getkodeaksi($id,$tabel);
      break;
    case 'quotation':
      $pile='quotation.pdf';
      $idmng=7;
      $kata='Penawaran barang , silahkan dilihat denga seksama ,Mohon klik <a href="'.site_url('gudang/kofirm?token='.$token).'">disini</a> untuk konfirmasi';
      $subject='quotation JVM '.getkodeaksi($id,$tabel);
      break;
    default:
      $pile='';
      $idmng='';
      $kata='';
      $subject='';
      break;
  }
   $namafile = $pile;
   // MIME type file PDF sbg attachment
   $fileType = "application/x-pdf";
   // setting pesan intro di email
   //click <a href="'.site_url("gudang/accept_inv/".$kdbrang."/".$qlast).'">here</a> to konfrim
   $introPesan = $kata; 
   $fileContent = get_content(site_url('gudang/createpdf/'.$idmng.'/'.$id));   

   // membuat attachment di email
   $semi_rand = md5(time());
   $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";
   $headers = "MIME-Version: 1.0\n" .
              "Content-Type: multipart/mixed;\n" .
              " boundary=\"{$mime_boundary}\"";
   $pesan = "This is a multi-part message in MIME format.\n\n" .
            "--{$mime_boundary}\n" .
            "Content-Type: text/html; charset=\"iso-8859-1\"\n" .
            "Content-Transfer-Encoding: 7bit\n\n" .
            $introPesan . "\n\n";
   $data = chunk_split(base64_encode($fileContent));
   $pesan .= "--{$mime_boundary}\n" .
             "Content-Type: {$fileType};\n" .
             " name=\"{$namafile}\"\n" .
             "Content-Disposition: attachment;\n" .
             " filename=\"{$namafile}\"\n" .
             "Content-Transfer-Encoding: base64\n\n" .
             $data . "\n\n" .
             "--{$mime_boundary}--\n"; 
   // proses mengirim email dengan attachment
   mail($email, $subject, $pesan, $headers);
}


//---------------------------------------------------fpdf


//function hex2dec
//returns an associative array (keys: R,G,B) from
//a hex html code (e.g. #3FE5AA)
function hex2dec($couleur = "#000000"){
  $R = substr($couleur, 1, 2);
  $rouge = hexdec($R);
  $V = substr($couleur, 3, 2);
  $vert = hexdec($V);
  $B = substr($couleur, 5, 2);
  $bleu = hexdec($B);
  $tbl_couleur = array();
  $tbl_couleur['R']=$rouge;
  $tbl_couleur['G']=$vert;
  $tbl_couleur['B']=$bleu;
  return $tbl_couleur;
}

//conversion pixel -> millimeter in 72 dpi
function px2mm($px){
  return $px*25.4/72;
}

function txtentities($html){
  $trans = get_html_translation_table(HTML_ENTITIES);
  $trans = array_flip($trans);
  return strtr($html, $trans);
}
////////////////////////////////////

//---------------------------------------------------tambahan-------------------------------------------------------------------------------

function toNum($data) {
    $alphabet = array( 'a', 'b', 'c', 'd', 'e',
                       'f', 'g', 'h', 'i', 'j',
                       'k', 'l', 'm', 'n', 'o',
                       'p', 'q', 'r', 's', 't',
                       'u', 'v', 'w', 'x', 'y',
                       'z'
                       );
    $alpha_flip = array_flip($alphabet);
    $return_value = -1;
    $length = strlen($data);
    for ($i = 0; $i < $length; $i++) {
        $return_value +=
            ($alpha_flip[$data[$i]] + 1) * pow(26, ($length - $i - 1));
    }
    return $return_value;
}

function is_admin(){
  // get the superobject
  $CI =& get_instance();
  if($CI->session->userdata('logged_in')){
    $session_data = $CI->session->userdata('logged_in');
    if ($session_data['jabatan']==='owner') {
      return true;
    }else{
      return false;
    }
  }  
}
function is_mimin()
{
      $CI =& get_instance();
      if($CI->session->userdata('logged_in')){
      $session_data = $CI->session->userdata('logged_in');
      if ($session_data['jabatan']==='admin') {
        return true;
      }else{
        return false;
      }
  }  
}
function adasaldo($idsl){
    $CI =& get_instance();
    $query=$CI->db->get_where('saldo_inv',array('idaksi'=>$idsl));
    if ($query->num_rows()!=0) {
      return $query->result_array();
    }else{
      return false;
    }
}
function get_statusbyid($idak){
    $CI=& get_instance();
    $query=$CI->db->get_where('status',array('idaksi'=>$idak));
    if ($query->num_rows()!=0) {
      return $query->result_array();
    }else{
      return false;
    }
}
function getnamabrg($kdb){
  $CI=& get_instance();
  $query=$CI->db->get_where('barang',array('kdbarang'=>$kdb));
  if ($query->num_rows()!=0) {
    foreach ($query->result() as $value) {
      return $value->Description;
    }
  }else{
    return false;
  }
}
function updatelunas($larik){
  $CI=& get_instance();
  $pecah=explode(',',$larik);
  $statusnya='';$kdst='';
  if ($pecah[2]==100) {
      $statusnya='paid';
      $kdst='p';
  }elseif ($pecah[2]==0 || empty($pecah[2]) ){
      $statusnya='unpaid';
      $kdst='u';
  }else{
      $statusnya='deposit';
      $kdst='d';
  }
  $data= array(
    'bayar' => $pecah[1],
    'sisa' => $pecah[3], 
    'persentase' =>$pecah[2],  
    'status' =>$kdst, 
    'ket' =>$statusnya
    );
  $query=$CI->db->update('status', $data, array('ids' => $pecah[0]));
  if ($query) {
    return true;
  }else{
    return false;
  }
}

function getcheckm($id,$mng,$act,$tabel){
  $CI=& get_instance();
  $query=$CI->db->get_where($tabel,array(
    'iduser'=>$id,
    'idmenu'=>$mng,
    'idact'=>$act
  ));
  if($query->num_rows()!=0){
      return $query->result_array();
  }else{
    return false;
  }
}
function returncab($id){
  $CI=& get_instance();
  $query=$CI->db->get_where('jabatan',array('kdcapab'=>$id));
  if ($query->num_rows()===0) {
    return false;
  }else{
    foreach ($query->result() as $value) {
        return $value->jabatan;
    }
  }
}
function returnm($kd,$id,$tabel){
  $CI=& get_instance();
  $query=$CI->db->group_by('idmenu')
            ->get_where($tabel,array(
              'iduser'=>$id,
              'idmenu'=>$kd
              ));
  if ($query->num_rows()==0) {
    return false;
  }else{
    return $query->result_array();
  }
} 
function insertdata($tabel,$data){
  $CI=& get_instance();
  $query=$CI->db->insert($tabel,$data);
  if ($query) {
    return $CI->db->insert_id();
  }else{
    return false;
  }
}

function returnact($id,$idm,$tabel)
{
    $CI=& get_instance();
     $query=$CI->db->get_where($tabel,array(
              'iduser'=>$id,
              'idmenu'=>$idm
              ));
  if ($query->num_rows()==0) {
    return false;
  }else{
    foreach ($query->result() as $key => $value) {
      $kirim[]=$value->idact;
    }
    return $kirim;
  }
}
function getprod($kdb){
    $CI=& get_instance();
    $query=$CI->db->select(array('kdbarang','Model','Description'))
                  ->get_where('barang',array('kdbarang'=>$kdb));
    if ($query->num_rows()==0) {
      return false;
    }else{
      foreach ($query->result() as $value) {
          $arrdata[]=$value->kdbarang;
          $arrdata[]=$value->Model;
          $arrdata[]=$value->Description;
      }
      return $arrdata;
    }
}



//----------------------------------------------get full url------------------------------------

function full_url()
{
   $ci=& get_instance();
   $return = $ci->config->site_url().$ci->uri->uri_string();
   if(count($_GET) > 0)
   {
      $get =  array();
      foreach($_GET as $key => $val)
      {
         $get[] = $key.'='.$val;
      }
      $return .= '?'.implode('&',$get);
   }
   return $return;
} 

function geturl_img($id){
    $CI=& get_instance();
    $query=$CI->db->select('src')
                  ->get_where('image',array('idimg'=>$id));
    if($query->num_rows()==0) {
      return false;
    }else{
      foreach ($query->result() as $value) {
          return $value->src;
      }
    }
}
function datauser(){
    $CI =& get_instance();
    if($CI->session->userdata('logged_in')){
    $session_data = $CI->session->userdata('logged_in');
    $dtuser = array(
      'id' =>$session_data['id'], 
      'username'=>$session_data['username'],
      'jabatan'=>$session_data['jabatan']
    );
    return $dtuser;
    }
}
function getuserbyid($id){
  if (is_admin()) {
      $CI =& get_instance();
      $query=$CI->db->get_where('user',array('id'=>$id),1);  
      if ($query->num_rows() > 0) {
        foreach ($query->result() as $value) {
            $userdata = array(
              'id'=>$value->id,
              'username' =>$value->username, 
              'jabatan'=>returncab($value->kdcapab)
              );
        }
        return $userdata;
      }else{
        return false;
      }
  }
}
function submenu($m){
  $CI =& get_instance();
  if($CI->session->userdata('logged_in')){
    $query=$CI->db->get_where('pages',array('idmenu'=>$m));
    if ($query->num_rows()==0 || $query->num_rows()==1) {
      return false;  
    }else{
      foreach ($query->result() as $value) {
          $arrsub[]=$value->idmng;
      }
      return $arrsub;
    }
  }
}
function getmngsinglem($m)
{
    $CI =& get_instance();
  if($CI->session->userdata('logged_in')){
    $query=$CI->db->get_where('pages',array('idmenu'=>$m));
    if ($query->num_rows()==1) {
      foreach ($query->result() as $value) {
          return $value->idmng;
      }
    }else{
      return false;
    }
  }
}
function namemenu($m){
  $CI =& get_instance();
  if($CI->session->userdata('logged_in')){
    $query=$CI->db->get_where('pages',array('idmng'=>$m));
    if ($query->num_rows()==0) {
      return false;  
    }else{
      foreach ($query->result() as $value) {
          return $value->page_name;
      }
    }
  }
}
function getuname($id){
  $CI =& get_instance();
  $query=$CI->db->select('username')
      ->get_where('user',array('id'=>$id));
  if ($query->num_rows()===0) {
    return 'anonymous';
  }else{
    foreach ($query->result() as $value) {
      return $value->username;
    }
  }
}
function getDescription($kdb)
{
  $CI =& get_instance();
  $query=$CI->db->select('Description')
      ->get_where('barang',array('kdbarang'=>$kdb));
  if ($query->num_rows()===0) {
    return false;
  }else{
    foreach ($query->result() as $value) {
      return $value->Description;
    }
  }
}
function getnamatbl($id){
    $CI =& get_instance();
    $query=$CI->db->select('table')
        ->get_where('manage',array('idmng'=>$id));
    if ($query->num_rows()===0) {
      return false;
    }else{
      foreach ($query->result() as $value) {
        return $value->table;
      }
    }
}
function get_details($id,$tbl)
{
    $CI =& get_instance();
    $tabel=getnamatbl($tbl);
    $likol=$CI->db->list_fields($tabel);
    $fkol=array_shift(array_slice($likol, 0, 1));
    $query=$CI->db->get_where($tabel,array($fkol=>$id));
    if ($query->num_rows()===0) {
      return false;
    }else{
        return $query->result_array();
    }   
}


//------------------------------------------------------------------------------------------------------------------------------------------------------
//--------------------------------------force download--------------------------------------------------------------------------------------------------
function force_download($filename = '', $data = '')
{
    if ($filename == '' || $data == '')
    {
        return false;
    }
 
    if (!file_exists($data))
    {
        return false;
    }
 
    if (false === strpos($filename, '.'))
    {
        return false;
    }
 
    $extension = strtolower(pathinfo(basename($filename), PATHINFO_EXTENSION));
 
    $mime_types = array(
        'txt' => 'text/plain',
        'htm' => 'text/html',
        'html' => 'text/html',
        'php' => 'text/html',
        'css' => 'text/css',
        'js' => 'application/javascript',
        'json' => 'application/json',
        'xml' => 'application/xml',
        'swf' => 'application/x-shockwave-flash',
        'flv' => 'video/x-flv',
        // images
        'png' => 'image/png',
        'jpe' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'gif' => 'image/gif',
        'bmp' => 'image/bmp',
        'ico' => 'image/vnd.microsoft.icon',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'svg' => 'image/svg+xml',
        'svgz' => 'image/svg+xml',
        // archives
        'zip' => 'application/zip',
        'rar' => 'application/x-rar-compressed',
        'exe' => 'application/x-msdownload',
        'msi' => 'application/x-msdownload',
        'cab' => 'application/vnd.ms-cab-compressed',
        // audio/video
        'mp3' => 'audio/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        // adobe
        'pdf' => 'application/pdf',
        'psd' => 'image/vnd.adobe.photoshop',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        // ms office
        'doc' => 'application/msword',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'rtf' => 'application/rtf',
        'xls' => 'application/vnd.ms-excel',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        // open office
        'odt' => 'application/vnd.oasis.opendocument.text',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
    );
 
    if (!isset($mime_types[$extension]))
    {
        $mime = 'application/octet-stream';
    } else
    {
        $mime = ( is_array($mime_types[$extension]) ) ? $mime_types[$extension][0] : $mime_types[$extension];
    }
 
    if (strstr($_SERVER['HTTP_USER_AGENT'], "MSIE"))
    {
        header('Content-Type: "' . $mime . '"');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
        header("Content-Transfer-Encoding: binary");
        header('Pragma: public');
        header("Content-Length: " . filesize($data));
    }else{
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: " . $mime, true, 200);
        header('Content-Length: ' . filesize($data));
        header('Content-Disposition: attachment; filename=' . $filename);
        header("Content-Transfer-Encoding: binary");
    }
    readfile($data);
    exit;
}
//--------------------------------------------------end force download------------------------------------------------;
function getnamaprod($id)
{
    $CI =& get_instance();
    $query=$CI->db->select(array('namaprod','Model','desc','iduser','idimg','time'))
        ->get_where('request',array('idreq'=>$id));
    if ($query->num_rows()===0) {
      return false;
    }else{
      return $query->result_array();
    }
}
function getdescprod($id){
        $CI =& get_instance();
    $query=$CI->db->select('namaprod')
        ->get_where('request',array('idreq'=>$id));
    if ($query->num_rows()===0) {
      return false;
    }else{
      foreach ($query->result() as $value) {
        return $value->namaprod;
      }
    }
}
function udahnyari($req)
{
    $CI =& get_instance();
    $query=$CI->db->select(array('linkbeli','hrg_beli','id'))
        ->get_where('purchase',array('idreq'=>$req));
    if ($query->num_rows()===0) {
        return false;
    }else{
        return $query->result_array();
    }
}
function getstatusantri($req)
{
  $CI =& get_instance();
    $query=$CI->db->select('status')
        ->get_where('antrian',array('idreq'=>$req));
    if ($query->num_rows()===0) {
        return false;
    }else{
        foreach ($query->result() as $value) {
            return $value->status;
        }
    }
}
function getdetuser($id){
    $CI =& get_instance();
    $query=$CI->db->get_where('user',array('id'=>$id));
    if ($query->num_rows()===0) {
        return false;
    }else{
        return $query->result_array();
    } 
}
function geturlweb($id){
    //
    $CI =& get_instance();
    $query=$CI->db->get_where('website',array('id'=>$id));
    if ($query->num_rows()===0) {
        return false;
    }else{
        foreach ($query->result() as $value) {
          return $value->website;
        }
    } 
} 
function getpagename($m,$mng){
  $CI =& get_instance();
    $query=$CI->db->get_where('pages',array('idmenu'=>$m,'idmng'=>$mng));
    if ($query->num_rows()===0) {
        return false;
    }else{
        foreach ($query->result() as $value) {
          return $value->page_name;
        }
    }
}
function getkodeaksi($id,$tabel){
    $CI =& get_instance();
    $query=$CI->db->get_where($tabel,array('id'=>$id));
    if ($query->num_rows()===0) {
        return false;
    }else{
        switch ($tabel) {
          case 'quotation':
              foreach ($query->result() as $value) {
                  return $value->kdquo;
              }
            break;
          case 'invoice':
              foreach ($query->result() as $value) {
                return $value->kdinv;
              }
            break;
          default:
            return false;
            break;
        }
    } 
}


function getnamacus($id){
    $CI =& get_instance();
    $query=$CI->db->select('nama')
        ->get_where('cus',array('idcus'=>$id));
    if ($query->num_rows()===0) {
        return false;
    }else{
        foreach ($query->result() as $value) {
          return $value->nama;
        }
    }
}
function getdatacus($id){
    $CI =& get_instance();
    $likol=$CI->db->list_fields('cus');
    $query=$CI->db->get_where('cus',array('idcus'=>$id));
    if ($query->num_rows()===0) {
        return false;
    }else{
      $data=array();
      foreach ($query->result() as $value) {
        foreach ($likol as $vkol) {
          $data[]=$value->$vkol;
        }
      }
      $combine=array_combine($likol, $data);
      return $combine;
    }
}
function cekurlid($tbl,$kol){
    $CI =& get_instance();
    $query=$CI->db->select($kol)
                  ->get($tbl);
    if ($query->num_rows()===0) {
        return false;
    }else{
        $arr=array();
        foreach ($query->result() as $value) {
          $arr[]=$value->$kol;
        }
        return $arr;
    } 
}
function getcusaddr($id){
    $CI =& get_instance();
    $query=$CI->db->get_where('cus',array('idcus'=>$id));
    if ($query->num_rows()===0) {
        return false;
    }else{
        $detcus=array();
        foreach ($query->result() as $value) {
            $detcus[]=$value->alamat;
            $detcus[]=$value->kota;
            $detcus[]=$value->kabupaten;
            $detcus[]=$value->provinsi;
            $detcus[]=$value->kdpos;
            $detcus[]=$value->negara;
        }
        $alamatnya=implode(',',$detcus);
        return $alamatnya;
    }  
}
function getusraksi($id,$tabel){
    $CI =& get_instance();
    $query=$CI->db->get_where($tabel,array('id'=>$id));
    if ($query->num_rows()===0) {
        return false;
    }else{
        switch ($tabel) {
          case 'quotation':
              foreach ($query->result() as $value) {
                  return $value->iduser;
              }
            break;
          case 'invoice':
              foreach ($query->result() as $value) {
                return $value->iduser;
              }
            break;
          default:
            return false;
            break;
        }
    }
}
function gethrgbrg($kdb){
  //Harga_Lama
    $CI =& get_instance();
    $query=$CI->db->select('Harga_Lama')
        ->get_where('barang',array('kdbarang'=>$kdb));
    if ($query->num_rows()===0) {
        return false;
    }else{
        foreach ($query->result() as $value) {
          return $value->Harga_Lama;
        }
    }
} 
 function getbyidreq($id,$tbl)
{
    $CI =& get_instance();
    $tabel=getnamatbl($tbl);
    $query=$CI->db->get_where($tabel,array('idreq'=>$id));
    if ($query->num_rows()===0) {
      return false;
    }else{
        return $query->result_array();
    }   
}
function getusereq($id){
    $CI =& get_instance();
    $query=$CI->db->select('iduser')
                  ->get_where('request',array('idreq'=>$id));
    if ($query->num_rows()===0) {
      return false;
    }else{
        foreach ($query->result() as $value) {
          return $value->iduser;
        }
    } 
}


function cekbrosur($kdb){
  $CI =& get_instance();
  $query=$CI->db->select(array('id','kdbarang','status'))
            ->get_where('brosur',array('kdbarang'=>$kdb));
    if ($query->num_rows()===0) {
      return false;
    }else{
      return $query->result_array();
    }
}

function gettemp_data($kd,$tabel){
    $CI =& get_instance();
    $query=$CI->db->select(array('tabel','kd','aksi','iduser'))
            ->get_where('temp_data',array('kd'=>$kd,'tabel'=>$tabel));
      if ($query->num_rows===0) {
        return false;
      }else{
        foreach ($query->result() as $value) {
          switch ($value->aksi) {
            case 'update':
              $idnya=array(
              'idnya' =>$value->kd, 
              'klas'=>'glyphicon glyphicon-pencil',
              'toolstip'=>'data telah diupdate oleh '.getuname($value->iduser)
            );
              break;
            case 'delete':
              $idnya=array(
              'idnya' =>$value->kd , 
              'klas'=>'glyphicon glyphicon-trash',
              'toolstip'=>'data telah terhapus oleh '.getuname($value->iduser)
              );
              break;
            default:
              $idnya=array(
                'idnya' =>$value->kd , 
                'klas'=>'glyphicon glyphicon-ok',
                'toolstip'=>'oke oke aja'
              );
              break;
          }
        }
        return $idnya;
      }
    }
function cekposting($kdb)
{
  $CI =& get_instance();
  $query=$CI->db->select(array('id','kdbarang'))
            ->get_where('postprod',array('kdbarang'=>$kdb));
    if ($query->num_rows()===0) {
      return false;
    }else{
      foreach ($query->result() as $value) {
        return $value->id;
      }
    }
}
function getid_own(){
  $CI =& get_instance();
  $query=$CI->db->get_where('user',array('kdcapab'=>'5'));
  if ($query->num_rows()===0) {
      return false;
    }else{
      foreach ($query->result() as $value) {
        return $value->id;
      }
    } 
}

function getid_min(){
  $CI =& get_instance();
  $query=$CI->db->get_where('user',array('kdcapab'=>'1'));
  if ($query->num_rows()===0) {
      return false;
    }else{
      foreach ($query->result() as $value) {
        return $value->id;
      }
    } 
}
function getid_design(){
  $CI =& get_instance();
  $query=$CI->db->get_where('user',array('kdcapab'=>'3'));
  if ($query->num_rows()===0) {
      return false;
    }else{
      foreach ($query->result() as $value) {
        return $value->id;
      }
    } 
}
function getkdbreq($req){
  $CI =& get_instance();
  $query=$CI->db->select(array('kdbarang','namaprod'))
  ->get_where('request',array('idreq'=>$req));
  if ($query->num_rows() > 0) {
      foreach ($query->result() as $value) {
        $cekdb=rtrim($value->kdbarang);
        if (empty($cekdb)) {
          return $value->namaprod;
        }else{
          return $value->kdbarang;
        }
      }
    }else{
     return false; 
    } 
}
function getacc($id,$mng){ 
    $CI =& get_instance();
    $CI->db->select('acc');
    switch ($mng) {
    case '7':
      $query=$CI->db->get_where('quotation',array('id'=>$id));
      break;
    case '6':
      $query=$CI->db->get_where('invoice',array('id'=>$id));
      break;
    default:
      $query='';
      return false;
      break;
    }
    if(!empty($query)){
      if ($query->num_rows()===0) {
        return false;
      }else{
        foreach ($query->result() as $value) {
            if ($value->acc==='1' || $value->acc===1) {
                return true;
            }else{
                return false;
            }
        }
      }
    }
}
function ceksent($id,$mng){
  $CI =& get_instance();
    $CI->db->select('sent');
    switch ($mng) {
    case '7':
      $query=$CI->db->get_where('quotation',array('id'=>$id));
      break;
    case '6':
      $query=$CI->db->get_where('invoice',array('id'=>$id));
      break;
    default:
      $query='';
      return false;
      break;
    }
    if(!empty($query)){
      if ($query->num_rows()===0) {
        return false;
      }else{
        foreach ($query->result() as $value) {
            if ($value->sent==='1' || $value->sent===1) {
                return true;
            }else{
                return false;
            }
        }
      }
    }
}

function getreq_byantri($id)
{
  $CI =& get_instance();
  $query=$CI->db->select('idreq')
  ->get_where('purchase',array('id'=>$id));
  if ($query->num_rows()===0) {
      return false;
    }else{
      foreach ($query->result() as $value) {
        return $value->idreq;
      }
    } 
}
function getuserbrosur($id){
  $CI =& get_instance();
  $query=$CI->db->select(array('iduser','kdbarang'))
        ->get_where('brosur',array('id'=>$id));
  if ($query->num_rows() > 0) {
    foreach ($query->result() as $value) {
        $kirim=array(
          'iduser'=>$value->iduser,
          'kdbarang'=>$value->kdbarang
        ); 
    }
    return $kirim;
  }else{
    return false;
  }
}
function getemailuser($id){
  $CI =& get_instance();
  $query=$CI->db->select(array('email'))
        ->get_where('user',array('id'=>$id));
  if ($query->num_rows() > 0) {
    foreach ($query->result() as $value) {
      return $value->email;
    }
  }else{
    return false;
  }
}
function getkdcab(){
  $CI =& get_instance();
  $query=$CI->db->get('jabatan');
  if ($query->num_rows() > 0) {
    return $query->result_array();
  }else{
    return false;
  }
}
function getttduser($id){
  $CI =& get_instance();
  $query=$CI->db->select(array('ttd'))
        ->get_where('user',array('id'=>$id));
  if ($query->num_rows() > 0) {
    foreach ($query->result() as $value) {
      return $value->ttd;
    }
  }else{
    return false;
  } 
}
function cekoptbyid($id,$ide=''){
  $CI =& get_instance();
  if($CI->session->userdata('logged_in')){
      $session_data = $CI->session->userdata('logged_in');
      $idu=(empty($ide))? $session_data['id'] : $ide;
      $query=$CI->db->get_where('options',array('idset'=>$id,'iduser'=>$idu));
      if ($query->num_rows() > 0) {
        foreach ($query->result() as $value) {
          return $value->val;
        }
      }else{
        return false;
      }
  }else{
    return false;
  }
}

function getpurc_byst($sts,$idr){
  $CI =& get_instance();
  $query=$CI->db->get_where('purchase',array('status'=>$sts,'idreq'=>$idr));
  if ($query->num_rows() > 0) {
    return $query->result_array();
  }else{
    return false;
  }
}

function tandastts($stts){
  
  switch ($stts) {
    case 'p':
      $msg='process';
      break;
    case 'w':
      $msg='waiting';
      break;
    case 'wp':
      $msg='Waiting Approval';
      break;
    case 's':
       $msg='success';
       break;
    default:
      $msg='pending';
      break;
  }
  return $msg;
}
function returnkol($tbl,$kol,$out,$key){
  $CI =& get_instance();
  $idreq=array();
  $query=$CI->db->get_where($tbl,array($kol=>$key));
  if ($query->num_rows() > 0) {
    foreach ($query->result() as $valreq) {
        $idreq[]=$valreq->$out;
    }
    return $idreq;
  }else{
    return false;
  }
}
function cekstatus($idreq){
  $CI =& get_instance();
  $query=$CI->db->get_where('antrian',array('status'=>'success','idreq'=>$idreq));
  if ($query->num_rows() > 0) {
    return true;
  }else{
    return false;
  }
}
function getsts_purc($req){
  $CI =& get_instance();
  $sts=array();
  $CI->db->where_in('idreq',$req);
  $query=$CI->db->get('purchase');
  if ($query->num_rows() > 0) {
    foreach ($query->result() as $valreq) {
        $sts[]=$valreq->status;
    }
    return $sts;
  }else{
    return false;
  }
}
/*
              curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: test=cookie"));
              $this->curl->option(CURLOPT_COOKIEFILE,'saved_cookies.txt');
              */
?>