

ArrayEnterprises back-end
 
## Cenário
A empresa ArrayEnterprises solicitou o desenvolvimento de um sistema de comentários para um novo produto que estão lançando. Como trata-se de um sistema que será utilizado por outros agentes então deve ser feito obrigatoriamente via API com entradas e saídas no formato JSON. Esse sistema deve manter os dados dos usuários que comentarem.
### Requisitos do sistema
#### Obrigatórios:
- [x] O sistema deverá gerenciar os usuários, permitindo-os se cadastrar e editar seu cadastro;   
- [x] O sistema poderá autenticar o usuário através do e-mail e senha do usuário e, nas outras requisições, utilizar apenas um token de identificação;
- [x] O sistema deverá retornar comentários a todos que o acessarem, porém deverá permitir inserir comentários apenas a usuários autenticados;
- [x] O sistema deverá retornar qual é o autor do comentário e dia e horário da postagem;
- [x] O sistema não deverá possuir número mínimo de comentário por usuário.
#### Desejáveis:
- [x] O sistema deverá permitir o usuário editar os próprios comentários (exibindo a data de criação do comentário e data da última edição);
- [x] O sistema deverá possuir histórico de edições do comentário;
- [x] O sistema deverá permitir o usuário excluir os próprios comentários;
- [x] O sistema deverá possuir um usuário administrador que pode excluir todos os comentários;
- [x] O sistema deverá criptografar a senha do usuário;
- [x] O sistema deverá permitir o usuário fazer o upload de uma foto de perfil e exibi-la nos comentários desse usuário.

# Instalação
Configure o arquivo .env de acordo com o DB Mysql/Mariadb que deseja utilizar  

Utilize a collation  "utf8mb4_unicode_ci"  

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=arrayenterprises
    DB_USERNAME=root
    DB_PASSWORD=

Instale as dependências:  
`composer install  `  
Execute os comandos do Artisan:  
`php artisan migrate` // tabelas necessárias para o funcionamento  
`php artisan passport:install` // para os tokens internos do laravel passport   
`php artisan db:seed --class=RoleTableSeeder` // gerar as roles de permissões e usuário 'admin'.  

####  Opcional:
`php artisan db:seed --class=UsersTableSeeder`  
Seed para criação de dados  de exemplo total: "usuários" que possuem "comentários", estes já possuindo um "histórico de edição". 

# Uso

Com o Postman ou outro programa para teste de API:  
Realizar cadastro em `public/api/v1/auth/register` ,  um **bearer token** será retornado, este é necessário para as ações  que requerem login.
![](https://i.imgur.com/9Pg4xdd.jpg)  
  
    
![](https://i.imgur.com/k0Vf1A5.jpg)  
####  Usuário ADMIN (gerado automaticamente):

   	"email": "admin@mail.com",
   	"password": "admin"



# Incompleto
O suporte a UUID foi adicionado como extra, apenas para demonstração.
Completar validação de sessão (autenticação), funcionando parcialmente .
Testes de unidade
