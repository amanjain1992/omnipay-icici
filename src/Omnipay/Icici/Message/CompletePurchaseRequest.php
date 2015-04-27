<?php
namespace Omnipay\Icici\Message;

use Crypt_DES;
use Crypt_Hash;


class CompletePurchaseRequest extends PurchaseRequest
{

    public function isSuccessful()
    {
        return ($this->checkResponse()) ? 1 : 0;
    }
    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        $data = $this->httpRequest->request->all();

        $response = $data['DATA'];
        parse_str($response, $output);
        return $output;
    }

    /**
     * function to get the payment id
     * @return [type] [description]
     */
    public function getTransactionReference()
    {
        $data = $this->httpRequest->request->all();

        $response = $data['DATA'];
        parse_str($response, $output);
        return $output['TxnID'];
    }

    public function checkResponse()
    {
        $data = $this->httpRequest->request->all();

        $response = $data['DATA'];
        $encrypted = $data['EncryptedData'];

        $signature  = $this->getSignature();
        
        $key = base64_encode($this->getAuthToken().$this->getAuthToken());
        $des = new Crypt_DES(CRYPT_DES_MODE_ECB);

        $des->setKey($this->hexstr(base64_decode($key)));

        $cleartext = $des->decrypt($this->hexstr($signature));

        $hexkey = $this->strhex($cleartext);

        $hexkey = (strlen($hexkey)<=40) ? $hexkey : substr($hexkey, 0, 40);

        $hash = new Crypt_Hash('sha1');

        $hash->setKey($hexkey);

        $digest = $hash->hash($response);

        $cleardigest = $this->strhex($digest);

        if (strcasecmp($encrypted, $cleardigest) == 0) {
            return true;
        }

        return false;

    }
}
