SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

CREATE TABLE usuarios (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    senha VARCHAR(255) NOT NULL,
    telefone VARCHAR(20) DEFAULT NULL,
    cpf VARCHAR(14) DEFAULT NULL,
    data_nascimento DATE DEFAULT NULL,
    nivel_acesso ENUM('admin', 'usuario') NOT NULL DEFAULT 'usuario',
    status TINYINT(1) NOT NULL DEFAULT 1,
    data_cadastro DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ultima_atualizacao TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    fichas INT NOT NULL DEFAULT 0,
    validade_fichas DATE DEFAULT NULL,
    mp_preapproval_id VARCHAR(255) DEFAULT NULL,
    assinatura_status VARCHAR(50) NOT NULL DEFAULT 'inactive',
    mp_customer_id VARCHAR(255) DEFAULT NULL,
    mp_card_token VARCHAR(255) DEFAULT NULL,
    mp_plan_id VARCHAR(255) DEFAULT NULL,
    mp_subscription_id VARCHAR(255) DEFAULT NULL,
    ultima_cobranca_assinatura_id VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_usuarios_email (email)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pacotes (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    fichas INT NOT NULL,
    preco DECIMAL(10, 2) NOT NULL,
    validade_dias INT NOT NULL,
    mp_interval_type VARCHAR(10) NOT NULL DEFAULT 'month',
    descricao VARCHAR(255) DEFAULT NULL,
    categoria ENUM('avulso', 'assinatura') NOT NULL,
    mp_plan_id VARCHAR(100) DEFAULT NULL,
    max_parcelas INT NOT NULL DEFAULT 1,
    cor VARCHAR(7) NOT NULL DEFAULT '#ff6A00',
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE aulas (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    professor VARCHAR(100) NOT NULL,
    modalidade VARCHAR(50) NOT NULL,
    data_aula DATE NOT NULL,
    horario TIME NOT NULL,
    vagas_totais INT NOT NULL,
    vagas_disponiveis INT NOT NULL,
    tipo_aula VARCHAR(50) NOT NULL DEFAULT 'HIIT',
    PRIMARY KEY (id),
    KEY idx_aulas_data (data_aula)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE agendamentos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario_id INT UNSIGNED NOT NULL,
    aula_id INT UNSIGNED NOT NULL,
    aparelho_id INT UNSIGNED NOT NULL,
    data_agendamento TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_aula_aparelho (aula_id, aparelho_id),
    KEY idx_agendamentos_usuario (usuario_id),
    CONSTRAINT fk_agendamentos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_agendamentos_aula FOREIGN KEY (aula_id) REFERENCES aulas (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cupons (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    codigo VARCHAR(50) NOT NULL,
    tipo ENUM('porcentagem', 'fixo') NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    uso_limite INT DEFAULT NULL,
    uso_contagem INT NOT NULL DEFAULT 0,
    validade DATE DEFAULT NULL,
    status ENUM('ativo', 'inativo') NOT NULL DEFAULT 'ativo',
    PRIMARY KEY (id),
    UNIQUE KEY uq_cupons_codigo (codigo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE cupom_usos (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    cupom_id INT UNSIGNED NOT NULL,
    usuario_id INT UNSIGNED NOT NULL,
    data_uso TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_cupom_usuario (cupom_id, usuario_id),
    KEY idx_cupom_usos_usuario (usuario_id),
    CONSTRAINT fk_cupom_usos_cupom FOREIGN KEY (cupom_id) REFERENCES cupons (id) ON DELETE CASCADE,
    CONSTRAINT fk_cupom_usos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE historico_compras (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario_id INT UNSIGNED NOT NULL,
    pacote_id INT UNSIGNED NOT NULL,
    transacao_id VARCHAR(100) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL,
    data_compra DATETIME NOT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_historico_transacao (transacao_id),
    KEY idx_historico_usuario (usuario_id),
    CONSTRAINT fk_historico_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_historico_pacote FOREIGN KEY (pacote_id) REFERENCES pacotes (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE pagamentos_historico (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    usuario_id INT UNSIGNED NOT NULL,
    pacote_id INT UNSIGNED NOT NULL,
    pagarme_id VARCHAR(100) DEFAULT NULL,
    valor DECIMAL(10, 2) DEFAULT NULL,
    status VARCHAR(50) DEFAULT NULL,
    data_criacao DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_pagamentos_pagarme (pagarme_id),
    KEY idx_pagamentos_usuario (usuario_id),
    CONSTRAINT fk_pagamentos_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios (id) ON DELETE CASCADE,
    CONSTRAINT fk_pagamentos_pacote FOREIGN KEY (pacote_id) REFERENCES pacotes (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE recuperacao_senha (
    id INT UNSIGNED NOT NULL AUTO_INCREMENT,
    email VARCHAR(255) NOT NULL,
    token VARCHAR(255) NOT NULL,
    expira_em DATETIME NOT NULL,
    usado TINYINT(1) NOT NULL DEFAULT 0,
    PRIMARY KEY (id),
    KEY idx_recuperacao_token (token)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

SET FOREIGN_KEY_CHECKS = 1;
