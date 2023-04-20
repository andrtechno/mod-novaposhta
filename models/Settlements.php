<?php

namespace panix\mod\novaposhta\models;

use Yii;
/**
 * This is the model class for table "novaposhta_cargo_types".
 *
 * @property string $Ref Guid
 * @property string $Description
 */
class Settlements extends CommonActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%novaposhta__settlements}}';
    }

    public static function loadAll()
    {
        self::getDb()->createCommand()->truncateTable(self::tableName())->execute();
        $result = Yii::$app->novaposhta
            ->model('AddressGeneral')
            ->method('getSettlements')
            ->execute();

        $fields = ['Ref', 'Description', 'DescriptionRu', 'DescriptionTranslit', 'Latitude', 'Longitude', 'SettlementType', 'SettlementTypeDescription', 'SettlementTypeDescriptionRu', 'SettlementTypeDescriptionTranslit',
            'Region', 'RegionsDescription', 'RegionsDescriptionRu', 'RegionsDescriptionTranslit', 'Area',
            'AreaDescription', 'AreaDescriptionRu', 'AreaDescriptionTranslit', 'IndexCOATSU1',
            'Index1', 'Index2', 'Delivery1', 'Delivery2', 'Delivery3', 'Delivery4', 'Delivery5', 'Delivery6', 'Delivery7',
            'Warehouse'];


        if ($result['success']) {
            $data = [];
            foreach ($result['data'] as $settlement) {
                $data[] = [
                    $settlement['Ref'],
                    $settlement['Description'],
                    $settlement['DescriptionRu'],
                    $settlement['DescriptionTranslit'],
                    $settlement['Latitude'],
                    $settlement['Longitude'],
                    $settlement['SettlementType'],
                    $settlement['SettlementTypeDescription'],
                    $settlement['SettlementTypeDescriptionRu'],
                    $settlement['SettlementTypeDescriptionTranslit'],
                    $settlement['Region'],
                    $settlement['RegionsDescription'],
                    $settlement['RegionsDescriptionRu'],
                    $settlement['RegionsDescriptionTranslit'],
                    $settlement['Area'],
                    $settlement['AreaDescription'],
                    $settlement['AreaDescriptionRu'],
                    $settlement['AreaDescriptionTranslit'],
                    $settlement['IndexCOATSU1'],
                    $settlement['Index1'],
                    $settlement['Index2'],
                    $settlement['Delivery1'],
                    $settlement['Delivery2'],
                    $settlement['Delivery3'],
                    $settlement['Delivery4'],
                    $settlement['Delivery5'],
                    $settlement['Delivery6'],
                    $settlement['Delivery7'],
                    $settlement['Warehouse'],
                ];

            }
            self::getDb()->createCommand()->batchInsert(self::tableName(), $fields, $data)->execute();
        }
    }
}
