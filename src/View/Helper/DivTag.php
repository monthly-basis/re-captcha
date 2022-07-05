<?php
namespace MonthlyBasis\ReCaptcha\View\Helper;

use Laminas\View\Helper\AbstractHelper;
use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use MonthlyBasis\String\Model\Service as StringService;

class DivTag extends AbstractHelper
{
    public function __construct(
        ReCaptchaService\Allowlists\IpV4 $ipV4Service,
        string $siteKey,
        StringService\Escape $escapeService
    ) {
        $this->ipV4Service   = $ipV4Service;
        $this->siteKey       = $siteKey;
        $this->escapeService = $escapeService;
    }

    public function __invoke()
    {
        if ($this->ipV4Service->isIpV4InAllowlists($_SERVER['REMOTE_ADDR'])) {
            return '<!-- The div tag was omitted because your IPv4 is in the allowlist. -->';
        }

        return '<div class="g-recaptcha" data-sitekey="'
             . $this->escapeService->escape($this->siteKey)
             . '"></div>';
    }
}
