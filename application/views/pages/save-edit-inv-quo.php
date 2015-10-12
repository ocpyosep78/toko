<?php
if (isset($_GET['savedit'])) {
    $dataedit=htmlspecialchars($_GET['savedit']);
    $pecahedit=explode(',',$dataedit);
    $query=$this->db->query('SELECT * FROM '.$namatbl.' where id="'.$pecahedit[0].'"');
    foreach ($query->result() as $datane) {
        $asli=$datane->produk;
        $pr=explode('|', $datane->produk);
        $qqt=explode('|', $datane->qty);
        $hrgh=explode('|',$datane->price);
        $diskk=explode('|', $datane->disc);
        $subbtl=explode('|', $datane->subtotal);
    }
    $pchedit=explode(',', $dataedit);
    $nz=count($pr);
    $tampung=array();
    for ($z=0; $z < $nz; $z++) { 
      if ($z==$pchedit[1]) {
        $pr[$z]=$pecahedit[2];
        $qqt[$z]=$pecahedit[3];
        $hrgh[$z]=$pecahedit[4];
        $diskk[$z]=$pecahedit[5];
        $subbtl[$z]=$pecahedit[6];
        $tampung[$z]=$pr[$z].','.$qqt[$z].','.$hrgh[$z].','.$diskk[$z].','.$subbtl[$z];
      }else{
        $tampung[]=$pr[$z].','.$qqt[$z].','.$hrgh[$z].','.$diskk[$z].','.$subbtl[$z];
      }
    }
    $ctamp=count($tampung);
    $pisahlagi=array();
    $tangkapl=array();
    for ($g=0; $g < $ctamp; $g++) { 
        $pisahlagi[$g]=explode(',', $tampung[$g]);
        $jmlx=count($pisahlagi[$g]);
        mysql_query("update tempbarang set kdbarang='".$pisahlagi[$g][0]."',qty='".$pisahlagi[$g][1]."',disc='".$pisahlagi[$g][3]."',price='".$pisahlagi[$g][2]."',subtotal='".$pisahlagi[$g][4]."' WHERE id='".$idtemp[$g]."'") or die ("error !");
    }
    for ($xx=0; $xx < $jmlx; $xx++) { 
      $tangkapl[]=$pisahlagi[0][$xx].'|'.$pisahlagi[1][$xx];
    }
    mysql_query("update ".$namatbl." set produk='".$tangkapl[0]."',qty='".$tangkapl[1]."',price='".$tangkapl[2]."',disc='".$tangkapl[3]."',subtotal='".$tangkapl[4]."' where id='".$pecahedit[0]."'");
    $param=explode(',', $urld);
    $query2=$this->db->query('SELECT * FROM '.$namatbl.' where id="'.$pecahedit[0].'"');
    foreach ($query2->result() as $habisupt) {
      $subt=explode('|', $habisupt->subtotal);
    }
    mysql_query("update ".$namatbl." set total='".array_sum($subt)."' where id='".$pecahedit[0]."'") or die("gagal update total");   
    header('Location:'.site_url('gudang/edit/'.$param[0].'/'.$param[1].'/'.$param[2]));
    exit;  
}
if (isset($_GET['cancel'])) {
    unset($_GET['isi2']);
    $param=explode(',', $urld);
    header('Location:'.site_url('gudang/edit/'.$param[0].'/'.$param[1].'/'.$param[2]));
    exit;
}
?>