<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Pengeluaran Dana
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i>DAFTAR Pengeluaran DANA</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Data Pengeluaran Dana</h3>
            <a href="#importModal" data-toggle="modal" class="btn btn-flat btn-success btn-sm pull-right">Tambah Data</a>
          </div>
          <div class="box-body">
            <?php include "view/include/alert.php" ?>
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#800000;color:white;">
                <tr>
                  <th>id</th>
                  <th>Nama Barang / Jasa</th>
                  <th>Jumlah Barang / Jasa</th>
                  <th>Satuan</th>
                  <th>Harga Satuan</th>
                  <th>Total Harga</th>
                  <th>Output Barang / Jasa</th>
                  <th>Username</th>
                  <th>Aksi</th>
                </tr>
              </thead>
            </table>
          </div>
        </div>        
      </div>
    </div>
  </section>
</div>
<div class="modal fade" id="importModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <form action="<?php echo $url_rewrite;?>process/pengeluaran/tambah-pengeluaran" id="submitdata" method="POST" enctype="multipart/form-data">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Tambah Data Pengeluaran Dana</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Tujuan Barang / Jasa</label>
            <select class="selectpicker form-control" id="daftar_kegiatan" required="" name="output_kegiatan">

            </select>
          </div>
          <div class="form-group">
            <label>Nama Barang / Jasa</label>
            <input type="text" class="form-control" id="nama_item" name="nama_item" placeholder="Nama Barang / Jasa Tanpa Merk">
          </div>
          <div class="form-group">
            <label>Jumlah Barang / Jasa</label>
            <input type="number" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Sesuai dengan Satuan">
          </div>
          <div class="form-group">
            <label>Satuan Barang / Jasa</label>
            <input type="text" class="form-control" id="satuan" name="satuan" placeholder="Cth: Buah / Orang / Lusin">
          </div>
          <div class="form-group">
            <label>Harga Satuan</label>
            <input type="number" class="form-control" id="harga_satuan" name="harga_satuan" placeholder="Harga Satuan per Barang">
          </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-flat btn-success">Simpan Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
<script>

  $(function () {
    $('#selectbtn').click(function () {
      $("#fileimport").trigger('click');
    });
    $("#fileimport").change(function(){
      $("#filename").attr('value', $(this).val().replace(/C:\\fakepath\\/i, ''));
    });
    $('#selectbtn-revisi').click(function () {
      $("#fileimport-revisi").trigger('click');
    });
    $("#fileimport-revisi").change(function(){
      $("#filename-revisi").attr('value', $(this).val().replace(/C:\\fakepath\\/i, ''));
    });
    var table = $(".table").DataTable({
      "oLanguage": {
        "sInfoFiltered": ""
      },
      "processing": true,
      "serverSide": true,
      "scrollX": true,
      "ajax": {
        "url": "<?php echo $url_rewrite;?>process/pengeluaran/table",
        "type": "POST"
      },
      "columnDefs" : [
        {"targets" : 0,
         "visible" : false},
        {"targets" : 1},
        {"targets" : 2},
        {"targets" : 3},
        {"targets" : 4},
        {"targets" : 5},
        {"targets" : 6},
        {"targets" : 7},
        {"targets" : 8},
      ],
      "order": [[ 1, "asc" ]]
    });
    $('#tanggal, #tanggald').mask('00/00/0000');
    $("#tanggal, #tanggald").datepicker({ 
      changeMonth: true,
      changeYear: true,
      format: 'dd/mm/yyyy' 
    });
    $.ajax({
          type: "post",
          url: '<?php echo $url_rewrite;?>process/pengeluaran/baca_kegiatan',
          success: function (output) {     
            $('#daftar_kegiatan').html(output);
          }
       });
    $(document).on("click", "#btn-edt", function (){

    });
    $('#submitdata').submit(function(e){   
     e.preventDefault();
     $('button:submit').attr("disabled", true); 
     var formURL = $(this).attr("action");
     var addData = new FormData(this);
     $.ajax({
      type: "post",
      data: addData,
      url : formURL,
      contentType: false,
      cache: false,  
      processData: false,
      success: function(data)
      {
        location.reload();
      }
    });
    return false;
  });

    $(document).on("click", "#btn-hps", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row( tr );
      row_id = tabrow.data()[0];
      $.ajax({
        type: "post",
        url : "<?php echo $url_rewrite;?>process/pengeluaran/hapus-pengeluaran",
        data: {key:row_id},
        success: function(data)
        {
          location.reload();
        }
      });
      // return false;
    });
    $(document).on("click", "#btn-pesan", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      $("#vtglimport").val('Tahun Anggaran : '+tabrow.data()[1]);
      // alert('no 2 : '+tabrow.data()[2])
      $("#vtanggal").val(tabrow.data()[2]);
      $("#vno_dipa").val(tabrow.data()[3]);
      $("#vpesan").val(tabrow.data()[8]);
    });
    $(document).on("click", "#btn-viw", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row(tr);
      var f = document.createElement('form');
      f.setAttribute('method','post');
      f.setAttribute('target','_blank');
      f.setAttribute('action','<?php echo $url_rewrite;?>process/rkakl/view');
      var i = document.createElement('input');
      i.setAttribute('type','hidden');
      i.setAttribute('name','filename');
      i.setAttribute('value', tabrow.data()[6]);
      f.appendChild(i);
      document.body.appendChild(f);
      f.submit();
    });
  });
</script>