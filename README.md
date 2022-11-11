### PROJETO DE TESTE PARA COTAÇÃO DE AÇÕES FEITO EM PHP/Laravel:
A Cotação utiliza informações da IEX Cloud, o resultado deverá ficar em tela de forma detalhada.

### Regras:
- Utilizar a API IEX Cloud;
- Exibir o Último preço da ação e informações sobre a empresa;
- Gravar as consultas no banco de dados;
- Evitar requisições repetidas

#### PASSOS PARA CONFIGURAÇÃO: 🚀
* Versão do php utilizada: 7.4
* Necessário ter o docker e o docker-compose instalados
- Criar o arquivo .env para as variáveis de ambiente. Para fins didáticos foi adicionado o .env_temp (Ciente que essas são informações críticas que não devem ser versionadas)
- Rodar o comando **[docker-compose up -d]**
- Dentro da pasta raiz executar o comando **[docker-compose ps]** para listar os containers em execução
- Após obter o nome do container [app] executar o seguinte comando: **[docker exec -it <nome_do_container> bash]**
- Logo em seguida já dentro do container executar os seguintes comandos para instalar as dependências, gerar a estrutura do banco e criar a key: 
- - **composer install** 
- - **php artisan key:generate**
- - **php artisan migrate**
- - **php artisan migrate —env=testing**

#### PASSOS PARA EXECUÇÃO DOS TESTES: 🚀
* Ainda dentro do container na raiz do projeto executar o seguinte comando para executar os testes:
- **php vendor/bin/codecept run unit**

## Testar a aplicação no endereço: http://localhost:8000/;

### OBS -
*Aqui Utilizei o pattern repository e um pouco de Service layer

#### Principais Técnologias: 🚀
- LARAVEL
- CODECEPTION
- MYSQL
- DOCKER
- NGINX
- REDIS

## Meu Contato 🚀🚀🚀
https://www.linkedin.com/in/adson-souza-21b1493a/
