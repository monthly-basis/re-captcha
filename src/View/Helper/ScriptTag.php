<?php
namespace MonthlyBasis\ReCaptcha\View\Helper;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use Laminas\View\Helper\AbstractHelper;

class ScriptTag extends AbstractHelper
{
    public function __construct(
        ReCaptchaService\Allowlists\IpAddress $ipAddressService
    ) {
        $this->ipAddressService = $ipAddressService;
    }

    public function __invoke()
    {
        if ($this->ipAddressService->isIpAddressInAllowlists($_SERVER['REMOTE_ADDR'])) {
            return '<!-- The script tag was omitted because your IP address is in the allowlists. -->';
        }

        return '<script src="https://www.google.com/recaptcha/api.js"></script>';
    }
}
