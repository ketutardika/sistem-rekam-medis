<html>
<head>
  <title>Cetak Data Pasien</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <style type="text/css">
    body{font-size: 9pt;}
    table tr td,
    table tr th{
      font-size: 9pt;
      border: 1px solid;
    }
    p{font-size: 9pt;}
    ul {
    list-style: none;
    margin-left: 0;
    padding-left: 1em;
    }
    ul > li:before {
    display: inline-block;
    content: "-";
    width: 1em;
    margin-left: -1em;
    }
  </style>
</head>
<body>
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
?>
  <div class="col-sm-12 row">
    <div class="col-md-6"><span class="float-left">{{get_setting('n_Klinik')}}</span></div>
    <div class="col-md-6"><span class="float-right">Sistem Rekam Medis</span></div>
  </div>
  <div class="clearfix"></div>
  <center>
    <h5>Data Rekam Medis Pasien</h5>
    @foreach ($datas as $data)
    <p>No Rekam Medis : {{$data->no_rm}}</p>
    @endforeach
  </center>
<!--End Modal-->
@foreach ($idens as $iden)
    <p><b>1. Identitas Pasien</b></p>
    <table class='table table-bordered'>
    <tr>
      <td><b>Nama</b></td>
      <td>{{$iden->nama}}</td>
      <td><b>Jenis Kelamin</b></td>
      <td>{{$iden->jk}}</td>
    </tr>
    <tr>
      <td><b>Tanggal Lahir</b></td>
      <td>{{$iden->tgl_lhr}}</td>
      <td><b>Umur</b></td>
      <td>@if ($iden->id != NULL)
        {{hitung_umur(get_value('pasien',$iden->id,'tgl_lhr'))}}                    
      @endif
      </td>
    </tr>
    <tr>
      <td><b>Alamat</b></td>
      <td>{{$iden->alamat}}</td>
      <td><b>No HP</b></td>
      <td>{{$iden->hp}}</td>
    </tr>
    <tr>
      <td><b>Tanggungan</b></td>
      <td>{{$iden->jenis_asuransi}}</td>
      <td><b>No BPJS</b></td>
      <td>{{$iden->no_bpjs}}</td>
    </tr>
    </table>
    <p><b>2. Pemeriksaan Fisik</b></p>
    <table class='table table-bordered'>
    <tr>
      <td>Tinggi Badan : {{$iden->tb}} Cm</td>
      <td>Berat Badan : {{$iden->bb}} Kg</td>
      <td>Lingkar Perut : {{$iden->lp}} Cm</td>
      <td>IMT : {{$iden->imt}} Kg/M2</td>
    </tr>
    <tr>
      <td>Sistole : {{$iden->stole}} Cm</td>
      <td>Diastole : {{$iden->dtole}} Kg</td>
      <td>Repiratory Rate : {{$iden->rr}} Cm</td>
      <td>Heart Rate : {{$iden->hr}} Kg/M2</td>
    </tr>
    </table>

@endforeach

@foreach ($datas as $data)
    <p><b>3. Rekam Medis Pasien</b></p>
    <table class='table table-bordered'>
    <tr>
      <td><b>Tanggal Periksa</b></td>
      <td>{{ format_date($data->created_time) }}</td>
    </tr>
    <tr>
      <td><b>Dokter Pemeriksa</b></td>
      <td>dr. {{ get_value('users',$data->dokter,'name') }}</td>
    </tr>
    <tr>
      <td><b>Keluhan Utama</b></td>
      <td>{{ $data->ku }}</td>
    </tr>
    <tr>
      <td><b>Anamnesis</b></td>
      <td>{{ $data->anamnesis}}</td>
    </tr>
    <tr>
      <td><b>Pemeriksaan Fisik</b></td>
      <td>{{ $data->pxfisik}}</td>
    </tr>
    <tr>
      <td><b>Diagnosa</b></td>
      <td>@if ($data->diagnosa != NULL)@for ($i=0;$i<$num['diagnosa'];$i++)<ul"><li>{{get_value('diagnosa',array_keys($data->alldiagnosa)[$i],'kode_diagnosa')}} - {{get_value('diagnosa',array_keys($data->alldiagnosa)[$i],'nama_diagnosa')}}</li></ul>@endfor
      @endif
      </td>      
    </tr>
    <tr>
      <td><b>Pemeriksaan Penunjang</b></td>
      <td>@if ($data->lab != NULL) @for ($i=0;$i<$num['lab'];$i++) <ul><li> {{get_value('lab',array_keys($data->labhasil)[$i],'nama')}} : {{$data->labhasil[array_keys($data->labhasil)[$i]]}} {{get_value('lab',array_keys($data->labhasil)[$i],'satuan')}} </li></ul> @endfor @endif</td>      
    </tr>
    <tr>
      <td><b>Tindakan</b></td>
      <td>@if ($data->tindakan != NULL) @for ($i=0;$i<$num['tindakan'];$i++) <ul><li>{{get_value('tindakan',array_keys($data->alltindakan)[$i],'nama')}}</li></ul>@endfor @endif
      </td>      
    </tr>
    <tr>
      <td><b>Resep</b></td>
      <td>@if ($data->resep != NULL)@for ($i=0;$i<$num['resep'];$i++) <ul><li class="text-md-left">{{get_value('obat',array_keys($data->allresep)[$i],'nama_obat')}} {{get_value('obat',array_keys($data->allresep)[$i],'sediaan')}} {{get_value('obat',array_keys($data->allresep)[$i],'dosis')}}  {{$data->allresep[array_keys($data->allresep)[$i]]}}</li></ul>@endfor @endif</td>
    </tr>
    </table>
@endforeach

<p>
  <?php
    $users = Auth::user()->username; 
    echo "Dibuat Oleh : ".$users."<br> Pada Tanggal: " . date("d F Y") . "<br>";
?>
</p>  
</body>
</html>