<?php declare(strict_types=1);

namespace Shopware\Product\Event;

use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Event\NestedEvent;
use Shopware\Framework\Event\NestedEventCollection;

class ProductConfiguratorSetGroupRelationWrittenEvent extends NestedEvent
{
    const NAME = 'product_configurator_set_group_relation.written';

    /**
     * @var string[]
     */
    protected $productConfiguratorSetGroupRelationUuids;

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

    public function __construct(array $productConfiguratorSetGroupRelationUuids, TranslationContext $context, array $errors = [])
    {
        $this->productConfiguratorSetGroupRelationUuids = $productConfiguratorSetGroupRelationUuids;
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
    public function getProductConfiguratorSetGroupRelationUuids(): array
    {
        return $this->productConfiguratorSetGroupRelationUuids;
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
