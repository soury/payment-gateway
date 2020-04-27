<?php

namespace PagamentiOnline\PagOnline\Lists;

class Operation implements OperationList
{
    const TRANSACTION_TYPE_AUTH     = 'AUTH';
    const TRANSACTION_TYPE_PURCHASE = 'PURCHASE';

    /**
     * @return array
     */
    public function getList()
    {
        return [
            self::TRANSACTION_TYPE_AUTH     => 'Authorize',
            self::TRANSACTION_TYPE_PURCHASE => 'Purchase',
        ];
    }
}
