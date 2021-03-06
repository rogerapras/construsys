<?php

namespace App\Http\Models\Obras;

use App\Http\Models\Model;

/**
 * Description of Faseobra
 *
 * @author Renan Rodrigues
 */
class Comodo extends Model{
    protected $fillable = [
        'idobra','idtipocomodo','comdescricao','comtamanho'
    ];
    
    public function tipoComodo(){
        return $this->belongsTo(Tipocomodo::class,'idtipocomodo');
    }
    
    public function obra(){
        return $this->belongsTo(Obra::class,'idobra');
    }

}
