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
		<dt>Сценарии</dt>
		<dd>
			<?php foreach (($devCases ?? []) as $devCaseCode => $devCase):
			/* @var \App\Application\UseCase\ClientTest\DevCase\DevCaseInterface $devCase */
				?><a href="/admin/test/<?=$portal->getMemberId()?>/<?=$devCaseCode?>"><?=htmlspecialchars($devCase->getTitle())?></a><br>
			<?php endforeach; ?>
		</dd>
	</dl>
	<?php endif; ?>
</div>
</body>
</html>
