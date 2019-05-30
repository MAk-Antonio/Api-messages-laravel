<?
@extends('layouts.default')

@section('content')
    <div id="inicio">

        <h3>Conexões</h3>
        <p>Para conexões não é necessário passar parametros.<br/> Porém recomendado passar a autenticação nas requisições para garantir a conexão</p>
    </div>
    <div id="list">
        <h5>Método "List"</h5>
        <p>URL:"{{Request::root()}}/connections"</p>
        <p>Nenhuma requisição necessária, porém recomendado usar uma autenticação</p>
        <pre>
            JSON(default) :{
            "auth":{
                "identifier": "Identificador de Autenticação",
                "pass": "Chave de registro",
            },
            "auth_type": "default",
            }
            JSON(simple) :{
                "identifier": "Identificador de Autenticação",
                "pass": "Chave de registro"("opcional"),
                "auth_type": "simple",
            }
        </pre>
    </div>
    <div id="delete">
        <h5>Método "Delete"</h5>
        <p>URL:"{{Request::root()}}/connections/connection/{id da conexão}"</p>
        <p>Nenhuma requisição necessária, porém recomendado usar uma autenticação</p>
        <pre>
            JSON(default) :{
            "auth":{
                "identifier": "Identificador de Autenticação",
                "pass": "Chave de registro",
            },
            "auth_type": "default",
            }
            JSON(simple) :{
                "identifier": "Identificador de Autenticação",
                "pass": "Chave de registro"("opcional"),
                "auth_type": "simple",
            }
        </pre>
    </div>

@stop
