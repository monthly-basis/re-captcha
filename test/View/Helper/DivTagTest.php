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
        $this->ipV4ServiceMock = $this->createMock(
            ReCaptchaService\Allowlists\IpV4::class
        );
        $this->escapeServiceMock = $this->createMock(
            StringService\Escape::class
        );

        $this->divTagHelper = new ReCaptchaHelper\DivTag(
            $this->ipV4ServiceMock,
            'the-site-key',
            $this->escapeServiceMock,
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test___invoke_ipV4InAllowlist_htmlComment()
    {
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';

        $this->ipV4ServiceMock
            ->expects($this->once())
            ->method('isIpV4InAllowlists')
            ->with('1.2.3.4')
            ->willReturn(true)
            ;
        $this->escapeServiceMock
            ->expects($this->exactly(0))
            ->method('escape')
            ;

        $this->assertSame(
            '<!-- The div tag was omitted because your IPv4 is in the allowlist. -->',
            $this->divTagHelper->__invoke()
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test___invoke_ipV4NotInAllowlist_divTag()
    {
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';

        $this->ipV4ServiceMock
            ->expects($this->once())
            ->method('isIpV4InAllowlists')
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
