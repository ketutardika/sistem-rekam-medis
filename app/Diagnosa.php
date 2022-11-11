<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Diagnosa extends Model
{
	public $timestamps = false;
	const CREATED_AT = 'name_of_created_at_column';
	const UPDATED_AT = 'name_of_updated_at_column';
    protected $table = "diagnosa";
    protected $fillable = ['kode_diagnosa','nama_diagnosa','keterangan','created_at','updated_at'];
}