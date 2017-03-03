<?php

class ConfigurationTest extends \PHPUnit_Framework_TestCase
{

    public function testBasicInstantiation()
    {
        $configuration = new \OtherCode\Rest\Core\Configuration();
        $this->assertInstanceOf('\OtherCode\Rest\Core\Configuration', $configuration);

        $this->assertInternalType('array', $configuration->toArray());
        $this->assertCount(3, $configuration->toArray());
    }

    /**
     * @return \OtherCode\Rest\Core\Configuration
     */
    public function testInstantiationWithParams()
    {
        $configuration = new \OtherCode\Rest\Core\Configuration(array(
            'url' => 'http://jsonplaceholder.typicode.com/',
            'thisConfigurationIsNotAllowed' => 'Some invalid value',
            'httpheader' => array(
                'some_header' => 'some_value'
            )
        ));
        $this->assertInstanceOf('\OtherCode\Rest\Core\Configuration', $configuration);

        $this->assertInternalType('array', $configuration->toArray());
        $this->assertCount(4, $configuration->toArray());

        return $configuration;
    }

    /**
     * @depends testInstantiationWithParams
     * @param \OtherCode\Rest\Core\Configuration $configuration
     * @return \OtherCode\Rest\Core\Configuration
     */
    public function testAddHeader(\OtherCode\Rest\Core\Configuration $configuration)
    {
        $configuration->addHeader('one_more_header', 'one_more_value');
        $this->assertCount(2, $configuration->httpheader);

        return $configuration;
    }

    /**
     * @depends testAddHeader
     * @param \OtherCode\Rest\Core\Configuration $configuration
     */
    public function testRemoveHeader(\OtherCode\Rest\Core\Configuration $configuration)
    {
        $configuration->removeHeader('one_more_header');
        $this->assertCount(1, $configuration->httpheader);
    }

    /**
     * @depends testInstantiationWithParams
     * @param \OtherCode\Rest\Core\Configuration $configuration
     * @return \OtherCode\Rest\Core\Configuration
     */
    public function testAddHeaders(\OtherCode\Rest\Core\Configuration $configuration)
    {
        $configuration->addHeaders(array(
            'one_more_header' => 'one_more_value',
            'two_more_header' => 'two_more_value'
        ));
        $this->assertCount(3, $configuration->httpheader);

        return $configuration;
    }

    /**
     * @depends testAddHeaders
     * @param \OtherCode\Rest\Core\Configuration $configuration
     */
    public function testRemoveHeaders(\OtherCode\Rest\Core\Configuration $configuration)
    {
        $configuration->removeHeaders(array(
            'one_more_header',
            'two_more_header'
        ));
        $this->assertCount(1, $configuration->httpheader);
    }

    /**
     * @depends testInstantiationWithParams
     * @param \OtherCode\Rest\Core\Configuration $configuration
     */
    public function testBasicAuth(\OtherCode\Rest\Core\Configuration $configuration)
    {
        $configuration->basicAuth('username', 'password');
        $this->assertCount(5, $configuration->toArray());
    }

    /**
     * @depends testInstantiationWithParams
     * @param \OtherCode\Rest\Core\Configuration $configuration
     */
    public function testSetSSLCertificate(\OtherCode\Rest\Core\Configuration $configuration)
    {
        $configuration->setSSLCertificate('/some/path/to/ssl.cert');
        $this->assertCount(6, $configuration->toArray());
    }

    /**
     * @depends testInstantiationWithParams
     * @param \OtherCode\Rest\Core\Configuration $configuration
     */
    public function testSetCACertificatesCapath(\OtherCode\Rest\Core\Configuration $configuration)
    {
        $configuration->setCACertificates('/some/path/to/capath', 'capath');
        $this->assertCount(8, $configuration->toArray());
    }

    /**
     * @depends testInstantiationWithParams
     * @param \OtherCode\Rest\Core\Configuration $configuration
     */
    public function testSetCACertificatesCainfo(\OtherCode\Rest\Core\Configuration $configuration)
    {
        $configuration->setCACertificates('/some/path/to/cainfo', 'cainfo');
        $this->assertCount(9, $configuration->toArray());
    }

    /**
     * @depends testInstantiationWithParams
     * @param \OtherCode\Rest\Core\Configuration $configuration
     * @expectedException \OtherCode\Rest\Exceptions\RestException
     */
    public function testWrongSetCACertificates(\OtherCode\Rest\Core\Configuration $configuration)
    {
        $configuration->setCACertificates('/some/path/to/wrong', 'wrong');
        $this->assertCount(8, $configuration->toArray());
    }
}