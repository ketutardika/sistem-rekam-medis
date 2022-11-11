<?php
namespace App;
use Illuminate\Database\Eloquent\Model;

class Lab extends Model
{
	public $timestamps = false;
	const CREATED_AT = 'name_of_created_at_column';
	const UPDATED_AT = 'name_of_updated_at_column';
    protected $table = "lab";
    protected $fillable = ['nama','satuan','harga','created_time','updated_time'];
}