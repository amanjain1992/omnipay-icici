<?php

namespace Omnipay\Icici\Message;

/**
 * Icici Purchase Request
 */
class PurchaseRequest extends AuthorizeRequest
{
    public function getData()
    {
        $data = parent::getData();

        return $data;
    }
}
