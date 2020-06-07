<h2>Instruções para executar o case</h2>  

1- Certifique-se de ter instalado o PHP ˆ7.2 e o gerenciador de pacotes composer  

2- Clonar o repositório, ir até a raiz do projeto pelo terminal e rodar: <strong>composer install</strong> para instalar os pacotes necessários  

3- Faça uma cópia do arquivo .env.example pelo comando <strong>cp .env.example .env</strong>  

4- Abrir o arquivo .env e o atualize com as informações do seu banco de dados MySQL  

- A seção MySQL deve estar algo próximo disso:
    <ul>
        <li>DB_CONNECTION=mysql</li>
        <li>DB_HOST=127.0.0.1</li>
        <li>DB_PORT=3306</li>
        <li>DB_DATABASE=nome_do_schema</li>
        <li>DB_USERNAME=username</li>
        <li>DB_PASSWORD=password</li>
    </ul>  
    
5- Com o MySQL configurado, é hora de criar as tabelas e os povoá-las. Para isso, o comando: <strong>php artisan migrate:fresh --seed</strong>    

6- Com as tabelas criadas, inicie a aplicação através do comando <strong>php artisan serve</strong> (por padrão será usada a porta 8000)  

7- Com isso, a aplicação está pronta pra funcionar. As rotas podem ser encontradas em <strong>routes/api.php</strong>  

8- Para agilizar os testes, eu exportei uma collection contendo todos os endpoints usados na API. Essa collection deve ser importada pelo Postman e está na raiz do projeto <strong>TruckPad.postman_collection.json</strong>  

9- Para finalizar, os testes unitários estão no diretório <strong>tests/Unit/</strong> e para rodá-los, execute o comando: <strong>./vendor/bin/phpunit</strong>   
