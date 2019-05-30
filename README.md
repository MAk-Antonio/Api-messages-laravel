# Api de Mensagens

Esta API ela utiliza o Laravel Framework.

É possível acessar um exemplar da mesma através de: [API](https://secure-cove-28803.herokuapp.com/)

Não necessariamente ela necessita utilizar autenticações.

Ela gera automaticamente uma autenticação de visitante e grava em sessão.

Caso queira utilizar possui dois métodos específicos além da gera na sessão.

#Simple:
```js
    {
        "identifier": "Identificador de Autenticação",
        "pass": "Chave de registro"("opcional"),
        "auth_type": "simple",
    }
```

#Default:
```js
    {
        "auth":{
            "identifier": "Identificador de Autenticação",
            "pass": "Chave de registro",
        },
        "auth_type": "default"
    }
```

Para mais informação sobre a mesma é possivel acessar a [DOC AQUI](https://secure-cove-28803.herokuapp.com/docs)

# Instalação de ambiente Local

Obrigatório ter um sql server instalado,

PHP>7.0

Web Server de preferência.

Ex:

NGINX, Apache

Baixe e instancie sobre o apontamento do web server de preferência.

Após ter baixado e instanciado sobre o apontamento do web server de preferência,
acesse o diretório e crie um arquivo .env o .env

OBS:
Obrigatório que a Sessão esteja configurada como cookie ao invés de file, e configure 
um Database local

Após isso rode os seguintes comandos:
```bash
    composer update
    composer dump-autoload
    php artisan migrate
    php artisan serve
```  
Tudo Realizado e já estará disponível o ambiente local.

