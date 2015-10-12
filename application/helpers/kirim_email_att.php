<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
// function untuk membaca konten file
function get_content($url){
     $data = curl_init();
     curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($data, CURLOPT_URL, $url);
     $hasil = curl_exec($data);
     curl_close($data);
     return $hasil;
}
// function pengiriman email dengan attachment
/*
$this->email->set_mailtype("html");
        $this->email->from('firmawaneiwan@gmail.com', $session_data['username']);
        $this->email->to($this->input->post('email')); 
        $this->email->subject('Quotation kode barang '.$kdbrang);
        $pesannya='click <a href="'.site_url("gudang/accept_inv/".$kdbrang."/".$qlast).'">here</a> to konfrim';
        $this->email->message($pesannya); 
        $this->email->send();
        */

function kirimquo($id, $email)
{
   // setting nama file attachment
   $namafile = ".pdf";
   // MIME type file PDF sbg attachment
   $fileType = "application/x-pdf";
   // setting pesan intro di email
   //click <a href="'.site_url("gudang/accept_inv/".$kdbrang."/".$qlast).'">here</a> to konfrim
   $introPesan = ''; 

   $fileContent = get_content(site_url('gudang/createpdf//'));
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
   mail($email, "JVM Service", $pesan, $headers);
}
?>