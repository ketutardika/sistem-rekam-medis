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
                 <p class="text-center">Apakah anda yakin untuk menghapus Rekam Medis? Data yang sudah dihapus tidak bisa kembali</p>
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
<style>
table#tblDiagnosa tr, table#tblobats tr{
      cursor: pointer;transition: all .25s ease-in-out;
  }
  table#tblobats .col1 { display: none; }
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
                      <th>Kode</th>
                      <th>Nama Diagnosa</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
              </table>
             </div>
             <div class="modal-footer">

             </div>
         </div>
   </div>
  </div>
  <div id="obatModal" class="modal fade text-success" role="dialog">
   <div class="modal-dialog modal-dialog modal-lg modal-dialog-centered ">
     <!-- Modal content-->
         <div class="modal-content">
             <div class="modal-header bg-success">
                 <h4 class="modal-title text-center text-white" >Tabel Data Obat</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             </div>
             <div class="modal-body">

              <table class="table table-bordered table-sm table-striped" id="tblobats" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th class="col1">id</th>
                      <th>Nama Obat</th>
                      <th>Sediaan</th>
                      <th>Dosis</th>
                      <th>Satuan</th>
                      <th>Harga</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php $j=1; ?>
                    @foreach ($obats as $obat)
                    <tr>
                      <td><?php echo $j; ?></td>
                      <td class="col1">{{ $obat->id }}</td>
                      <td>{{ $obat->nama_obat }}</td>
                      <td>{{ $obat->sediaan }}</td>
                      <td>{{ $obat->dosis }}</td>
                      <td>{{ $obat->satuan }}</td>
                      <td>{{ $obat->harga}}</td>
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
                <a href="#Identitas" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="Identitas">
                  <h6 class="m-0 font-weight-bold text-primary">Identitas Pasien</h6></a>
                <div class="collapse show" id="Identitas">
                <div class="card-body">
                    @foreach ($idens as $iden)
                    <form class="user" action="">
                        <div class="form-group row">                          
                          <div class="@if ($iden->jenis_asuransi == 'BPJS') col-sm-4 @else col-sm-6 @endif mb-3 mb-sm-0">
                                <label for="no_bpjs">Jenis Tanggungan</label>
                                <input type="text" class="form-control " name="jenis_asuransi" value="{{$iden->jenis_asuransi}}" readonly>
                          </div>
                          @if ($iden->jenis_asuransi == 'BPJS')
                          <div class="col-sm-4">
                            <label for="no_handphone">No BPJS</label>
                            <input type="text" class="form-control " name="no_handphone"  value="{{$iden->no_bpjs}}" readonly>
                          </div>
                          @endif
                          <div class="@if ($iden->jenis_asuransi == 'BPJS') col-sm-4 @else col-sm-6 @endif ">
                            <label for="no_handphone">ID Pasien</label>
                            <input type="text" class="form-control " name="no_handphone"  value="{{$iden->no_pasien}}" readonly>
                          </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Nama Lengkap</label>
                                <input type="text" class="form-control " name="Nama_Lengkap" value="{{$iden->nama}}" readonly>
                            </div>
                            <div class="col-sm-6">
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
                          <div class="col-sm-6">
                            <label for="no_handphone">No. Handphone</label>
                            <input type="text" class="form-control " name="no_handphone"  value="{{$iden->hp}}" readonly>
                          </div>
                        </div>

                    </form>
                    @endforeach
                </div>
                </div>
    </div>
    <form class="user" action="{{route('rm.update')}}" method="post">
    {{csrf_field()}}
    @foreach ($datas as $data)

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
                                  <input type="text" class="form-control" id="tb" name="tb" value="{{$iden->tb}}" placeholder="Tinggi Badan" readonly="">
                                  <div class="input-group-append">
                                    <span class="input-group-text">Cm</span>
                                  </div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Berat Badan</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="bb" name="bb" value="{{$iden->bb}}" placeholder="Berat Badan" readonly="">
                                  <div class="input-group-append">
                                    <span class="input-group-text">Kg</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Lingkar Perut</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="lp" name="lp" value="{{$iden->lp}}" placeholder="Lingkar Perut" readonly="">
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
                                  <input type="text" class="form-control" id="stole" name="stole" value="{{$iden->stole}}" placeholder="Sistole" readonly="">
                                  <div class="input-group-append">
                                    <span class="input-group-text">mmHg</span>
                                  </div>
                                </div>
                            </div>
                            <div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Diastole</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="dtole" name="dtole" value="{{$iden->dtole}}" placeholder="Diastole" readonly="">
                                  <div class="input-group-append">
                                    <span class="input-group-text">mmHg</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Repiratory Rate</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="rr" name="rr" value="{{$iden->rr}}" placeholder="Repiratory Rate" readonly="">
                                  <div class="input-group-append">
                                    <span class="input-group-text">/ Minute</span>
                                  </div>
                                </div>
                            </div><div class="col-sm-3 mb-3 mb-sm-0">
                                <label for="Nama_Lengkap">Heart Rate</label>
                                <div class="input-group">
                                  <input type="text" class="form-control" id="hr" name="hr" value="{{$iden->hr}}" placeholder="Heart Rate" readonly="">
                                  <div class="input-group-append">
                                    <span class="input-group-text">bpm</span>
                                  </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        @endforeach
                        <div class="row">
                          <div class="col-sm-12" align="left">
                              <a href="#" id="editfisik" class="btn btn-icon-split btn-warning">
                              <span class="icon"><i class="fas fa-pen" style="padding-top: 4px;"></i></span><span class="text">Edit Data Fisik</span></a>
                          </div>
                      </div>
           </div>
           </div>
    </div>

    <div class="card shadow mb-4">
                <a href="#tambahrm" class="d-block card-header py-3" data-toggle="collapse" role="button" aria-expanded="true" aria-controls="tambahrm">
                  <h6 class="m-0 font-weight-bold text-primary">Tambah Rekam Medis</h6> </a> 
                </a>
                <div class="collapse show" id="tambahrm">
                <div class="card-body">
                <div class="row">
                    <div class="col-sm-12" align="right">
                        <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$data->id}})" data-target="#DeleteModal" class="btn btn-icon-split btn-danger">
                        <span class="icon"><i class="fa  fa-trash" style="padding-top: 4px;"></i></span><span class="text">Hapus Rekam Medis</span></a>
                    </div>
                </div>
                    
                    <input type="hidden" name="idpasien" value="{{ $data->idpasien }}">
                    <input type="hidden" name="id" value="{{ $data->id }}">
                        <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0 row"> 
                            <label for="dokter">Dokter Pemeriksa</label>
                            <select class="form-control " name="dokter" {{(Auth::user()->admin !== 1) ? 'readonly' : ''}}>
                            @foreach ($dokters as $dokter)
                            <option value ="{{$dokter->id}}" {{$dokter->id === $data->dokter ? 'selected' : ''}}>dr. {{get_value('users',$dokter->id,'name') }}</option>
                            @endforeach
                            </select>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0 row"> 
                              <label for="No-RM">No RM</label>
                            <input type="text" class="form-control " name="no_rm" value="{{ $data->no_rm }}" readonly="">
                            </div>
                            </div>
                        </div>
                        </div>

                        <div class="form-group row">
                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0 row"> 
                            <label for="keluhan-utama">Keluhan Utama</label>
                            <input type="text" class="form-control " name="keluhan_utama" value="{{ $data->ku }}" required>
                            </div>
                            </div>
                        </div>

                        <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0 row"> 
                            <label for="anamnesis">Anamnesis</label>
                            <textarea type="date" class="form-control " name="anamnesis"  required>{{ $data->anamnesis}}</textarea>
                            </div>
                            </div>
                        </div>
                        </div>

                        <div class="form-group row">
                        <div class="col-sm-12 mb-3 mb-sm-0">
                            <div class="form-group">
                            <div class="col-sm-12 mb-3 mb-sm-0 row">
                              <label for="pemeriksaan_fisik">Pemeriksaan Fisik</label>
                            <textarea type="date" class="form-control " name="px_fisik">{{ $data->pxfisik }}</textarea>
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
                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                              <label for="diagnosa">Diagnosa</label>
                            </div>

                            <div class="form-group row">
                            <div class="col-sm-9 row">                              
                              <input type="hidden" id="iddiagnosa" name="iddiagnosa" value="">
                              <div class="col-sm-5">
                              <input type="text" id="diagnosis" placeholder="Kode" data-toggle="modal" data-target="#diagnosaModal" class="form-control " name="diagnosiskode" value="" kode="">
                              </div>
                              <div class="col-sm-7 row">
                              <input type="text" id="diagnosisnama" placeholder="Nama Diagnosa" class="form-control " name="diagnosisnama" value="" readonly="">
                              </div>
                            </div>
                            <div class="col-sm-3 row">
                              <a href="javascript:;" onclick="adddiagnosa()" type="button" name="adddiagnosa" id="adddiagnosa" class="btn btn-success">Tambahkan</a>
                            </div>
                            </div>

                          <div class="form-group row">
                          <div class="col-sm-12 mb-3 mb-sm-0">
                              <table id="diagnosaTable" width="75%">
                                  @if ($data->diagnosa != NULL)
                                  @for ($i=0;$i<$num['diagnosa'];$i++)
                                  <tr>
                                      <td><input type="hidden" name="diagnosa[{{$i}}][id]" value="{{array_keys($data->alldiagnosa)[$i]}}" class="form-control" readonly></td>
                                      <td width="30%"><input type="text" name="diagnosa[{{$i}}][kode_diagnosa]" value="{{get_value('diagnosa',array_keys($data->alldiagnosa)[$i],'kode_diagnosa')}}" class="form-control" readonly></td>
                                      <td width="50%"><input type="text" name="diagnosa[{{$i}}][nama_diagnosa]" value="{{get_value('diagnosa',array_keys($data->alldiagnosa)[$i],'nama_diagnosa')}}" class="form-control" readonly></td>
                                      <td><button type="button" class="btn btn-danger remove-dig">Hapus</button></td>
                                  </tr>
                                  @endfor
                                  @endif
                                  </table>
                          </div>
                          </div>

                        </div>


                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                              <label for="penunjang">Pemeriksaan Penunjang</label>
                            </div>
                            
                            <div class="form-group row">
                            <div class="col-sm-9 mb-3 mb-sm-0">
                            <select num="{{$num['lab']}}" class="form-control " id="penunjang" name="penunjang" >
                                <option value="" selected disabled>Pilih satu</option>
                                @foreach ($labs as $lab)
                                <option satuan="{{$lab->satuan}}" value="{{$lab->id}}">{{$lab->nama}}</option>
                                @endforeach
                            </select>  
                            </div>
                              <div class="col-sm-3">
                                  <a href="javascript:;" onclick="addpenunjang()" type="button" name="add" id="add" class="btn btn-success">Tambahkan</a>
                              </div> 
                              </div>                          

                              <div class="form-group row">
                              <div class="col-sm-12 mb-3 mb-sm-0">
                              <table id="dynamicTable" width="75%">
                                @if ($data->lab != NULL)
                                @for ($i=0;$i<$num['lab'];$i++)
                                <tr>
                                    <td><input type="hidden" name="lab[{{$i}}][id]" value="{{array_keys($data->labhasil)[$i]}}" class="form-control" readonly></td>
                                    <td width="50%"><input type="text" name="lab[{{$i}}][nama]" value="{{get_value('lab',array_keys($data->labhasil)[$i],'nama')}}" class="form-control" readonly></td>
                                    <td width="20%"><input type="text" name="lab[{{$i}}][hasil]" value="{{$data->labhasil[array_keys($data->labhasil)[$i]]}}" placeholder="Hasil" class="form-control" required>
                                    <td width="20%"><input class="form-control" value='{{get_value('lab',array_keys($data->labhasil)[$i],'satuan')}}' readonly></td></td>
                                    <td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td>
                                </tr>
                                @endfor
                                @endif
                                </table>
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
                            <div class="col-sm-9 mb-3 mb-sm-0">
                            <select num="{{$num['tindakan']}}" class="form-control " id="tindakans" name="tindakans" >
                                <option value="" selected disabled>Pilih satu</option>
                                @foreach ($tindakans as $tindakan)
                                <option kode="{{$tindakan->no_tindakan}}" value="{{$tindakan->id}}">{{$tindakan->nama}}</option>
                                @endforeach
                            </select>  
                          </div>
                            <div class="col-sm-3">
                                <a href="javascript:;" onclick="addtindakan()" type="button" name="addtindakan" id="addtindakan" class="btn btn-success">Tambahkan</a>
                            </div>
                          </div>

                          <div class="form-group row">
                          <div class="col-sm-12 mb-3 mb-sm-0">
                              <table id="tindakanTable" width="75%">
                                  @if ($data->tindakan != NULL)
                                  @for ($t=0;$t<$num['tindakan'];$t++)
                                  <tr>
                                      <td><input type="hidden" name="tindakan[{{$t}}][id]" value="{{array_keys($data->alltindakan)[$t]}}" class="form-control" readonly></td>
                                      <td width="60%"><input type="text" name="tindakan[{{$t}}][nama]" value="{{get_value('tindakan',array_keys($data->alltindakan)[$t],'nama')}}" class="form-control" readonly></td>
                                      <td width="30%"><input type="text" name="tindakan[{{$t}}][no_tindakan]" value="{{get_value('tindakan',array_keys($data->alltindakan)[$t],'no_tindakan')}}" placeholder="tindakan" class="form-control" readonly></td>
                                      <td><button type="button" class="btn btn-danger remove-tin">Hapus</button></td>
                                  </tr>
                                  @endfor
                                  @endif
                                  </table>
                          </div>
                          </div>

                        </div>
                            


                            <div class="col-sm-6 mb-3 mb-sm-0">
                            <div class="col-sm-12 mb-3 mb-sm-0">
                                <label for="reseplist">Resep</label>
                            </div>
                            
                           <div class="form-group row">
                            <div class="col-sm-9 row">                              
                              <input type="hidden" id="idobats" name="idobats" value="">
                              <div class="col-sm-12">
                              <input type="text" id="inputobats" placeholder="Tambah Resep" data-toggle="modal" data-target="#obatModal" class="form-control " name="inputobats" value="" kode="" num="{{$num['resep']}}">
                              </div>
                            </div>
                            <div class="col-sm-3 row">
                              <a href="javascript:;" onclick="addresep()" type="button" name="addresep" id="addresep" class="btn btn-success">Tambahkan</a>
                            </div>
                            </div>                         

                               <div class="form-group row">
                                <div class="col-sm-12 mb-3 mb-sm-0">
                                <table width="90%" id="reseps">
                                @if ($data->resep != NULL)
                                @for ($i=0;$i<$num['resep'];$i++)
                                <tr>
                                    <td><input type="hidden" name="resep[{{$i}}][id]" value="{{array_keys($data->allresep)[$i]}}" class="form-control" readonly></td>
                                    <td width="50%"><input type="text" name="resep[{{$i}}][nama]" value="{{get_value('obat',array_keys($data->allresep)[$i],'nama_obat')}} {{get_value('obat',array_keys($data->allresep)[$i],'sediaan')}} {{get_value('obat',array_keys($data->allresep)[$i],'dosis')}} {{get_value('obat',array_keys($data->allresep)[$i],'satuan')}}" class="form-control" readonly></td>
                                    <td width="20%"><input type="text" name="resep[{{$i}}][jumlah]" value="{{$data->jum[$i]}}" placeholder="Jumlah" class="form-control" required></td>
                                    <td width ="30%"><input type="text" name="resep[{{$i}}][aturan]" value="{{$data->allresep[array_keys($data->allresep)[$i]]}}" placeholder="Aturan" class="form-control" required></td>
                                    <td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td>
                                </tr>
                                @endfor
                                @endif
                                </table>
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
    </div>
    @endforeach
    </form>
