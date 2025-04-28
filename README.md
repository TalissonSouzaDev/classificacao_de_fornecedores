

# Sistema de classificação de Fornecedor

Este sistema exibe os fornecedores mais próximos das demandas criadas, utilizando integração com a API do Google para calcular distâncias. A distribuição segue a lógica de round-robin para garantir um balanceamento justo entre os atendimentos.

## Tecnologias Utilizadas
- PHP: Linguagem de programação

- Laravel 11: Framework PHP

- PostgreSQL: Banco de dados relacional

- VueJs3: Framework Javascript

## Pré-requisitos
Antes de começar, você precisará de:

- PHP 8.2 ou superior

- Composer (gerenciador de dependências PHP)

- PostgreSQL ou outro banco de dados relacional

## Instalação
Siga os passos abaixo para configurar e rodar em seu ambiente local.

### Passo 1: Clonar o repositório
Clone o repositório para sua máquina local:
```bash
  git clone https://github.com/TalissonSouzaDev/classificacao_de_fornecedores.git
  cd nomedoprojeto
```

### Passo 2: Instalar as dependências
caso for usar no docker
```bash
  docker-compose up -d
  docker-compose exec app bash
```
Instale as dependências do projeto usando o Composer:
```bash
  composer install
```
Instale as dependências do projeto usando o npm:
```bash
  npm install
```
### Passo 3: Configuração do ambiente
Crie um arquivo .env copiando o arquivo .env.example:
```bash
  cp .env.example .env
```

No arquivo .env, configure as credenciais do seu banco de dados:
```bash
# DB_CONNECTION=sqlite
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=laravel
# DB_USERNAME=root
# DB_PASSWORD=
```

No arquivo .env, configure as credenciais do seu banco de dados caso for usar o docker:
```bash
DB_CONNECTION=pqsql
DB_HOST=postgres
DB_PORT=5432
DB_DATABASE=desafio_backend
DB_USERNAME=postgres
DB_PASSWORD=postgres
```

### Passo 4: Gerar a chave da aplicação
Execute o comando para gerar a chave da aplicação:
```bash
  php artisan key:generate
```

### Passo 5: Rodar as Migrations
Execute as migrations para criar as tabelas no banco de dados:
```bash
  php artisan migrate
```

### Passo 6: Popular o banco de dados (opcional)
Para popular o banco de dados com serviços e forncedores:
```bash
  php artisan db:seed
```

### Passo 7: Roda o sistema
verifique se tem o node e npm instalado no computador.
Agora rode o comando
```bash
  npm run dev
```
Rota de acesso
```bash
  http://localhost:8080/demanda
```
#### caso for usar outra porta no backend altere em \resources\js\axiosConfig.js
Rota de acesso
```bash
  baseURL: "http://localhost:8080/api/",
```

# Link da modelagem dos dados
`` https://drawsql.app/teams/talisson-ss/diagrams/classificacao-de-fornecedores``

# Tutorial de uso
`` https://drive.google.com/drive/folders/10fBkLjRrVs-vgKwBXnbxbJPcIB2Lk5mg?usp=sharing``

