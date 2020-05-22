<?php

require __DIR__.'/../vendor/autoload.php';

$access = [
    'email' => 'youremail@email.com',
    'token' => 'yourToken',
    'currency' => 'BRL',
    'reference' => 'REF1234'
];

$pag_seguro = new BrPagamentos\Payments\PagSeguro($access);
$pag_seguro->customer('Jose Comprador', 11, 999999999, 'c89471631444091465245@sandbox.pagseguro.com.br');
$pag_seguro->shipping(1, 'Av. PagSeguro', 99, '99 esquina', 'Jardim Internet', 84600000, 'Cidade Exemplo', 'SP', 'ATA');
$pag_seguro->addProduct(1, 'Curso de PHP', 19.99, 20);
$pag_seguro->addProduct(2, 'Livro de Laravel', 19.99, 31);

$response = (new BrPagamentos\MakeRequest())->post($pag_seguro, true);
$xml = new \SimpleXMLElement((string)$response);
$url = (new BrPagamentos\Requests\PagSeguro())->getUrlFinal($xml->code, true);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PagSeguro PHP</title>
</head>
<body>
    <button onclick="PagSeguroLightbox('<?php echo $xml->code;?>')">Pagar com ligthbox</button>

<script type="text/javascript" src="https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js"></script>
</body>
</html>