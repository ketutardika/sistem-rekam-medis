@extends('master')
@foreach ($metadatas as $metadata)
    @section('judul_halaman')
        {{ $metadata->Judul }}
    @endsection
    @section('deskripsi_halaman')
        {{ $metadata->Deskripsi }}
    @endsection
@endforeach
@section('konten')
<?php
function hitung_umur($tanggal_lahir){
    $birthDate = new DateTime($tanggal_lahir);
    $today = new DateTime("today");
    if ($birthDate > $today) { 
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    return $y." tahun ".$m." bulan ".$d." hari";

}
//Tampilkan Umur dengan Tanggal Lahir 1990-Oktober-25
?>
    <div class="card shadow mb-4">
                <div class="card-header py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Formulir Pasien Baru</h6>
                </div>
                <div class="card-body">
                <div class="card-body">
                    <form class="user" action="{{route('pasien.simpan')}}" method="post">
                    {{csrf_field()}}
                    <?php 
                    $AWAL = 'PS';
                    // karna array dimulai dari 0 maka kita tambah di awal data kosong
                    // bisa juga mulai dari "1"=>"I"
                    $bulanRomawi = array("", "01","02","03", "04", "05","06","07","08","09","10", "11","12");
                    $noUrutAkhir = \App\Pasien::max('id');
                    $no = 1;
                    ?>
                    <div class="form-group row">
                        <div class="col-sm-3">
                        <select id="asuransi" class="form-control " name="Jenis_Asuransi" placeholder="Jenis Kelamin">
                                <option value="" selected disabled>Jenis Tanggungan</option>
                                <option value="Umum">Umum</option>
                                <option value="BPJS">BPJS</option>
                        </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="text" class="form-control " id="nobpjs" name="no_bpjs" placeholder="Nomer BPJS (Tidak Wajib)">
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control " id="no_pasien" name="no_pasien" placeholder="ID Pasien" value="" readonly="">
                        </div>
                        
                    </div>
                    <div class="form-group row">
                            
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <input type="text" class="form-control " name="Nama_Lengkap" placeholder="Nama Lengkap" >
                            </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control datepicker" id="Tanggal_Lahir" name="Tanggal_Lahir" placeholder="Tanggal lahir">
    
                          </div>
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control " id="umur" name="umur" placeholder="Umur" readonly=readonly value="">
                          </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                          <input type="text" class="form-control " name="Alamat" placeholder="Alamat">
                            </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control " name="Pekerjaan" placeholder="Pekerjaan">
                          </div>
                          <div class="col-sm-6">
                            <input type="text" class="form-control " name="no_handphone" placeholder="Nomer Handphone">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <select class="form-control " name="Pendidikan_terakhir" placeholder="Pendidikan terakhir">
                                <option value="" selected disabled>Pendidikan Terakhir</option>
                                <option value="Tidak Ssekolah">Tidak Sekolah</option>
                                <option value="SD">SD</option>
                                <option value="SMP">SMP</option>
                                <option value="SMA">SMA</option>
                                <option value="Perguruan Tinggi">Perguruan Tinggi</option>
                            </select>    
                          </div>
                          <div class="col-sm-6">
                            <select class="form-control " name="Jenis_Kelamin" placeholder="Jenis Kelamin">
                                <option value="" selected disabled>Jenis Kelamin</option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="perempuan">Perempuan</option>
                            </select>
                          </div>
                        </div>

                            <div class="form-group">
                                <textarea class="form-control " name="alergi" placeholder="Daftar Alergi (Tidak Wajib)"></textarea>
                            </div>                                
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <a href="{{route('pasien')}}" class="btn btn-danger btn-block btn">
                                    <i class="fas fa-arrow-left fa-fw"></i> Kembali
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-primary btn-block" name="simpan" value="simpan" >
                                    <i class="fas fa-save fa-fw"></i> Simpan
                                </button>
                            </div>
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-warning btn-block" name ="simpan" value="simpan_baru">
                                    <i class="fas fa-plus fa-fw"></i> Simpan Dan Buat Baru
                                </button>
                            </div>    
                            <div class="col-sm-3">
                                <button type="submit" class="btn btn-success btn-block" name ="simpan" value="simpan_rm">
                                    <i class="fas fa-file fa-fw"></i> Simpan Dan Buka RM
                                </button>
                            </div>       
                        </div>
                    </form>
                </div>
              </div>
<script type="text/javascript">
$(document).ready(function () {
  $( function() {
    $( ".datepicker" ).datepicker({
      changeMonth: true,
      autoclose: false,
      constrainInput: false,
      changeYear: true,
      dateFormat: "yy-mm-dd",
      showButtonPanel: true,
      yearRange: "1930:+0",
      maxDate: "-0Y",
    });
  } );
});
</script>

<script type="text/javascript">
    jQuery(window).on("load", function(){
    $('#Tanggal_Lahir').change(function() {
        var mdate = $("#Tanggal_Lahir").val().toString();
        var yearThen = parseInt(mdate.substring(0,4), 10);
        var monthThen = parseInt(mdate.substring(5,7), 10);
        var dayThen = parseInt(mdate.substring(8,10), 10);
        
        var today = new Date();
        var birthday = new Date(yearThen, monthThen-1, dayThen);
        
        var differenceInMilisecond = today.valueOf() - birthday.valueOf();
        
        var year_age = Math.floor(differenceInMilisecond / 31536000000);
        var day_age = Math.floor((differenceInMilisecond % 31536000000) / 86400000);
        
      
        var month_age = Math.floor(day_age/30);
        
        day_age = day_age % 30;
        
        if (isNaN(year_age) || isNaN(month_age) || isNaN(day_age)) {
            $("#umur").val("Tanggal Lahir Salah");
        }
        else {
            $("#umur").val(year_age + " Tahun " + month_age + " Bulan ");
        }
    });
});
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $("#nobpjs").attr('readonly', true);
        $('#asuransi').change(function() {
              if($(this).val() == 'BPJS'){ // or this.value == 'volvo'
                $("#nobpjs").attr('readonly', false);
              }
              else{
              	$("#nobpjs").attr('readonly', true);
              }            
        });
    });
</script>

<script>
$(document).ready(function(){
  $("#asuransi").on('change', function(){
      event.preventDefault();

      var pcs_val  = $(this).val();

      $.ajax({
        url: "{{route('pasien.ajaxcreate')}}",
        type:"POST",
        data:{
          pcs: pcs_val,
          _token: '{{csrf_token()}}'
        },
        success:function(response){
          $('#no_pasien').val(response);  
        },
        error: function(error) {
         console.log(error);
        }
       });
  });
}); 
</script>
@endsection