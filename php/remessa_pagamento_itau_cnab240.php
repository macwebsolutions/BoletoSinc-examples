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

/**
 * Gerando uma remessa de pagamento (débito em conta) Cnab240 Itaú
 * @author Glauber Portella <suporte@boletosinc.com.br>
 */

require_once __DIR__.'/vendor/autoload.php';

use BoletoSinc\Request\RemessaCreateRequest;
use BoletoSinc\Request\RequestException;
use BoletoSinc\Service\RemessaPagamentoItauCnab240;


// Uso

// Dados da remessa a ser gerada, montar conforme seus dados em seu sistema
// e campos do serviço da api (no caso CNAB 240 > Banco Itaú > Pagamentos
// vide Serviços da API em http:/docs.boletosinc.com.br/servicos

$headerArquivo = array(
    'codigo_banco' => 341,
    'codigo_lote' => 1,
    'tipo_registro' => 0,
    //'brancos_01' => '',
    'layout_arquivo' => '',
    'tipo_inscricao' => '',
    'inscricao_numero' => '',
    //'brancos_02' => '',
    'agencia_debito' => '',
    //'brancos_03' => '',
    'conta_debito' => '',
    //'brancos_04' => '',
    'dac_debito' => '',
    'nome_empresa' => '',
    'nome_banco' => '',
    //'brancos_05' => '',
    'arquivo_codigo' => '',
    'data_geracao' => '',
    'hora_geracao' => '',
    //'zeros_01' => '',
    'densidade_gravacao' => '',
    //'brancos_06' => '',
);

$trailerArquivo = array(
    'codigo_banco' => 341,
    'codigo_lote' => 1,
    'tipo_registro' => 9,
    //'brancos_01' => '',
    'total_lotes_arquivo' => '',
    'total_registros' => '',
    //'brancos_02' => '',
);

$headerLote = array(
    'codigo_banco' => '',
    'codigo_lote' => '',
    'tipo_registro' => '',
    'tipo_operacao' => '',
    'tipo_pagamento' => '',
    'forma_pagamento' => '',
    'layout_lote' => '',
    //'brancos_01' => '',
    'tipo_inscricao_debito' => '',
    'inscricao_numero' => '',
    'identificacao_lancamento' => '',
    //'brancos_02' => '',
    'agencia_debito' => '',
    'brancos_03' => '',
    'conta_debito' => '',
    //'brancos_04' => '',
    'dac_debito' => '',
    'nome_empresa' => '',
    'finalidade_lote' => '',
    'historico_cc_debito' => '',
    'endereco_empresa' => '',
    'numero' => '',
    'complemento' => '',
    'cidade' => '',
    'cep' => '',
    'estado' => '',
    //'brancos_05' => '',
    'codigo_ocorrencias' => '',
);

$trailerLote = array(
    'codigo_banco' => '',
    'codigo_lote' => '',
    'tipo_registro' => '',
    //'brancos_01' => '',
    'total_registros_lote' => '',
    'total_valor_pagtos' => '',
    //'zeros_01' => '',
    //'brancos_02' => '',
    'codigos_ocorrencias' => '',
);

// cada item em detalhes é um título/pagamento que possui segmentos
// conforme documentação da API http://docs.boletosinc.com.br/servicos/pagamentos-ted-doc-cc/cnab240/341.html
$detalhes => array(
    // pagamento para um favorecido
    array(
        'segmentos' => array(
            // Segmento A - (Obrigatório)
            array(
                'codigo_segmento': 'a',
                'codigo_banco' => 341,
                'codigo_lote' => 1,
                'tipo_registro' => '',
                'numero_registro' => '',
                'segmento_codigo' => 'A',
                'tipo_movimento' => '',
                'codigo_camara_centralizadora' => '',
                'codigo_banco_favorecido' => '',
                'agencia_favorecido' => '',
                'nome_favorecido' => '',
                'numero_doc' => '',
                'data_pagto' => '',
                'moeda' => '',
                'codigo_ispb' => '',
                //'zeros_01' => '',
                'valor_pagto' => '',
                'nosso_numero' => '',
                //'brancos_01' => '',
                'data_efetiva' => '',
                'valor_efetivo' => '',
                'finalidade' => '',
                //'brancos_02' => '',
                'num_documento' => '',
                'num_inscricao_favorecido' => '',
                'finalidade_doc_status_funcionario' => '',
                'finalidade_ted' => '',
                //'brancos_03' => '',
                'aviso' => '',
                'codigo_ocorrencias' => '',
            ),
            // Segmento B - (opcional)
            // quando for necessária emissão de aviso ao favorecido ou quando contratado o envio de
            // Demonstrativo de Pagamentos via e-mail

            // Segmento C – (opcional)
            // Necessário quando contratado o serviço de Demonstrativo de Pagamentos via web / e-mail

            // Segmento D, E e F – (opcionais)
            // Necessário quando contratado o serviço de
            // Holerite – Demonstrativo de Pagamentos / Informe de Rendimentos via Itaú 30 horas / Auto Atendimento
        ),
    ),
    // ... demais pagamentos para os demais favorecidos
);

// lotes da remessa, como apenas serviço de débito em conta está sendo enviado na remessa
// a mesma possuirá somente um lote com os vários detalhes (pagamentos) pertencentes a esse lote
$lotes = array(
    // lote único
    array(
        'codigo_lote' => 1,
        'header_lote' => $headerLote,
        'trailer_lote' => $trailerLote,
        'detalhes' => $detalhes,
    ),
);

$remessa = new RemessaPagamentoItauCnab240();
$remessa
    ->setHeaderArquivo($headerArquivo)
    ->setHeaderLote($headerLote)
    ->setLotes($lotes);
    ->setTrailerLote($trailerLote)
    ->setTrailerArquivo($trailerArquivo)
;
$payload = $remessa->createPayload();

try {
    $request = new RemessaCreateRequest('SUA CHAVE DA API');
    $response = $request->send($payload);
} catch (RequestException $e) {
    // Tratar exceção da requisição
}

if ($response->success) {
    // Requisição executada com sucesso
    // Obter dados do retorno em $response->data conforme http://docs.boletosinc.com.br
} else {
    // Erro no retono, vide $response->exception->message
}
