<!-- Представление сущности "Каталог"-->

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="../../styles/catalog_style.css">
</head>
<body>
<form method="post">
<?php
$directoryList = $data->getCatalog();

foreach ($directoryList as $directory)
{
    if ($directory != "." && $directory != "..") {
        echo '<input type="hidden" name="' . $data->myPath . '">';
        echo '<button name="' . $directory . '">' . $directory . '</button>';
        echo '<tr><button class="delete_button right_tab" name="' . $directory . 'DELETE">Удалить</button>';
        echo '<br>';
    }

}

echo '<br><input type = "text" name = "createDirectory" placeholder = "Введите название директории"><br>';
echo '<button class="create_button" type = "submit">Добавить директорию</button><br>';

echo '<br><input type = "text" name = "createFile" placeholder = "Введите название файла"><br>';
echo '<button class="create_button" type = "submit">Добавить файл</button>';
?>
</form>
</body>
</html>