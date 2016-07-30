<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";

  class modelPengeluaran extends mysql_db {
  	public function insertPengeluaran($data){

      $output_kegiatan = $data["output_kegiatan"];
      $nama_item = $data["nama_item"];
      $jumlah = $data["jumlah"];
      $satuan = $data["satuan"];
      $harga_satuan = $data["harga_satuan"];
      $total_harga = $jumlah*$harga_satuan;
  		$username = $data["username"];
  		$alamat = $data["alamat"];
  		$jumlah = $data["jumlah"];
  		$username = $_SESSION["username"];
		$sql = " INSERT INTO realisasi
					set 
          output_kegiatan = '$output_kegiatan',
          nama_item = '$nama_item',
          jumlah = '$jumlah',
          satuan = '$satuan',
          harga_satuan = '$harga_satuan',
          total_harga = '$total_harga',
					username = '$username'
					";
		return $this->query($sql);

  	}
  	public function deletePengeluaran($id) {
      $query = "delete from realisasi where id='$id'";
      $result = $this->query($query);
      return $result;
    }
    public function baca_kegiatan() {
      $query = "select nama_kegiatan from kegiatan";
      $result = $this->query($query);
      echo '<option value="">-- Pilih Kegiatan --</option>';
      while ($row = $this->fetch_array($result))
      {
        echo '<option value="'.$row['nama_kegiatan'].'">'.$row['nama_kegiatan']."</option>";
      }
    }
  }

?>
