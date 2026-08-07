<?php

namespace boundstate\eventful\services;

use boundstate\eventful\base\EventSource;
use boundstate\eventful\db\Table;
use boundstate\eventful\enums\Color;
use boundstate\eventful\events\RegisterEventSourcesEvent;
use boundstate\eventful\events\RegisterEventSourceTypesEvent;
use boundstate\eventful\fields\EventDate as EventDateField;
use boundstate\eventful\models\EntryEventSource;
use boundstate\eventful\models\ProductEventSource;
use Craft;
use craft\base\ElementInterface;
use craft\base\FieldLayoutProviderInterface;
use craft\elements\db\ElementQuery;
use craft\elements\User;
use craft\helpers\ArrayHelper;
use craft\helpers\Db;
use yii\base\Component;
use yii\db\Expression;

class Events extends Component
{
    /**
     * @see RegisterEventSourceTypesEvent
     */
    const EVENT_REGISTER_SOURCE_TYPES = 'registerSourceTypes';

    /**
     * @see RegisterEventSourcesEvent
     */
    const EVENT_REGISTER_SOURCES = 'registerSources';

    private ?array $_sourceTypes = null;

    private ?array $_sources = null;

    public function findDateField(ElementInterface|FieldLayoutProviderInterface $type): ?EventDateField
    {
        $fieldLayout = $type->getFieldLayout();
        if ($fieldLayout === null) {
            return null;
        }

        return ArrayHelper::firstWhere($fieldLayout->getCustomFields(), fn ($field) => $field instanceof EventDateField);
    }

    /**
     * @return array<class-string<EventSource>>
     */
    public function getSourceTypes(): array
    {
        if (! $this->_sourceTypes) {
            $this->_sourceTypes = [EntryEventSource::class];

            if (Craft::$app->plugins->isPluginEnabled('commerce')) {
                $this->_sourceTypes[] = ProductEventSource::class;
            }

            $event = new RegisterEventSourceTypesEvent(['types' => $this->_sourceTypes]);
            $this->trigger(self::EVENT_REGISTER_SOURCE_TYPES, $event);
            $this->_sourceTypes = $event->types;
        }

        return $this->_sourceTypes;
    }

    /**
     * @return array<string, EventSource>
     */
    public function getSources(): array
    {
        if (! $this->_sources) {
            $sources = [];

            $index = 0;
            /** @var class-string<EventSource> $type */
            foreach ($this->getSourceTypes() as $type) {
                foreach ($type::sources() as $key => $params) {
                    // @phpstan-ignore argument.templateType
                    $sources[$key] = Craft::createObject([
                        'class' => $type,
                        'color' => Color::at($index),
                        ...$params,
                    ]);
                    $index++;
                }
            }

            $event = new RegisterEventSourcesEvent(['sources' => $sources]);
            $this->trigger(self::EVENT_REGISTER_SOURCES, $event);

            $this->_sources = $event->sources;
        }

        return $this->_sources;
    }

    public function findSourceByKey(string $key): EventSource
    {
        return $this->getSources()[$key];
    }

    /**
     * @param  string[]|null  $sourceKeys
     * @param  User|null  $user  only return events the user can access
     * @return array<string, ElementInterface[]>
     */
    public function getEvents(
        mixed $date = null,
        ?array $extraCriteria = null,
        ?array $sourceKeys = null,
        ?User $user = null,
    ): array {
        $elementsBySource = [];

        foreach ($this->getSources() as $key => $source) {
            if (
                (! $sourceKeys || in_array($key, $sourceKeys)) &&
                (! $user || $source->canView($user))
            ) {
                /** @var ElementQuery<int, ElementInterface> $query */
                $query = $source::elementType()::find();

                $criteria = $source->criteria();

                if ($date !== null) {
                    $criteria = [...$criteria, $source->dateFieldHandle => $date];
                }

                if ($extraCriteria) {
                    $criteria = [...$criteria, ...$extraCriteria];
                }

                if ($user && ! $source->canViewPeers($user)) {
                    $criteria = [...$criteria, 'authorId' => $user->id];
                }

                Craft::configure($query, $criteria);

                $elementsBySource[$key] = $query->all();
            }
        }

        return $elementsBySource;
    }

    public function updateICalendarSequence(int $elementId): void
    {
        Db::upsert(
            Table::METADATA,
            [
                'id' => $elementId,
                'iCalendarSequence' => 0,
            ],
            [
                'iCalendarSequence' => new Expression('[[iCalendarSequence]] + 1'),
            ]
        );
    }
}
