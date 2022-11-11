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
<style type="text/css">
      input[type="date"]:before {
    content: attr(placeholder) !important;
    color: #aaa;
    margin-right: 0.5em;
  }
</style>
<!--Modal Konfirmasi Delete-->
    <div id="DeleteModal" class="modal fade text-danger" role="dialog">
   <div class="modal-dialog modal-dialog modal-dialog-centered ">
     <!-- Modal content-->
     <form action="" id="deleteForm" method="post">
         <div class="modal-content">
             <div class="modal-header bg-danger">
                 <h4 class="modal-title text-center text-white" >Konfirmasi Penghapusan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">
                 {{ csrf_field() }}
                 {{ method_field('DELETE') }}
                 <p class="text-center">Apakah anda yakin untuk menghapus pasien? Data yang sudah dihapus tidak bisa kembali</p>
             </div>
             <div class="modal-footer">
                 <center>
                     <button type="button" class="btn btn-success" data-dismiss="modal">Tidak, Batal</button>
                     <button type="button" name="" class="btn btn-danger" data-dismiss="modal" onclick="formSubmit()">Ya, Hapus</button>
                 </center>
             </div>
         </div>
     </form>
   </div>
  </div>
<!--End Modal-->
    <div class="card shadow mb-4">
    @foreach ($datas as $data)
                <div class="card-header d-sm-flex align-items-center justify-content-between py-3">
                  <h6 class="m-0 font-weight-bold text-primary">Formulir Edit Pasien</h6>
                    <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$data->id}})" data-target="#DeleteModal" class="btn btn-sm btn-icon-split btn-danger">
                        <span class="icon"><i class="fa  fa-trash" style="padding-top: 4px;"></i></span><span class="text">Hapus</span>
                    </a>
                </div>
                <div class="card-body">
                <div class="card-body">
                    <code class="mb-6">Data terakhir diperbaharui {{ hitung_usia($data->updated_time) }} yang lalu</code>
                    <form class="user" action="{{route('pasien.update')}}" method="post">
                    {{csrf_field()}}
                    <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="form-group row">
                              <div class="col-sm-3">
                                <select id="asuransi" class="form-control " name="Jenis_Asuransi" placeholder="Jenis Kelamin">
                                    <option value="" {{ $data->jenis_asuransi == '' ? 'selected' : '' }} disabled>Jenis Tanggungan</option>
                                    <option value="Umum"{{ $data->jenis_asuransi == 'Umum' ? 'selected' : '' }}>Umum</option>
                                    <option value="BPJS"{{ $data->jenis_asuransi == 'BPJS' ? 'selected' : '' }}>BPJS</option>
                                </select>
                              </div>
                              <div class="col-sm-3">
                                <input type="text" class="form-control " id="nobpjs" name="no_bpjs" placeholder="Nomer BPJS (Tidak Wajib)" value="{{ $data->no_bpjs}}" >
                            </div>
                              <div class="col-sm-6 mb-3 mb-sm-0">
                                <input type="text" class="form-control " id="no_pasien" name="no_pasien" placeholder="ID Pasien" value="{{ $data->no_pasien}}" readonly="">
                            </div>
                        </div>
                        <div class="form-group row">                          
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <input type="text" class="form-control " name="Nama_Lengkap" placeholder="Nama Lengkap" value="{{ $data->nama}}" >
                            </div>
                          </div>
                          <div class="form-group row">
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control datepicker" id="Tanggal_Lahir" name="Tanggal_Lahir" placeholder="Tanggal lahir" value="{{ $data->tgl_lhr}}">
                          </div>
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control " id="umur" name="umur" placeholder="Umur" readonly=readonly value="">
                          </div>
                        </div>
                        <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                          <input type="text" class="form-control " name="Alamat" placeholder="Alamat" value="{{ $data->alamat}}">
                        </div>
                        </div>

                        <div class="form-group row">
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <input type="text" class="form-control " name="Pekerjaan" placeholder="Pekerjaan" value="{{ $data->pekerjaan}}">
                          </div>
                          <div class="col-sm-6">
                            <input type="text" class="form-control " name="no_handphone" placeholder="Nomer Handphone" value="{{ $data->hp}}">
                          </div>
                        </div>
                        <div class="form-group row">
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <select class="form-control " name="Pendidikan_terakhir" placeholder="Pendidikan terakhir" value="{{ $data->pendidikan}}">
                                <option value=""{{ $data->pendidikan == '' ? 'selected' : ''  }} disabled>Pendidikan Terakhir</option>
                                <option value="Tidak Sekolah" {{ $data->pendidikan == 'Tidak Sekolah' ? 'selected' : ''  }}>Tidak Sekolah</option>
                                <option value="SD" {{ $data->pendidikan == 'SD' ? 'selected' : '' }}>SD</option>
                                <option value="SMP"{{ $data->pendidikan == 'SMP' ? 'selected' : '' }}>SMP</option>
                                <option value="SMA" {{ $data->pendidikan == 'SMA' ? 'selected' : ''  }}>SMA</option>
                                <option value="Perguruan Tinggi" {{ $data->pendidikan == 'Perguruan Tinggi' ? 'selected' : ''  }}>Perguruan Tinggi</option>
                            </select>    
                          </div>
                          <div class="col-sm-6">
                            <select class="form-control " name="Jenis_Kelamin" placeholder="Jenis Kelamin">
                                <option value="" {{ $data->jk == '' ? 'selected' : '' }} disabled>Jenis Kelamin</option>
                                <option value="Laki-laki"{{ $data->jk == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan"{{ $data->jk == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                          </div>
                        </div>

                        <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0 row">  
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Tinggi Badan</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="tb" name="tb" value="{{$data->tb}}" placeholder="Tinggi Badan">
                                  <div class="input-group-append">
                                    <span class="input-group-text">Cm</span>
                                  </div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Berat Badan</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="bb" name="bb" value="{{$data->bb}}" placeholder="Berat Badan">
                                  <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Lingkar Perut</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="lp" name="lp" value="{{$data->lp}}" placeholder="Lingkar Perut">
                                  <div class="input-group-append">
                                    <span class="input-group-text">Cm</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">IMT</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="imt" name="imt" value="{{$data->imt}}" placeholder="IMT">
                                  <div class="input-group-append">
                                    <span class="input-group-text">Kg/M2</span>
                                  </div>
                                </div>
                            </div>
                          </div>
                          </div>

                          <div class="form-group row">
                            <div class="col-sm-12 mb-3 mb-sm-0 row">  
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Sistole</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="stole" name="stole" value="{{$data->stole}}" placeholder="Sistole">
                                  <div class="input-group-append">
                                    <span class="input-group-text">mmHg</span>
                                  </div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Diastole</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="dtole" name="dtole" value="{{$data->dtole}}" placeholder="Diastole">
                                  <div class="input-group-append">
                                    <span class="input-group-text">mmHg</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Repiratory Rate</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="rr" name="rr" value="{{$data->rr}}" placeholder="Repiratory Rate">
                                  <div class="input-group-append">
                                    <span class="input-group-text">/ Minute</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Heart Rate</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="hr" name="hr" value="{{$data->hr}}" placeholder="Heart Rate">
                                  <div class="input-group-append">
                                    <span class="input-group-text">bpm</span>
                                  </div>
                                </div>
                            </div>
                        </div>
                        </div>

                            <div class="form-group">
                                <textarea class="form-control " name="alergi" placeholder="Daftar Alergi (Tidak Wajib)">{{ $data->alergi}}</textarea>
                            </div>                                
                        <div class="form-group row">
                            <div class="col-sm-3">
                                <a href="{{route ('pasien')}}" class="btn btn-danger btn-block btn">
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
                    @endforeach
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
     function deleteData(id)
     {
         var id = id;
         var url = '{{ route("pasien.destroy", ":id") }}';
         url = url.replace(':id', id);
         $("#deleteForm").attr('action', url);
     }
     function formSubmit()
     {
         $("#deleteForm").submit();
     }
  </script>
  <script type="text/javascript">
    $(document).ready(function(){
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
    $(document).ready(function(){
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
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#nobpjs").attr('readonly', true);
        if($("#asuransi").val() == 'BPJS'){ // or this.value == 'volvo'
            $("#nobpjs").attr('readonly', false);
        }   
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