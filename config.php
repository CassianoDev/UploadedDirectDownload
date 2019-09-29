<?php
/* defina seu usuário do Uploaded */
define("UPLOADED_USER","FULANO");
/* defina sua senha do Uploaded */
define("UPLOADED_PASS","123456");
/* defina o IP ou Domínio de seu site/servidor */
define("IP_HOST","127.0.0.1");
/* defina a porta de seu site/servidor  */
define("IP_PORT","80");
/* caminho para salvar os cookies da sessão */
define("COOKIE_PATCH","/usr/share/cookie.txt"); //touch /usr/share/cookie.txt + chmod 777 /usr/share/cookie.txt
/* User agent para simular navegador */
define("USER_AGENT","Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/73.0.3683.75 Safari/537.36");
/* Defina para 1 caso queira que o próprio PHP leia o arquivo com readfile() */
define("READ_INTERNAL",0);
/* Tempo de esperar para tentar novamente em caso de falha */
ini_set('default_socket_timeout', 1);
