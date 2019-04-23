<?php 
require_once"../konmysqli.php";
$nama_user="";
$usia_kandungan=0;
$method = $_SERVER['REQUEST_METHOD'];

// Process only when method is POST
if($method == 'POST'){
	$requestBody = file_get_contents('php://input');
	$json = json_decode($requestBody);

	$text = $json->result->parameters->text;

	switch ($text) {
		case 'hai':
			$speech = "haii.. Silahkan masukan ID ya";
			break;

		
		default:

		$sql="select nama_user, usia_kandungan from `$tbuser` where `id_user`='$text'";
		if(getJum($conn,$sql)>0){
			$d=getField($conn,$sql);
				$nama_user=$d["nama_user"];
				$usia_kandungan=$d["usia_kandungan"];
		$speech = "terima kasih bu $nama_user sudah melakukan login , saat ini usia kehamilan bunda sudah mencapai $usia_kandungan bulan. Ada yg bisa jos bantu ?";
		}
		else {
		$speech = "Maaf perintah yang anda masukkan salah";			
		}

			break;
	}

	$response = new \stdClass();
	$response->speech = $speech;
	$response->displayText = $speech;
	$response->source = "webhook";
	echo json_encode($response);
}
else
{
	echo "Method not allowed";
}


function getJum($conn,$sql){
  $rs=$conn->query($sql);
  $jum= $rs->num_rows;
	$rs->free();
	return $jum;
}

function getField($conn,$sql){
	$rs=$conn->query($sql);
	$rs->data_seek(0);
	$d= $rs->fetch_assoc();
	$rs->free();
	return $d;
}


?>