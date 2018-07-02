<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Checkup extends Model
{
    public $fillable     = ['titulo', 'vl_total_com', 'vl_total_net', 'cs_status', 'tipo'];

    const ATIVO = 'A';
    const INATIVO = 'I';
    
}
