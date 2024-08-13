# Sistema de Gerenciamento de Petshop

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

Mas para conseguir usar o Sail, precisamos executar o composer install, comando recomendado:
```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php83-composer:latest \
    composer install --ignore-platform-reqs
```

Após isso, testar se o comando foi reconhecido executando
```bash
./vendor/bin/sail version
```

Agora, pode seguir com o passo padrão
```bash
cp .env.example .env
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate
./vendor/bin/sail npm install
./vendor/bin/sail run dev
```

Sugestão: [criar o alias](https://laravel.com/docs/11.x/sail#configuring-a-shell-alias) "sail" para "./vendor/bin/sail" 

## 🛠️ Status do Projeto
Em desenvolvimento