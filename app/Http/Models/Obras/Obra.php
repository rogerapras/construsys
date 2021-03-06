<?php

namespace App\Http\Models\Obras;

use App\Http\Models\Model;
use App\Http\Models\Cadastros\Cliente;
/**
 * Description of Obra
 *
 * @author Renan Rodrigues
 */
class Obra extends Model{
    protected $fillable = [
        'idcliente','idorcamento','obrtamanho','obrtipo','obrdescricao','obrdatainicio',
        'obrprevisao','obrvalororcado','obrtipoprevisao'
    ];
    
    public function comodos(){
        return $this->hasMany(Comodo::class,'idobra');
    }
    
    public function fasesObra(){
        return $this->hasMany(Faseobra::class,'idobra');
    }
    
    public function cliente(){
        return $this->belongsTo(Cliente::class,'idcliente');
    }
    
    public function despesas(){
        return $this->hasMany(Despesaobra::class,'idobra');
    }
    
    public function pagamentos(){
        return $this->hasMany(Pagamento::class,'idobra');
    }
    
    public function funcionarios(){
        return $this->hasMany(Funcionarioobra::class,'idobra');
    }

    public function comodosAsArray(){
        $comodos = [''=>''];
        foreach ($this->comodos as $comodo) {
            $comodos[$comodo->idcomodo] = $comodo->comdescricao . ' ('.$comodo->tipoComodo->tconome.')';
        }
        return $comodos;
    }

    public function fasesObraAsArray(){
        $fases = [''=>''];
        foreach ($this->fasesObra as $fase) {
            $fases[$fase->idfaseobra] = $fase->fsodescricao . ' ('.$fase->fase->fsedescricao.')';
        }
        return $fases;        
    }
    
    public function endereco(){
        return "";
    }
    
    public function getTiposPrevisao(){
        return [''=>'', 1=>'Dia(s)', 2=>'Mês(es)', 3=>'Ano(s)'];
    }
    public function getTiposObra(){
        return [''=>'', 1=>'Construção', 2=>'Reforma'];
    }
    
    public function getTotalDespesas(){
        return $this->despesas->sum('dsovalortotal');
    }
    
    public function getTotalMaoDeObra(){
        $total = 0;
        foreach($this->funcionarios as $funcionario){
            $total += $funcionario->getTotalCusto();
        }
        return $total;
    }
    
    public function custo(){
        return $this->getTotalDespesas() + $this->getTotalMaoDeObra();
    }
    
    public function totalPago(){
        return $this->pagamentos->sum('pagvalor');
    }
        
    public function dataFim(){
        $inc = 0 ;
        switch($this->obrtipoprevisao){
            case 1:
                $inc = $this->obrprevisao;
                break;
            case 2:
                $inc = $this->obrprevisao * 30;
                break;
            case 3:
                $inc = $this->obrprevisao * 365;
                break;
        }
        return date('Y-m-d',strtotime($this->obrdatainicio.' +'.$inc.' days'));
//        return $inc;
//        return $this->obrprevisao .' '.$this->getTiposPrevisao()[$this->obrtipoprevisao];
    }
    
    public function hintCusto(){
        $despesas = $this->getFloatValue($this->getTotalDespesas());
        $maodeobra = $this->getFloatValue($this->getTotalMaoDeObra());
        return 'Despesas: R$ '.$despesas."\n".'Mão de Obra: R$ '.$maodeobra;
    }
}
