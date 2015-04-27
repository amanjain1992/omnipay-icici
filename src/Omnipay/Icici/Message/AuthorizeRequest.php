<?php

namespace Omnipay\Icici\Message;

/**
 * Icici Authorize Request
 */
class AuthorizeRequest extends SubmitRequest
{
    /**
     * function to create data
     * signature is require for authentication
     * at Icici
     * @return [type] [description]
     */
    public function getData()
    {
        $data = parent::getData();

        return $data;
    }
}
