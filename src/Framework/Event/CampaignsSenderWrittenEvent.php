<?php declare(strict_types=1);

namespace Shopware\Framework\Event;

use Shopware\Context\Struct\TranslationContext;

class CampaignsSenderWrittenEvent extends NestedEvent
{
    const NAME = 'campaigns_sender.written';

    /**
     * @var string[]
     */
    protected $campaignsSenderUuids;

    /**
     * @var NestedEventCollection
     */
    protected $events;

    /**
     * @var array
     */
    protected $errors;

    /**
     * @var TranslationContext
     */
    protected $context;

    public function __construct(array $campaignsSenderUuids, TranslationContext $context, array $errors = [])
    {
        $this->campaignsSenderUuids = $campaignsSenderUuids;
        $this->events = new NestedEventCollection();
        $this->context = $context;
        $this->errors = $errors;
    }

    public function getName(): string
    {
        return self::NAME;
    }

    public function getContext(): TranslationContext
    {
        return $this->context;
    }

    /**
     * @return string[]
     */
    public function getCampaignsSenderUuids(): array
    {
        return $this->campaignsSenderUuids;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return count($this->errors) > 0;
    }

    public function addEvent(?NestedEvent $event): void
    {
        if ($event === null) {
            return;
        }
        $this->events->add($event);
    }

    public function getEvents(): NestedEventCollection
    {
        return $this->events;
    }
}
