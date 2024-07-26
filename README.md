# API de Autenticação em Laravel

Este projeto é uma API básica de autenticação construída com Laravel. Ele permite o registro de usuários, login, obtenção de perfil de usuário autenticado e logout. A API utiliza Laravel Sanctum para autenticação baseada em tokens.

## Funcionalidades

- **Registro de Usuário**: Cria um novo usuário na base de dados.
- **Login de Usuário**: Autentica o usuário e retorna um token de acesso.
- **Perfil de Usuário**: Obtém os dados do usuário autenticado.
- **Logout de Usuário**: Invalida o token de acesso do usuário.

## Endpoints

### Registro

- **URL**: `/api/register`  
- **Método**: `POST`  
- **Corpo da Requisição**:
  ```json
  {
      "name": "Nome do Usuário",
      "email": "email@dominio.com",
      "password": "senha"
  }

### Login

- **URL**: `/api/login`  
- **Método**: `POST`  
- **Corpo da Requisição**:
  ```json
    {
        "email": "email@dominio.com",
        "password": "senha"
    }

### Perfil

- **URL**: `/api/profile`  
- **Método**: `GET`  
- **Cabeçalho**:
  ```json
    {
        "accept": "application/json",
        "Authorization": "Bearer {token}"
    }

### Logout

- **URL**: `/api/logout`  
- **Método**: `POST`  
- **Cabeçalho**:
  ```json
    {
        "accept": "application/json",
        "Authorization": "Bearer {token}"
    }

## Como executar o projeto

1. Clone o Repositório
```git clone https://github.com/gabriellgomess/api-login-laravel-11.git```

2. Instale as dependências
```composer install```

3. Configure o arquivo .env
```cp .env.example .env```

4. Gere a chave da aplicação
```php artisan key:generate```

5. Execute as migrações
```php artisan migrate```

6. Inicir o servidor
```php artisan serve```


