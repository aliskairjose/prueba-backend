<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Landin Page</title>
</head>
<body>

    <p >Hola {{ $data['user_full_name']}}</p>

    <p>
        {{ $data['first_name']. ' ' . $data['last_name']}} a través del Landing Page,  te ha solicitado {{ $data['quantity'] }}, del producto  {{ $data['product_name'] }}.
    </p>
    <p>
        Datos del solicitante:
        <ul>
            <li>Email: {{ $data[ 'email' ] }}</li>
            <li>Teléfono: {{ $data[ 'phone' ] }}</li>
            <li>Dirección: {{ $data[ 'address' ] }}, {{ $data[ 'city' ] }}, {{ $data[ 'country' ] }} </li>
            <li>Código postal: {{ $data[ 'zip_code' ] }}</li>
            <li>Nota: {{ $data[ 'note' ] }}</li>
        </ul>
    </p>

</body>
</html>
