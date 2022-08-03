<?php
namespace MonthlyBasis\ReCaptchaTest\Model\Service;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use PHPUnit\Framework\TestCase;

class ValidTest extends TestCase
{
    protected function setUp(): void
    {
        $this->ipAddressServiceMock = $this->createMock(
            ReCaptchaService\Allowlists\IpAddress::class
        );

        $this->validService = new ReCaptchaService\Valid(
            $this->ipAddressServiceMock,
            'secret'
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test_isValid_ipAddressIsInAllowlist_true()
    {
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';

        $this->ipAddressServiceMock
            ->expects($this->once())
            ->method('isIpAddressInAllowlists')
            ->with('1.2.3.4')
            ->willReturn(true)
            ;

        $this->assertTrue(
            $this->validService->isValid()
        );
    }

    public function test_isValid_invalidPostData_false()
    {
        $this->markTestSkipped('Skip test unless you want to curl data from Google');

        $this->ipAddressServiceMock
            ->expects($this->once())
            ->method('isIpAddressInAllowlists')
            ->with('1.2.3.4')
            ->willReturn(false)
            ;

        $_POST['g-recaptcha-response'] = 'test';
        $_SERVER['REMOTE_ADDR'] = '123.123.123.123';
        $this->assertFalse(
            $this->validService->isValid()
        );
    }
}
