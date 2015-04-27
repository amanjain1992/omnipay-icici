<?php

namespace Omnipay\Icici;

use Omnipay\Common\AbstractGateway;

/**
 * Icici Gateway
 *
 * @link http://docs.Iciciservices.com/raven/api-guide/
 */
class Gateway extends AbstractGateway
{
    public function getName()
    {
        return 'Icici';
    }

    public function getDefaultParameters()
    {
        return array(
            'api_key' => '',
            'auth_token' => '',
            'end_point' =>'',
            'salt' => ''
        );
    }

    /**
     * Setting up the salt for signature
     * @return [type] [description]
     */
    public function getSalt()
    {
        return $this->getParameter('salt');
    }

    public function setSalt($value)
    {
        return $this->setParameter('salt', $value);
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
     * function to get the merchant Id 
     * @return [type] [description]
     */
    public function getAuthToken()
    {
        return $this->getParameter('auth_token');
    }

    /**
     * function to set the Merchant Id
     * @param [type] $value [description]
     */
    public function setAuthToken($value)
    {
        return $this->setParameter('auth_token', $value);
    }

    /**
     * function to get the orderid (unique)
     * @return [type] [description]
     */
    public function getOrderId()
    {
        return $this->getParameter('order_id');
    }

    /**
     * function to get the order id 
     * @param [type] $value [description]
     */
    public function setOrderId($value)
    {
        return $this->setParameter('order_id', $value);
    }

    public function getLink()
    {
        return $this->getParameter('link');
    }

    public function setLink($value)
    {
        return $this->setParameter('link', $value);
    }

    public function purchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Icici\Message\PurchaseRequest', $parameters);
    }

    public function authorize(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Icici\Message\AuthorizeRequest', $parameters);
    }

    public function completePurchase(array $parameters = array())
    {
        return $this->createRequest('\Omnipay\Icici\Message\CompletePurchaseRequest', $parameters);
    }
}
