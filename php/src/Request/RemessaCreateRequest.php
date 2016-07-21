<?php
// Copyright (c) 2016 BoletoSinc

// Permission is hereby granted, free of charge, to any person obtaining a
// copy of this software and associated documentation files (the "Software"),
// to deal in the Software without restriction, including without limitation
// the rights to use, copy, modify, merge, publish, distribute, sublicense,
// and/or sell copies of the Software, and to permit persons to whom the
// Software is furnished to do so, subject to the following conditions:

// The above copyright notice and this permission notice shall be included in
// all copies or substantial portions of the Software.

// THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
// IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
// FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
// AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
// LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
// FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
// DEALINGS IN THE SOFTWARE.

namespace BoletoSinc\Request;

/**
 * Request para gerar remessa
 * @author Glauber Portella <suporte@boletosinc.com.br>
 */
class RemessaCreateRequest
{
    const API_ENDPOINT = 'https://www.boletosinc.com.br/v1/remessas/gerar';

    /**
     * Sua chave da API BoletoSinc
     * @var string
     */
    private $apiToken;

    /**
     * Array com os dados que serão enviados na requisição
     * @var array
     */
    private $payload;

    public function __construct($apiToken)
    {
        $this->apiToken = $apiToken;
    }

    /**
     * Envia chamada na API
     * @param  array $payload Array com os dados para compor a remessa
     * @return array Retorna resposta da api
     */
    public function send(array $payload)
    {
        $ch = curl_init(self::API_ENDPOINT);

        $payloadJson = json_encode($payload);

        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payloadJson);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'CNAB-API-KEY: '.$this->apiToken,
            'Content-Type: application/json',
            'Content-Length: ' . strlen($payloadJson))
        );

        $result = curl_exec($ch);
        curl_close($ch);

        if (false === $result)
            throw new RequestException('Falha na requisição.');

        return json_decode($result);
    }
}
