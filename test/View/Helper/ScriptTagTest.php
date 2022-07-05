<?php
namespace MonthlyBasis\ReCaptchaTest\View\Helper;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use MonthlyBasis\ReCaptcha\View\Helper as ReCaptchaHelper;
use PHPUnit\Framework\TestCase;

class ScriptTagTest extends TestCase
{
    protected function setUp(): void
    {
        $this->ipV4ServiceMock = $this->createMock(
            ReCaptchaService\Allowlists\IpV4::class
        );

        $this->scriptTagHelper = new ReCaptchaHelper\ScriptTag(
            $this->ipV4ServiceMock,
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

        $this->assertSame(
            '<!-- The script tag was omitted because your IPv4 is in the allowlist. -->',
            $this->scriptTagHelper->__invoke()
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test___invoke_ipV4NotInAllowlist_scriptTag()
    {
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';

        $this->ipV4ServiceMock
            ->expects($this->once())
            ->method('isIpV4InAllowlists')
            ->with('1.2.3.4')
            ->willReturn(false)
            ;

        $this->assertSame(
            '<script src="https://www.google.com/recaptcha/api.js"></script>',
            $this->scriptTagHelper->__invoke()
        );
    }
}
