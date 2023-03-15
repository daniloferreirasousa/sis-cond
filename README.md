<div class="title">

<h1>API - GESTÃO DE CONDOMÍNIO</h1>

</div> <br/>

<!-- Tecnologias -->
<div>

<h1>Informações:</h1>

```
Versão - 1.0.0
Author - Danilo Ferreira Sousa
PHP - ^8.1
Laravel - ^10.0
MySQL - ^8.0
JWT - ^2.0
```

</div><br>

<!-- Passo a passo de instalação -->
<div>
<h1> Passos para clone e utilização da API </h1>
<br>
<h2>1º Passo:</h2>

```
git clone https://github.com/daniloferreirasousa/sis-cond.git [name-your-project]
```
<h2>2º Passo:</h2>

```
composer update
```
<h2>3º Passo:</h2>

``` 
composer dump-autoload
```
<h2>4º Passo:</h2>

```
Criar uma tabela no DB com o nome que for definido no DB_DATABASE no arquivo .env
```
<h2>5º Passo:</h2>

```
php artisan migrate
```
<h2>6º Passo:</h2>

```
php artisan db-serve
```
<h2>7º Passo:</h2>

```
php artisan serve
```

</div><br><br>


<!-- Rotas -->
<div>
<h1>Rotas da API:</h1>
<!-- Rotas de Autenticação -->
<div class="routes">
    <h2> Autenticação </h2> 
    <details>
        <summary>Login</summary>
        <p>Rota: <b>api/auth/login</b> </p>
        <p>Parâmetros necessários: <b>cpf, password</b></p>
    </details>
    <details>
        <summary>Register</summary>
        <p>Rota: <b>api/auth/register</b></p>
        <p>Parâmetros necessários: <b>name, email, cpf, password, password_confirm</b></p>
    </details>
    <details>
        <summary>Validate</summary>
        <p>Rota: <b>api/auth/validate</b> </p>
        <p>Rota para validação do token de usuário, necessário enviar o Token JWT como autenticação Bearer</p>
    </details>
    <details>
        <summary>Logout</summary>
        <p>Rota: <b>api/auth/logout</b></p>
        <p>Necessário enviar o Token JWT para fazer o logout, pois para deslogar é necessário que esteja logado.</p>
    </details>
</div>

</div><br>

<h3> Todas as rotas abaixo necescitam do Token JWT de autenticação </h3>
<!-- Rotas de Avisos -->
<div class="routes">
    <h2>Avisos</h2>
    <details>
        <summary>Walls</summary>
        <p>Rota: <b>api/walls</b></p>
        <p>Responsávelpor trazer todos os avisos criados no sistema para os condôminos.</p>
    </details>
    <details>
        <summary>Walls Like</summary>
        <p>Rota: <b>api/wall/{id}/like</b></p>
        <p>Responsável por dar like em um aviso criado no sistema.</p>
    </details>

</div><br>

<!-- Rotas de Documentos -->
<div class="routes">
    <h2>Documentos</h2>
    <details>
        <summary>Docs</summary>
        <p>Rota: <b>api/docs</b></p>
        <p>Reponsável por trazer todos os documentos que são de carater geral do coondomínio.</p>
    </details>

</div><br>

<!-- Rotas do Livro de ocorrências -->
<div class="routes">
    <h2>Ocorrências</h2>
    <details>
        <summary>Warnings</summary>
        <p>Rota: <b>api/warnings</b></p>
        <p>Responsável por pegar as minhas ocorrências no livro de ocorrências.</p>
    </details>
    <details>
        <summary>Set Warning</summary>
        <p>Rota: <b>api/warning</b></p>
        <p>Responsável por criar uma nova ocorrência.</p>
    </details>
    <details>
        <summary>Add File Warning</summary>
        <p>Rota: <b>api/warning/file</b></p>
        <p>Responsável por adicionar images que serão usadas ao criar uma nova ocorrência.
        Obs: Esta rota deve ser implementada diretamente na criação da ocorrência, futuramente.</p>
    </details>

</div><br>

<!-- Rotas de Boletos -->
<div class="routes">
    <h2>Boletos</h2>
    <details>
        <summary>Billets</summary>
        <p>Rota: <b>api/billets</b></p>
        <p>Responsável por trazer os boletos relacionados a unidade do usuário conectado.
        Necessário parâmetro: <b>property</b></p>
    </details>

</div><br>

<!-- Rotas de Achados e perditos -->
<div class="routes">
    <h2>Achados e Perdidos</h2>
    <details>
        <summary>Found And Lost - Get All</summary>
        <p>Rota GET: <b>api/foundandlost</b></p>
        <p>Responsável por retornar todos os registros de achados e perdidos</p>
    </details>
    <details>
        <summary>Found And Lost - Insert</summary>
        <p>Rota POST: <b>api/foundandlost</b></p>
        <p>Responsável por inseriri um novo item para achados e perdidos. Parâmetros necessários: <b>description, where, photo</b></p>
    </details>
    <details>
        <summary>Found And Lost - Update</summary>
        <p>Rota POST: <b>api/foundandlost/{id}</b></p>
        <p>Responsável por atualizar o registro enviado no 'id'. Parâmetros necessários: description, where, photo</p>
    </details>

