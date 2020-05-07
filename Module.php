<?php

namespace panix\mod\novaposhta;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'novaposhta';

    public function bootstrap($app)
    {
        $app->urlManager->addRules(
            [
                'page/<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>/per-page/<per-page:\d+>' => 'pages/default/view',
                'page/<slug:[0-9a-zA-Z_\-]+>/page/<page:\d+>' => 'pages/default/view',
                'page/<slug:[0-9a-zA-Z_\-]+>' => 'pages/default/view',

            ],
            true
        );


        $app->setComponents([
            'novaposhta' => ['class' => 'panix\mod\novaposhta\components\Novaposhta'],
        ]);
    }

    public function getAdminMenu()
    {
        return [
            'modules' => [
                'items' => [
                    [
                        'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
                        'url' => '#',
                        'icon' => $this->icon,
                        'items' => [
                            [
                                'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
                                'url' => ['/admin/novaposhta'],
                                'icon' => $this->icon,
                            ],
                            [
                                'label' => Yii::t('novaposhta/default', 'Экспресс-накладная'),
                                'url' => ['/admin/novaposhta/express-invoice'],
                                'icon' => $this->icon,
                            ],
                            [
                                'label' => Yii::t('novaposhta/default', 'counterparties'),
                                'url' => ['/admin/novaposhta/counterparties'],
                                'icon' => $this->icon,
                            ],
                            [
                                'label' => Yii::t('app/default', 'SETTINGS'),
                                'url' => ['/admin/novaposhta/settings'],
                                'icon' => 'settings',
                            ]
                        ]
                    ],

                ],
            ],
        ];
    }


    public function getInfo()
    {
        return [
            'label' => Yii::t('novaposhta/default', 'MODULE_NAME'),
            'author' => 'dev@pixelion.com.ua',
            'version' => '1.0',
            'icon' => $this->icon,
            'description' => Yii::t('novaposhta/default', 'MODULE_DESC'),
            'url' => ['/admin/novaposhta'],
        ];
    }

}
