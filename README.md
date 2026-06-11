# Projeto PHP - Exercicios

Exercicios semanais de PHP feitos durante o curso. Desde o basico ate API REST.

---

## Semana 1 - Basico

- Arrays associativos
- array_filter com arrow function
- foreach com referencia (&)
- Aplicar desconto em pedidos acima de R$100

---

## Semana 2 - Orientacao a Objetos

Carrinho de compras com classes.

- Produto.php → classe com controle de estoque
- Carrinho.php → adiciona produtos e calcula total
- FormaPagamento.php → enum com desconto (PIX 10%, Boleto 5%, Cartao 0%)
- ProdutoDAO.php → salva/busca produtos no banco
- index.php → testa tudo

Conceitos: classes, enums, match, DAO, PDO.

---

## Semana 3 - API de Contatos

CRUD de contatos em um arquivo só (contatos.php). Usa switch no REQUEST_METHOD pra decidir o que fazer.

- GET → lista contatos (paginado) ou busca por ID
- POST → cria contato
- PUT → atualiza contato
- DELETE → remove contato

Respostas em JSON com status codes.

---

## Semana 4 - API de Tarefas

Mesma ideia da semana 3, mas agora organizado com pastas, autoload do Composer e Router proprio.

Rotas:
- GET /tarefas → lista
- GET /tarefas/{id} → busca uma
- POST /tarefas → cria
- PUT /tarefas/{id} → atualiza
- DELETE /tarefas/{id} → remove

Tem enums pra status (pendente, em_progresso, concluida, cancelada) e prioridade (baixa, media, alta, urgente).

Pra rodar:
  cd semana4_php
  composer install
  cp .env.example .env
  (preenche o .env com os dados do banco)
  php -S localhost:8000 -t public

---

## Tecnologias

- PHP 8.1+
- MySQL
- PDO
- Composer (semana 4)
- PHPUnit (semana 4)
