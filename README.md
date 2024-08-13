# Sistema de Gerenciamento de Petshop

[![Codacy Badge](https://api.codacy.com/project/badge/Grade/be1ed76eedfe44ec9e4c9e887964865e)](https://app.codacy.com/gh/projetos-ufape/patinha-pet-admin?utm_source=github.com&utm_medium=referral&utm_content=projetos-ufape/patinha-pet-admin&utm_campaign=Badge_Grade)

## Integrantes

- **Analice de Melo Battisti** - [AnaliceBattisti](https://github.com/AnaliceBattisti)
- **José Leonardo Santos de Lima** - [leoslima](https://github.com/leoslima)
- **Gustavo Henrique Melo Barbosa** - [gustavohmbarbosa](https://github.com/gustavohmbarbosa)
- **Laysa Alves Protásio** - [laysaprotasio](https://github.com/laysaprotasio)
- **Luan Soares de Lima Zacarias** - [Luanzacarias](https://github.com/Luanzacarias)
- **Marco Antônio Matos Moraes** - [marcomoraesx](https://github.com/marcomoraesx)
- **Mariane de Melo Silva** - [marianeme](https://github.com/marianeme)
- **Yuri Alves Batista** - [Capeudinho](https://github.com/Capeudinho)

## 📃 Descrição do Projeto

Projeto para implementação de um SaaS em [PHP](https://www.php.net/) e [Laravel](https://laravel.com/) para a disciplina de Engenharia de Software ministrado pelo Professor Dr. [Rodrigo Andrade](https://github.com/rcaa), da UFAPE, referente ao período de 2024.1 com intuito de avaliação para a 2ª Verificação de Aprendizagem.

O projeto consiste em elaborar um sistema de gerenciamento de um petshop para otimizar operações diárias como gerenciamento de clientes e seus pets, agendamentos de serviços e gestão de pedidos sobre seus produtos ofertados. Também deve permitir que o cliente faça suas compras e agendamentos de serviços pelo sistema.

## 📍Objetivos

- Permitir que administradores (tem todas as funcionalidades de um funcionário)
  - Gerenciar funcionários;
  - Gerenciar produtos;
  - Gerenciar serviços.

- Permitir que funcionários
  - Gerenciar clientes e seus pets;
  - Gerenciar vendas de produtos;
  - Associar serviços e vendas a clientes;
  - Gerenciar pagamentos de clientes.

- Permitir que funcionários
  - Gerenciar suas informações;
  - Gerenciar seus pets;
  - Fazer compras de produtos;
  - Realizar agendamentos para serviços;
  - Realizar pagamentos de compras e serviços;
  - Receber notificações sobre seus agendamentos.


## 🧪 Tecnologias Utilizadas

Abaixo estão as tecnologias e ferramentas que serão utilizadas no desenvolvimento do projeto:
* [PHP](https://www.php.net/)
* [Laravel](https://laravel.com/)

## Como executar
Para executar o projeto, utilizaremos o [Laravel Sail](https://laravel.com/docs/11.x/sail), para isso, é necessário ter o docker instalado na máquina.
```bash
cp .env.example .env
sail up -d
sail artisan migrate
sail npm install
sail run dev
```

## 🛠️ Status do Projeto
Em desenvolvimento