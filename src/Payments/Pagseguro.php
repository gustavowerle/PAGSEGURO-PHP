<?php

namespace BrPagamentos\Payments;

class PagSeguro
{
    protected $config;
    protected $sender;
    protected $shipping;
    protected $products = [];

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function customer($name, $area_code, $phone, $email)
    {
        $this->sender = [
            'senderName' => $name,
            'senderAreaCode' => $area_code,
            'senderPhone' => $phone,
            'senderEmail' => $email
        ];
    }

    public function shipping($type, $street, $number, $complement, $district, $postal_code, $city, $state, $country)
    {
        $this->shipping = [
            'shippingType' => $type,
            'shippingAddressStreet' => $street,
            'shippingAddressNumber' => $number,
            'shippingAddressComplement' => $complement,
            'shippingAddressDistrict' => $district,
            'shippingAddressPostalCode' => $postal_code,
            'shippingAddressCity' => $city,
            'shippingAddressState' => $state,
            'shippingAddressCountry' => $country,
        ];
    }

    public function addProduct($id, $description, $amount, $quantity, $wheight = null)
    {
        $index = count($this->products);
        $this->products[$index] = [
            'id' => $id,
            'description' => $description,
            'amount' => $amount,
            'quantity' => $quantity,
        ];

        if (!empty($wheight)) {
            $this->products[$index]['wheight'] = $wheight;
        }
    }

    public function removeProduct($id)
    {
        $products = array_filter($this->products, function ($product) use ($id) {
            return $product['id'] != $id;
        });

        $this->products = array_values($products);
    }

    public function __toString(): string
    {
        return http_build_query($this->toArray());
    }

    public function toArray(): array
    {
        $items = [];

        foreach ($this->products as $k => $product) {
            $counter = $k+1;
            $items['itemId'.$counter] = $product['id'];
            $items['itemDescription'.$counter] = $product['description'];
            $items['itemAmount'.$counter] = $product['amount'];
            $items['itemQuantity'.$counter] = $product['quantity'];
            if (!empty($items['itemWeight'])) {
                $items['itemWeight'.$counter] = $product['weight'];
            }
        }

        return array_merge($this->config, $items, $this->sender, $this->shipping);
    }
}
