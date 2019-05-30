<?
@extends('layouts.app')

@section('content')
    <div data-spy="scroll" data-target="#navbar-example3" data-offset="0" style="
        margin-left: 3rem;
        padding: 2rem 4rem;
    ">
        <h1 id="ínicio">API REST Mensagens</h1>
        <p>
            Essa API cria Conexões de mensagens como conversa,<br/>
            utilizando 3 diferentes métodos de autenticação para criar um usuário.
            <br/>
            Autenticação Simples, Default e por sessão.
            <br/>
            Todas registram a autenticação na sessão.
        </p>
        <b>OBS: Todas as rotas para recursos dessa API devem ser precedidos pelos respectivos grupos:
                "/users","/connections/","/messages"
                Ex:
                "{{Request::root()}}/api/group/resource"
        </b>
        <h2 id="metodos">1. Métodos usados na API</h2>
        <p>São usados nessa API, GET, POST, PUT, DELETE </p>
        <h2 id="codigos-http">2. Códigos HTTP usados</h2>
        <div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">código</th>
                    <th scope="col">Descrição</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>200</td>
                    <td>Status "OK" retornado geralmente quando um GET é efetuado com sucesso</td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>201</td>
                    <td>Status "CRIADO" retornado quando um POST de sucesso é realizado</td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>400</td>
                    <td>Status "REQUISIÇÃO RUIM" esse erro ocorre quando o body de uma requisição POST não segue
                        os padrões requisitado. A API pode retorna informações que ajudem a corrigir o erro.
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>403</td>
                    <td>Status "Proibido" retornado quando o cliente não possui o token adiquirido em /auth.
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>404</td>
                    <td>Status "Não encontrado" retornado quando uma rota ou recurso solicitando não existe.
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <h2 id="padrao-resposta">3. Padrão de resposta</h2>
        <p>
            Essa API responde com JSON "JavaScript Object Notation".
        </p>
        <p></p>
        <h2 id="rota-recursos">4. Rota dos recursos</h2>
        <h3 id="rota-users">4.1 Users</h3>
        <div>
            <p>
                Rota exclusiva para Manipulação de Usuarios.
            </p>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Método</th>
                    <th scope="col">URL</th>
                    <th scope="col">Descrição</th>
                    <th scope="col"><abbr title="Requisição/Resposta">Req/Res</abbr></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>GET</td>
                    <td>users/user/{id/auth_hash}</td>
                    <td>Retorna Informações sobre o usuário Determinado. (Pode ser usado o ID ou o auth_hash) <br/> Para um modelo de requisições, <a href="/model/user/#get" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
"user": [
{
    "id": "User Id",
    "identifier": "Identifier Informado",
    "auth_hash": "Hash de Autenticação gerado ao criar o usuário(Possivel usar em autenticação)",
    "auth_type": "Tipo de Autenticação que foi usada para o Cadastro",
    "created_at": "Data de Criação",
    "updated_at": "2019-05-30 16:35:39"
    "errors": [...(caso exitir)];
    "warning": [...(caso exitir)];
}
]
                        </pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>POST</td>
                    <td>users/user</td>
                    <td>Cria um novo usuário e instancia na Sessão.<br/> Para um modelo de requisições, <a href="/model/user/#create" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
"user": [
    {
        "id": "User Id",
        "identifier": "Identifier Informado",
        "auth_hash": "Hash de Autenticação gerado ao criar o usuário(Possivel usar em autenticação)",
        "auth_type": "Tipo de Autenticação que foi usada para o Cadastro",
        "created_at": "Data de Criação",
        "updated_at": "2019-05-30 16:35:39"
        "errors": [...(caso exitir)];
        "warning": [...(caso exitir)];
    }
]
                        </pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>PUT</td>
                    <td>users/user/{id}</td>
                    <td>Retorna sobre a atualização do usuário.<br/> Para um modelo de requisições, <a href="/model/user/#put" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
