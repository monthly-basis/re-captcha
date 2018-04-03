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
                    ReCaptchaHelper\DivTag::class => function ($serviceManager) {
                        $viewHelperManager = $serviceManager->get('ViewHelperManager');
                        return new ReCaptchaHelper\DivTag(
                            $serviceManager->get('Config')['re-captcha']['site-key'],
                            $viewHelperManager->get(StringHelper\Escape::class)
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
                ReCaptchaService\Valid::class => function ($serviceManager) {
                    return new ReCaptchaService\Valid(
                        $serviceManager->get('Config')['re-captcha']['secret-key']
                    );
                },
            ],
        ];
    }
}
