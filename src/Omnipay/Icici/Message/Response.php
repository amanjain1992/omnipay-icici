<?php

namespace Omnipay\Icici\Message;

use Omnipay\Common\Message\AbstractResponse;
use Omnipay\Common\Message\RequestInterface;
use Omnipay\Common\Message\RedirectResponseInterface;

/**
 * Citrus Response
 */
class Response extends AbstractResponse implements RedirectResponseInterface
{
    public function __construct(RequestInterface $request, $data, $redirectUrl)
    {
        parent::__construct($request, $data);
        $this->redirectUrl = $redirectUrl;
        $this->data = $data;
    }

    public function isSuccessful()
    {
        return false;
    }

    public function isRedirect()
    {
        $txn_id = $this->data['RedirectionTxnID'];
        return (isset($txn_id)) ? true : false;
    }

    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }

    public function getRedirectMethod()
    {
        return 'POST';
    }

    public function getRedirectData()
    {
        return null;
    }
}
