<?php
namespace MonthlyBasis\ReCaptcha;

use MonthlyBasis\ReCaptcha\Model\Service as ReCaptchaService;
use MonthlyBasis\ReCaptcha\View\Helper as ReCaptchaHelper;
use MonthlyBasis\String\Model\Service as StringService;

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
                        return new ReCaptchaHelper\DivTag(
                            $sm->get('Config')['re-captcha']['domains'][$_SERVER['HTTP_HOST']]['site-key'],
                            $sm->get(StringService\Escape::class)
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
                        $sm->get('Config')['re-captcha']['domains'][$_SERVER['HTTP_HOST']]['secret-key']
                    );
                },
            ],
        ];
    }
}
