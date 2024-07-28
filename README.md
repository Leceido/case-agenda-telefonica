https://youtu.be/eHH1_LnWpdI - link do video apresentação

# Case full-stack agenda-telefonica

Este é um projeto full-stack que utiliza o Laravel como framework back-end (PHP) e o Vue.js como framework front-end (JavaScript) e o MySQL de banco de dados. 

## Requisitos obrigatórios presentes no projeto: 
 - Agenda telefonica em formato de lista, a lista é renderizada no Component ContactListComponent.vue
 - Ao selecionar um contato ele é exibido em um outro componente ContactComponent.vue
 - CRUD, no backend foi desenvolvido uma API RestFul com os metodos GET, POST, PUT, DELETE e o frontend faz requisições para essas rotas
 - O projeto é responsivo para mobile e desktop, foi utilizado o framework TailwindCSS na estilização do front-end, a escolha desse framework foi devido a facilidade para deixar o projeto responsivo

## Requisitos opcionais presentes no projeto:
- autenticação de usuario e validação de rotas, foi feito a autenticação com o JWT, só é possivel utilizar a aplicação autenticado, pois as requisições pedem o Bearer Token e por ser possivel cadastrar mais de um usuario, a autenticação garante que os dados de um usuario não vão aparecer e nem ser alterados por outro
- uploads de imagens está sendo feito em um bucketS3 da AWS

 O backend é uma API no padrão RestFul utilizando a arquitetura de desenvolvimento MVC model view controller
 
## Ferramentas Back-end:

 - PHP: Versão 8.0 ou superior.
 - Laravel: Versão 10
 - MySQL: MySQL 8
 - Composer: Gerenciador de dependências PHP.
 - JWT: Para autenticação
 - AWS S3 para salvar as imagens

   
## Ferramentas Front-end:

Vue.js: Framework JavaScript para desenvolvimento de interfaces de usuário.
Vue Router: Roteamento no front-end.
Pinia: Gerenciamento de estado.
NPM ou Yarn: Gerenciadores de pacotes JavaScript.


Instalação
Clone o Repositório:
git clone https://github.com/Leceido/case-agenda-telefonica.git


Instale as Dependências (Back-end):

cd agenda-telefonica-api
composer install

Configure o Ambiente:

Crie um arquivo .env baseado no .env.example.
Configure as informações de conexão com o banco de dados.
Execute as Migrations

php artisan migrate:fresh

Instale as Dependências (Front-end):

cd agenda-telefonica
npm install ou yarn install


npm run dev ou yarn run dev
php artisan serve
Inicie o Servidor de Desenvolvimento:


Estrutura do Projeto
app: Lógica principal do Laravel (models, controllers, etc.).
bootstrap: Arquivos de inicialização.
config: Arquivos de configuração.
database: Migrations, seeders e factories.
public: Arquivos públicos (CSS, JS, imagens).
routes: Arquivos de definição de rotas.
