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
 <style>
            table#tblDiagnosa tr{
                cursor: pointer;transition: all .25s ease-in-out;
            }
            table#tblDiagnosa tr:hover{background-color: #ddd;}
        </style>
  <div id="diagnosaModal" class="modal fade text-success" role="dialog">
   <div class="modal-dialog modal-dialog modal-lg modal-dialog-centered ">
     <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header bg-success">
                 <h4 class="modal-title text-center text-white" >Tabel Data Diagnosa</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">

              <table class="table table-bordered table-sm table-striped" id="tblDiagnosa" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>id</th>
                      <th>Kode</th>
                      <th>Nama Diagnosa</th>
                      <th>Keterangan</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $j=1; ?>
                    @foreach ($diagnosas as $diagnosa)
                    <tr>
                      <td><?php echo $j; ?></td>
                      <td>{{ $diagnosa->id }}</td>
                      <td>{{ $diagnosa->kode_diagnosa }}</td>
                      <td>{{ $diagnosa->nama_diagnosa }}</td>
                      <td>{{ $diagnosa->keterangan }}</td>
                    </tr>
                    <?php $j++; ?>
                    @endforeach
                  </tbody>
              </table>
             </div>
             <div class="modal-footer">

             </div>
         </div>
   </div>
  </div>
    <div class="card shadow mb-4">
                <!-- Card Header - Accordion -->
                <a href="#PilihPasien" class="d-block card-header py-3 {{$cont['col']}}" data-toggle="collapse" role="button" aria-expanded="{{$cont['aria']}}" aria-controls="PilihPasien">
                  <h6 class="m-0 font-weight-bold text-primary">Pilih pasien</h6>
                </a>
                <!-- Card Content - Collapse -->
                <div class="collapse {{$cont['show']}}" id="PilihPasien" style="">
                  <div class="card-body">
                   <div class="table-responsive">
                <table class="table table-bordered table-sm table-striped" id="pasien" data-order='[[ 0, "desc" ]]' width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Nama Lengkap</th>
                      <th>ID Pasien</th>
                      <th>No. Hp</th>
                      <th>Tindakan</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>#</th>
                      <th>Nama Lengkap</th>
                      <th>ID Pasien</th>
                      <th>No. Hp</th>
                      <th>Tindakan</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php $j=1; ?>
                  @foreach ($pasiens as $pasien)
                    <tr>
                      <td><?php echo $j; ?></td>
                      <td>{{ $pasien->nama }}</td>
                      <td>{{ $pasien->no_pasien }}</td>
                      <td>{{ $pasien->hp }}</td>
                      <td width="120px">
                        <a href="{{route('rm.tambah.id',$pasien->id)}}" class="btn btn-primary btn-sm btn-icon-split">
                        <span class="icon text-white-50">
                        <i style="padding-top:4px"class="fas fa-check"></i>
                        </span>
                        <span class="text">Pilih</span>
                        </a>
                      </td>
                    </tr>
                    <?php $j++; ?>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
                  </div>
                </div>
        <div class="card shadow mb-4">
                <a href="#Identitas" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="Identitas">
                  <h6 class="m-0 font-weight-bold text-primary">Identitas Pasien</h6></a>
                <div class="collapse show" id="Identitas">
                <div class="card-body">
                    @if (isset($idens))
                    @foreach ($idens as $iden)
                    <form class="user" action="">
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control " name="Nama_Lengkap" value="{{$iden->nama}}" readonly>
                            </div>
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="jk">Jenis Kelamin</label>
                                <input type="text" class="form-control " name="jk" value="{{$iden->jk}}" readonly> 
                              </div>
                            </div>
                        <div class="form-group row">
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="Tanggal_Lahir">Tanggal lahir :</label>
                            <input type="date" class="form-control " id="Tanggal_Lahir"  name="Tanggal_Lahir"  value="{{$iden->tgl_lhr}}" readonly>
                          </div>
                             <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="jk">Umur</label>
                                <input type="text" class="form-control " id="umur" name="umur" value="" readonly> 
                              </div>
                            </div>
                          <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="Alamat">Alamat</label>
                                <input type="text" class="form-control " name="Alamat"  value="{{$iden->alamat}}" readonly>   
                            </div>
                             <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="no_handphone">No. Handphone</label>
                            <input type="text" class="form-control " name="no_handphone"  value="{{$iden->hp}}" readonly>
                          </div>
                            </div>
                        <div class="form-group row">
                          <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="no_bpjs">Jenis Tanggungan</label>
                                <input type="text" class="form-control " name="jenis_asuransi" value="{{$iden->jenis_asuransi}}" readonly>
                          </div>
                          <div class="col-sm-6 mb-3 mb-sm-0">
                            <label for="no_handphone">No BPJS</label>
                            <input type="text" class="form-control " name="no_bpjs"  value="{{$iden->no_bpjs}}" readonly>
                          </div>
                        </div>
                    </form>
                    @endforeach
                </div>
                </div>
    </div>
    <form class="user" action="{{route('rm.simpan')}}" method="post">
    {{csrf_field()}}

    <div class="card shadow mb-4">
                <a href="#datafisik" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="datafisik">
                  <h6 class="m-0 font-weight-bold text-primary">Data Fisik Pasien</h6></a>
                <div class="collapse show" id="datafisik">
                <div class="card-body">
                            @foreach ($idens as $iden)
                        <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0 row">  
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Tinggi Badan</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="tb" name="tb" value="{{$iden->tb}}" placeholder="Tinggi Badan">
                                  <div class="input-group-append">
                                    <span class="input-group-text">Cm</span>
                                  </div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Berat Badan</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="bb" name="bb" value="{{$iden->bb}}" placeholder="Berat Badan">
                                  <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Lingkar Perut</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="lp" name="lp" value="{{$iden->lp}}" placeholder="Lingkar Perut">
                                  <div class="input-group-append">
                                    <span class="input-group-text">Cm</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">IMT</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="imt" name="imt" value="{{$iden->imt}}" placeholder="IMT" readonly="">
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
                                  <input type="text" class="form-control" id="stole" name="stole" value="{{$iden->stole}}" placeholder="Sistole">
                                  <div class="input-group-append">
                                    <span class="input-group-text">mmHg</span>
                                  </div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Diastole</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="dtole" name="dtole" value="{{$iden->dtole}}" placeholder="Diastole">
                                  <div class="input-group-append">
                                    <span class="input-group-text">mmHg</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Repiratory Rate</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="rr" name="rr" value="{{$iden->rr}}" placeholder="Repiratory Rate">
                                  <div class="input-group-append">
                                    <span class="input-group-text">/ Minute</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Heart Rate</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="hr" name="hr" value="{{$iden->hr}}" placeholder="Heart Rate">
                                  <div class="input-group-append">
                                    <span class="input-group-text">bpm</span>
                                  </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        @endforeach
                          </div>
                      </div>
    </div>


    <div class="card shadow mb-4">
                <a href="#tambahrm" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="tambahrm">
                  <h6 class="m-0 font-weight-bold text-primary">Tambah Rekam Medis</h6></a>
                <div class="collapse show" id="tambahrm">
                <div class="card-body">
                    
                    @foreach ($idens as $iden)
                    <input type="hidden" name="idpasien" value="{{ $iden->id }}">
                    @endforeach
                        <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0 row"> 
                            <label for="dokter">Dokter Pemeriksa</label>
                            <select class="form-control " name="dokter" {{(Auth::user()->admin !== 1) ? (Auth::user()->profesi !== "Staff") ? 'disabled="true"' : '' : ''}}>
                            @foreach ($dokters as $dokter)
                            <option value ="{{$dokter->id}}" {{$dokter->id === Auth::user()->id ? 'selected' : ''}}>dr. {{get_value('users',$dokter->id,'name') }}</option>
                            @endforeach
                            </select>
                            </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0">
                        <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0 row"> 
                            <label for="No-RM">No RM</label>
                            <input type="text" class="form-control " name="no_rm" value="{{ $nomerrm }}" readonly="">
                            </div>
                        </div>
                        </div>                        
                        </div>

   
                        <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0 row"> 
                            <label for="keluhan-utama">Keluhan Utama</label>
                            <input type="text" class="form-control " name="keluhan_utama" value="{{Request::old('keluhan_utama')}}" required>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                            <label for="anamnesis">Anamnesis</label>
                            <div class="col-sm-12 mb-3 mb-sm-0 row"> 
                            <textarea type="date" class="form-control " name="anamnesis" required></textarea>
                            </div>
                            </div>
                        </div>
                        </div>


                        <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0 row"> 
                            <label for="pemeriksaan_fisik">Pemeriksaan Fisik</label>
                            <textarea type="date" class="form-control " name="px_fisik" required></textarea>
                            </div>
                            </div>
                        </div>
                        </div>


                      </div>
                      </div>
    </div>

   
    <div class="card shadow mb-4">
                <a href="#tambahrmresep" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="tambahrmresep">
                  <h6 class="m-0 font-weight-bold text-primary">Data Tindakan & Resep</h6></a>
                <div class="collapse show" id="tambahrmresep">
                <div class="card-body">
                         <div class="form-group row">                            
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                              <label for="diagnosa">Diagnosa</label>
                            </div>
                            <div class="form-group row">
                            <div class="col-sm-9">
                              <input type="hidden" id="iddiagnosa" name="iddiagnosa" value="">
                              <input type="text" id="diagnosis" data-toggle="modal" data-target="#diagnosaModal" class="form-control " name="diagnosis" value="" kode="">
                            </div>
                            <div class="col-sm-3">
                              <a href="javascript:;" onclick="adddiagnosas()" type="button" name="add" id="add" class="btn btn-success">Tambahkan</a>
                                <a href="#" type="button" name="adds" id="adds" class="btn btn-success">Tambahkan</a>
                            </div>
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <table id="diagnosasTable"></table>
                            </div>
                            </div>
                            </div>

 
                        </div>

                        <div class="form-group row">                            
                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                              <label for="diagnosa">Diagnosa</label>
                            </div>
                            <div class="form-group row">
                            <div class="col-sm-9">
                            <select class="form-control " id="diagnosa" name="diagnosa" {{Auth::user()->profesi !== "Dokter" ? 'disabled="true"': ''}}>
                                <option value="" selected disabled>Pilih satu</option>
                                @foreach ($diagnosas as $diagnosa)
                                <option kode="{{$diagnosa->kode_diagnosa}}" value="{{$diagnosa->id}}">{{$diagnosa->kode_diagnosa}} -  {{$diagnosa->nama_diagnosa}}</option>
                                @endforeach
                            </select>  
                            </div>
                            <div class="col-sm-3">
                                <a href="javascript:;" onclick="adddiagnosa()" type="button" name="add" id="add" class="btn btn-success">Tambahkan</a>
                            </div>
                            <div class="col-sm-12 mb-3 mb-sm-0">
                            <table id="diagnosaTable"></table>
                            </div>
                            </div>
                            </div>

                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                              <label for="penunjang">Pemeriksaan Penunjang</label>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-9">
                                <select class="form-control " id="penunjang" name="penunjang" {{Auth::user()->profesi !== "Dokter" ? 'disabled="true"': ''}}>
                                <option value="" selected disabled>Pilih satu</option>
                                @foreach ($labs as $lab)
                                <option satuan="{{$lab->satuan}}" value="{{$lab->id}}">{{$lab->nama}}</option>
                                @endforeach
                                </select>  
                            </div>
                            <div class="col-sm-3">
                                <a href="javascript:;" onclick="addpenunjang()" type="button" name="add" id="add" class="btn btn-success">Tambahkan</a>
                            </div>
                            <div class="col-sm-12 mb-3 mb-sm-0">
                               <table id="dynamicTable"></table>
                            </div>

                            </div>

                            </div>
                        </div>

                        <div class="form-group row">                            
                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                              <label for="tindakan">Tindakan</label>
                            </div>
                            <div class="form-group row">
                            <div class="col-sm-9">
                                <select class="form-control " id="tindakan" name="tindakan" {{Auth::user()->profesi !== "Dokter" ? 'disabled="true"': ''}}>
                                    <option value="" selected disabled>Pilih satu</option>
                                    @foreach ($tindakans as $tindakan)
                                    <option kode="{{$tindakan->no_tindakan}}" value="{{$tindakan->id}}">{{$tindakan->nama}}</option>
                                    @endforeach
                                </select> 
                            </div>
                            <div class="col-sm-3">
                                <a href="javascript:;" onclick="addtindakan()" type="button" name="add" id="add" class="btn btn-success">Tambahkan</a>
                            </div>
                            <div class="col-sm-12 mb-3 mb-sm-0">
                              <table id="tindakanTable"></table>
                            </div>
                            </div>
                            </div>

                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                              <label for="reseplist">Resep</label>
                            </div>

                            <div class="form-group row">
                              <div class="col-sm-9">
                              <select class="form-control " name="reseplist" id="reseplist" {{Auth::user()->profesi !== "Dokter" ? 'disabled="true"': ''}}>
                                  <option value="" selected disabled>Pilih satu</option>
                                  @foreach ($obats as $obat)
                                  <option value="{{$obat->id}}">{{$obat->nama_obat}} {{$obat->sediaan}} {{$obat->dosis}}{{$obat->satuan}}</option>
                                  @endforeach
                              </select> 
                            </div>
                            <div class="col-sm-3">
                                 <a href="javascript:;" onclick="addresep()" type="button" name="addresep" id="addresep" class="btn btn-success">Tambahkan</a>
                            </div>
                            <div class="col-sm-12 mb-3 mb-sm-0">
                               <table width="100%" id="reseps"></table>
                            </div>

                            </div>

                            </div>
                        </div>

                        <div class="form-group row">
                        <div class="col-sm-4 mb-3 mb-sm-0">
                        @foreach ($idens as $iden)
                            <a href= "{{route('rm.list',$iden->id)}}" class="btn btn-danger btn-block" name="simpan">
                                 <i class="fas fa-arrow-left fa-fw"></i> kembali
                            </a>
                        @endforeach
                        </div>
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <button type="submit" class="btn btn-primary btn-block" name="simpan" value="simpan_edit" >
                                 <i class="fas fa-save fa-fw"></i> Simpan
                            </button>
                        </div>
                        <div class="col-sm-4 mb-3 mb-sm-0">
                            <button type="submit" class="btn btn-success btn-block" name="simpan" value="simpan_tagihan" >
                                 <i class="fas fa-cart-plus fa-fw"></i> Simpan & Buat Tagihan
                            </button>
                        </div> 
                    
                </div>
                </div>
                    @endif
    </div>
    </form>
