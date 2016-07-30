<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelPenerimaan extends mysql_db {
  	public function insertPenerimaan($data){
  		// echo "masuk";
  		$nama_donatur = $data["nama_donatur"];
  		$alamat = $data["alamat"];
  		$jumlah = $data["jumlah"];
  		$username = $_SESSION["username"];
		$sql = " INSERT INTO penerimaan
					set 
					nama_donatur = '$nama_donatur',
					alamat = '$alamat',
					jumlah = '$jumlah',
					username = '$username'
					";
		return $this->query($sql);

  	}
  	public function deletePenerimaan($id) {
      $query = "delete from penerimaan where id='$id'";
      $result = $this->query($query);
      return $result;
    }
  }

?>
