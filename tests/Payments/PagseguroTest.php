<?php

namespace BrPagamentos\Payments;

class PagseguroTest extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        //executa sempre antes de iniciar o teste
        $access = [
            'email' => 'email@email',
            'token' => 'token',
            'currency' => 'BRL',
            'reference' => 'REF1234'
        ];

        $this->pag_seguro = new PagSeguro($access);
        
        //Dados comprador(cliente)
        //name, areacode, phone, email
        $this->pag_seguro->customer('Jose Comprador', 11, 999999999, 'comprador@comprador.com.br');

        //Endereço de entrega
        //type, street, number, complement, district, postal code, city, state, country
        $this->pag_seguro->shipping(
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

        //Dados dos itens
        //id, description, amount, quantity, wheight
        $this->pag_seguro->addProduct(1, 'Curso de PHP', 19.99, 20);
        $this->pag_seguro->addProduct(2, 'Livro de Laravel', 19.99, 31);
    }

    public function testListarProdutosAdicionadosEmUmArray()
    {
        $actual = $this->pag_seguro->toArray();
        $expected = [
            'email'             => 'email@email',
            'token'             => 'token',
            'currency'          => 'BRL',
            'reference'         => 'REF1234',
            'itemId1'           => 1,
            'itemDescription1'  => 'Curso de PHP',
            'itemAmount1'       => 19.99,
            'itemQuantity1'     => 20,
            'itemId2'           => 2,
            'itemDescription2'  => 'Livro de Laravel',
            'itemAmount2'       => 19.99,
            'itemQuantity2'     => 31,
            'senderName'        => 'Jose Comprador',
            'senderAreaCode'    =>  11,
            'senderPhone'       =>  999999999,
            'senderEmail'       =>  'comprador@comprador.com.br',
            'shippingType'      => 1,
            'shippingAddressStreet'     => 'Av. PagSeguro',
            'shippingAddressNumber'     => 99,
            'shippingAddressComplement' => '99 esquina',
            'shippingAddressDistrict'   => 'Jardim Internet',
            'shippingAddressPostalCode' => 84600000,
            'shippingAddressCity'       => 'Cidade Exemplo',
            'shippingAddressState'      => 'SP',
            'shippingAddressCountry'    => 'ATA'
        ];
        $this->assertEquals($expected, $actual);
    }

    public function testRemoverProduto()
    {
        $this->pag_seguro->removeProduct(2);
        $actual = $this->pag_seguro->toArray();
        $expected = [
            'email'             => 'email@email',
            'token'             => 'token',
            'currency'          => 'BRL',
            'reference'         => 'REF1234',
            'itemId1'           => 1,
            'itemDescription1'  => 'Curso de PHP',
            'itemAmount1'       => 19.99,
            'itemQuantity1'     => 20,
            'senderName'        => 'Jose Comprador',
            'senderAreaCode'    =>  11,
            'senderPhone'       =>  999999999,
            'senderEmail'       =>  'comprador@comprador.com.br',
            'shippingType'      => 1,
            'shippingAddressStreet'     => 'Av. PagSeguro',
            'shippingAddressNumber'     => 99,
            'shippingAddressComplement' => '99 esquina',
            'shippingAddressDistrict'   => 'Jardim Internet',
            'shippingAddressPostalCode' => 84600000,
            'shippingAddressCity'       => 'Cidade Exemplo',
            'shippingAddressState'      => 'SP',
            'shippingAddressCountry'    => 'ATA'
        ];
        $this->assertEquals($expected, $actual);
    }

    public function testListarProdutosAdicionadosEmUmaString()
    {
        $actual = (string)$this->pag_seguro;
        $this->assertTrue(is_string($actual));
    }
}
