<?php
namespace MonthlyBasis\ReCaptchaTest\Model\Service\Allowlists;

use MonthlyBasis\IpAddress\Model\Service as IpAddressService;
use MonthlyBasis\ReCaptcha\Model\Entity as ReCaptchaEntity;
use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use PHPUnit\Framework\TestCase;

class IpV6Test extends TestCase
{
    protected function setUp(): void
    {
        $this->firstFourSegmentsServiceMock = $this->createMock(
            IpAddressService\V6\FirstFourSegments::class
        );
        $configArray = require($_SERVER['PWD'] . '/config/autoload/local.php');
        $this->configEntity = new ReCaptchaEntity\Config(
            $configArray['monthly-basis']['re-captcha']
        );

        $this->ipV6Service = new ReCaptchaService\Allowlists\IpV6(
            $this->firstFourSegmentsServiceMock,
            $this->configEntity,
        );
    }

    public function test_isIpV6InAllowlists_localConfig_true()
    {
        $this->firstFourSegmentsServiceMock
             ->expects($this->once())
             ->method('getFirstFourSegments')
             ->with('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
             ->willReturn('2001:0db8:85a3:0000')
         ;
        $this->assertTrue(
            $this->ipV6Service->isIpV6InAllowlists(
                '2001:0db8:85a3:0000:0000:8a2e:0370:7334'
            )
        );
    }

    public function test_isIpV6InAllowlists_emptyConfig_false()
    {
        $this->configEntity['service'] = [];

        $this->firstFourSegmentsServiceMock
             ->expects($this->exactly(0))
             ->method('getFirstFourSegments')
         ;

        $this->assertFalse(
            $this->ipV6Service->isIpV6InAllowlists(
                '2001:0db8:85a3:0000:0000:8a2e:0370:7334'
            )
        );
    }

    public function test_isIpV6InAllowlists_firstFourSegmentsAreNotSet_false()
    {
        $this->configEntity['service']['allowlists']['ip-v6'] = [
            'addresses' => [
                '2001:db8:85a3:8d3:1319:8a2e:370:7348',
            ],
        ];

        $this->firstFourSegmentsServiceMock
             ->expects($this->exactly(0))
             ->method('getFirstFourSegments')
         ;

        $this->assertFalse(
            $this->ipV6Service->isIpV6InAllowlists('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
        );
    }

    public function test_isIpV6InAllowlists_firstFourSegmentsDoNotMatch_false()
    {
        $this->firstFourSegmentsServiceMock
             ->expects($this->once())
             ->method('getFirstFourSegments')
             ->with('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
             ->willReturn('2001:0db8:85a3:0000')
         ;
        $this->configEntity['service']['allowlists']['ip-v6'] = [
            'addresses' => [],
            'first-four-segments' => [
                '2001:0db8:85a3:0001',
                '2001:0db8:85a3:0002',
                '2001:0db8:85a3:0003',
            ],
        ];

        $this->assertFalse(
            $this->ipV6Service->isIpV6InAllowlists('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
        );
    }

    public function test_isIpV6InAllowlists_firstFourSegmentsMatch_true()
    {
        $this->firstFourSegmentsServiceMock
             ->expects($this->once())
             ->method('getFirstFourSegments')
             ->with('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
             ->willReturn('2001:0db8:85a3:0000')
         ;
        $this->configEntity['service']['allowlists']['ip-v6'] = [
            'addresses' => [],
            'first-four-segments' => [
                '2001:0db8:85a3:0000',
                '2001:0db8:85a3:0001',
                '2001:0db8:85a3:0002',
            ],
        ];

        $this->assertTrue(
            $this->ipV6Service->isIpV6InAllowlists('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
        );
    }
}
