<?php
namespace MonthlyBasis\ReCaptchaTest\Model\Service\Allowlists;

use MonthlyBasis\IpAddress\Model\Service as IpAddressService;
use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use PHPUnit\Framework\TestCase;

class IpAddressTest extends TestCase
{
    protected function setUp(): void
    {
        $this->versionServiceMock = $this->createMock(
            IpAddressService\Version::class
        );
        $this->ipV4ServiceMock = $this->createMock(
            ReCaptchaService\Allowlists\IpV4::class
        );
        $this->ipV6ServiceMock = $this->createMock(
            ReCaptchaService\Allowlists\IpV6::class
        );

        $this->ipAddressService = new ReCaptchaService\Allowlists\IpAddress(
            $this->versionServiceMock,
            $this->ipV4ServiceMock,
            $this->ipV6ServiceMock,
        );
    }

    public function test_isIpAddressInAllowlists_ipAddressIsVersion4_true()
    {
        $this->versionServiceMock
            ->expects($this->once())
            ->method('getVersion')
            ->with('1.2.3.4')
            ->willReturn(4)
            ;
        $this->ipV4ServiceMock
            ->expects($this->once())
            ->method('isIpV4InAllowlists')
            ->with('1.2.3.4')
            ->willReturn(true)
            ;
        $this->ipV6ServiceMock
            ->expects($this->exactly(0))
            ->method('isIpV6InAllowlists')
            ;

        $this->assertTrue(
            $this->ipAddressService->isIpAddressInAllowlists(
                '1.2.3.4'
            )
        );
    }

    public function test_isIpAddressInAllowlists_ipAddressIsVersion6_true()
    {
        $this->versionServiceMock
            ->expects($this->once())
            ->method('getVersion')
            ->with('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
            ->willReturn(6)
            ;
        $this->ipV4ServiceMock
            ->expects($this->exactly(0))
            ->method('isIpV4InAllowlists')
            ;
        $this->ipV6ServiceMock
            ->expects($this->once())
            ->method('isIpV6InAllowlists')
            ->with('2001:0db8:85a3:0000:0000:8a2e:0370:7334')
            ->willReturn(true)
            ;

        $this->assertTrue(
            $this->ipAddressService->isIpAddressInAllowlists(
                '2001:0db8:85a3:0000:0000:8a2e:0370:7334'
            )
        );
    }
}
