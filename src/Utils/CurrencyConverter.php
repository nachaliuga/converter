<?php
namespace Cart\Utils;

use Cart\Utils\Provider\CurrencyExchangeRates;
use Exception;

class CurrencyConverter implements CurrencyConverterInterface
{
    /**
     * @var
     */
    protected $rateProvider;

    private $baseCurrency = 'EUR';

    /**
     * @param $from
     * @param $to
     * @param int $amount
     * @return float|int
     * @throws Exception
     */
    public function convert($from, $to, $amount = 1)
    {
        if (!$from) {
            $from = $this->baseCurrency;
        }

        $fromCurrency = $this->formatCurrencyArgument($from);
        $toCurrency = $this->formatCurrencyArgument($to);
        $rate = $this->getRateProvider()->getRate($fromCurrency, $toCurrency);

        return $rate * $amount;
    }

    /**
     * @return mixed
     */
    public function getRateProvider()
    {
        if (!$this->rateProvider) {
            $this->setRateProvider(new CurrencyExchangeRates());
        }

        return $this->rateProvider;
    }

    /**
     * @param Provider\CurrencyExchangeProviderInterface $rateProvider
     * @return $this
     */
    public function setRateProvider(Provider\CurrencyExchangeProviderInterface $rateProvider)
    {
        $this->rateProvider = $rateProvider;

        return $this;
    }

    /**
     * @param $data
     * @return false|string
     * @throws Exception
     */
    private function formatCurrencyArgument($data)
    {
        if (empty($data) || !is_string($data)) {
            throw new Exception("Please provide valid argument to function");

            return false;
        }

        return $data;
    }
}