<?php
namespace MonthlyBasis\ReCaptchaTest\Model\Entity;

use MonthlyBasis\ReCaptcha\Model\Entity as ReCaptchaEntity;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function test___construct()
    {
        $array = ['key-123' => 'value 456'];
        $configEntity = new ReCaptchaEntity\Config($array);

        $this->assertFalse(
            isset($configEntity['key that does not exist'])
        );
        $this->assertSame(
            'hello world',
            $configEntity['another key that does not exist'] ?? 'hello world',
        );
        $this->assertSame(
            'value 456',
            $configEntity['key-123'],
        );
    }
}
