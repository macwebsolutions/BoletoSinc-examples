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

namespace BoletoSinc\Service;

use BoletoSinc\Request\RequestPayloadInterface.php

/**
 * Uma remessa
 * @author Glauber Portella <suporte@boletosinc.com.br>
 */
class RemessaPagamentoItauCnab240 implements RequestPayloadInterface
{
    const BANCO = 341;
    const CNAB = 'cnab240';
    const SERVICO = 'pagamentos';

    private $headerArquivo;
    private $headerLote;
    private $trailerLote;
    private $trailerArquivo;
    private $lotes;

    public function setHeaderArquivo(array $data)
    {
        $this->headerArquivo = $data;
        return $this;
    }

    public function setHeaderLote(array $data)
    {
        $this->headerLote = $data;
        return $this;
    }

    public function setTrailerLote(array $data)
    {
        $this->trailerLote = $data;
        return $this;
    }

    public function setTrailerArquivo(array $data)
    {
        $this->trailerArquivo = $data;
        return $this;
    }

    public function setLotes(array $data)
    {
        $this->lotes = $data;
        return $this;
    }

    public function createPayload()
    {
        return array(
            'banco' => self::BANCO, // código do banco Itaú
            'formato' => self::CNAB,
            'servico' => self::SERVICO, // veja http://docs.boletosinc.com.br/servicos
            'header_arquivo' => $this->headerArquivo,
            'trailer_arquivo' => $this->trailerArquivo,
            'lotes' => $this->lotes
        );
    }
}
