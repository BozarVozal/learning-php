<?php

echo "<h1>PHP работает через nginx</h1>";
echo "<h2>Артем</h2>";
echo "<p>SAPI: <b>" . PHP_SAPI . "</b></p>";
echo "<p>Версия PHP: " . PHP_VERSION . "</p>";
echo "<p>Имя контейнера с PHP: " . gethostname() . "</p>";
echo "<p>Запрошенный адрес: " . $_SERVER['REQUEST_URI'] . "</p>";
echo '<p><a href="/info.php">Подробности о PHP</a></p>';
