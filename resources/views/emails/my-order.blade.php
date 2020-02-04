<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Mis Ordenes</title>
</head>
<body>

    <h5>Mis ordenes</h5>

    @if ($status !== '')
        <p> El estatus de su orden ha sido actualizado a: {{ $status }}</p>
    @else
        <p>Ha sido incluida una nueva orden</p>
    @endif

</body>
</html>
