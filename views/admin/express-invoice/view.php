<?php

use panix\engine\CMS;

/* @var $this yii\web\View */
/* @var $model app\modules\pages\models\Pages */
$senderInfo = $api->getCounterparties('Sender', 1, '', '');


// Выбор отправителя в конкретном городе (в данном случае - в первом попавшемся)
$sender = $senderInfo['data'][0];
// Информация о складе отправителя

$city = $api->getCity('Киев', 'Киевская');
//CMS::dump($city['data'][0]['Ref']);die;

$senderWarehouses = $api->getWarehouses($city['data'][0]['Ref']);

// Генерирование новой накладной
$result = $api->newInternetDocument(
// Данные отправителя
    [
        // Данные пользователя
        'FirstName' => $sender['FirstName'],
        'MiddleName' => $sender['MiddleName'],
        'LastName' => $sender['LastName'],
        // Вместо FirstName, MiddleName, LastName можно ввести зарегистрированные ФИО отправителя или название фирмы для юрлиц
        // (можно получить, вызвав метод getCounterparties('Sender', 1, '', ''))
        // 'Description' => $sender['Description'],
        // Необязательное поле, в случае отсутствия будет использоваться из данных контакта
         'Phone' => '0682937379',
        // Город отправления
        // 'City' => 'Белгород-Днестровский',
        // Область отправления
        // 'Region' => 'Одесская',
        'CitySender' => $city['data'][0]['Ref'],
        // Отделение отправления по ID (в данном случае - в первом попавшемся)
        'SenderAddress' => $senderWarehouses['data'][0]['Ref'],
        // Отделение отправления по адресу
        // 'Warehouse' => $senderWarehouses['data'][0]['DescriptionRu'],
    ],
    // Данные получателя
    [
        'FirstName' => 'Андрей',
        'MiddleName' => 'Анатольевич',
        'LastName' => 'Семенов',
        'Phone' => '380682937379',
        'City' => 'Киев',
        'Region' => 'Киевская',
        'Email'=>'andrew.panix@gmail.com',
        'Warehouse' => 'Отделение №3: ул. Калачевская, 13 (Старая Дарница)',
    ],
    [
        // Дата отправления
        'DateTime' => date('d.m.Y'),
        // Тип доставки, дополнительно - getServiceTypes()
        'ServiceType' => 'WarehouseWarehouse',
        // Тип оплаты, дополнительно - getPaymentForms()
        'PaymentMethod' => 'Cash',
        // Кто оплачивает за доставку
        'PayerType' => 'Recipient',
        // Стоимость груза в грн
        'Cost' => '500',
        // Кол-во мест
        'SeatsAmount' => '1',
        // Описание груза
        'Description' => 'Кастрюля',
        // Тип доставки, дополнительно - getCargoTypes
        'CargoType' => 'Cargo',
        // Вес груза
        'Weight' => '10',
        // Объем груза в куб.м.
        'VolumeGeneral' => '0.5',
        // Обратная доставка
        'BackwardDeliveryData' => [
            [
                // Кто оплачивает обратную доставку
                'PayerType' => 'Recipient',
                // Тип доставки
                'CargoType' => 'Money',
                // Значение обратной доставки
                'RedeliveryString' => 4552,
            ]
        ]
    ]
);

CMS::dump($result);