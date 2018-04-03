<?php
namespace LeoGalleguillos\ReCaptcha;

use LeoGalleguillos\ReCaptcha\View\Helper as ReCaptchaHelper;

class Module
{
    public function getConfig()
    {
        return [
            'view_helpers' => [
                'aliases' => [
                ],
                'factories' => [
                ],
            ],
        ];
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
            ],
        ];
    }
}
