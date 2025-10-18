<!-- templates/portals/list.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Портал</title>
</head>
<body>
<div class="container">
	<h1>Битрикс24</h1>

	<?php if (empty($portal)): ?>
		<p>Битрикс24 не найден.</p>
	<?php else: ?>
	<dl>
		<dt>MemberId</dt>
		<dd>
		<?=$portal->getMemberId()?>
		</dd>
		<dt>Domain</dt>
		<dd>
			<?=$portal->getDomain()?>
		</dd>
		<dt>Сценарий</dt>
		<dd><?=htmlspecialchars($devCaseName)?></dd>
		<dt>Результаты</dt>
		<dd><pre><?print_r($result)?></pre></dd>
	</dl>
	<?php endif; ?>
</div>
</body>
</html>
