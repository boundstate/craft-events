<?php

namespace boundstate\eventful\fields;

use boundstate\eventful\models\EventDate as EventDateModel;
use boundstate\eventful\web\assets\CpEventDateAsset;
use Craft;
use craft\base\ElementInterface;
use craft\base\Field;
use craft\base\PreviewableFieldInterface;
use craft\base\SortableFieldInterface;
use craft\elements\Entry;
use craft\helpers\Db;
use craft\i18n\Locale;
use DateTime;
use yii\db\ExpressionInterface;
use yii\db\Schema;

class EventDate extends Field implements PreviewableFieldInterface, SortableFieldInterface
{
    public static function displayName(): string
    {
        return 'Event Date';
    }

    public static function icon(): string
    {
        return 'calendar-days';
    }

    public static function dbType(): array
    {
        return [
            'start' => Schema::TYPE_DATETIME,
            'end' => Schema::TYPE_DATETIME,
            'timezone' => Schema::TYPE_STRING,
            'firstStart' => Schema::TYPE_DATETIME,
            'lastEnd' => Schema::TYPE_DATETIME,
            'rule' => Schema::TYPE_STRING,
        ];
    }

    public static function phpType(): string
    {
        return sprintf('\\%s|null', EventDateModel::class);
    }

    public bool $allowNeverEnding = false;

    public bool $allDay = false;

    public function getElementValidationRules(): array
    {
        return [
            [
                function (ElementInterface $element): void {
                    /** @var EventDateModel $value */
                    $value = $element->getFieldValue($this->handle);
                    if (! $value->validate()) {
                        foreach ($value->getErrorSummary(false) as $errors) {
                            $element->addError($this->handle, $errors);
                        }
                    }
                },
            ],
        ];
    }

    /**
     * @param  ?EventDateModel  $value
     */
    public function serializeValue(
        mixed $value,
        ?ElementInterface $element,
    ): mixed {
        if (! $value) {
            return null;
        }

        return [
            'start' => Db::prepareDateForDb($value->start),
            'end' => Db::prepareDateForDb($value->end),
            'timezone' => $this->allDay
                ? Craft::$app->timeZone
                : $value->timezone,
            'firstStart' => Db::prepareDateForDb($value->getFirstStartDate()),
            'lastEnd' => Db::prepareDateForDb($value->getLastEndDate()),
            'rule' => $value->getRule()?->getString(),
        ];
    }

    public static function queryCondition(
        array $instances,
        mixed $value,
        array &$params,
    ): array|string|ExpressionInterface|false|null {
        if (is_array($value)) {
            $conditions = [];

            if (isset($value['inRange'])) {
                $start = $value['inRange'][0];
                if ($start instanceof DateTime) {
                    $start = $start->format(DateTime::ATOM);
                }
                $end = $value['inRange'][1];
                if ($end instanceof DateTime) {
                    $end = $end->format(DateTime::ATOM);
                }

                $value = [
                    'firstStart' => "<= $end",
                    'lastEnd' => ['or', ">= $start", ':empty:'],
                ];
            }

            if (isset($value['lastEnd'])) {
                $valueSql = static::valueSql($instances, 'lastEnd');
                $conditions[] = Db::parseDateParam(
                    $valueSql,
                    $value['lastEnd'],
                );
            }

            if (isset($value['firstStart'])) {
                $valueSql = static::valueSql($instances, 'firstStart');
                $conditions[] = Db::parseDateParam(
                    $valueSql,
                    $value['firstStart'],
                );
            }

            if (! empty($conditions)) {
                return ['and', ...$conditions];
            }
        }

        return parent::queryCondition($instances, $value, $params);
    }

    public function normalizeValue(
        mixed $value,
        ?ElementInterface $element,
    ): mixed {
        if ($value instanceof EventDateModel) {
            // already normalized
            return $value;
        }

        if (! $value || ! is_array($value)) {
            return null;
        }

        $value['allDay'] = $this->allDay;

        // from database or POST data
        unset($value['firstStart']);
        unset($value['lastEnd']);

        return new EventDateModel([
            'allowNeverEnding' => $this->allowNeverEnding,
            ...$value,
        ]);
    }

    public function getSortOption(): array
    {
        return [
            'label' => Craft::t('site', $this->name),
            'orderBy' => $this->getValueSql('start'),
            'attribute' => isset($this->layoutElement->handle)
                ? "fieldInstance:{$this->layoutElement->uid}"
                : "field:$this->uid",
        ];
    }

    public function getPreviewHtml(
        mixed $value,
        ElementInterface $element,
    ): string {
        if (! $value) {
            return '';
        }

        $formatter = Craft::$app->getFormatter();

        return $this->allDay
            ? $formatter->asDate($value->start, Locale::LENGTH_MEDIUM)
            : $formatter->asDatetime($value->start, Locale::LENGTH_SHORT);
    }

    public function previewPlaceholderHtml(
        mixed $value,
        ?ElementInterface $element,
    ): string {
        return $this->getPreviewHtml(
            $value ??
                new EventDateModel([
                    'allDay' => $this->allDay,
                    'start' => new DateTime,
                ]),
            $element ?? new Entry,
        );
    }

    public function getInputHtml(
        mixed $value,
        ?ElementInterface $element = null,
    ): string {
        $freqOptions = [
            ['label' => 'day', 'value' => 'DAILY'],
            ['label' => 'week', 'value' => 'WEEKLY'],
            ['label' => 'month', 'value' => 'MONTHLY'],
            ['label' => 'year', 'value' => 'YEARLY'],
        ];

        $dayOptions = [
            ['label' => 'S', 'value' => 'SU'],
            ['label' => 'M', 'value' => 'MO'],
            ['label' => 'T', 'value' => 'TU'],
            ['label' => 'W', 'value' => 'WE'],
            ['label' => 'T', 'value' => 'TH'],
            ['label' => 'F', 'value' => 'FR'],
            ['label' => 'S', 'value' => 'SA'],
        ];

        $view = Craft::$app->view;
        $id = $this->getInputId();

        $locale = Craft::$app->getUser()->getIdentity()->getPreferredLocale();

        $view->registerAssetBundle(CpEventDateAsset::class);
        $view->registerJsWithVars(
            fn ($inputId, $inputName, $locale): string => <<<JS
            new Craft.Eventful.Input($inputId, $inputName, $locale);
            JS
            ,
            [
                $view->namespaceInputId($id),
                $view->namespaceInputName($this->handle),
                $locale,
            ],
        );

        return $view->renderTemplate('eventful/fields/EventDate/input', [
            'id' => $id,
            'name' => $this->handle,
            'value' => $value ?? new EventDateModel(['allDay' => $this->allDay]),
            'field' => $this,
            'freqOptions' => $freqOptions,
            'dayOptions' => $dayOptions,
        ]);
    }

    public function getSettingsHtml(): string
    {
        return Craft::$app
            ->getView()
            ->renderTemplate('eventful/fields/EventDate/settings', [
                'field' => $this,
            ]);
    }
}

// @phpstan-ignore-next-line
class_alias(EventDate::class, \events\fields\EventDate::class);
