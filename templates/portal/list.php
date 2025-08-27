<!-- templates/portals/list.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<title>Список порталов</title>
	<style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background: #f4f4f4; }
	</style>
</head>
<body>
<h1>Порталы</h1>
<table>
	<thead>
	<tr>
		<th>ID</th>
		<th>Название</th>
		<th>URL</th>
	</tr>
	</thead>
	<tbody>
	<?php foreach ($portals as $portal): ?>
		<tr>
			<td><?= htmlspecialchars($portal->getId()) ?></td>
			<td><?= htmlspecialchars($portal->getName()) ?></td>
			<td><a href="<?= htmlspecialchars($portal->getUrl()) ?>" target="_blank">
					<?= htmlspecialchars($portal->getUrl()) ?>
				</a></td>
		</tr>
	<?php endforeach; ?>
	</tbody>
</table>
</body>
</html>
