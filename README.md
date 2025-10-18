1. Установить приложение разработчика:
```bash
cd путь_куда_надо;
hg clone http://hg.bx/repos/rest-developer-app
composer install
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```
2.Настроить nginx для работы с PHP-FPM стандартными настройками Symfony
/etc/nginx/config.d/dev-app.conf

```nginx

server {
	listen 80;
	# listen 443 ssl; # SSL если нужно
	server_name dev-app.yurta.bx; # заменить на нужный домен

	## SSL если нужно, то своё
	# ssl_certificate  /home/airr/localhost/certs/nginx-selfsigned1.crt; 
	# ssl_certificate_key /home/airr/localhost/certs/nginx-selfsigned1.key;
	# ssl_protocols TLSv1.2;

	root /home/airr/repo/rest-developer-app/public;

	index index.html index.php;

	client_max_body_size 8m;
	location / {
		try_files $uri /index.php$is_args$args;
	}

	location ~ \.php {
		fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
		
		fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
		fastcgi_param DOCUMENT_ROOT $realpath_root;
		fastcgi_param SCRIPT_NAME $fastcgi_script_name;

		include fastcgi_params;
	}

	location ~ \.php$ {
		return 404;
	}
}
```
3. Перезагрузить nginx
```bash
sudo nginx -s reload
```
4. Проверить работу сайта в браузере по адресу http://dev-app.yurta.bx (заменить на нужный домен)

