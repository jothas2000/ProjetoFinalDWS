# Chat Messenger - Projeto de Mensagens em Tempo Real

Bem-vindo ao repositório do Chat Messenger, um projeto de mensagens em tempo real desenvolvido para fins educacionais e de prática. Este projeto utiliza XAMPP para o servidor local, HeidiSQL para gerenciamento do banco de dados MySQL, e Composer para gerenciamento de dependências.

## Pré-requisitos

Antes de começar, certifique-se de ter os seguintes softwares instalados em sua máquina:

- [XAMPP](https://www.apachefriends.org/index.html)
- [HeidiSQL](https://www.heidisql.com/)
- [Composer](https://getcomposer.org/)

## Passo a Passo para Configuração do Projeto

### 1. Instalação e Configuração do XAMPP

1. **Baixe e instale o XAMPP**:
   - Acesse o site oficial do [XAMPP](https://www.apachefriends.org/index.html) e baixe a versão mais recente.
   - Siga as instruções de instalação.

2. **Inicie o Apache e o MySQL**:
   - Abra o painel de controle do XAMPP.
   - Clique em "Start" ao lado de "Apache" e "MySQL" para iniciar os serviços.

3. **Coloque os arquivos do projeto na pasta `htdocs`**:
   - Localize a pasta `htdocs` dentro do diretório de instalação do XAMPP (geralmente em `C:\xampp\htdocs`).
   - Copie todos os arquivos do projeto para dentro dessa pasta.

### 2. Instalação e Configuração do HeidiSQL

1. **Baixe e instale o HeidiSQL**:
   - Acesse o site oficial do [HeidiSQL](https://www.heidisql.com/) e baixe a versão mais recente.
   - Siga as instruções de instalação.

2. **Conecte-se ao banco de dados MySQL**:
   - Abra o HeidiSQL e crie uma nova conexão com o servidor MySQL.
   - Use as credenciais padrão (usuário: `root`, senha: vazia) ou as que você configurou durante a instalação do XAMPP.

3. **Execute o arquivo `chatMessenger.sql`**:
   - No HeidiSQL, abra o arquivo `chatMessenger.sql` que está na pasta do projeto.
   - Execute o script para criar o banco de dados e as tabelas necessárias.

### 3. Instalação das Dependências com Composer

1. **Baixe e instale o Composer**:
   - Acesse o site oficial do [Composer](https://getcomposer.org/) e baixe o instalador.
   - Siga as instruções de instalação.

2. **Instale as dependências do projeto**:
   - Abra o terminal ou prompt de comando e navegue até a pasta do projeto dentro de `htdocs`.
   - Execute o comando:
     ```bash
     composer install
     ```
   - Isso irá baixar e instalar todas as dependências listadas no arquivo `composer.json`.

### 4. Acessando o Projeto no Navegador

1. **Inicie o servidor local**:
   - Certifique-se de que o Apache e o MySQL estão rodando no XAMPP.

2. **Acesse o projeto**:
   - Abra o navegador e digite `http://localhost/nome-da-pasta-do-projeto` na barra de endereços.
   - Substitua `nome-da-pasta-do-projeto` pelo nome da pasta onde você colocou os arquivos do projeto.

3. **Teste a aplicação**:
   - Navegue pela aplicação e verifique se tudo está funcionando corretamente.

## Contribuição

Se você deseja contribuir para este projeto, siga os passos abaixo:

1. Faça um fork do repositório.
2. Crie uma nova branch com sua feature ou correção: `git checkout -b minha-feature`.
3. Faça commit das suas alterações: `git commit -m 'Adicionando nova feature'`.
4. Envie para o repositório remoto: `git push origin minha-feature`.
5. Abra um Pull Request.

## Licença

Este projeto está licenciado sob a Licença MIT - veja o arquivo [LICENSE](LICENSE) para mais detalhes.

## Contato

Se tiver alguma dúvida ou sugestão, sinta-se à vontade para entrar em contato:

- **Email**: jothas2000@hotmail.com
- **GitHub**: [jothas2000](https://github.com/jothas2000)
