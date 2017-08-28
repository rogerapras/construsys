@extends('layouts.modal')

@section('header')
    Módulo
@endsection
@section('body')
    {{Form::hidden('idmodulo',$record->idmodulo,['label'=>'Código','required','readonly'])}}
    {{Form::formGroup([
        Form::text('modnome',$record->modnome,['label'=>'Nome','required'])
      ])
    }}
    {{Form::formGroup([
        Form::text('modpath',$record->modpath,['label'=>'Path','required'])
      ])
    }}
    {{Form::formGroup([
        Form::text('modicone',$record->modicone,['label'=>'Ícone'])
      ])
    }}
@endsection