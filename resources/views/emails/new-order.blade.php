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

    <h5>Nueva Orden</h5>

    <ul>
        <li>ID: {{ $data->id}}</li>
        <li>USer ID: {{ $data->user_id}}</li>
        <li>Supplier ID {{ $data->suplier_id}}</li>
        <li>Metodo de Pago{{ $data->payment_method_id}}</li>
        <li>Estatus {{ $data->status}}</li>
        <li>Dirección {{ $data->dir}}</li>
        <li>Teléfono: {{ $data->phone}}</li>
        <li>Tipo: {{ $data->type}}</li>
        <li>Cantidad: {{ $data->quantity}}</li>
        <li>Precio: {{ $data->price }}</li>
        <li>Total: {{ $data->total_order }}</li>
        <li>Notas: {{ $data->notes }}</li>
        <li>Nombre: {{ $data->name }}</li>
        <li>Apellido: {{ $data->surname }}</li>
        <li>Codigo Postal {{ $data->zip_code }}</li>
    </ul>

</body>
</html>
