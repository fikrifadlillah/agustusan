<div class="content-wrapper">
  <section class="content-header">
    <h1>
      Data Penerimaan Dana
      <small>Menu</small>
    </h1>
    <ol class="breadcrumb">
      <li><i class="fa fa-table"></i>DAFTAR PENERIMAAN DANA</li>
    </ol>
  </section>
  <section class="content">
    <div class="row">
      <div class="col-xs-12">
        <div class="box">
          <div class="box-header">
            <h3 class="box-title" style="margin-top:6px;">Table Data Penerimaan Dana</h3>
            <a href="#importModal" data-toggle="modal" class="btn btn-flat btn-success btn-sm pull-right">Tambah Data</a>
          </div>
          <div class="box-body">
            <?php include "view/include/alert.php" ?>
            <table id="table" class="display nowrap table table-bordered table-striped" cellspacing="0" width="100%">
              <thead style="background-color:#11245B;color:white;">
                <tr>
                  <th>id</th>
                  <th>Nama Donatur</th>
                  <th>Alamat</th>
                  <th>Jumlah (Rp)</th>
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
      <form action="<?php echo $url_rewrite;?>process/penerimaan/tambah-dana" method="POST" id="submitdata" enctype="multipart/form-data">
        <div class="modal-header" style="background-color:#111F3F !important; color:white;">
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true" style="color:white">×</span></button>
          <h4 class="modal-title">Tambah Data Penerimaan Dana</h4>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Nama Donatur</label>
            <input type="text" class="form-control tanggal" id="nama_donatur" name="nama_donatur" placeholder="Nama Donatur">
          </div>
          <div class="form-group">
            <label>Alamat Donatur</label>
            <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Misal Blok N1/35 atau RW 20 (Jika dari Kas RT)">
          </div>
          <div class="form-group">
            <label>Jumlah Diterima (Rp)</label>
            <input type="text" class="form-control" id="jumlah" name="jumlah" placeholder="Jumlah Dana Diterima">
          </div>
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
        "url": "<?php echo $url_rewrite;?>process/penerimaan/table",
        "type": "POST"
      },
      "columnDefs" : [
        {"targets" : 0,
         "visible" : false},
        {"targets" : 1},
        {"targets" : 2},
        {"targets" : 3},
        {"targets" : 4},
      ],
      "order": [[ 1, "asc" ]]
    });
    $('#tanggal, #tanggald').mask('00/00/0000');
    $("#tanggal, #tanggald").datepicker({ 
      changeMonth: true,
      changeYear: true,
      format: 'dd/mm/yyyy' 
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
return false;});
    $(document).on("click", "#btn-hps", function (){
      var tr = $(this).closest('tr');
      tabrow = table.row( tr );
      row_id = tabrow.data()[0];
      $.ajax({
        type: "post",
        url : "<?php echo $url_rewrite;?>process/penerimaan/hapus-penerimaan",
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