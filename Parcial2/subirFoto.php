<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="./AgregarConFoto.php" method="post" enctype="multipart/form-data">
        <input type="text" name="tipo" placeholder="tipo">
        <input type="text" name="precio" placeholder="precio">
        <input type="text" name="paisOrigen" placeholder="Pais de origen">
        <input type="file" name="archivo" placeholder="Subir foto">
        <input type="submit">
    </form>
</body>
</html>