<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
class Bookprice_material extends Admin_Controller
{
    //Permission
    protected $viewPermission 	= 'Bookprice_material.View';
    protected $addPermission  	= 'Bookprice_material.Add';
    protected $managePermission = 'Bookprice_material.Manage';
    protected $deletePermission = 'Bookprice_material.Delete';

   public function __construct()
    {
        parent::__construct();

        // $this->load->library(array('Mpdf', 'upload', 'Image_lib'));
        $this->load->model(array('bookprice_material/Slitting_model',
		                         'Aktifitas/aktifitas_model',
                                ));
        $this->template->title('Manage Data Supplier');
        $this->template->page_icon('fa fa-building-o');

        date_default_timezone_set('Asia/Bangkok');
    }

    public function index()
    {
       $this->auth->restrict($this->viewPermission);
        $session = $this->session->userdata('app_session');
		$this->template->page_icon('fa fa-users');
        $data	= $this->db->query("SELECT * FROM ms_bookprice_material ")->result();
        $this->template->set('results', $data);
        $this->template->title('Book Price Material');
        $this->template->render('index'); 
    }

    public function modalUpload(){

		$session = $this->session->userdata('app_session');
		$this->template->title('Add Penawaran Slitting');
		$this->template->render('modalUpload');
    }
	public function importData(){
		set_time_limit(0);
		ini_set('memory_limit','2048M');
		// echo "Masuk"; exit;
		if($_FILES['excel_file']['name']){
			$exts   = getExtension($_FILES['excel_file']['name']);
			if(!in_array($exts,array(1=>'xls','xlsx')))
			{
				$Arr_Kembali		= array(
					'status'		=> 3,
					'pesan'			=> 'Invalid file type, Please Upload the Excel format ...'
				);
			}
			else{
				$fileName = $_FILES['excel_file']['name'];
				$this->load->library(array('PHPExcel'));
				$config['upload_path'] = './assets/files/'; 
				$config['file_name'] = $fileName;
				$config['allowed_types'] = 'xls|xlsx';
				$config['max_size'] = 10000;

				$this->load->library('upload', $config);
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('excel_file')) {
					$error = array('error' => $this->upload->display_errors());
					$Arr_Kembali		= array(
						'status'		=> 3,
						'pesan'			=> 'An Errror occured, please try again later ...'
					);
				}
				else{
					// echo "Masuk"; exit;
					$media = $this->upload->data();
					$inputFileName = './assets/files/'.$media['file_name'];
					$Create_By      = '1';
					$Create_Date    = date('Y-m-d H:i:s');
					 
					try{
						$inputFileType  = PHPExcel_IOFactory::identify($inputFileName);
						$objReader      = PHPExcel_IOFactory::createReader($inputFileType); 
						$objReader->setReadDataOnly(true);                               
						$objPHPExcel    = $objReader->load($inputFileName);
						 
					}catch(Exception $e){
						die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());                               
					}
					 
					$sheet = $objPHPExcel->getSheet(0);
					$highestRow     = $sheet->getHighestRow();
					$highestColumn = $sheet->getHighestColumn();
					$Error      = 0;
					$Arr_Keys   = array();
					$Loop       = 0;
					$Total      = 0;
					$Message    = "";
					$Urut       = 0;
					$Arr_Summary= array();
					$Arr_Detail = array();
					
					$intL 		= 0;
					$intError 	= 0;
					$pesan 		= '';
					$status		= '';
					
					for ($row = 6; $row <= $highestRow; $row++)
					{                              
						$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL,TRUE,FALSE);
						// echo "<pre>";print_r($rowData);exit;
						$Urut++;
						$id_category3							= (isset($rowData[0][1]) && $rowData[0][1])?$rowData[0][1]:'';
						$Arr_Detail[$Urut]['id_category3']  	= $id_category3;
						$alloy									= (isset($rowData[0][2]) && $rowData[0][2])?$rowData[0][2]:'';
						$Arr_Detail[$Urut]['alloy']  			= $alloy;
						$material								= (isset($rowData[0][3]) && $rowData[0][3])?$rowData[0][3]:'-';
						$Arr_Detail[$Urut]['material']  		= $material;
						$hardness								= (isset($rowData[0][4]) && $rowData[0][4])?$rowData[0][4]:'-';
						$Arr_Detail[$Urut]['hardness'] 			= $hardness;
						$thickness								= (isset($rowData[0][5]) && $rowData[0][5])?$rowData[0][5]:'-';
						$Arr_Detail[$Urut]['thickness']  		= $thickness;
						$nilai_bookprice						= (isset($rowData[0][6]) && $rowData[0][6])?$rowData[0][6]:'-';
						$Arr_Detail[$Urut]['nilai_bookprice']  	= $nilai_bookprice;
						
						$Arr_Detail[$Urut]['created_by']    = $Create_By;
						$Arr_Detail[$Urut]['created_date']  = $Create_Date; 
						
					} 
					if($intError > 0){
						$Arr_Kembali	= array(
							'pesan'		=> $pesan,
							'status'	=> $status
						);
					}
					else{
							
								$dtCust 	= array();
								foreach($Arr_Detail AS $val => $valx){
									
									$dtCust[$val]['id_category3']		= trim(strtoupper($valx['id_category3']));
									$dtCust[$val]['alloy']				= trim(strtoupper($valx['alloy']));
									$dtCust[$val]['material']			= trim(strtoupper($valx['material']));
									$dtCust[$val]['hardness']			= trim(strtoupper($valx['hardness']));
									$dtCust[$val]['thickness']			= trim(strtoupper($valx['thickness']));
									$dtCust[$val]['nilai_bookprice']	= trim(strtoupper($valx['nilai_bookprice']));
									$dtCust[$val]['created_by']   		= $valx['created_by'];
									$dtCust[$val]['created_on'] 		= $valx['created_date'];
								} //akhir perulangan
								
								// print_r($dtCust); exit;
								// $this->db->trans_strict(FALSE);
								$this->db->trans_start();
									$this->db->truncate('ms_bookprice_material');
									$this->db->insert_batch('ms_bookprice_material', $dtCust);
								$this->db->trans_complete();
								// echo "Saved Success";
								// exit;
								if ($this->db->trans_status() === FALSE){
									$this->db->trans_rollback();
									$Arr_Kembali	= array(
										'pesan'		=>'Upload Excell Bookprice Failed. Please try again later ...',
										'status'	=> 2
									);
								}
								else{
									$this->db->trans_commit();
									$Arr_Kembali	= array(
										'pesan'		=>'Upload Excell Bookprice Success. Thanks ...',
										'status'	=> 1
									);
								}

					}
				}
			}
		} 
		//penutup data array
		echo json_encode($Arr_Kembali);
	}
	
	public function Download_template(){
        set_time_limit(0);
        ini_set('memory_limit','1024M');
        $this->load->library("PHPExcel");
        $objPHPExcel    = new PHPExcel();
        $style_header = array(
            'borders' => array(
                'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN,
                      'color' => array('rgb'=>'1006A3')
                  )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb'=>'E1E0F7'),
            ),
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
 
        $style_header2 = array( 
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb'=>'E1E0F7'),
            ),
            'font' => array(
                'bold' => true,
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
            )
        );
 
        $styleArray = array(                      
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER
              )
          );
        $styleArray3 = array(                     
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT
              )
          );  
        $styleArray1 = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              ),
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
              )
          );
        $styleArray2 = array(
              'borders' => array(
                  'allborders' => array(
                      'style' => PHPExcel_Style_Border::BORDER_THIN
                  )
              ),
              'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER
              )
          );
          
        $Arr_Bulan  = array(1=>'Jan','Feb','Mar','Apr','Mei','Jun','Jul','Aug','Sep','Oct','Nov','Dec'); 
        $sheet      = $objPHPExcel->getActiveSheet();
		
        $dateX	= date('Y-m-d H:i:s');
        $Row        = 1;
        $NewRow     = $Row+1;
        $Col_Akhir  = $Cols = getColsChar(7);
        $sheet->setCellValue('A'.$Row, "DAFTAR DATA  Bookprice (Waktu Download : ".date('d F Y H:i:s', strtotime($dateX)).")");
        $sheet->getStyle('A'.$Row.':'.$Col_Akhir.$NewRow)->applyFromArray($style_header2);
        $sheet->mergeCells('A'.$Row.':'.$Col_Akhir.$NewRow);
         
        $NewRow = $NewRow +2;
        $NextRow= $NewRow +1;
        
				$sheet ->getColumnDimension("A")->setAutoSize(true);
        $sheet->setCellValue('A'.$NewRow, 'No');
        $sheet->getStyle('A'.$NewRow.':A'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('A'.$NewRow.':A'.$NextRow);
        
		$sheet ->getColumnDimension("B")->setAutoSize(true);
        $sheet->setCellValue('B'.$NewRow, 'Id Category');
        $sheet->getStyle('B'.$NewRow.':B'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('B'.$NewRow.':B'.$NextRow);
		
		$sheet ->getColumnDimension("C")->setAutoSize(true);
		$sheet->setCellValue('C'.$NewRow, 'Type Alloy');
        $sheet->getStyle('C'.$NewRow.':C'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('C'.$NewRow.':C'.$NextRow);
        
		$sheet ->getColumnDimension("D")->setAutoSize(true);
        $sheet->setCellValue('D'.$NewRow, 'Nama Material');
        $sheet->getStyle('D'.$NewRow.':D'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('D'.$NewRow.':D'.$NextRow);
        
		$sheet ->getColumnDimension("E")->setAutoSize(true);
        $sheet->setCellValue('E'.$NewRow, 'Hardness');
        $sheet->getStyle('E'.$NewRow.':E'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('E'.$NewRow.':E'.$NextRow);
		
		$sheet ->getColumnDimension("F")->setAutoSize(true);
		$sheet->setCellValue('F'.$NewRow, 'Thickness');
        $sheet->getStyle('F'.$NewRow.':F'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('F'.$NewRow.':F'.$NextRow);
		
		$sheet ->getColumnDimension("G")->setAutoSize(true);
		$sheet->setCellValue('G'.$NewRow, 'Nilai Book Price');
        $sheet->getStyle('G'.$NewRow.':G'.$NextRow)->applyFromArray($style_header);
        $sheet->mergeCells('G'.$NewRow.':G'.$NextRow);
		
		$qSupplier   	= "	SELECT * FROM 	ms_bookprice_material ";
		// echo $qSupplier;
		// exit;
		$restSupplier   = $this->db->query($qSupplier);
		 
		$Num_Cek    = $restSupplier->num_rows();
		if($Num_Cek > 0){
			$data_Det   = $restSupplier->result_array();
		}
		 
		if($data_Det){
			$awal_row   = $NextRow;
			 $no = 0;
			foreach($data_Det as $key=>$vals){
				$no++;
				$awal_row++;
				$awal_col   = 0;
				 
				$awal_col++;
				$no   = $no;
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $no);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$id_category3   = strtoupper((isset($row_Cek[0]['id_category3']) && $row_Cek[0]['id_category3'])?$row_Cek[0]['id_category3']:$vals['id_category3']);
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $id_category3);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$alloy   = strtoupper((isset($row_Cek[0]['alloy']) && $row_Cek[0]['alloy'])?$row_Cek[0]['alloy']:$vals['alloy']);
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $alloy);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$material   = (isset($row_Cek[0]['material']) && $row_Cek[0]['material'])?$row_Cek[0]['material']:$vals['material'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $material);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$hardness   = strtoupper((isset($row_Cek[0]['hardness']) && $row_Cek[0]['hardness'])?$row_Cek[0]['hardness']:$vals['hardness']);
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $hardness);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$thickness   = (isset($row_Cek[0]['thickness']) && $row_Cek[0]['thickness'])?$row_Cek[0]['thickness']:$vals['thickness'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $thickness);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
				
				$awal_col++;
				$nilai_bookprice   = (isset($row_Cek[0]['nilai_bookprice']) && $row_Cek[0]['nilai_bookprice'])?$row_Cek[0]['nilai_bookprice']:$vals['nilai_bookprice'];
				$Cols       = getColsChar($awal_col);
				$sheet->setCellValue($Cols.$awal_row, $nilai_bookprice);
				$sheet->getStyle($Cols.$awal_row)->applyFromArray($styleArray2);
			}
		}
        $sheet->setTitle('Supplier');
        //mulai menyimpan excel format xlsx, kalau ingin xls ganti Excel2007 menjadi Excel5          
        $objWriter      = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        ob_end_clean();
        //sesuaikan headernya 
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: no-store, no-cache, must-revalidate");
        header("Cache-Control: post-check=0, pre-check=0", false);
        header("Pragma: no-cache");
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        //ubah nama file saat diunduh
        header('Content-Disposition: attachment;filename="Bookprice_Template_'.date('YmdHis').'.xls"');
        //unduh file
        $objWriter->save("php://output"); 
    }



	public function view(){
		$this->auth->restrict($this->viewPermission);
		$id 	= $this->input->post('id');
		$header = $this->db->get_where('cycletime_header',array('id_time' => $id))->result();
    // print_r($header);
		$data = [
			'header' => $header
			];
    $this->template->set('results', $data);
		$this->template->render('view', $data);
	}
	
  public function delete_cycletime(){

  	$Arr_Kembali	= array();
		$data			    = $this->input->post();
    // print_r($data);
    // exit;
		$session 		   = $this->session->userdata('app_session');
    $id_material	 = $data['id'];

    $ArrHeader		  = array(
      'deleted'			=> "Y",
      'deleted_by'	=> $session['id_user'],
      'deleted_date'	=> date('Y-m-d H:i:s')
    );

		$this->db->trans_start();
      $this->db->where('id_time', $id_material);
			$this->db->update('cycletime_header', $ArrHeader);
		$this->db->trans_complete();

		if($this->db->trans_status() === FALSE){
			$this->db->trans_rollback();
			$Arr_Data	= array(
				'pesan'		=>'Delete gagal disimpan ...',
				'status'	=> 0
			);
		}
		else{
			$this->db->trans_commit();
			$Arr_Data	= array(
				'pesan'		=>'Delete berhasil disimpan. Thanks ...',
				'status'	=> 1
			);
		}

		echo json_encode($Arr_Data);
	}

}

?>
