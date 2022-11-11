<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
	public $timestamps = false;
	const CREATED_AT = 'name_of_created_at_column';
	const UPDATED_AT = 'name_of_updated_at_column';
    protected $table = "pasien";
    protected $fillable = ['no_pasien','nama','tgl_lhr','alamat','pekerjaan','hp','jk','pendidikan','jenis_asuransi','no_bpjs','alergi','created_time','updated_time'];
}