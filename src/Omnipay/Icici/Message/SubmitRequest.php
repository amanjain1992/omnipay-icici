<?php

namespace Omnipay\Icici\Message;

use Omnipay\Icici\Message\AbstractRequest;
use Crypt_DES;
use Crypt_Hash;

/**
 * Icici Submit Request
 */
class SubmitRequest extends AbstractRequest
{
    public function getData()
    {
        $data = parent::getData();

        $this->validate('amount');

        $data['MerchantID'] = $this->getAuthToken();
        $data['Vendor'] = $this->getAuthToken();
        $data['Partner'] = $this->getAuthToken();
        $data['OrdRefNo'] = date('Ymdhis').mt_rand(0,100);
        $data['MerchantTxnID'] = $this->getOrderId();
        $data['MessageType'] = 'req.Sale';
        $data['InvoiceNo'] = 'INV123';
        $data['InvoiceDate'] = mktime();
        $data['CurrCode'] = $this->getCurrency();
        $data['GMTOffset'] = '';
        $data['RespMethod'] = 'POST';
        $data['RespURL'] = $this->getReturnUrl();
        $data['Amount'] = $this->getAmount();
        $data['Ext1'] = 'Ext1';
        $data['Ext2'] = 'true';
        $data['Ext3'] = 'Ext3';
        $data['Ext4'] = 'Ext4';
        $data['Ext5'] = 'New PHP';
        $data['MrtIpAddr'] = '69.16.243.49';//$_SERVER["REMOTE_ADDR"];

        $billing = $this->getCustomerBillingDetails();
        $data['CustomerId'] = $billing["customer_id"];
        $data['CustomerName'] = $billing["customer_name"];
        $data['BillAddrLine1'] = $billing["addr1"];
        $data['BillAddrLine2'] = $billing["addr2"];
        $data['BillAddrLine3'] = $billing["addr3"];
        $data['BillCity'] = $billing["city"];
        $data['BillState'] = $billing["state"];
        $data['BillZip'] = $billing["zip"];
        $data['BillCountryAlphaCode'] = $billing["country_code"];
        $data['BillEmail'] = $billing["email"];

        $shipping = $this->getCustomerShippingDetails();
        $data['CustomerId'] = $shipping["customer_id"];
        $data['CustomerName'] = $shipping["customer_name"];
        $data['ShipAddrLine1'] = $shipping["addrshipping1"];
        $data['ShipAddrLine2'] = $shipping["addr2"];
        $data['ShipAddrLine3'] = $shipping["addr3"];
        $data['ShipCity'] = $shipping["city"];
        $data['ShipState'] = $shipping["state"];
        $data['ShipZip'] = $shipping["zip"];
        $data['ShipCountryAlphaCode'] = $shipping["country_code"];
        $data['ShipEmail'] = $shipping["email"];

        $data['EncryptedData'] = $this->generateSignature();
        $data['IntfVer'] = 'ASPV2.0';
        $data['OsType'] = 'UNIX';
        $data['LanguageType'] = 'php';
        $data['RequestType'] = 'SFAStatusInquiry';

        $data['WhatIUse'] = '';
        $data['AcceptHdr'] = '';
        $data['UserAgent'] = '';
        $data['CurrencyVal'] = '';
        $data['Exponent'] = '';
        $data['RecurFreq'] = '';
        $data['RecurEnd'] = '';
        $data['Installment'] = '';
        $data['DeviceCategory'] = '';
        $data['OrderDesc'] = '';
        $data['PurchaseAmount'] = '';
        $data['DisplayAmount'] = '';

        $data['Reserve1'] = '';
        $data['Reserve2'] = '';
        $data['Reserve3'] = '';
        $data['Reserve4'] = '';
        $data['Reserve5'] = '';
        $data['Reserve6'] = '';
        $data['Reserve7'] = '';
        $data['Reserve8'] = '';
        $data['Reserve9'] = '';
        $data['Reserve10'] = '';

        return $data;
    }

    /**
     * Function to generate the signature
     * @return [type] [description]
     */
    protected function generateSignature()
    {
        $sign = $this->getAuthToken().trim($this->getOrderId()).trim($this->getAmount()).trim('req.sale').trim($this->getCurrency()).trim('INV123');

        $signature  = $this->getSignature();
        
        $key = base64_encode($this->getAuthToken().$this->getAuthToken());
        $des = new Crypt_DES(CRYPT_DES_MODE_ECB);

        $des->setKey($this->hexstr(base64_decode($key)));

        $cleartext = $des->decrypt($this->hexstr($signature));

        $hexkey = $this->strhex($cleartext);

        $hexkey = (strlen($hexkey)<=40) ? $hexkey : substr($hexkey, 0, 40);

        $hash = new Crypt_Hash('sha1');

        $hash->setKey($hexkey);

        $digest = $hash->hash($sign);

        $cleardigest = $this->strhex($digest);

        return $cleardigest;
    }

    /**
     * function to modify key string
     * @param  [type] $hexstr [description]
     * @return [type]         [description]
     */
    public function hexstr($hexstr)
    {
        $hexstr = str_replace(' ', '', $hexstr);

        $retstr = pack('H*', $hexstr);

        return $retstr;

    }

    /**
     * function to modify the returned signature
     * @param  [type] $string [description]
     * @return [type]         [description]
     */
    public function strhex($string)
    {
        $hexstr = unpack('H*', $string);

        return array_shift($hexstr);

    }
}
