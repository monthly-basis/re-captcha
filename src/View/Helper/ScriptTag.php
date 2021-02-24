<?php
namespace MonthlyBasis\ReCaptcha\View\Helper;

use Laminas\View\Helper\AbstractHelper;

class ScriptTag extends AbstractHelper
{
    public function __invoke()
    {
        return '<script src="https://www.google.com/recaptcha/api.js"></script>';
    }
}
