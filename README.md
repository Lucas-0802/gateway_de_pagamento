# Gateway de Pagamento 💸💳

Projeto de Teste contendo integração do Omnipay com Stripe.

ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️

ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️

A integração oferece suporte às seguintes operações: 
  - Autorização
  - Captura
  - Estorno
  - Cancelamento
  
Foram escritos teste unitários para garantir o bom funcionamento de cada parte do código.

As rotas foram criadas no arquivo `api.php` e são direcionadas para `PaymentController`. Nela estão implementados os 4 métodos citados acima.

Todos os endpoints precisam receber o nome do Gateway que será utilizado, para a aplicação poder buscar a respectiva chave associada ao nome informado, podendo assim fazer a chamada.

O endpoint de autorização cria na API uma cobrança com o status "Não capturado". O endpoint de Captura necessita do id da transação de autorização para de fato efetivar a cobrança no cartão.
Após capturado o valor, temos duas opções: Cancelamento e Estorno. No estorno, precisa ser informado o id da transação de captura e também o valor que deseja ser estornado. 
No cancelamento, basta apenas informar o id da transação para efetivar o cancelamento.

# Rodando a aplicação 🚀🔥

1) Configurar o `.env` com a `api_key`
2) Rodar o comando `docker compose up api`
3) A aplicação está configurada para rodar na porta: 9000
4) Para testar a aplicação utilize cartões fake disponíveis na plataforma da Stripe próprios para simular cobranças
5) Para rodar os testes: `docker compose up test`

ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️

ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️ ℹ️

Caso você esqueça de configurar o `.env` com a `api_key` e já tenha rodado o `docker compose up api`:
1) Configurar o `.env` com a `api_key`
2) `docker compose up test --build`

