<?php

namespace BrPagamentos;

use BrPagamentos\MakeRequest;

class MakeRequestTest extends \PHPUnit\Framework\TestCase
{
    public function testePagSeguroRequest()
    {
        $access = [
            'email' => 'youremail@email.com',
            'token' => 'yourToken',
            'currency' => 'BRL',
            'reference' => 'REF1234'
        ];

        $pag_seguro = new Payments\PagSeguro($access);

        $pag_seguro->customer('Jose Comprador', 11, 999999999, 'c89471631444091465245@sandbox.pagseguro.com.br');

        $pag_seguro->shipping(
            1,
            'Av. PagSeguro',
            99,
            '99 esquina',
            'Jardim Internet',
            84600000,
            'Cidade Exemplo',
            'SP',
            'ATA'
        );

        $pag_seguro->addProduct(1, 'Curso de PHP', 19.99, 20);
        $pag_seguro->addProduct(2, 'Livro de Laravel', 19.99, 31);

        $response = (new MakeRequest())->post($pag_seguro, true);
        $xml = new \SimpleXMLElement((string)$response);

        $url = (new Requests\PagSeguro())->getUrlFinal($xml->code, true);

        $this->assertTrue(is_string($url));
    }
}
