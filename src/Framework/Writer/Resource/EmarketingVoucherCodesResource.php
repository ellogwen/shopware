<?php declare(strict_types=1);

namespace Shopware\Framework\Write\Resource;

use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Write\Field\IntField;
use Shopware\Framework\Write\Field\StringField;
use Shopware\Framework\Write\Flag\Required;
use Shopware\Framework\Write\Resource;

class EmarketingVoucherCodesResource extends Resource
{
    protected const VOUCHERID_FIELD = 'voucherID';
    protected const USERID_FIELD = 'userID';
    protected const CODE_FIELD = 'code';
    protected const CASHED_FIELD = 'cashed';

    public function __construct()
    {
        parent::__construct('s_emarketing_voucher_codes');

        $this->fields[self::VOUCHERID_FIELD] = new IntField('voucherID');
        $this->fields[self::USERID_FIELD] = new IntField('userID');
        $this->fields[self::CODE_FIELD] = (new StringField('code'))->setFlags(new Required());
        $this->fields[self::CASHED_FIELD] = (new IntField('cashed'))->setFlags(new Required());
    }

    public function getWriteOrder(): array
    {
        return [
            \Shopware\Framework\Write\Resource\EmarketingVoucherCodesResource::class,
        ];
    }

    public static function createWrittenEvent(array $updates, TranslationContext $context, array $errors = []): ?\Shopware\Framework\Event\EmarketingVoucherCodesWrittenEvent
    {
        if (empty($updates) || !array_key_exists(self::class, $updates)) {
            return null;
        }

        $event = new \Shopware\Framework\Event\EmarketingVoucherCodesWrittenEvent($updates[self::class] ?? [], $context, $errors);

        unset($updates[self::class]);

        $event->addEvent(\Shopware\Framework\Write\Resource\EmarketingVoucherCodesResource::createWrittenEvent($updates, $context));

        return $event;
    }
}
