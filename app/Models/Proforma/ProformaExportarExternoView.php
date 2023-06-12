<?php

namespace App\Models\Proforma;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProformaExportarExternoView extends Model
{
    use HasFactory;
    protected $table = 'mgcp_acuerdo_marco.proformas_exportar_externo_view';
    protected $connection= 'mgcp';
    public $timestamps = false;

    public function getFechaEmisionAttribute()
    {
        return $this->attributes['fecha_emision'] == null ? '' : date_format(date_create($this->attributes['fecha_emision']), 'd-m-Y');
    }

    public function getFechaLimiteAttribute()
    {
        return $this->attributes['fecha_limite'] == null ? '' : date_format(date_create($this->attributes['fecha_limite']), 'd-m-Y');
    }
}
