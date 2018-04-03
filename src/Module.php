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
                    'getReCaptchaDivTag'    => ReCaptchaHelper\DivTag::class,
                    'getReCaptchaScriptTag' => ReCaptchaHelper\ScriptTag::class,
                ],
                'factories' => [
                    ReCaptchaHelper\DivTag::class => function ($serviceManager) {
                        $config = $serviceManager->get('Config')['re-captcha'];
                        return new ReCaptchaHelper\DivTag(
                            $config['site-key']
                        );
                    },
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
