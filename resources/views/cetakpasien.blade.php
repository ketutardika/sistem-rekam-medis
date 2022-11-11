<html>
<head>
  <title>Rekap Data Pasien</title>
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
    <h5>Data Rekap Pasien</h5>
    <p>Tanggal <?php echo date("Y-m-d H:i:s"); ?><p>
  </center>
 
  <table class='table table-bordered' id="pasien" data-order='[[ 0, "desc" ]]'>
  <thead>
    <tr>
      <th>#</th>  
      <th>ID Pasien</th> 
      <th>Jenis Pasien</th>             
      <th>Nama Lengkap</th> 
      <th>Jenis Kelamin</th>
      <th>Tanggal Lahir</th>
      <th>Umur</th>
      <th>Pendidikan</th>
      <th>Pekerjaan</th>
      <th>Alamat</th>
      <th>No Hp</th>      
    </tr>
  </thead>
  <tbody>
  <?php $j=1; ?>
  @foreach ($idens as $iden)
    <tr>
      <td><?php echo $j; ?></td>
      <td>{{ $iden->no_pasien}}</td>      
      <td>{{ $iden->jenis_asuransi}} @if ($iden->jenis_asuransi == 'BPJS') - {{ $iden->no_bpjs}} @endif</td>
      <td>{{ $iden->nama}}</td>
      <td>{{ $iden->jk}}</td>
      <td>{{ $iden->tgl_lhr}}</td>
      <td>{{ hitung_usia($iden->tgl_lhr) }}</td>
      <td>{{ $iden->pendidikan}}</td>
      <td>{{ $iden->pekerjaan}}</td>
      <td>{{ $iden->alamat}}</td>
      <td>{{ $iden->hp}}</td>
    </tr>
   <?php $j++; ?>
  @endforeach
  </tbody>
</table>
<p>
  <?php
    $users = Auth::user()->username; 
    echo "Dibuat Oleh : ".$users."<br> Pada Tanggal: " . date("Y-m-d H:i:s") . "<br>";
?>
</p>
</body>
</html>