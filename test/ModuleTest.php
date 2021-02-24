<?php
namespace MonthlyBasis\ReCaptchaTest;

use MonthlyBasis\LaminasTest\ModuleTestCase;
use MonthlyBasis\ReCaptcha\Module;

class ModuleTest extends ModuleTestCase
{
    protected function setUp(): void
    {
        $this->module = new Module();

        $_SERVER['HTTP_HOST'] = 'example.com';
    }
}
