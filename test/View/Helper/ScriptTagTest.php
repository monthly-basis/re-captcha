<?php
namespace MonthlyBasis\ReCaptchaTest\View\Helper;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use MonthlyBasis\ReCaptcha\View\Helper as ReCaptchaHelper;
use PHPUnit\Framework\TestCase;

class ScriptTagTest extends TestCase
{
    protected function setUp(): void
    {
        $this->ipAddressServiceMock = $this->createMock(
            ReCaptchaService\Allowlists\IpAddress::class
        );

        $this->scriptTagHelper = new ReCaptchaHelper\ScriptTag(
            $this->ipAddressServiceMock,
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

        $this->assertSame(
            '<!-- The script tag was omitted because your IP address is in the allowlists. -->',
            $this->scriptTagHelper->__invoke()
        );
    }

    /**
     * @runInSeparateProcess
     */
    public function test___invoke_ipV4NotInAllowlist_scriptTag()
    {
        $_SERVER['REMOTE_ADDR'] = '1.2.3.4';

        $this->ipAddressServiceMock
            ->expects($this->once())
            ->method('isIpAddressInAllowlists')
            ->with('1.2.3.4')
            ->willReturn(false)
            ;

        $this->assertSame(
            '<script src="https://www.google.com/recaptcha/api.js"></script>',
            $this->scriptTagHelper->__invoke()
        );
    }
}
