<?php

require dirname(__DIR__) . '/vendor/autoload.php';

(Dotenv\Dotenv::createImmutable(__DIR__))->load();

(new \MockedApplication\Application(
	getenv('C_REST_CLIENT_ID'),
	getenv('C_REST_CLIENT_SECRET'),
	getenv('OAUTH_SERVER_URL'),
	dbHost: getenv('DB_HOST') ?: 'localhost',
	dbName: getenv('DB_NAME'),
	dbUser: getenv('DB_USER'),
	dbPassword: getenv('DB_PASS'),
))->install(
'/handler.php'
);

if($install_result['rest_only'] === false):?>
<head>
	<script src="//api.bitrix24.com/api/v1/"></script>
	<?if($install_result['install'] == true):?>
    /*
	<script>
		BX24.init(function(){
			BX24.installFinish();
		});
	</script>
    */
	<?endif;?>
</head>
<body>
	<?if($install_result['install'] == true):?>
		installation has been finished
	<?else:?>
        <pre><?print_r($install_result);?></pre>
		installation error
	<?endif;?>
</body>
<?endif;
