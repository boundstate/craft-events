<?php

namespace boundstate\eventful\models;

use boundstate\eventful\helpers\DateHelper;
use boundstate\eventful\transformers\ArrayTransformer;
use boundstate\eventful\translators\Translator;
use craft\base\Model;
use craft\helpers\DateTimeHelper;
use craft\validators\DateTimeValidator;
use DateTime;
use DateTimeZone;
use Recurr\DateExclusion;
use Recurr\DateInclusion;
use Recurr\Recurrence;
use Recurr\RecurrenceCollection;
use Recurr\Rule;
use Recurr\Transformer\Constraint\AfterConstraint;
use Recurr\Transformer\ConstraintInterface;
use Recurr\Transformer\TextTransformer;

/**
 * @property-read ?Rule $rule
 */
class EventDate extends Model
{
    public bool $allowNeverEnding = false;

    public ?DateTime $start = null;

    public ?DateTime $end = null;

    public ?string $timezone = null;

    public bool $allDay = false;

    public bool $repeat = false;

    public int $interval = 1;

    public string $freq = 'DAILY';

    public array $byDay = [];

    public array $byMonthDay = [];

    public ?string $ends = null;

    public ?int $count = null;

    public ?DateTime $until = null;

    public array $inDates = [];

    public array $exDates = [];

    private static array $dateAttributes = ['start', 'end', 'until'];

    private ?Rule $_rule = null;

    private ?ArrayTransformer $_arrayTransformer = null;

    private ?TextTransformer $_textTransformer = null;

    private ?RecurrenceCollection $_allRecurrences = null;

    public function __construct($config = [])
    {
        // use our own logic to typecast & normalize DateTime attributes,
        // which takes into account the timezone for this field
        if (! empty($config['timezone'])) {
            foreach (self::$dateAttributes as $attribute) {
                if (empty($config[$attribute])) {
                    continue;
                }

                $value = $config[$attribute];

                $isTimeOnly = is_array($value) && ! isset($value['date']);
                $isDateOnly = is_array($value) && ! isset($value['time']);

                $config[$attribute] = self::toDateTime(
                    $value,
                    $config['timezone'],
                );

                if (! $config[$attribute]) {
                    continue;
                }

                switch ($attribute) {
                    case 'end':
                        // if end time is provided without date, use start date
                        if ($isTimeOnly && ! empty($config['start'])) {
                            $config[$attribute]->modify(
                                $config['start']->format('Y-m-d'),
                            );
                        }
                        break;
                    case 'until':
                        // if until date is provided without time, set to end of day
                        if ($isDateOnly) {
                            $config[$attribute] = DateHelper::endOfDay(
                                $config[$attribute],
                            );
                        }
                        break;
                }
            }
        }

        // if rule is set, determine other properties from it
        if (! empty($config['rule'])) {
            $config['repeat'] = true;

            $rule = new Rule($config['rule'], $config['start'], $config['end']);
            $config['interval'] = $rule->getInterval();
            $config['freq'] = $rule->getFreqAsText();
            $config['byDay'] = $rule->getByDay();
            $config['byMonthDay'] = $rule->getByMonthDay();

            $config['exDates'] = array_map(
                fn (DateExclusion $m): string => $m->date->format('Y-m-d'),
                $rule->getExDates(),
            );
            $config['inDates'] = array_map(
                fn (DateInclusion $m): string => $m->date->format('Y-m-d'),
                $rule->getRDates(),
            );

            asort($config['exDates']);
            asort($config['inDates']);

            if ($count = $rule->getCount()) {
                $config['ends'] = 'count';
                $config['count'] = $count;
            } elseif ($until = $rule->getUntil()) {
                $config['ends'] = 'until';
                $config['until'] = $until;
            }
        }

        unset($config['rule']);

        parent::__construct($config);
    }

    public function getRule(?bool $forceRefresh = false): ?Rule
    {
        if (! $this->repeat) {
            return null;
        }

        if (! $this->_rule || $forceRefresh) {
            $rule = (new Rule(null, $this->start, $this->end))
                ->setFreq($this->freq)
                ->setRDates($this->inDates)
                ->setExDates($this->exDates);

            if ($this->interval) {
                $rule->setInterval($this->interval);
            }
            if ($this->byDay) {
                $rule->setByDay($this->byDay);
            }
            if ($this->byMonthDay) {
                $rule->setByMonthDay($this->byMonthDay);
            }
            if ($this->ends === 'count') {
                $rule->setCount($this->count);
            } elseif ($this->ends === 'until') {
                if ($this->until) {
                    $rule->setUntil($this->until);
                }
            }

            $this->_rule = $rule;
        }

        return $this->_rule;
    }