<script>
    $(document).ready( function () {
  var table = $('#pasien,#tblDiagnosa').DataTable( {
    pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
  } )
} );
</script>
<script>
$(document).ready( function () {
$('#diagnosis').focus(function(){
    //open bootsrap modal
    $('#diagnosaModal').modal({
       show: true,     
    });
    $('#tblDiagnosa_filter input').focus();
    return false;
});
</script>
<script type="text/javascript">
$(document).ready( function () {    
  var table = document.getElementById('tblDiagnosa');  
  for(var i = 1; i < table.rows.length; i++)  {
      table.rows[i].onclick = function()
      {    
           var cell1 = this.cells[1].innerHTML;
           var cell2 = this.cells[2].innerHTML;
           var cell3 = this.cells[3].innerHTML;
           var cell4 = this.cells[4].innerHTML;
           var hub = " - "
           var cellinput = cell2 + hub + cell3;

           $('#diagnosis').val(cellinput);
           $('#diagnosis').attr('kode',cell2);
           $('#iddiagnosa').val(cell1);       
           $('#diagnosaModal').modal('toggle');
      };
  }
});
</script>
<script type="text/javascript">
    var i = 0;
    var a = 0;
    var d = 0;
    var t = 0;
    var c = 0;
    function addpenunjang() {
        var pen= $("#penunjang option:selected").html();
        var penid= $("#penunjang").val();
        var satuan =$("#penunjang option:selected").attr('satuan');
        if (penid !== null) {
            //code
            $("#dynamicTable").append('<tr><td><input type="hidden" name="lab['+i+'][id]" value="'+penid+'" class="form-control" readonly></td><td width="60%"><input type="text" name="lab['+i+'][nama]" value="'+pen+'" class="form-control" readonly></td><td width="20%"><input type="text" name="lab['+i+'][hasil]" placeholder="Hasil" class="form-control" required><td width=20%"><input class="form-control" value='+satuan+' readonly></td></td><td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td></tr>');
        }
        ++i;
    };

    function adddiagnosa() {
        var diagnosa= $("#diagnosa option:selected").html();
        var diagnosaid= $("#diagnosa").val();
        var kode =$("#diagnosa option:selected").attr('kode');
        if (diagnosaid !== null) {
            //code
            $("#diagnosaTable").append('<tr><td><input type="hidden" name="diagnosa['+d+'][id]" value="'+diagnosaid+'" class="form-control" readonly></td><td width="50%"><input type="text" name="diagnosa['+d+'][nama_diagnosa]" value="'+diagnosa+'" class="form-control" readonly></td><td width=30%"><input type="text" name="diagnosa['+d+'][kode_diagnosa]" class="form-control" value='+kode+' readonly></td></td><td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td></tr>');
        }
        ++d;
    };

    function adddiagnosas() {
        var diagnosa= $("#diagnosis").val();
        var diagnosaid= $("#iddiagnosa").val();
        var kode =$("#diagnosis").attr('kode');
        if (diagnosaid !== null) {
            //code
            $("#diagnosasTable").append('<tr><td><input type="hidden" name="diagnosa['+c+'][id]" value="'+diagnosaid+'" class="form-control" readonly></td><td width="50%"><input type="text" name="diagnosa['+c+'][nama_diagnosa]" value="'+diagnosa+'" class="form-control" readonly></td><td width=30%"><input type="text" name="diagnosa['+c+'][kode_diagnosa]" class="form-control" value='+kode+' readonly></td></td><td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td></tr>');
        }
        ++c;
    };

    function addtindakan() {
        var tindakan= $("#tindakan option:selected").html();
        var tindakanid= $("#tindakan").val();
        var kode =$("#tindakan option:selected").attr('kode');
        if (tindakanid !== null) {
            //code
            $("#tindakanTable").append('<tr><td><input type="hidden" name="tindakan['+t+'][id]" value="'+tindakanid+'" class="form-control" readonly></td><td width="50%"><input type="text" name="tindakan['+t+'][nama]" value="'+tindakan+'" class="form-control" readonly></td><td width=30%"><input name="tindakan['+t+'][kode_tindakan]" class="form-control" value='+kode+' readonly></td></td><td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td></tr>');
        }
        ++t;
    };

     function addresep() {
        var res= $("#reseplist option:selected").html();
        var resid= $("#reseplist").val();
        if (resid !== null) {
            //code
            $("#reseps").append('<tr><td><input type="hidden" name="resep['+a+'][id]" value="'+resid+'" class="form-control" readonly></td><td width="30%"><input type="text" name="resep['+a+'][nama]" value="'+res+'" class="form-control" readonly></td><td width ="10%"><input type="text" name="resep['+a+'][jumlah]" placeholder="Jumlah" class="form-control" required><td width="30%"><input type="text" name="resep['+a+'][aturan]" placeholder="Aturan pakai" class="form-control" required></td><td><button type="button" class="btn btn-danger remove-res">Hapus</button></td></tr>');
        }
        ++a;
    };
    $(document).on('click', '.remove-pen', function(){  
         $(this).parents('tr').remove();
    });
    $(document).on('click', '.remove-res', function(){  
         $(this).parents('tr').remove();
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
$(document).ready(function(){
$("#tb").keyup(calc);
$("#bb").keyup(calc);
var tinggi,berat,keterangan,bmi;
function calc() {
  tinggi = parseFloat($('#tb').val(), 10);
  tinggi /= 100;
  berat = parseFloat($('#bb').val(), 10);
  bmi = berat / (tinggi * tinggi);
  $('#imt').val(bmi.toFixed(1));
}
});
</script>
@endsection