# Todo List API

Este é um projeto de backend em PHP para um sistema de gerenciamento de tarefas (To-Do List). A API fornece endpoints para criar, ler, atualizar e excluir tarefas, bem como gerenciar usuários.

## Tecnologias Utilizadas

- PHP 7.4+
- MySQL 5.7+
- Apache Server

## Estrutura do Projeto

todo-list-api/
│
├── config/
│ └── database.php
│
├── models/
│ ├── Task.php
│ └── User.php
│
├── controllers/
│ ├── TaskController.php
│ └── UserController.php
│
├── api/
│ ├── tasks.php
│ └── users.php
│
├── utils/
│ ├── Response.php
│ └── Validator.php
│
├── .htaccess
├── index.php
└── README.md


## Configuração

1. Clone o repositório para o seu servidor local.
2. Configure o banco de dados MySQL e atualize as credenciais em `config/database.php`.
3. Importe o esquema do banco de dados a partir do arquivo `database.sql` (não incluído neste exemplo, mas você deve criá-lo).
4. Configure o servidor Apache para apontar para o diretório do projeto.

## Endpoints da API

### Tarefas

- `GET /api/tasks.php`: Listar todas as tarefas
- `POST /api/tasks.php`: Criar uma nova tarefa
- `PUT /api/tasks.php`: Atualizar uma tarefa existente
- `DELETE /api/tasks.php`: Excluir uma tarefa

### Usuários

- `GET /api/users.php`: Listar todos os usuários
- `POST /api/users.php`: Criar um novo usuário
- `PUT /api/users.php`: Atualizar um usuário existente
- `DELETE /api/users.php`: Excluir um usuário

## Uso

Para usar a API, envie requisições HTTP para os endpoints apropriados. Certifique-se de incluir os cabeçalhos necessários e os dados no corpo da requisição quando aplicável.

Exemplo de criação de uma nova tarefa:

POST /api/tasks.php
Content-Type: application/json
{
"user_id": 1,
"title": "Comprar leite",
"description": "Comprar 2 litros de leite no supermercado",
"status": "pendente"
}


## Segurança

Este é um projeto básico e não inclui autenticação ou autorização. Em um ambiente de produção, você deve implementar:

- Autenticação de usuários (por exemplo, usando JWT)
- Autorização para garantir que os usuários só possam acessar suas próprias tarefas
- Validação de entrada mais robusta
- HTTPS para todas as comunicações
