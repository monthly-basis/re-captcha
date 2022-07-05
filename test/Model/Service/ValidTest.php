<?php
namespace MonthlyBasis\ReCaptchaTest\Model\Service;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use PHPUnit\Framework\TestCase;

class ValidTest extends TestCase
{
    protected function setUp(): void
    {
        $this->ipV4ServiceMock = $this->createMock(
            ReCaptchaService\Allowlists\IpV4::class
        );

        $this->validService = new ReCaptchaService\Valid(
            $this->ipV4ServiceMock,
            'secret'
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test_isValid_ipV4IsInAllowlist_true()
    {
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';

        $this->ipV4ServiceMock
            ->expects($this->once())
            ->method('isIpV4InAllowlists')
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

        $_POST['g-recaptcha-response'] = 'test';
        $_SERVER['REMOTE_ADDR'] = '123.123.123.123';
        $this->assertFalse(
            $this->validService->isValid()
        );
    }
}
