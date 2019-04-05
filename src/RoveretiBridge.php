<?php

namespace SonnyBlaine\RoveretiBridge;

use GuzzleHttp\Client as GuzzleClient;
use Simonetti\Rovereti as SDK;
use SonnyBlaine\IntegratorBridge\BridgeInterface;
use SonnyBlaine\IntegratorBridge\IntegrateRequestInterface;
use SonnyBlaine\IntegratorBridge\SearchRequestInterface;
use SonnyBlaine\RoveretiBridge\Search;

/**
 * Class RoveretiBridge
 * @package SonnyBlaine\RoveretiBridge
 */
class RoveretiBridge implements BridgeInterface
{
    const URI_INCLUIR_PESSOA_JURIDICA = 'PessoaJuridica/IncluirPessoaJuridica';
    const URI_INCLUIR_CONTA_PAGAR = 'ContaPagar/IncluirContaPagar';
    const URI_CANCELAR_CONTA_PAGAR = 'ContaPagar/CancelarContaPagar';
    const URI_INCLUIR_MOVIMENTO_CAIXA = 'Caixa/IncluirMovtoCaixa';
    const URI_INCLUIR_MOVIMENTO_CAIXA_BANCO = 'Caixa/IncluirMovtoCaixaBanco';
    const URI_INCLUIR_MOVIMENTO_CONTA_CORRENTE = 'ContaCorrente/IncluirMovtoContaCorrente';
    const URI_INCLUIR_CREDITO_FORNECEDOR = 'CreditoFornecedor/IncluirCreditoFornecedor';
    const URI_INCLUIR_CONTRATO_CONTA_RECEBER = 'ContaReceber/IncluirContrato';

    /**
     * Client to integrate
     * @var SDK\Client
     */
    protected $client;

    /**
     * RoveretiBridge constructor.
     * @param string $baseUri
     * @param string $user
     * @param int $key
     */
    public function __construct(string $baseUri, string $user, int $key)
    {
        $guzzleClient = new GuzzleClient(['base_uri' => $baseUri]);
        $token = new SDK\Token($user, $key);

        $this->client = new SDK\Client($guzzleClient, $token);
    }

    /**
     * Integrates a requisition
     * @param IntegrateRequestInterface $request
     * @throws \Exception
     * @return void
     */
    public function integrate(IntegrateRequestInterface $request): void
    {
        switch ($request->getMethodIdentifier()) {
            case 'IncluirPessoaJuridica':
                $pessoaJuridica = new SDK\PessoaJuridica();
                $pessoaJuridica->populate($request->getData());

                $incluirPJ = new SDK\IncluirPessoaJuridica($this->client);
                $incluirPJ->execute(self::URI_INCLUIR_PESSOA_JURIDICA, $pessoaJuridica);
                break;

            case 'IncluirContaPagar':
                $contaPagar = new SDK\ContaPagar();
                $contaPagar->populate($request->getData());

                $incluirCP = new SDK\IncluirContaPagar($this->client);
                $incluirCP->execute(self::URI_INCLUIR_CONTA_PAGAR, $contaPagar);
                break;

            case 'CancelarContaPagar':
                $cancelamentoContaPagar = new SDK\CancelamentoContaPagar();
                $cancelamentoContaPagar->populate($request->getData());

                $cancelarCP = new SDK\CancelarContaPagar($this->client);
                $cancelarCP->execute(self::URI_CANCELAR_CONTA_PAGAR, $cancelamentoContaPagar);
                break;

            case 'IncluirMovtoCaixa':
                $movimentoCaixa = new SDK\MovimentoCaixa();
                $movimentoCaixa->populate($request->getData());

                $incluirMC = new SDK\IncluirMovimentoCaixa($this->client);
                $incluirMC->execute(self::URI_INCLUIR_MOVIMENTO_CAIXA, $movimentoCaixa);
                break;

            case 'IncluirMovtoCaixaBanco':
                $transferenciaCaixaBanco = new SDK\TransferenciaCaixaBanco();
                $transferenciaCaixaBanco->populate($request->getData());

                $incluirTCB = new SDK\IncluirTransferenciaCaixaBanco($this->client);
                $incluirTCB->execute(self::URI_INCLUIR_MOVIMENTO_CAIXA_BANCO, $transferenciaCaixaBanco);
                break;

            case 'IncluirMovtoContaCorrente':
                $movimentoCC = new SDK\MovimentoContaCorrente();
                $movimentoCC->populate($request->getData());

                $incluirMCC = new SDK\IncluirMovimentoContaCorrente($this->client);
                $incluirMCC->execute(self::URI_INCLUIR_MOVIMENTO_CONTA_CORRENTE, $movimentoCC);
                break;

            case 'IncluirCreditoFornecedor':
                $creditoFornecedor = new SDK\CreditoFornecedor();
                $creditoFornecedor->populate($request->getData());

                $incluirCF = new SDK\IncluirCreditoFornecedor($this->client);
                $incluirCF->execute(self::URI_INCLUIR_CREDITO_FORNECEDOR, $creditoFornecedor);
                break;

            case 'IncluirContratoContaReceber':
                $data = $request->getData();

                $parcela = new \stdClass;
                $parcela->numParcela = $data->numParcela;
                $parcela->datVencimento = $data->datVencimento;
                $parcela->vlrParcela = $data->vlrParcela;

                $data->parcelas = [$parcela];

                unset($data->numParcela, $data->datVencimento, $data->vlrParcela);

                $contratoContaReceber = new SDK\ContratoContaReceber();
                $contratoContaReceber->populate($data);

                $incluirCCR = new SDK\IncluirContratoContaReceber($this->client);
                $incluirCCR->execute(self::URI_INCLUIR_CONTRATO_CONTA_RECEBER, $contratoContaReceber);
                break;

            default:
                throw new \Exception("Error: Method undefined.");
        }
    }

    /**
     * @param SearchRequestInterface $request
     * @return mixed
     */
    public function search(SearchRequestInterface $request)
    {
        return Search\MethodGateway::getInstance()
            ->getMethodFromRequest($request)
            ->execute($this->client, $request);
    }
}