<?php

namespace panix\mod\novaposhta;

use Yii;
use panix\engine\WebModule;
use yii\base\BootstrapInterface;

class Module extends WebModule implements BootstrapInterface
{

    public $icon = 'novaposhta';

    public function init()
    {
        parent::init();
        $this->params = [
            'typesPayersForRedelivery' => [
                'Sender' => 'Відправник',
                'Recipient' => 'Одержувач'
            ],
            'typesCounterparties' => [
                'Organization' => 'Организация',
                'PrivatePerson' => 'Частное лицо'
            ],
            'typesPayers' => [
                'Sender' => 'Відправник',
                'Recipient' => 'Одержувач',
                'ThirdPerson' => 'Третя особа'
            ]
        ];
    }

    public function bootstrap($app)
    {

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
                        'visible' => Yii::$app->user->can('/novaposhta/admin/default/index') || Yii::$app->user->can('/novaposhta/admin/default/*'),
                        'items' => [
                            [
                                'label' => Yii::t('novaposhta/default', 'EXPRESS_WAYBILL'),
                                'url' => ['/admin/novaposhta/express-invoice'],
                                'icon' => 'books',
                                'visible' => Yii::$app->user->can('/novaposhta/admin/express-invoice/index') || Yii::$app->user->can('/novaposhta/admin/express-invoice/*'),
                            ],
                            [
                                'label' => Yii::t('novaposhta/default', 'COUNTERPARTIES'),
                                'url' => ['/admin/novaposhta/counterparties'],
                                'icon' => 'user-card',
                                'visible' => Yii::$app->user->can('/novaposhta/admin/counterparties/index') || Yii::$app->user->can('/novaposhta/admin/counterparties/*'),
                            ],
                            [
                                'label' => Yii::t('novaposhta/default', 'SERVICES_TYPES'),
                                'url' => ['/admin/novaposhta/service-types'],
                                'icon' => $this->icon,
                                'visible' => Yii::$app->user->can('/novaposhta/admin/service-types/index') || Yii::$app->user->can('/novaposhta/admin/service-types/*'),
                            ],
                            [
                                'label' => Yii::t('novaposhta/default', 'CITIES'),
                                'url' => ['/admin/novaposhta/cities'],
                                'icon' => 'location-map',
                                'visible' => Yii::$app->user->can('/novaposhta/admin/cities/index') || Yii::$app->user->can('/novaposhta/admin/cities/*'),
                            ],
                            [
                                'label' => Yii::t('novaposhta/default', 'AREAS'),
                                'url' => ['/admin/novaposhta/area'],
                                'icon' => 'location-map',
                                'visible' => Yii::$app->user->can('/novaposhta/admin/area/index') || Yii::$app->user->can('/novaposhta/admin/area/*'),
                            ],
                            [
                                'label' => Yii::t('novaposhta/default', 'WAREHOUSES'),
                                'url' => ['/admin/novaposhta/warehouses'],
                                'icon' => 'location',
                                'visible' => Yii::$app->user->can('/novaposhta/admin/warehouses/index') || Yii::$app->user->can('/novaposhta/admin/warehouses/*'),
                            ],
                            [
                                'label' => Yii::t('app/default', 'SETTINGS'),
                                'url' => ['/admin/novaposhta/default/settings'],
                                'icon' => 'settings',
                                'visible' => Yii::$app->user->can('/novaposhta/admin/default/settings') || Yii::$app->user->can('/novaposhta/admin/default/*'),
                            ]
                        ]
                    ],

                ],
            ],
        ];
    }
    public function getAdminSidebar()
    {
        $menu = $this->getAdminMenu();
        return \yii\helpers\ArrayHelper::merge($menu['modules']['items'], $menu['modules']['items'][0]['items']);
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


    public function getTrackingStatus()
    {
        return [
            1 => 'Нова пошта очікує надходження від відправника',
            2 => 'Видалено',
            3 => 'Номер не знайдено',
            4 => 'Відправлення у місті ХХXХ. (Статус для межобластных отправлений)',
            41 => 'Відправлення у місті ХХXХ. (Статус для услуг локал стандарт и локал экспресс - доставка в пределах города)',
            5 => 'Відправлення прямує до міста YYYY.',
            6 => 'Відправлення у місті YYYY, орієнтовна доставка до ВІДДІЛЕННЯ-XXX dd-mm. Очікуйте додаткове повідомлення про прибуття.',
            7 => 'Прибув на відділення',
            8 => 'Прибув на відділення',
            9 => 'Відправлення отримано',
            10 => 'Відправлення отримано %DateReceived%. Протягом доби ви одержите SMS-повідомлення про надходження грошового переказу та зможете отримати його в касі відділення «Нова пошта».',
            11 => 'Відправлення отримано %DateReceived%. Грошовий переказ видано одержувачу.',
            14 => 'Відправлення передано до огляду отримувачу',
            101 => 'На шляху до одержувача',
            102 => 'Відмова одержувача',
            103 => 'Відмова одержувача',
            108 => 'Відмова одержувача',
            104 => 'Змінено адресу',
            105 => 'Припинено зберігання',
            106 => 'Одержано і створено ЄН зворотньої доставки',
        ];
    }
}
