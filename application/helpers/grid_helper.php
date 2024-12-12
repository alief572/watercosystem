<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
		
		function Enkripsi($sData, $sKey='200881173_limchaemoo'){ 
			$sResult = '';
			for($i=0;$i<strlen($sData);$i++){
				$sChar    = substr($sData, $i, 1);
				$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
				$sChar    = chr(ord($sChar) + ord($sKeyChar));
				$sResult .= $sChar;
			}
			return Enkripsi_base64($sResult);
		}
		
		function Dekripsi($sData, $sKey='200881173_limchaemoo'){
			$sResult = '';
			$sData   = Dekripsi_base64($sData);
			for($i=0;$i<strlen($sData);$i++){
				$sChar    = substr($sData, $i, 1);
				$sKeyChar = substr($sKey, ($i % strlen($sKey)) - 1, 1);
				$sChar    = chr(ord($sChar) - ord($sKeyChar));
				$sResult .= $sChar;
			}
			return $sResult;
		}
		
		function Enkripsi_base64($sData){
			$sBase64 = base64_encode($sData);
			return strtr($sBase64, '+/', '-_');
		}
		
		function Dekripsi_base64($sData){
			$sBase64 = strtr($sData, '-_', '+/');
			return base64_decode($sBase64);
		}
		
		function history($desc=NULL){
			$CI 			=& get_instance();
			$path			= $CI->uri->segment(1); 
			$data_session	= $CI->session->userdata('app_session');
			$userID			= $data_session['id_user'];
			$Date			= date('Y-m-d H:i:s');
			$IP_Address		= $CI->input->ip_address();
			
			$DataHistory=array();
			$DataHistory['user_id']		= $userID;
			$DataHistory['path']		= $path;
			$DataHistory['description']	= $desc;
			$DataHistory['ip_address']	= $IP_Address;
			$DataHistory['created']		= $Date;		
			$CI->db->insert('histories',$DataHistory);
		}
		
			
		function cryptSHA1($fields){
			$key			='-chaemoo173';
			$Encrpt_Kata	= sha1($fields.$key);
			return $Encrpt_Kata;
		}
		
		function getRomawi($bulan){
			$month	= intval($bulan);
			switch($month){
				case "1":
					$romawi	='I';	
					break;
				case "2":
					$romawi	='II';	
					break;
				case "3":
					$romawi	='III';	
					break;
				case "4":
					$romawi	='IV';	
					break;
				case "5":
					$romawi	='V';	
					break;
				case "6":
					$romawi	='VI';	
					break;
				case "7":
					$romawi	='VII';	
					break;
				case "8":
					$romawi	='VIII';	
					break;
				case "9":
					$romawi	='IX';	
					break;
				case "10":
					$romawi	='X';	
					break;
				case "11":
					$romawi	='XI';	
					break;
				case "12":
					$romawi	='XII';	
					break;
			}
			return $romawi;
		}
		
		
	
	function tahun($tgl){
			$tahun = substr($tgl,0,4);
			return $tahun;		 
	}	
	
	

	function getBulan($bln){
				switch ($bln){
					case 1: 
						return "Januari";
						break;
					case 2:
						return "Februari";
						break;
					case 3:
						return "Maret";
						break;
					case 4:
						return "April";
						break;
					case 5:
						return "Mei";
						break;
					case 6:
						return "Juni";
						break;
					case 7:
						return "Juli";
						break;
					case 8:
						return "Agustus";
						break;
					case 9:
						return "September";
						break;
					case 10:
						return "Oktober";
						break;
					case 11:
						return "November";
						break;
					case 12:
						return "Desember";
						break;
				}
			} 
			
		function tgl_indojam($tgl){
			$tanggal2 = substr($tgl,8,2);
			$bulan2 =substr($tgl,5,2);
			$tahun2 = substr($tgl,0,4);
			$jam = substr($tgl,11,2);
			$menit = substr($tgl,14,2);
			
			return $tanggal2.'/'.$bulan2.'/'.$tahun2.' '.$jam.':'.$menit;		 
		}
		
		function jin_date_sql($date){
	$exp = explode('/',$date);
	if(count($exp) == 3) {
		$date = $exp[2].'-'.$exp[1].'-'.$exp[0];
	}
	return $date;
}
 
function jin_date_str($date){
	$exp = explode('-',$date);
	if(count($exp) == 3) {
		$date = $exp[2].'/'.$exp[1].'/'.$exp[0];
	}
	return $date;
}	
?>