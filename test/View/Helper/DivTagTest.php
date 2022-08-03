<?php
namespace MonthlyBasis\ReCaptchaTest\View\Helper;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use MonthlyBasis\ReCaptcha\View\Helper as ReCaptchaHelper;
use MonthlyBasis\String\Model\Service as StringService;
use PHPUnit\Framework\TestCase;

class DivTagTest extends TestCase
{
    protected function setUp(): void
    {
        $this->ipAddressServiceMock = $this->createMock(
            ReCaptchaService\Allowlists\IpAddress::class
        );
        $this->escapeServiceMock = $this->createMock(
            StringService\Escape::class
        );

        $this->divTagHelper = new ReCaptchaHelper\DivTag(
            $this->ipAddressServiceMock,
            'the-site-key',
            $this->escapeServiceMock,
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test___invoke_ipAddressIsInAllowlist_htmlComment()
    {
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';

        $this->ipAddressServiceMock
            ->expects($this->once())
            ->method('isIpAddressInAllowlists')
            ->with('1.2.3.4')
            ->willReturn(true)
            ;
        $this->escapeServiceMock
            ->expects($this->exactly(0))
            ->method('escape')
            ;

        $this->assertSame(
            '<!-- The div tag was omitted because your IP address is in the allowlists. -->',
            $this->divTagHelper->__invoke()
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test___invoke_ipV4NotInAllowlist_divTag()
    {
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';

        $this->ipAddressServiceMock
            ->expects($this->once())
            ->method('isIpAddressInAllowlists')
            ->with('1.2.3.4')
            ->willReturn(false)
            ;
        $this->escapeServiceMock
            ->expects($this->once())
            ->method('escape')
            ->with('the-site-key')
            ->willReturn('the-site-key-escaped')
            ;

        $this->assertSame(
            '<div class="g-recaptcha" data-sitekey="the-site-key-escaped"></div>',
            $this->divTagHelper->__invoke()
        );
    }
}
