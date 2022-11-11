<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
	public $timestamps = false;
	const CREATED_AT = 'name_of_created_at_column';
	const UPDATED_AT = 'name_of_updated_at_column';
    protected $table = "obat";
    protected $fillable = ['nama_obat','sediaan','dosis','satuan','stok','harga','created_time','updated_time'];
}

