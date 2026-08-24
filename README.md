# Hiitstudio

Sistema de agendamento de aulas, fichas e assinaturas para um estúdio de treino funcional. Alunos compram fichas avulsas ou assinam um plano recorrente, agendam aulas escolhendo o aparelho no mapa da sala e recebem confirmação por e-mail. O painel administrativo controla alunos, aulas, pacotes e cupons.

Este projeto é uma reescrita completa, do zero, de um sistema que mantenho em produção desde 2024 para um cliente real. A versão original foi construída em PHP procedural. Aqui apliquei MVC, separação de responsabilidades por camada e as regras de negócio corrigidas ao longo de meses de uso real — sem dados de clientes, credenciais ou qualquer informação sensível do sistema original.

## Stack

- PHP 8.2+, sem framework — MVC próprio (Router, Controller, Model, View) para expor domínio sobre a arquitetura ao invés de esconder atrás de um framework
- PDO com prepared statements em todas as queries
- MySQL/MariaDB com transações e `SELECT ... FOR UPDATE` nos pontos de concorrência
- Pagar.me (cartão de crédito, assinatura recorrente) e Mercado Pago (Pix) via API, com o SDK oficial usado apenas para reconsulta server-side do pagamento
- PHPMailer para e-mail transacional
- Login social via Google OAuth
- Composer com autoload PSR-4

## Decisões de arquitetura

**Por que MVC sem framework.** O objetivo era demonstrar entendimento de como um framework resolve os problemas que resolve — roteamento, injeção de dados na view, camada de acesso a dados — e não apenas saber consumir a API de um. `App\Core` tem as peças mínimas: `Router`, `Controller`, `Model`, `View`, `Auth`, `Database`.

**Regras de negócio que vieram de bugs reais em produção.** Um sistema de agendamento com fichas pagas tem uma superfície de concorrência maior do que parece. Os pontos abaixo eram bugs reais, encontrados e corrigidos ao longo do tempo em produção, e aqui já nascem corrigidos:

- *Agendamento duplo no mesmo aparelho.* Dois alunos podem clicar em "confirmar" no mesmo aparelho quase ao mesmo tempo. A constraint `UNIQUE (aula_id, aparelho_id)` no banco é a proteção real; o código trata a exceção de violação (`PDOException` código `23000`) e devolve uma mensagem amigável, mas a garantia de integridade é do banco, não da aplicação.
- *Cupom de uso limitado.* Um cupom com limite de uso podia ser aplicado por mais requisições simultâneas do que o limite permitia, se a validação fosse feita com um `SELECT` seguido de `UPDATE`. A contagem de uso é incrementada com um `UPDATE` condicional atômico (`WHERE uso_contagem < uso_limite`), e só se a linha for afetada o cupom é considerado válido.
- *Reembolso duplicado ao cancelar.* Cancelar um agendamento duas vezes seguidas (duplo clique, retry de rede) não pode creditar a ficha duas vezes. O `DELETE` e o crédito da ficha só acontecem se o `DELETE` afetou exatamente uma linha.
- *Fichas avulsas vs. assinatura têm regras de validade diferentes.* Comprar fichas avulsas estende a validade a partir da validade atual (se ainda não venceu) ou de hoje; a renovação de assinatura sempre reseta a validade a partir de hoje. Misturar essas duas regras gera fichas com validade incorreta silenciosamente.
- *Confirmação de pagamento sem duplo cobrança.* Se o pagamento é aprovado no gateway mas a gravação no banco falha (queda de conexão, timeout), o sistema não oferece um botão de "tentar novamente" — isso cobraria o cliente duas vezes pela mesma compra. O status fica pendente de conciliação manual.

**Tokens e credenciais.** Nada de chave de API, senha de banco ou segredo fica no código. Tudo vem de variáveis de ambiente (`.env`, fora do controle de versão) através de um helper `env()`/`config()`. O `.env.example` documenta todas as variáveis necessárias, sem valores reais.

## Estrutura

```
app/
  Controllers/     Um controller por área (Auth, Dashboard, Checkout, Payment, Admin/*)
  Core/             Router, Controller, Model, View, Auth, Database
  Models/           Uma classe por tabela, sem ORM — SQL explícito e revisável
  Services/         Integrações externas (gateways de pagamento, e-mail, tradução de erros)
  Support/          Helpers globais (env, config, url, asset, csrf, flash)
config/             Configuração lida via env()
database/migrations/ Schema SQL versionado
resources/views/    Templates PHP puro, sem engine de template
routes/web.php      Tabela de rotas
public/             Front controller e assets estáticos
```

## Rodando localmente

```bash
composer install
cp .env.example .env
# edite .env com as credenciais do seu MySQL local
mysql -u root -e "CREATE DATABASE hiitstudio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci"
mysql -u root hiitstudio < database/migrations/0001_create_schema.sql
php -S localhost:8000 -t public public/index.php
```

As integrações de pagamento (Pagar.me, Mercado Pago) e login com Google exigem credenciais próprias nas variáveis correspondentes do `.env`; sem elas, todo o restante do sistema — cadastro, login, agendamento, painel admin — funciona normalmente.

## Licença

MIT.
