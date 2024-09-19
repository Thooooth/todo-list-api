# Todo List API

Este é um projeto de backend em PHP para um sistema de gerenciamento de tarefas (To-Do List). A API fornece endpoints para criar, ler, atualizar e excluir tarefas, bem como gerenciar usuários, com autenticação JWT.

## Tecnologias Utilizadas

- PHP 7.4+
- MySQL 5.7+
- Apache 2.4+
- Composer (para gerenciamento de dependências)
- Firebase JWT (para autenticação)

## Estrutura do Projeto
```
todo-list-api/
├── config/
│ ├── config.php # Configurações globais
│ └── Database.php # Configuração do banco de dados
├── models/
│ ├── Task.php # Modelo da entidade Tarefa
│ └── User.php # Modelo da entidade Usuário
├── controllers/
│ ├── TaskController.php # Lógica do CRUD de Tarefas
│ └── UserController.php # Lógica do CRUD de Usuários
├── api/
│ ├── tasks.php # Endpoints para manipulação de Tarefas
│ └── users.php # Endpoints para manipulação de Usuários
├── utils/
│ ├── Response.php # Classe para formatar respostas da API
│ ├── Validator.php # Validação de dados da API
│ ├── JWT.php # Utilitário para geração e validação de JWT
│ └── Logger.php # Classe para logging
├── middleware/
│ └── AuthMiddleware.php # Middleware de autenticação
├── logs/
│ └── app.log # Arquivo de log da aplicação
├── .htaccess # Configuração de reescrita de URLs
├── index.php # Ponto de entrada principal
├── database.sql # Esquema do banco de dados
└── README.md # Documentação do projeto
```

## Configuração

1. Clone o repositório para o seu servidor local.
2. Execute `composer install` para instalar as dependências.
3. Configure o banco de dados MySQL e atualize as credenciais em `config/config.php`.
4. Importe o esquema do banco de dados a partir do arquivo `database.sql`.
5. Configure o servidor Apache para apontar para o diretório do projeto.
6. Certifique-se de que o mod_rewrite está habilitado no Apache.

## Endpoints da API

### Usuários

- `POST /api/users.php`: Criar um novo usuário
- `POST /api/users.php` (com action=login): Login de usuário
- `GET /api/users.php`: Listar todos os usuários (requer autenticação)
- `GET /api/users.php?id={id}`: Obter um usuário específico (requer autenticação)
- `PUT /api/users.php`: Atualizar um usuário existente (requer autenticação)
- `DELETE /api/users.php?id={id}`: Excluir um usuário (requer autenticação)

### Tarefas

- `GET /api/tasks.php`: Listar todas as tarefas do usuário autenticado
- `GET /api/tasks.php?id={id}`: Obter uma tarefa específica
- `POST /api/tasks.php`: Criar uma nova tarefa
- `PUT /api/tasks.php`: Atualizar uma tarefa existente
- `DELETE /api/tasks.php?id={id}`: Excluir uma tarefa

## Uso

Para usar a API, envie requisições HTTP para os endpoints apropriados. Certifique-se de incluir os cabeçalhos necessários e os dados no corpo da requisição quando aplicável.

### Autenticação

Após o login bem-sucedido, você receberá um token JWT. Inclua este token no cabeçalho `Authorization` de todas as requisições subsequentes:

uthorization: Bearer <seu_token_jwt>

Exemplo de criação de uma nova tarefa:

```
POST /api/tasks.php
Content-Type: application/json
Authorization: Bearer <seu_token_jwt>
{
"title": "Comprar leite",
"description": "Comprar 2 litros de leite no supermercado",
"status": "pendente"
}
```


## Segurança

Este projeto implementa:

- Autenticação de usuários usando JWT
- Autorização para garantir que os usuários só possam acessar suas próprias tarefas
- Validação de entrada
- HTTPS para todas as comunicações (deve ser configurado no servidor)

## Logging

O sistema possui um mecanismo de logging básico. Os logs são armazenados em `logs/app.log`.

## Contribuição

Contribuições são bem-vindas! Por favor, abra uma issue ou envie um pull request com suas melhorias.

## Licença

Este projeto está licenciado sob a licença MIT.