<script>
  $(document).ready( function () {
  var table = $('#pasien, #tblobats').DataTable( {
    pageLength : 5,
    lengthMenu: [[5, 10, 20, -1], [5, 10, 20, 'Todos']]
  });  
});
</script>
<script type="text/javascript">
    var i = $("#penunjang").attr('num');
    var a = $("#reseplist").attr('num');
    var d = $("#diagnosa").attr('num');
    var t = $("#tindakans").attr('num');
    function addpenunjang() {
        var pen= $("#penunjang option:selected").html();
        var penid= $("#penunjang").val();
        var satuan =$("#penunjang option:selected").attr('satuan');
        if (penid !== null) {
            //code
            $("#dynamicTable").append('<tr><td><input type="hidden" name="lab['+i+'][id]" value="'+penid+'" class="form-control" readonly></td><td><input type="text" name="lab['+i+'][nama]" value="'+pen+'" class="form-control" readonly></td><td><input type="text" name="lab['+i+'][hasil]" placeholder="Hasil" class="form-control" required><td width=20%"><input class="form-control" value='+satuan+' readonly></td></td><td><button type="button" class="btn btn-danger remove-pen">Hapus</button></td></tr>');
        }
        ++i;
    };
    function adddiagnosa() {
        var diagnosa= $("#diagnosisnama").val();
        var diagnosaid= $("#iddiagnosa").val();
        var kode =$("#diagnosis").attr('kode');
        if (diagnosaid !== null) {
            //code
            $("#diagnosaTable").append('<tr><td><input type="hidden" name="diagnosa['+d+'][id]" value="'+diagnosaid+'" class="form-control" readonly></td><td width="30%"><input type="text" name="diagnosa['+d+'][kode_diagnosa]" value="'+kode+'" class="form-control" readonly></td><td width=50%"><input type="text" name="diagnosa['+d+'][nama_diagnosa]" class="form-control" value="'+diagnosa+'" readonly></td></td><td><button type="button" class="btn btn-danger remove-dig">Hapus</button></td></tr>');
        }
        ++d;
    };
    function addtindakan() {
        var tindakan= $("#tindakans option:selected").html();
        var tindakanid= $("#tindakans").val();
        var kode= $("#tindakans option:selected").attr('kode');
        if (tindakanid !== null) {
            //code
            $("#tindakanTable").append('<tr><td><input type="hidden" name="tindakan['+t+'][id]" value="'+tindakanid+'" class="form-control" readonly></td><td width="50%"><input type="text" name="tindakan['+t+'][nama]" value="'+tindakan+'" class="form-control" readonly></td><td width=30%"><input class="form-control" value='+kode+' readonly></td></td><td><button type="button" class="btn btn-danger remove-tin">Hapus</button></td></tr>');
        }
        ++t;
    };
     function addresep() {
        var res= $("#inputobats").val();
        var resid= $("#idobats").val();
        if (resid !== null) {
            //code
            $("#reseps").append('<tr><td><input type="hidden" name="resep['+a+'][id]" value="'+resid+'" class="form-control" readonly></td><td><input type="text" name="resep['+a+'][nama]" value="'+res+'" class="form-control" readonly></td><td><input type="text" name="resep['+a+'][jumlah]" placeholder="Jumlah" class="form-control" required><td><input type="text" name="resep['+a+'][aturan]" placeholder="Aturan pakai" class="form-control" required></td><td><button type="button" class="btn btn-danger remove-res">Hapus</button></td></tr>');
        }
        ++a;
    };
    $(document).on('click', '.remove-pen', function(){  
         $(this).parents('tr').remove();
    });
    $(document).on('click', '.remove-res', function(){  
         $(this).parents('tr').remove();
    });
    $(document).on('click', '.remove-dig', function(){  
         $(this).parents('tr').remove();
    });
    $(document).on('click', '.remove-tin', function(){  
         $(this).parents('tr').remove();
    }); 