</div><br>

<!-- Rotas de Unidades/Casa/Apt -->
<div class="routes">
    <h2>Unidades</h2>
    <details>
        <summary>Unit - Get Info</summary>
        <p>Rota GET: <b>api/unit/{id}</b></p>
        <p>Responsável por pegar todas as informações de uma unidade específica.</p>
    </details>
    <details>
        <summary>Unit - Add Person</summary>
        <p>Rota POST: <b>api/unit/{id}/addperson</b></p>
        <p>Responsável por adicionar um Morador a unidade especificada. Parâmetros necessários: <b>name, birthdate</b></p>
    </details>
    <details>
        <summary>Unit - Add Vehicle</summary>
        <p>Rota POST: <b>api/unit/{id}/addvehicle</b></p>
        <p>Responsável por adicionar um Veículo a unidade especificada. Parâmetros necessários: <b>title, color, plate</b></p>
    </details>
    <details>
        <summary>Unit - Add Pet</summary>
        <p>Rota POST: <b>api/unit/{id}/addperson</b></p>
        <p>Responsável por adicionar um Pet a unidade especificada. Parâmetros necessários: <b>name, race</b></p>
    </details>
    <details>
        <summary>Unit - Remove Person</summary>
        <p>Rota POST: <b>api/unit/{id}/removeperson</b></p>
        <p>Responsável por remover um morador da unidade especificada. Parâmetros necessários: <b>id_person</b></p>
    </details>
    <details>
        <summary>Unit - Remove Vehicle</summary>
        <p>Rota POST: <b>api/unit/{id}/removevehicle</b></p>
        <p>Responsável por remover um Veículo da unidade especificada. Parâmetros necessários: <b>id</b></p>
    </details>
    <details>
        <summary>Unit - Remove Pet</summary>
        <p>Rota POST: <b>api/unit/{id}/removepet</b></p>
        <p>Responsável por remover um Pet da unidade especificada. Parâmetros necessários: <b>id</b></p>
    </details>

</div><br>

<!-- Rotas de Reservas -->
<div class="routes">
    <h2>Reserva de Área</h2>
    <details>
        <summary>Reservations - Get Reservations</summary>
        <p>Rota GET: <b>api/reservations</b></p>
        <p>Responsável por trazer as informações dos locais disponíveis para reserva, juntamente com os horários e dias disponíveis.</p>
    </details>
    <details>
        <summary>Reservation - Set Reservation</summary>
        <p>Rota POST: <b>api/reservation/{id}</b></p>
        <p>Responsável por criar uma nova Reserva de uma área. Parâmetros necessários: <b>id, date, time, property</b></p>
    </details>
    <details>
        <summary>Reservation - Get Disabled Dates</summary>
        <p>Rota GET: <b>api/reservation/{id}/disabledates</b></p>
        <p>Responsável por trazer uma lista com todos os dias indisponíveis para reserva dos próximos 3 meses a partir da data atual.</p>
    </details>
    <details>
        <summary>Reservation - Get Times</summary>
        <p>Rota GET: <b>api/reservation/{id}/times</b></p>
        <p>Responsável por trazer todas as horas disponíveis para reservar do dia atual. Parâmetros necessários: <b>date</b></p>
    </details>
    <details>
        <summary>Reservation - Get My Reservations</summary>
        <p>Rota GET: <b>api/myreservations</b></p>
        <p>Responsável por trazer todas as reservas da minha unidade. Parâmetros necessários <b>property</b></p>
    </details>
    <details>
        <summary>Reservation - Del My Reservation</summary>
        <p>Rota DELETE: <b>api/foundandlost/{id}</b></p>
        <p>Responsável por excluir uma reserva que tenha para minha propriedade. Parâmetrosa necessários: <b>id (id da reserva)</b></p>
    </details>

</div><br>

<!-- Rotas de Usuário -->
<div class="routes">
    <h2>Usuário</h2>
    <details>
        <summary>User - Get Info</summary>
        <p>Rota GET: <b>api/user</b></p>
        <p>Reponsável por trazer todas as informações do usuário conectado.</p>
    </details>
    <details>
        <summary>User - Update</summary>
        <p>Rota POST: <b>api/user/{id}</b></p>
        <p>Responsável por atualizar as informações de perfil do usuário conectado. Parâmetros necessários: <b>name, email, cpf</b></p>
    </details>

</div><br>


<!-- Estilização -->

<style>
* {
    margin: 0px;
    padding: 0px;
    font-family: Verdana, Helvetica, Arial;
}
h1, h2 {
    padding: 0px;
    margin: 0px;
}


.title {
    display: block;
    text-align:center;
    padding: 10px;
    font-size: 22px;
}

.routes {
    display: flex;
    flex-direction: column;

}

details summary {
    user-select:none;
    cursor: pointer;
    color: #bbb;
}

details p {
    color: #efefef;
}
</style>