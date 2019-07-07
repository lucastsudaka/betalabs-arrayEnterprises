

# ArrayEnterprises back-end
 
**Laravel passport** para gerenciamento da autenticação e token.


# Instalação
Configure o arquivo .env de acordo com o DB Mysql/Mariadb que deseja utilizar  
Utilize a collation  "utf8mb4_unicode_ci"  

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=arrayenterprises
    DB_USERNAME=root
    DB_PASSWORD=

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
Completar validação de sessão (autenticação), funcionando parcialmente .  
Testes de unidade
