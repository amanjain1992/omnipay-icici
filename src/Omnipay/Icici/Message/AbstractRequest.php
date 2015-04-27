<?php

namespace Omnipay\Icici\Message;

/**
 * Icici Abstract Request
 */
abstract class AbstractRequest extends \Omnipay\Common\Message\AbstractRequest
{
    protected $liveEndPoint = 'https://payseal.icicibank.com/mpi/Ssl.jsp';
    protected $testEndPoint = 'https://payseal.icicibank.com/mpi/Ssl.jsp';

    public function getUsername()
    {
        return $this->getParameter('username');
    }

    public function setUsername($value)
    {
        return $this->setParameter('username', $value);
    }
    
    public function getSalt()
    {
        return $this->getParameter('salt');
    }

    public function setSalt($value)
    {
        return $this->setParameter('salt', $value);
    }

    /**
     * function to send the Icici link
     * @return [type] [description]
     */
    public function getLink()
    {
        return $this->getParameter('link');
    }

    public function setLink($value)
    {
        return $this->setParameter('link', $value);
    }

    public function getApiKey()
    {
        return $this->getParameter('api_key');
    }

    public function setApiKey($value)
    {
        return $this->setParameter('api_key', $value);
    }

    /**
     * function to get the Merchant id
     * @return [type] [description]
     */
    public function getAuthToken()
    {
        return $this->getParameter('auth_token');
    }

    /**
     * function to set the merchantid
     * @param [type] $value [description]
     */
    public function setAuthToken($value)
    {
        return $this->setParameter('auth_token', $value);
    }

    /**
     * function to get the order id
     * @return [type] [description]
     */
    public function getOrderId()
    {
        return $this->getParameter('order_id');
    }

    /**
     * function to set order id
     * @param [type] $value [description]
     */
    public function setOrderId($value)
    {
        return $this->setParameter('order_id', $value);
    }

    /**
     * public function to get the signature
     * @return [type] [description]
     */
    public function getSignature()
    {
        return '8CB2CD32FA352CC148DDFE3FC6ECC27D9594D2BDF08F7A61F05B0CC8C3CE78FED7D48F52BEB940AF0794A3E7395E136994E6E4D334243FD2FD5D8B6E766904C87CF69A153CF7E00DC45747E2CD0366333B5F57A63C310FEF5E5D9B96357F047054CC7EA7C58427DC64E2C172901CFB4CF1721EF5B13A41CCDEB95BD9F59845895B62D2A5F3577B5F82FAEBB4C82442205624BB7AD290B7D418CC55B1AF27C113';
    }

    public function getCustomerBillingDetails()
    {
        return $data;
    }

    public function getCustomerShippingDetails()
    {
        return $data;
    }

    /**
     * function to send the data to Icici
     * @param  [type] $data [description]
     * @return [type]       [description]
     */
    public function sendData($data)
    {
        $ch = curl_init();

        $data = $this->getData();

        foreach ($data as $key => $value) {
            $str .= $key.'='.$value.'&';
        }

        curl_setopt($ch, CURLOPT_URL, $this->getEndpoint());
        curl_setopt($ch, CURLOPT_POSTFIELDS, $str);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_CAINFO, __DIR__. "/cacert.pem");
        $result = curl_exec($ch);
        curl_close($ch);
        
        $response = $this->response($result);

        $txn_id = $this->getParameter('RedirectionTxnID');

        //if(!empty($txn_id)) {
            $url =  $this->getEndpoint().'?txnId='.$txn_id;
            $data['RedirectionTxnID']= $txn_id;
            return $this->response = new Response($this, $data, $url);
        //}
    }

    /**
     * Function to return the output 
     * @param  [type]
     * @return [type]
     */
    public function response($retData)
    {
        $return = array();

        $retData = trim($retData);

        parse_str($retData, $output);

        if( array_key_exists('RespCode', $output) == 1) {
            $this->setParameter('RespCode', $output['RespCode']);
        }

        if( array_key_exists('Message', $output) == 1) {
            $this->setParameter('Message', $output['Message']);
        }

        if( array_key_exists('TxnID', $output) == 1) {
            $this->setParameter('TxnID', $output['TxnID']);
        }

        if( array_key_exists('RedirectionTxnID', $output) == 1) {
            $this->setParameter('RedirectionTxnID', $output['RedirectionTxnID']);
        }

        if( array_key_exists('ePGTxnID', $output) == 1) {
            $this->setParameter('ePGTxnID', $output['ePGTxnID']);
        }

        if( array_key_exists('AuthIdCode', $output) == 1) {
            $this->setParameter('AuthIdCode', $output['AuthIdCode']);
        }

        if( array_key_exists('RRN', $output) == 1) {
            $this->setParameter('RRN', $output['RRN']);
        }

        if( array_key_exists('TxnType', $output) == 1) {
            $this->setParameter('TxnType', $output['TxnType']);
        }

        if( array_key_exists('TxnDateTime', $output) == 1) {
            $this->setParameter('TxnDateTime', $output['TxnDateTime']);
        }

        if( array_key_exists('CVRespCode', $output) == 1) {
            $this->setParameter('CVRespCode', $output['CVRespCode']);
        }

        if( array_key_exists('Reserve1', $output) == 1) {
            $this->setParameter('Reserve1', $output['Reserve1']);
        }

        if( array_key_exists('Reserve2', $output) == 1) {
            $this->setParameter('Reserve2', $output['Reserve2']);
        }

        if( array_key_exists('Reserve3', $output) == 1) {
            $this->setParameter('Reserve3', $output['Reserve3']);
        }

        if( array_key_exists('Reserve4', $output) == 1) {
            $this->setParameter('Reserve4', $output['Reserve4']);
        }

        if( array_key_exists('Reserve5', $output) == 1) {
            $this->setParameter('Reserve5', $output['Reserve5']);
        }

        if( array_key_exists('Reserve6', $output) == 1) {
            $this->setParameter('Reserve6', $output['Reserve6']);
        }

        if( array_key_exists('Reserve7', $output) == 1) {
            $this->setParameter('Reserve7', $output['Reserve7']);
        }

        if( array_key_exists('Reserve8', $output) == 1) {
            $this->setParameter('Reserve8', $output['Reserve8']);
        }

        if( array_key_exists('Reserve9', $output) == 1) {
            $this->setParameter('Reserve9', $output['Reserve9']);
        }

        if( array_key_exists('Reserve10', $output) == 1) {
            $this->setParameter('Reserve10', $output['Reserve10']);
        }

        return $oPGResphp;

    }

    protected function getEndpoint()
    {
        return $this->getTestMode() ? $this->testEndPoint : $this->liveEndPoint;
    }

    public function getData()
    {
        $this->validate('amount', 'auth_token', 'order_id');

        $data = array();

        return $data;
    }
}
