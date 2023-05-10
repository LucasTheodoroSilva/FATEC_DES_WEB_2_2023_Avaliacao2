# Segunda Avaliação DESENVOLVIMENTO WEB II

## Projeto de Cadastro de Candidatos para Vestibular

Este é um projeto simples de cadastro de candidatos para um vestibular, desenvolvido durante a prova do professor Orlando utilizando PHP orientado a objetos e o SGBD MySQL.

## Pré-requisitos

- Servidor web com suporte a PHP instalado.
- SGBD MySQL instalado.

## Instruções

1. Faça o download dos arquivos do projeto: `index.php` e `vestibular.sql`.
2. Lembre-se de que este projeto foi desenvolvido utilizando o XAMPP em conjunto com o phpMyAdmin para a criação do banco de dados. Para que o projeto funcione corretamente, siga os passos abaixo:
    - Inicie o XAMPP e inicie o Apache e o MySQL.
    - Acesse o phpMyAdmin clicando em "Admin" ao lado do MySQL.
    - Crie um novo banco de dados chamado "vestibular".
     
3. Abaixo está a estrutura da tabela utilizada. Execute o seguinte código SQL para criar a tabela:
    ```sql
    CREATE DATABASE vestibular;
    
    CREATE TABLE candidates (
      id INT(11) NOT NULL AUTO_INCREMENT,
      name VARCHAR(255) NOT NULL,
      rg_cpf VARCHAR(20) NOT NULL,
      phone VARCHAR(20) NOT NULL,
      escola_publica TINYINT(1) NOT NULL,
      PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ```
4. Coloque o arquivo `index.php` na pasta raiz do XAMPP (`htdocs`) para que o projeto seja executado corretamente.
5. Abra o navegador da web e digite o endereço do servidor web seguido do caminho para o diretório do projeto (por exemplo, http://localhost/nome_da_pasta).

Agora você deverá conseguir acessar o projeto e utilizar as funcionalidades de cadastro, consulta, atualização e exclusão de candidatos.
