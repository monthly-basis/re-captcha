<?php
namespace LeoGalleguillos\ReCaptcha;

use LeoGalleguillos\ReCaptcha\Model\Service as ReCaptchaService;
use LeoGalleguillos\ReCaptcha\View\Helper as ReCaptchaHelper;
use LeoGalleguillos\String\View\Helper as StringHelper;

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
                    ReCaptchaHelper\DivTag::class => function ($sm) {
                        $viewHelperManager = $sm->get('ViewHelperManager');
                        return new ReCaptchaHelper\DivTag(
                            $sm->get('Config')['re-captcha']['site-key'],
                            $viewHelperManager->get(StringHelper\Escape::class)
                        );
                    },
                    ReCaptchaHelper\ScriptTag::class => function ($sm) {
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
                ReCaptchaService\Valid::class => function ($sm) {
                    return new ReCaptchaService\Valid(
                        $sm->get('Config')['re-captcha']['secret-key']
                    );
                },
            ],
        ];
    }
}
