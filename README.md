# Disparador Open Source

A ideia desse software, é servir como base para outros programadores implementarem suas integrações com o WhatsApp 

### Requisitos
Você irá precisar de uma conta com um plano ativo na plataforma APIBrasil para utilizar e cadastrar os dispostivos

### Veja algumas etapas

Esse é o roadmap planejado para a plataforma 

| Status  | Tarefa                                      |
| ------- | --------                                    |
| Em andamento   |   Login                                     |   
| Em andamento   |   Importação de contatos excel              |   
| Em andamento   |   Importação de contatos grupos             |   
| Em andamento   |   Criar templates (texto/arquivos/imagens)  |   
| Em andamento   |   Editar templates                          |   
| Em andamento   |   Deletar templates                         |
| Em andamento   |   Criar dispositivo                         |   
| Em andamento   |   Editar dispositivo                        |   
| Em andamento   |   Deletar dispositivo                       |   
| Em andamento   |   Criar usuário                             |   
| Em andamento   |   Editar usuário                            |   
| Em andamento   |   Deletar usuário                           |   

-------------------------------

### Vincular usuário
php artisan db:seed:createFirstUser --email="email_apibrasil@email.com" --senha="sua_senha_apibrasil"

### API Local
http://127.0.0.1:8000/api/sendText?token=1234&number=5531994359434&text=Enviado%20via%20API

### Screenshots
Dashboard
![Dashboard](screen-dashboard.png)

Uploads de contatos
![Contatos](screen-upload-contatos.png)

Cadastro de campanha
![Contatos](screen-novo-disparos.png)

Disparador
![Contatos](screen-disparos.png)

Historico
![Contatos](screen-historico.png)
