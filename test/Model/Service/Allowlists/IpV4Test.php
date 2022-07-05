<?php
namespace MonthlyBasis\ReCaptchaTest\Model\Service\Allowlists;

use MonthlyBasis\ReCaptcha\Model\Entity as ReCaptchaEntity;
use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use PHPUnit\Framework\TestCase;

class IpV4Test extends TestCase
{
    protected function setUp(): void
    {
        $configArray = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $this->configEntity = new ReCaptchaEntity\Config(
            $configArray['monthly-basis']['re-captcha']
        );

        $this->ipV4Service = new ReCaptchaService\Allowlists\IpV4(
            $this->configEntity
        );
    }

    public function test_isIpV4InAllowlists_localConfig_true()
    {
        $this->assertTrue(
            $this->ipV4Service->isIpV4InAllowlists('1.2.3.4')
        );
    }

    public function test_isIpV4InAllowlists_emptyConfig_false()
    {
        $this->configEntity['service'] = [];

        $this->assertFalse(
            $this->ipV4Service->isIpV4InAllowlists('1.2.3.4')
        );
    }

    public function test_isIpV4InAllowlists_customConfig_expectedValues()
    {
        $this->configEntity['service']['allowlists']['ip-v4'] = [
            '5.6.7.8',
        ];

        $this->assertFalse(
            $this->ipV4Service->isIpV4InAllowlists('1.2.3.4')
        );
        $this->assertTrue(
            $this->ipV4Service->isIpV4InAllowlists('5.6.7.8')
        );
    }
}
