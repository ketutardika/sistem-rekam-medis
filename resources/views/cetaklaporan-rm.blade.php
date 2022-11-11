<html>
<head>
  <title>Laporan Rekap Data Pasien</title>
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
   $sd = date('d F Y', strtotime($_GET['start_date'])); 
   $ed = date('d F Y', strtotime($_GET['end_date']));
?>
  <div class="col-sm-12 row">
    <div class="col-md-6"><span class="float-left">{{get_setting('n_Klinik')}}</span></div>
    <div class="col-md-6"><span class="float-right">Sistem Rekam Medis</span></div>
  </div>
  <div class="clearfix"></div>
  <center>
    <h5>Data Rekap Rekam Medis Pasien</h5>
    <p>Tanggal <?php echo $sd; ?>  Sampai Tanggal : <?php echo $ed; ?><p>
  </center>
 
  <table class='table table-bordered' id="pasien" data-order='[[ 0, "desc" ]]'>
  <thead>
    <tr>
      <th>#</th>                
      <th>Tanggal</th>
      <th>Nama Pasien</th>
      <th>Jenis kelamin</th>
      <th>Umur</th>
      <th>Tanggungan</th>
      <th>Diagnosa</th>
      <th>Terapi</th>
    </tr>
  </thead>
  <tbody>
  <?php $j=1; ?>
  @foreach ($rms as $rm)
    <tr>
      <td><?php echo $j; ?></td>
      <!-- <td>{{str_pad($rm->idpasien, 4, '0', STR_PAD_LEFT)  }}</td> -->
      <td>{{ format_date($rm->created_time) }}</td>
      <td>@if ($rm->idpasien != NULL){{get_value('pasien',$rm->idpasien,'nama')}}@endif</td>
      <td>@if ($rm->idpasien != NULL){{get_value('pasien',$rm->idpasien,'jk')}}@endif</td>
      <td>@if ($rm->idpasien != NULL)
        {{hitung_umur(get_value('pasien',$rm->idpasien,'tgl_lhr'))}}                    
      @endif
      </td>
      <td>@if ($rm->idpasien != NULL){{get_value('pasien',$rm->idpasien,'jenis_asuransi')}}@endif</td>
            <td>
      @if ($rm->diagnosa != NULL)
        @for ($i=0;$i<sizeof($diagnosa=encode($rm->diagnosa));$i++)
                <ul class="dash"><li>{{ get_value('diagnosa',$diagnosa[$i],'kode_diagnosa')}} {{ get_value('diagnosa',$diagnosa[$i],'nama_diagnosa')}}</li></ul>
        @endfor
      @endif
      </td>
      <td>
      @if ($rm->resep != NULL)
        @for ($i=0;$i<sizeof($resep=encode($rm->resep));$i++)
            @if ($aturan=encode($rm->aturan))
                <ul><li>{{ get_value('obat',$resep[$i],'nama_obat')}} {{ get_value('obat',$resep[$i],'sediaan')}} {{ get_value('obat',$resep[$i],'dosis')}} {{ get_value('obat',$resep[$i],'satuan')}} : {{$aturan[$i]}}</li></ul>
            @endif
        @endfor
      @endif
      </td>
    </tr>
   <?php $j++; ?>
  @endforeach
  </tbody>
</table>
<p>
  <?php
    $users = Auth::user()->username; 
    echo "Dibuat Oleh : ".$users."<br> Pada Tanggal: " . date("d F Y") . "<br>";
?>
</p>
</body>
</html>