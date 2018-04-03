<?php
namespace LeoGalleguillos\ReCaptchaTest\View\Helper;

use LeoGalleguillos\ReCaptcha\View\Helper as ReCaptchaHelper;
use PHPUnit\Framework\TestCase;

class ScriptTagTest extends TestCase
{
    protected function setUp()
    {
        $this->scriptTagHelper = new ReCaptchaHelper\ScriptTag();
    }

    public function testInitialize()
    {
        $this->assertInstanceOf(
            ReCaptchaHelper\ScriptTag::class,
            $this->scriptTagHelper
        );
    }
}
