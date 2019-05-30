<?
@extends('layouts.default')

@section('content')
    <div id="inicio">
        <h3>Usuários</h3>
    </div>
    <div id="list">
        <h5>Método "List"</h5>
        <p>URL:"{{Request::root()}}/messages/list/{id da Conexão (Opcional)}"</p>
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
    <div id="get">
        <h5>Método "get Message"</h5>
        <p>URL:"{{Request::root()}}/messages/message/{id da Mensagem}"</p>
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
    <div id="create">
        <h5>Método "Post Message"</h5>
        <p>URL:"{{Request::root()}}/messages/message/{id da Conexão (Necessário ao mandar para uma mesma conversa)}"</p>
        <p>Nenhuma requisição necessária, porém recomendado usar uma autenticação</p>
        <pre>
            JSON(default) :{
                "auth":{
                    "identifier": "Identificador de Autenticação",
                    "pass": "Chave de registro",
                },
                "message": "Mensagem",
                "subject": "Assunto da Conversa",
                "destination": "Usuário a se Conectar, pode ser um array() com mais de um usuário a se conectar",
                "auth_type": "default",
            }
            JSON(simple) :{
                "identifier": "Identificador de Autenticação",
                "pass": "Chave de registro"("opcional"),
                "auth_type": "simple",
                "message": "Mensagem",
                "subject": "Assunto da Conversa",
                "destination": "Usuário a se Conectar, pode ser um array() com mais de um usuário a se conectar",
            }
        </pre>
    </div>
    <div id="put">
        <h5>Método "Update Message"</h5>
        <p>URL:"{{Request::root()}}/messages/message/{id da Mensagem}"</p>
        <p>Nenhuma requisição necessária, porém recomendado usar uma autenticação</p>
        <pre>
            JSON(Possíveis Alterações) :{
                "message": "Identificador de Autenticação",
            }
        </pre>
    </div>
    <div id="delete">
        <h5>Método "Delete Message"</h5>
        <p>URL:"{{Request::root()}}/messages/message/{id da Mensagem}"</p>
        <p>Não necessita autenticação</p>
    </div>
@stop
