# Disparador Open Source

A ideia desse software, é servir como base para outros programadores implementarem suas integrações com o WhatsApp 

[![Star on GitHub](https://img.shields.io/github/stars/APIBrasil/apibrasil-disparador-free.svg?style=social)](https://github.com/APIBrasil/apibrasil-disparador-free/stargazers)
[![GitHub tag](https://img.shields.io/github/tag/APIbrasil/apibrasil-disparador-free)](https://github.com/APIbrasil/apibrasil-disparador-free/releases/?include_prereleases&sort=semver "View GitHub releases")
[![License](https://img.shields.io/badge/License-MIT-blue)](#license "Go to license section")
[![Known Vulnerabilities](https://snyk.io/test/github/APIbrasil/badge-generator/badge.svg?targetFile=package.json)](https://snyk.io/test/github/APIbrasil/apibrasil-disparador-free?targetFile=package.json "APIBrasil vulnerabilities")

### Requisitos
Você irá precisar de uma conta com um plano ativo na plataforma APIBrasil para utilizar e cadastrar os dispostivos

### Veja algumas etapas

Esse é o roadmap planejado para a plataforma 

| Status  | Tarefa                                   |
| ------- | --------                                 |
| OK   |   Login                                     |   
| OK   |   Importação de contatos csv                |   
| OK   |   Importação de contatos grupos             |   
| OK   |   Criar templates (texto/arquivos/imagens)  |   
| OK   |   Editar templates                          |   
| OK   |   Deletar templates                         |
| OK   |   Criar dispositivo                         |   
| OK   |   Editar dispositivo                        |   
| OK   |   Deletar dispositivo                       |
| OK   |   Envia Texto, Imagens e arquivos           |
| OK   |   Criar usuário                             |   
| Em andamento   |   Editar usuário                  |   
| Em andamento   |   Deletar usuário                 |   
-----------------------------------------------------

### Vincular usuário
php artisan db:seed:createFirstUser --email="email_apibrasil@email.com" --senha="sua_senha_apibrasil"

### API Local
http://127.0.0.1:8000/api/sendText?token=1234&number=5531994359434&text=Enviado%20via%20API

### Screenshots
Dashboard
![Dashboard](screen-dashboard.png)

Uploads de contatos
![Contatos](screen-upload-contatos.png)

Novo de disparo
![Novo de disparo](screen-novo-disparos.png)

Disparando
![Disparador](screen-disparando.png)

Novo dispositivo
![Novo dispositivo](screen-novo-dispositivos.png)

Dispositivo
![Dispositivo](screen-dispositivos.png)

Historico
![Contatos](screen-historico.png)
