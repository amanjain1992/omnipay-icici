<?php

namespace Omnipay\Icici\Message;

class CompletePurchaseResponse extends Response
{
    /**
     * {@inheritdoc}
     */
    public function getMessage()
    {
        if ($status = $this->getStatus()) {
            return $status;
        } elseif (!is_null($this->code)) {
            return $this->data;
        }

        return null;
    }

    public function getStatus()
    {
        if (isset($this->data->transaction) && isset($this->data->transaction->status)) {
            return (string) $this->data->transaction->status;
        }

        return null;
    }
}
