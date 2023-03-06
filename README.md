```
INFO
Versão: 1.0
Autor: Danilo de Andrade Ferreira Sousa
Início da criação: 28/02/2023

``` 

# SISTEMA DE GESTÃO DE CONDOMÍNIOS

### Atividades dia 28 FEV 2023
> - Criação do Projeto com laravel 8.2
> - Inserção do JWT para autenticação da API
> - Configuração para utilização do JWT como autenticador de usuários
> - Remoção das migrations padrões do sistema
> - Criação da migration 'create_all_tables'

### Atividades dia 01 MAR 2023
> - Criação da Migration 'create_all_tables', a qual faz a criação de todas as tabelas utilizadas pelo sistema
> - Criação dos seguintes models: 
>> - Area
>> - AreaDisabledDay
>> - Billet
>> - Doc 
>> - FondAndLost
>> - Reservation
>> - Unit
>> - UnitPeople
>> - UnitPet
>> - UnitVehicle
>> - Wall
>> - WallLike
>> - Warning

### Atividades dia 02 MAR 2023
> #### Criação dos seguintes Controllers que serão utilizados pela API
>> - AuthController
>> - BilletController
>> - DocController
>> - FoundAndLostController
>> - ReservationController
>> - UnitController
>> - UserController
>> - WallController
>> - WarningController

> #### Criação das seguintes rotas que serão utilizadas na API
>> - get::'/401'
>> - post::'/auth/login'
>> - post::'/auth/register'
>> - post::'/auth/validate'
>> - post::'auth/logout'
>> - get::'/walls'
>> - post::'/wall/{id}/like'
>> - get::'/docs'
>> - get::'/warnings'
>> - post::'/warning'
>> - post::'/warning/file'
>> - get::'/billets'
>> - get::'/foundandlost'
>> - post::foundandlost'
>> - post::'/foundandlost/{id}'
>> - get::'/unit/{id}'
>> - post::'/unit/{id}/addperson'
>> - post::'/unit/{id}/addvehicle'
>> - post::'/unit/{id}/addpet'
>> - post::'/unit/{id}/removeperson'
>> - post::'/unit/{id}/removevehicle'
>> - post::'/unit/{id}/removepet'
>> - get::'/reservetions'
>> - post::'/reservation/{id}'
>> - get::'/reservation/{id}/disableddates'
>> - get::'/reservation/{id}/times'
>> - get::'/myreservations'
>> - delete::'/myreservation/{id}'

> - Criação do método de registro da rota 'register'
> - Criação do método de login da rota 'login'
> - Criação do método de Validar Token da rota 'validate'
> - Criação do método de logout da rota 'logout'
> - Criação do Seeder 'DatabaseSeeder.php' para inserir dados de teste no banco de dados
> - Criação do Link do Storage para ser utilizado na pasta Public do sistema
> - Criação do método walls da rota 'walls'


### Atividades do dia 05 MAR 23
> #### Criação do método 'like' no 'WallController', função para dar like em um Aviso
> #### Criação do método 'getAll' no 'DocController', pega todos os documentos relacioandos ao condomínio
> #### Criação do método 'getAll' no 'BilletController', pega todos os boletos da unidade que o usuário possui
> #### Criação do método 'getMyWarnings' no WarningController', função para pegar todas as ocorrências do usuário
> #### Criação do método 'setWarning' no 'WarningController', função para adicionar uma ocorrência com ou sem fotos
> #### Criação do método 'addWarningFile' no WarningController', função para adicionar fotos a uma ocorrência