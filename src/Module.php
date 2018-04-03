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
                    'getReCaptchaScriptTag' => ReCaptchaHelper\ScriptTag::class,
                ],
                'factories' => [
                    ReCaptchaHelper\ScriptTag::class => function ($serviceManager) {
                        return new ReCaptchaHelper\ScriptTag();
                    },
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
