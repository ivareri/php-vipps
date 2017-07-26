<?php

namespace Vipps\Resource\Authorization;

use Vipps\Model\Authorization\RequestGetToken;
use Vipps\Model\Authorization\ResponseGetToken;
use Vipps\Resource\ResourceBase;
use Vipps\Resource\HttpMethod;
use Vipps\VippsInterface;

class GetToken extends ResourceBase
{

    /**
     * @var \Vipps\Resource\HttpMethod;
     */
    protected $method = HttpMethod::POST;

    /**
     * @var string
     */
    protected $path = '/accessToken/get';

    /**
     * @var string
     */
    protected $client_id;

    /**
     * @var string
     */
    protected $client_secret;

    public function __construct(\Vipps\VippsInterface $vipps, $client_id, $client_secret)
    {
        parent::__construct($vipps);
        $this->client_id = $client_id;
        $this->client_secret = $client_secret;
    }

    /**
     * Gets client_id value.
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * Gets client_secret value.
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->client_secret;
    }

    /**
     * {@inheritdoc}
     */
    public function getHeaders()
    {
        return [
            'client_id' => $this->getClientId(),
            'client_secret' => $this->getClientSecret(),
            'Ocp-Apim-Subscription-Key' => $this->app->getClient()->getSubscriptionKey(),
        ] + parent::getHeaders();
    }

    /**
     * @return \Vipps\Model\Authorization\ResponseGetToken
     */
    public function call()
    {
        $response = parent::call();
        /** \Vipps\Model\Authorization\ResponseGetToken */
        $responseObject = $this
            ->app
            ->getSerializer()
            ->deserialize(
                $response->getBody()->getContents(),
                'Vipps\Model\Authorization\ResponseGetToken',
                'json'
            );

        return $responseObject;
    }
}
