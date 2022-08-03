<?php
namespace MonthlyBasis\ReCaptcha\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use MonthlyBasis\String\Model\Service as StringService;

class DivTag extends AbstractHelper
{
    public function __construct(
        ReCaptchaService\Allowlists\IpAddress $ipAddressService,
        string $siteKey,
        StringService\Escape $escapeService
    ) {
        $this->ipAddressService = $ipAddressService;
        $this->siteKey          = $siteKey;
        $this->escapeService    = $escapeService;
    }

    public function __invoke()
    {
        if ($this->ipAddressService->isIpAddressInAllowlists($_SERVER['REMOTE_ADDR'])) {
            return '<!-- The div tag was omitted because your IP address is in the allowlists. -->';
        }

        return '<div class="g-recaptcha" data-sitekey="'
             . $this->escapeService->escape($this->siteKey)
             . '"></div>';
    }
}
