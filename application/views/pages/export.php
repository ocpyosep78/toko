<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php echo form_open('gudang/createxls/'.$idtbl);?>
<?php
//var_dump($kolom);?>
<input type="submit" value="create xls" />
<?php echo form_close();?>
<?php
/*-------------------kenangan excelreader export
function headerdyn($tbl){
 		$filed=$this->db->list_fields($tbl);
 		$listf=array();
 		foreach ($filed as $row) {
 			$listf[]=$row;
 		}
 		return $listf;
 	}
 	function export(){
 					$idtbl=$this->input->post("idtbl");
		 			$tabel=$this->mweb->getmanage_by_id($idtbl);
 					$headdd=$this->headerdyn($tabel);
 					$data=array($headdd);
  					$filename='Laporan_'.$tabel;
  					$loop=0;
  					$temparr=array();
  					$content=array();
					$listkol=$this->db->list_fields($tabel);
					$n=count($listkol);
					$queryselect=$this->mweb->gettable($tabel);
					$jmlq=count($queryselect);
					foreach ($queryselect as $row){
						for ($i=0; $i < $n; $i++) { 
							$temparr[] = $row[$listkol[$i]];
							if ($i==$n-1) {
								$temparr[] .=$row[$listkol[$i]].'|';
							}
						}
						
					}
					$isiim=implode(',', $temparr);
					$pisahrow=explode('|', $isiim);
					for ($x=0; $x < $jmlq; $x++) { 
						$content[$x]=explode(',', $pisahrow[$x]);
						array_push($data,$content[$x]);
					}
  					array_to_excel($data, $filename);
  					//redirect('gudang','refresh');
		 }
*/
?>