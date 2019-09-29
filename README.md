Obtenha links diretos de arquivos do Uploaded usando PHP.

ISTO NÃO É UM GERADOR "FREE"!!!

É necessário informar usuário e senha premium válido do uploaded no arquivo config.php!

Para usar hospede os arquivos em seu servidor com PHP>=5.5, abra o config.php e defina seu usuário e senha do uploaded, informe também o domínio ou IP de seu servidor seguido da porta do mesmo para ser mostrado ao listar uma pasta.

IMPORTANTE: Crie um arquivo .txt em /usr/share/cookie.txt para salvar as sessões de login, execute:

touch /usr/share/cookie.txt [isto cria o arquivo]

chmod 777 /usr/share/cookie.txt [isto dar permissão ao cURL para gravar no arquivo]

Após isso acesse a url de seu servidor:

http://meuservidor.net/UploadedDirectDownload/?url=http://uploaded.net...

O script aceita a variável "folder=1", com isso o script vai listar os links de todos os arquivos de uma pasta do Uploaded.

Ex: http://meuservidor.net/UploadedDirectDownload/?url=http://uploaded.net/link/pasta&folder=1
