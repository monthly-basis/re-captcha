<?php
namespace LeoGalleguillos\ReCaptchaTest\Model\Service;

use LeoGalleguillos\ReCaptcha\Model\Service as ReCaptchaService;
use PHPUnit\Framework\TestCase;

class ValidTest extends TestCase
{
    protected function setUp()
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
}
