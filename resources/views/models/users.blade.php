<?
@extends('layouts.default')

@section('content')
    <div id="inicio">
        <h3>Usuários</h3>
    </div>
    <div id="get">
        <h5>Método "Get User"</h5>
        <p>URL:"{{Request::root()}}/users/user/{id do Usuário}"</p>
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
        <h5>Método "Post User"</h5>
        <p>URL:"{{Request::root()}}/users/user/"</p>
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
    <div id="put">
        <h5>Método "Update User"</h5>
        <p>URL:"{{Request::root()}}/users/user/{id do Usuário}"</p>
        <p>Nenhuma requisição necessária, porém recomendado usar uma autenticação</p>

        <pre>
            JSON(Possíveis Alterações) :{
                "identifier": "Identificador de Autenticação",
                "pass": "Chave de registro",
            }
        </pre>
    </div>
    <div id="delete">
        <h5>Método "Delete User"</h5>
        <p>URL:"{{Request::root()}}/users/user/{id do Usuário}"</p>
        <p>Não necessita de autenticação</p>
    </div>
    <div id="auth">
        <h5>Método "get Auth_hash User"</h5>
        <p>Retorna a hash de autenticação do Usuário registrado Default</p>
        <p>URL:"{{Request::root()}}/users/user/{id do Usuário}"</p>
        "auth":{
            "identifier": "Identificador de Autenticação",
            "pass": "Chave de registro",
        },
        "auth_type": "default",
        }
    </div>
@stop
