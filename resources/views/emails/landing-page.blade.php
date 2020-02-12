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
        {{ $data['first_name']. ' ' . $data['last_name']}} a través del Landing Page,  te ha solicitado el producto: {{ $data['product_name'] }}.
    </p>

</body>
</html>
