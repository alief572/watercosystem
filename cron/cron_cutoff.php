<?php

error_reporting(E_ALL & ~E_NOTICE);

ini_set('display_errors', 1);

	  $bulan=date("m");
	  $tahun=date("Y");
	  //$bulan="05";
	  

//misal bulan aktif bulan 2

	  if($bulan=="01")
	  {
		$bulan_prev=12;
		$tahun_prev=$tahun-1;
       
//bulan_prev=1
//tahun_prev=2018


		}
	 else
	  {
		$bulan_prev=$bulan-1;
		$tahun_prev=$tahun;



		}	  
	  
	
      if($bulan_prev=="1")
	  {
		$bulan_prev_prev=12;
		$tahun_prev_prev=$tahun-1;

		}
	 else
	  {
		$bulan_prev_prev=$bulan_prev-1;
	    $tahun_prev_prev=$tahun_prev; 

//bulan_prev_prev = 12
//tahun_prev_prev = 2017


		}	  
	

  
      $conn=mysql_connect("localhost","root","Annabell2018");
	  mysql_select_db("importa_dev");
	  

  //SETUP PIUTANG
      
      $sql=" update ar set saldo_akhir=saldo_awal+debet-kredit where bln='$bulan_prev' and thn='$tahun_prev' ";
      $ex=mysql_query($sql,$conn);
	  if($ex)
	  {
	    echo "sukses $sql <br>";
		}
	  


	  
	  //PIUTANG
      
      $sql=" DELETE from artmp";
      $ex=mysql_query($sql,$conn);
	  if($ex)
	  {
	    echo "sukses $sql <br>";
		}
	  
	  $sql2="  INSERT INTO artmp select * from ar where bln='$bulan_prev' and thn='$tahun_prev' and saldo_akhir > 0 ";
      $ex=mysql_query($sql2,$conn);
	  if($ex)
	  {
	    echo "sukses $sql2 <br>";
		}

	  else
      {
	    echo "GAGAL $sql2 <br>";
		}

	  $sql3=" update artmp set bln='$bulan',thn='$tahun',saldo_awal = saldo_akhir ";
      $ex=mysql_query($sql3,$conn);
	  if($ex)
	  {
	    echo "sukses $sql3 <br>";
		}
	  else
      {
	    echo "GAGAL $sql3 <br>";
		}
	  
	  $sql4=" update artmp set debet=0,kredit=0 ";
      $ex=mysql_query($sql4,$conn);
    if($ex)
	  {
	    echo "sukses $sql4 <br>";
		}
	  else
      {
	    echo "GAGAL $sql4 <br>";
		}

	  	
    
      $sql5=" INSERT INTO ar(`no_invoice`,`tgl_invoice`,`no_so`, `tgl_terima_invoice`,`tgl_jatuh_tempo`,`customer_code`, 
	          `customer`, `bln`, `thn`, `saldo_awal`, `debet`, `kredit`, `saldo_akhir`, `kdcab`,`last_update`) 
              select `no_invoice`, `tgl_invoice`,`no_so`,`tgl_terima_invoice`,`tgl_jatuh_tempo`, `customer_code`,`customer`,
			  `bln`, `thn`, `saldo_awal`, `debet`, `kredit`, `saldo_akhir`, `kdcab`,`last_update` from artmp ";
	  $ex=mysql_query($sql5,$conn);

	  if($ex)
	  {
	    echo "sukses $sql5 <br>";
		}
	  else
      {
	    echo "GAGAL $sql5 <br>";
		}



	  
   
   ?>