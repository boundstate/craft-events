<?php

namespace boundstate\eventful\records;

use boundstate\eventful\db\Table;
use craft\base\Element;
use craft\db\ActiveRecord;
use yii\db\ActiveQueryInterface;

/**
 * @property int $id
 * @property int $iCalendarSequence
 */
class Metadata extends ActiveRecord
{
    public static function tableName(): string
    {
        return Table::METADATA;
    }

    public function getElement(): ActiveQueryInterface
    {
        return $this->hasOne(Element::class, ['id' => 'id']);
    }
}
