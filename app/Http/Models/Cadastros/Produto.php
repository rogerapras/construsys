<?php

namespace App\Http\Models\Cadastros;

use App\Http\Models\Model;
/**
 * Description of Produto
 *
 * @author Renan Rodrigues
 */
class Produto extends Model{
    protected $fillable = [
        'idproduto','prddescricao','prddescdet','prdcodigobarras','idunidademedida',
        'idcategoriaproduto','idsubcategoriaproduto'
    ];
    
    public function unidadeMedida(){
        return $this->belongsTo(Unidademedida::class,'idunidademedida');
    }
    
    public function categoria(){
        return $this->belongsTo(Categoriaproduto::class,'idcategoriaproduto');
    }
    
    public function subcategoria(){
        return $this->belongsTo(Subcategoriaproduto::class,'idsubcategoriaproduto');
    }
}