</script>
                      <script type="text/javascript">
     function deleteData(id)
     {
         var id = id;
         var url = '{{ route("rm.destroy", ":id") }}';
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
        $("#editfisik").on('click', function(){
         event.preventDefault();
          $('#tb').focus();
          $('#tb,#bb,#lp,#stole,#dtole,#rr,#hr').attr('readonly', false);          
         });
    });
</script>
<script>
$(document).ready( function () {
$('#diagnosis').focus(function(){
    //open bootsrap modal
    $('#diagnosaModal').modal({
       show: true,     
    });
});
$('#inputobats').focus(function(){
    //open bootsrap modal
    $('#obatModal').modal({
       show: true,     
    });
});
});
</script>
<script type="text/javascript">
      $(document).ready( function () {        
        var table = $('#tblDiagnosa').DataTable({
            processing: true,
            serverSide: true,
            cache: false,
            ajax: "{{ route('diagnosa.json') }}",
            columns: [
                {data: 'id', name: 'id'},
                {data: 'kode_diagnosa', name: 'kode_diagnosa'},
                {data: 'nama_diagnosa', name: 'nama_diagnosa'},
            ]
        });
        $('#tblobats tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
        var dataid = this.cells[1].innerHTML;
        var datanama = this.cells[2].innerHTML;
        var sediaan = this.cells[3].innerHTML;
        var dosis = this.cells[4].innerHTML;
        var satuan = this.cells[5].innerHTML;
        var hub = " ";
        var datainputsobat = datanama + hub + sediaan + hub + dosis + hub + satuan;
        $('#idobats').val(dataid); 
        $('#inputobats').val(datainputsobat);             
        $('#obatModal').modal('toggle');
    });
});
</script>
<script type="text/javascript">
  $(document).ready(function() {
    var table = $('#tblDiagnosa').DataTable();
     
    $('#tblDiagnosa tbody').on('click', 'tr', function () {
        var data = table.row( this ).data();
         $('#iddiagnosa').val(data['id']); 
        $('#diagnosis').val(data['kode_diagnosa']);
        $('#diagnosisnama').val(data['nama_diagnosa']);        
        $('#diagnosis').attr('kode',data['kode_diagnosa']);              
        $('#diagnosaModal').modal('toggle');
    } );
} );
</script>
<script type="text/javascript">
$(document).ready(function(){
  tinggi = parseFloat($('#tb').val(), 10);
  tinggi /= 100;
  berat = parseFloat($('#bb').val(), 10);
  bmi = berat / (tinggi * tinggi);
  $('#imt').val(bmi.toFixed(1));
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