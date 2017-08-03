<?php

namespace Vipps\Tests\Unit\Resource\Payment;

use GuzzleHttp\Psr7\Response;
use function GuzzleHttp\Psr7\stream_for;
use Vipps\Model\Payment\RequestRefundPayment;
use Vipps\Model\Payment\ResponseRefundPayment;
use Vipps\Resource\Payment\RefundPayment;
use Vipps\Resource\HttpMethod;

class RefundPaymentTest extends PaymentResourceBaseTestBase
{

    /**
     * @var \Vipps\Resource\Payment\RefundPayment
     */
    protected $resource;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->resource = $this->getMockBuilder(RefundPayment::class)
            ->setConstructorArgs([$this->vipps, 'test_subscription_key', 'test_order_id', new RequestRefundPayment()])
            ->disallowMockingUnknownTypes()
            ->setMethods(['makeCall'])
            ->getMock();

        $this->resource
            ->expects($this->any())
            ->method('makeCall')
            ->will($this->returnValue(new Response(200, [], stream_for(json_encode([])))));
    }

    /**
     * @covers \Vipps\Resource\Payment\RefundPayment::getBody()
     * @covers \Vipps\Resource\Payment\RefundPayment::__construct()
     */
    public function testBody()
    {
        $this->assertNotEmpty($this->resource->getBody());
        // Valid JSON.
        $this->assertNotNull(json_decode($this->resource->getBody()));
    }

    /**
     * @covers \Vipps\Resource\Payment\RefundPayment::getMethod()
     */
    public function testMethod()
    {
        $this->assertEquals(HttpMethod::POST, $this->resource->getMethod());
    }

    /**
     * @covers \Vipps\Resource\Payment\RefundPayment::getPath()
     */
    public function testPath()
    {
        $this->assertEquals('/Ecomm/v1/payments/test_order_id/refund', $this->resource->getPath());
    }

    /**
     * @covers \Vipps\Resource\Payment\RefundPayment::call()
     */
    public function testCall()
    {
        $this->assertInstanceOf(ResponseRefundPayment::class, $response = $this->resource->call());
        $this->assertEquals(new ResponseRefundPayment(), $response);
    }
}