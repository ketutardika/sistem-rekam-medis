<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Tindakan extends Model
{
	public $timestamps = false;
	const CREATED_AT = 'name_of_created_at_column';
	const UPDATED_AT = 'name_of_updated_at_column';
    protected $table = "tindakan";
    protected $fillable = ['no_tindakan','nama','satuan','harga','created_at','updated_at'];
}