    public function rules(): array
    {
        return [
            ['start', 'required'],
            [['start', 'end', 'until'], DateTimeValidator::class],
            [['end', 'timezone'], 'required', 'when' => fn (EventDate $model): bool => ! $model->allDay],
            ['repeat', 'boolean'],
            [
                ['interval', 'count'],
                'number',
                'integerOnly' => true,
                'min' => 1,
            ],
            [
                'byDay',
                'required',
                'when' => fn (EventDate $model): bool => $model->freq === 'WEEKLY',
            ],
            [
                'byMonthDay',
                'required',
                'when' => fn (EventDate $model): bool => $model->freq === 'MONTHLY' &&
                    empty($model->byDay),
            ],
            ['ends', 'required', 'when' => fn (EventDate $model): bool => $model->repeat && ! $model->allowNeverEnding],
            [
                'count',
                'required',
                'when' => fn (EventDate $model): bool => $model->repeat && $model->ends === 'count',
            ],
            [
                'until',
                'required',
                'when' => fn (EventDate $model): bool => $model->repeat && $model->ends === 'until',
            ],
            [
                'until',
                'validateUntil',
                'skipOnError' => true,
                'when' => fn (EventDate $model): bool => $model->repeat && $model->ends === 'until',
            ],
        ];
    }

    public function validateUntil(): void
    {
        $start = DateTimeHelper::toDateTime($this->start);
        $until = DateTimeHelper::toDateTime($this->until);
        if (
            $start &&
            $until &&
            $until->format('Y-m-d') < $start->format('Y-m-d')
        ) {
            $this->addError('until', 'Until cannot be before start date');
        }
    }

    public function getRepeatDescription(): ?string
    {
        if (! $this->rule) {
            return null;
        }
        $description = $this->getTextTransformer()->transform($this->rule);

        return $description ? ucfirst((string) $description) : null;
    }

    public function getOccurrences(
        ?ConstraintInterface $constraint = null,
    ): RecurrenceCollection {
        if (! $this->rule) {
            return new RecurrenceCollection([
                new Recurrence($this->start, $this->end),
            ]);
        }

        if (! $constraint) {
            if (! $this->_allRecurrences) {
                $this->_allRecurrences = $this->getArrayTransformer()->transform(
                    $this->rule,
                );
            }

            return $this->_allRecurrences;
        }

        return $this->getArrayTransformer()->transform(
            $this->rule,
            $constraint,
        );
    }

    public function getNextOccurrence(): ?Recurrence
    {
        $today = (new DateTime)->setTime(0, 0);

        return $this->getOccurrences(
            new AfterConstraint($today, true),
        )->first() ?:
            null;
    }

    public function getFirstStartDate(): ?DateTime
    {
        if (! $this->rule) {
            // event does not repeat
            return $this->start ?: null;
        }

        $firstRecurrence = $this->getOccurrences()->first();

        return $firstRecurrence ? $firstRecurrence->getStart() : null;
    }

    public function getLastEndDate(): ?DateTime
    {
        if (! $this->rule) {
            // event does not repeat
            return $this->end ?: null;
        }

        if (! $this->count && ! $this->until) {
            // event repeats forever
            return null;
        }

        $lastRecurrence = $this->getOccurrences()->last();

        return $lastRecurrence ? $lastRecurrence->getEnd() : null;
    }

    public function isPast(): bool
    {
        $lastEndDate = $this->getLastEndDate();

        return (bool) $lastEndDate && $lastEndDate < new DateTime;
    }

    private static function toDateTime(
        mixed $value,
        ?string $timezone,
    ): DateTime|false {
        // dates are stored in the database as UTC
        $date = DateTimeHelper::toDateTime($value, false, false);
        if (! $date) {
            return false;
        }
        if ($timezone) {
            $date->setTimezone(new DateTimeZone($timezone));
        }

        return $date;
    }

    private function getArrayTransformer(): ArrayTransformer
    {
        if (! $this->_arrayTransformer) {
            $this->_arrayTransformer = new ArrayTransformer;
        }

        return $this->_arrayTransformer;
    }

    private function getTextTransformer(): TextTransformer
    {
        if (! $this->_textTransformer) {
            $this->_textTransformer = new TextTransformer(new Translator);
        }

        return $this->_textTransformer;
    }
}
