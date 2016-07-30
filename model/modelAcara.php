<?php
  require_once __DIR__ . "/../utility/database/mysql_db.php";
  // session_start();
  class modelAcara extends mysql_db {
    public function insertAcara($data) {
      $nama_kegiatan     = $data['nama_kegiatan'];
      $array_date  = explode("/", $data['tanggal']);
      $array_date_new = array($array_date[2],$array_date[1],$array_date[0]);
      $tanggal = implode("-", $array_date_new);
      $lokasi  = $data['lokasi'];
      $pj     = $data['pj'];
      $dana      = $data['dana'];
      $username      =  $_SESSION['username'];
      // $kdprogram  = $data['kdprogram'];
      // $direktorat = $data['direktorat'];
      // $kdoutput   = $data['kdoutput'];
      $status     = 0;

      $query      = " INSERT INTO kegiatan SET
      nama_kegiatan        = '$nama_kegiatan',
      tanggal               = '$tanggal',
      lokasi                = '$lokasi',
      pj                    = '$pj',
      dana                  = '$dana',
      user_name             = '$username'   ";

      $result = $this->query($query);
      return $result;
    }


    public function updatePengguna($data) {
      $id         = $data['id'];
      $nama       = $data['name'];
      $username   = $data['username'];
      $password   = $data['password'];
      $email      = $data['email'];
      $keterangan = $data['keterangan'];

      $query       = "UPDATE pengguna SET
        nama       = '$nama',
        username   = '$username',
        password   = '$password',
        email      = '$email',
        keterangan = '$keterangan'
        WHERE id   = '$id'
      ";
      
      $result = $this->query($query);
      return $result;
    }

    public function updatePengguna2($data) {
      $id         = $data['id'];
      $nama       = $data['name'];
      $username   = $data['username'];
      $email      = $data['email'];

      $query       = "UPDATE pengguna SET
        nama       = '$nama',
        username   = '$username',
        email      = '$email',
        WHERE id   = '$id'
      ";
      
      $result = $this->query($query);
      $_SESSION['nama'] = $nama;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;
      return $result;
    }
    public function updatePass($data) {
      $id         = $data['id'];
      $newpassword       = $utility->sha512($data['newpassword']);
      $query       = "UPDATE pengguna SET
        password       = '$newpassword'
        WHERE id   = '$id'
      ";
      
      $result = $this->query($query);
      return $result;
    }

    public function getPass($data){
      $id         = $data['id'];
      $query  = "SELECT password from pengguna where id = '$id'";
      $result = $this->query($query);
      $fetch  = $this->fetch_object($result);
      return $fetch->password;
    }

    public function getGroup() {
      $query  = "SELECT kode, nama FROM  grup as r";
      $result = $this->query($query);
      $i=0;
      while($fetch  = $this->fetch_object($result)) {
        $data[$fetch->kode] = $fetch->nama;
        $i++;
      }
      return $data;
    }
    public function editPengguna($data) {
      foreach ($data as $key => $value) {
        $setdata .= "$key = '$value', ";
      }
      $setdata = rtrim($setdata,', ');
      $query = "update pengguna set $setdata where id='$data[id]'";
      $result = $this->query($query);
      return $result;
    }
    public function deleteAcara($id) {
      $query = "delete from kegiatan where id='$id'";
      $result = $this->query($query);
      return $result;
    }
    public function deleteGroup($id) {
      $query = "update grup set status=0 where kode='$id'";
      $result = $this->query($query);
      return $result;
    }
    public function activatePengguna($id) {
      $query = "update pengguna set status = 1 where id='$id'";
      $result = $this->query($query);
      return $result;
    }
    public function deactivatePengguna($id) {
      $query = "update pengguna set status = 0 where id='$id'";
      $result = $this->query($query);
      return $result;
    }
    public function readPengguna($data) {
      $where  = $this->where($data);
      $query  = "SELECT * from pengguna $where";
      $result = $this->query($query);
      $fetch  = $this->fetch_object($result);
      return $fetch;
    }
  }

?>
