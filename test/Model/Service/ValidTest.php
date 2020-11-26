<?php
namespace MonthlyBasis\ReCaptchaTest\Model\Service;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use PHPUnit\Framework\TestCase;

class ValidTest extends TestCase
{
    protected function setUp(): void
    {
        $this->validService = new ReCaptchaService\Valid('secret');
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            ReCaptchaService\Valid::class,
            $this->validService
        );
    }

    public function testIsValid()
    {
        $_POST['g-recaptcha-response'] = 'test';
        $_SERVER['REMOTE_ADDR'] = '123.123.123.123';
        $this->assertFalse(
            $this->validService->isValid()
        );
    }
}