"user": {
    "id": "User Id",
    "update": "Update Status"
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>DELETE</td>
                    <td>users/user/{id}</td>
                    <td>Retorna sobre a remoção do usuário.<br/> Para um modelo de requisições, <a href="/model/user/#delete" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
"user": {
    "id": "User Id",
    "delete": "Delete Status"
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>POST</td>
                    <td>users/auth</td>
                    <td>Retorna a Auth_Hash sobre o usuário Criado (Funciona apenas para usuarios de Autenticação padrão). Para um modelo de requisições, <a href="/model/user/#auth" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
"user": [
    {
        "id": "User Id",
        "identifier": "Identifier Informado",
        "auth_hash": "Hash de Autenticação gerado ao criar o usuário(Possivel usar em autenticação)",
        "auth_type": "Tipo de Autenticação que foi usada para o Cadastro",
        "created_at": "Data de Criação",
        "updated_at": "2019-05-30 16:35:39"
        "errors": [...(caso exitir)];
    }
]
                        </pre>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
        <hr>
        <h3 id="rota-messages">4.2 Mensagens</h3>
        <div>
            <p>
                Rota exclusiva para criação de Mensagem.
            </p>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Método</th>
                    <th scope="col">URL</th>
                    <th scope="col">Descrição</th>
                    <th scope="col"><abbr title="Requisição/Resposta">Req/Res</abbr></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>GET</td>
                    <td>messages/list/{conection id}</td>
                    <td>Retorna Informações sobre todas as mensagens.(Possivel listar de apenas uma conexão)<br/> Para um modelo de requisições, <a href="/model/messages/#list" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
"data": {
    "Connection Subject": [
        {
            "id": " ID da Mensagem",
            "user_id": "User ID",
            "connection": "Connexão criada",
            "message": "Mensagem",
            "reference_message": "Id da Mensagem (exemplo de resposta especificada)",
            "created_at": "Data de Criação",
            "updated_at": "Data de Atualização"
        },
        { ... }
    ]
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>GET</td>
                    <td>messages/message/{id}</td>
                    <td>Retorna Informações sobre a mensagem Determinada.<br/> Para um modelo de requisições, <a href="/model/messages/#get" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
{
    "data": {
        "id": " ID da Mensagem",
        "user_id": "User ID",
        "connection": "Connexão criada",
        "message": "Mensagem",
        "reference_message": "Id da Mensagem (exemplo de resposta especificada)",
        "created_at": "Data de Criação",
        "updated_at": "Data de Atualização"
    }
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">3</th>
                    <td>POST</td>
                    <td>messages/message/{?connection_id}</td>
                    <td>Cria uma nova Mensagem. (Necessário passar o parametro da ID da conexão para utilizar da mesma)<br/> Para um modelo de requisições, <a href="/model/messages/#create" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
{
    "connection": 10,
    "user_id": 17,
    "message": 3,
    "success": "Mensagem Criada com sucesso"
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">4</th>
                    <td>PUT</td>
                    <td>users/user/{id}</td>
                    <td>Retorna sobre a atualização da Mensagem.<br/> Para um modelo de requisições, <a href="/model/messages/#put" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
{
    "message": "Message Id",
    "update": "Update Status",
    "success": "Update success",
    "errors": "Erros",
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">5</th>
                    <td>DELETE</td>
                    <td>users/user/{id}</td>
                    <td>Retorna sobre a remoção da Mensagem.<br/> Para um modelo de requisições, <a href="/model/messages/#delete" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
{
    "message": "Message Id",
    "delete": "Delete Status",
    "success": "Delete success",
    "errors": "Erros",
}
                        </pre>
                    </td>
                </tr>
                </tbody>
            </table>

        </div>
        <hr>
        <h3 id="rota-connections">4.3 Connections</h3>
        <div>
            <p>
                Rota exclusiva para consultar e deletar conexões.
            </p>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Método</th>
                    <th scope="col">URL</th>
                    <th scope="col">Descrição</th>
                    <th scope="col"><abbr title="Requisição/Resposta">Req/Res</abbr></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>GET</td>
                    <td>connections/</td>
                    <td>Retorna todas as informações sobre o usuário Determinado. <br/> Para um modelo de requisições, <a href="/model/connections/#list" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>
"data": {
    "9": {
        "id": "Id de Conexão",
        "connection_id": "Conexão",
        "user_id": "Id do Usuário",
        "subject": "Assunto",
        "created_at": "Data de Criação",
        "updated_at": "Data de Atualização"
    }
}
                        </pre>
                    </td>
                </tr>
                <tr>
                    <th scope="row">2</th>
                    <td>DELETE</td>
                    <td>connections/connection</td>
                    <td>Remove o vinculo da conexão ao usuario.<br/> Para um modelo de requisições, <a href="/model/connections/#delete" target="_blank">clique aqui</a>.</td>
                    <td>
                        <b>Resposta</b>
                        <pre>

{
    "connection": "Connection Id",
    "delete": "Delete Status",
}
                        </pre>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
        <div>
            <h2 id="observações">5. Observações Extras</h2>
            <p>
                Essa API fornece de uma rota dev para cada grupo, onde pode ser listado tudo inserido na collection.
                <br/>
                EX: <a href="{{Request::root()}}/api/users/dev">Usuários : {{Request::root()}}/api/users/dev</a>
            </p>
        </div>
    </div>

@stop
