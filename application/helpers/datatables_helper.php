<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
 * function that generate the action buttons edit, delete
 * This is just showing the idea you can use it in different view or whatever fits your needs
 */
function get_buttons($id,$idmng,$kolid)
{
    $ci = & get_instance();
    $html = '<div class="btn-group" role="group">';
    $html .=anchor(site_url('gudang/edit/'.$id.'/'.$idmng.'/'.$kolid), 'Edit', array('class' => 'btn btn-sm btn-primary'));
    $html .=anchor(site_url('gudang/delete/'.$id.'/'.$idmng.'/'.$kolid), 'Delete', array('class' => 'btn btn-sm btn-primary'));
    $html .= '</div>';
 
    return $html;
}

function get_idmenu($idmng){
	  $CI =& get_instance();
  if($CI->session->userdata('logged_in')){
    $query=$CI->db->get_where('pages',array('idmng'=>$idmng));
    if ($query->num_rows()>0) {
      foreach ($query->result() as $value){
         return $value->idmenu;
      }
    }else{
    	return false;
    }
  }else{
  	return false;
  }

}

function getidmng($tabel){
      $CI =& get_instance();
  if($CI->session->userdata('logged_in')){
    $query=$CI->db->get_where('manage',array('table'=>$tabel));
    if ($query->num_rows()>0) {
      foreach ($query->result() as $value){
         return $value->idmng;
      }
    }else{
      return false;
    }
  }else{
    return false;
  }
}
function getuserID(){
  $CI =& get_instance();
  if($CI->session->userdata('logged_in')){
    $session_data = $CI->session->userdata('logged_in');
    $idu=$session_data['id'];
    return $idu;
  }else{
    return false;
  }
}

function search_array($needle, $haystack) {
     if(in_array($needle, $haystack)) {
          return true;
     }
     foreach($haystack as $element) {
          if(is_array($element) && search_array($needle, $element))
               return true;
     }
   return false;
}
