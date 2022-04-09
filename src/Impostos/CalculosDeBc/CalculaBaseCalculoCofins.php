<?php

namespace PhpTributos\Impostos\CalculosDeBc;

use PhpTributos\Flags\TipoDesconto;
use PhpTributos\Impostos\CalculosDeBc\Base\CalculaBaseCalculoBase;
use PhpTributos\Impostos\Tributavel;

class CalculaBaseCalculoCofins extends CalculaBaseCalculoBase
{
    /**
     * @var string TipoDesconto
     */
    protected $tipoDesconto;

    /**
     * @param Tributavel
     * @param string
     */
    public function __construct(Tributavel $tributavel, string $tipoDesconto)
    {
        parent::__construct($tributavel);
        $this->tipoDesconto = $tipoDesconto;
    }

    public function calculaBaseCalculoBase(): float
    {
        $baseCalculo = $this->tributavel->icmsSobreIpi ?
        parent::calculaBaseDeCalculo() + $this->tributavel->valorIpi : parent::calculaBaseDeCalculo();
        return $this->tipoDesconto == TipoDesconto::Condicional ?
        $this->calculaBaseComDescontoCondicional($baseCalculo) :
        $this->calculaBaseComDescontoIncondicional($baseCalculo);

    }

    private function calculaBaseComDescontoCondicional(float $baseCalculoInicial): float
    {
        $baseCalculo = $baseCalculoInicial + $this->tributavel->desconto;
        return $baseCalculo;
    }

    private function calculaBaseComDescontoIncondicional(float $baseCalculoInicial): float
    {
        $baseCalculo = $baseCalculoInicial - $this->tributavel->desconto;
        return $baseCalculo;
    }
}
