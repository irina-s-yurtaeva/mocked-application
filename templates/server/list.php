<!-- templates/portals/list.php -->
<!DOCTYPE html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Список порталов</title>
	<style>
        :root {
            --bg: #f8f9fa;
            --text: #212529;
            --border: #dee2e6;
            --header-bg: #495057;
            --header-text: #ffffff;
            --link: #007bff;
            --link-hover: #0056b3;
            --table-bg: #ffffff;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--bg);
            color: var(--text);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--table-bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: var(--header-bg);
            font-size: 1.8rem;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            font-size: 0.95rem;
            background-color: #fff;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        thead {
            background-color: var(--header-bg);
            color: var(--header-text);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--border);
        }

        tbody tr:hover {
            background-color: #f1f3f5;
            transition: background-color 0.2s;
        }

        td a {
            color: var(--link);
            text-decoration: none;
            font-weight: 500;
        }

        td a:hover {
            color: var(--link-hover);
            text-decoration: underline;
        }

        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            h1 {
                font-size: 1.5rem;
            }

            table {
                font-size: 0.85rem;
            }

            th, td {
                padding: 8px 10px;
            }
        }
	</style>
</head>
<body>
<div class="container">
	<h1>Порталы</h1>

	<?php if (empty($portals)): ?>
		<p>Нет доступных порталов.</p>
	<?php else: ?>
		<table>
			<thead>
			<tr>
				<th>ID</th>
				<th>Название</th>
				<th>Адрес</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($portals as $portal): ?>
				<tr>
					<td><?= htmlspecialchars($portal->getId()) ?></td>
					<td><?= htmlspecialchars($portal->getName()) ?></td>
					<td>
						<a href="<?= htmlspecialchars($portal->getUrl()) ?>" target="_blank" rel="noopener">
							<?= htmlspecialchars($portal->getUrl()) ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php endif; ?>
</div>
</body>
</html>
