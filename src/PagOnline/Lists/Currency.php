<?php

namespace PagamentiOnline\PagOnline\Lists;


class Currency implements CurrencyList
{
    const CURRENCY_CODE_EUR = 'EUR';
    const CURRENCY_CODE_USD = 'USD';

    /**
     * @return array
     */
    public function getList()
    {
        return [
            self::CURRENCY_CODE_EUR => 'Euro',
            self::CURRENCY_CODE_USD => 'US Dollar',
        ];
    }
}
