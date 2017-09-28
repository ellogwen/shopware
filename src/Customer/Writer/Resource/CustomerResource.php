<?php declare(strict_types=1);

namespace Shopware\Customer\Writer\Resource;

use Shopware\Context\Struct\TranslationContext;
use Shopware\Framework\Write\Field\BoolField;
use Shopware\Framework\Write\Field\DateField;
use Shopware\Framework\Write\Field\FkField;
use Shopware\Framework\Write\Field\IntField;
use Shopware\Framework\Write\Field\LongTextField;
use Shopware\Framework\Write\Field\ReferenceField;
use Shopware\Framework\Write\Field\StringField;
use Shopware\Framework\Write\Field\SubresourceField;
use Shopware\Framework\Write\Field\UuidField;
use Shopware\Framework\Write\Flag\Required;
use Shopware\Framework\Write\Resource;

class CustomerResource extends Resource
{
    protected const UUID_FIELD = 'uuid';
    protected const NUMBER_FIELD = 'number';
    protected const SALUTATION_FIELD = 'salutation';
    protected const FIRST_NAME_FIELD = 'firstName';
    protected const LAST_NAME_FIELD = 'lastName';
    protected const PASSWORD_FIELD = 'password';
    protected const EMAIL_FIELD = 'email';
    protected const TITLE_FIELD = 'title';
    protected const ENCODER_FIELD = 'encoder';
    protected const ACTIVE_FIELD = 'active';
    protected const ACCOUNT_MODE_FIELD = 'accountMode';
    protected const CONFIRMATION_KEY_FIELD = 'confirmationKey';
    protected const FIRST_LOGIN_FIELD = 'firstLogin';
    protected const LAST_LOGIN_FIELD = 'lastLogin';
    protected const SESSION_ID_FIELD = 'sessionId';
    protected const NEWSLETTER_FIELD = 'newsletter';
    protected const VALIDATION_FIELD = 'validation';
    protected const AFFILIATE_FIELD = 'affiliate';
    protected const REFERER_FIELD = 'referer';
    protected const INTERNAL_COMMENT_FIELD = 'internalComment';
    protected const FAILED_LOGINS_FIELD = 'failedLogins';
    protected const LOCKED_UNTIL_FIELD = 'lockedUntil';
    protected const BIRTHDAY_FIELD = 'birthday';

    public function __construct()
    {
        parent::__construct('customer');

        $this->primaryKeyFields[self::UUID_FIELD] = (new UuidField('uuid'))->setFlags(new Required());
        $this->fields[self::NUMBER_FIELD] = (new StringField('customer_number'))->setFlags(new Required());
        $this->fields[self::SALUTATION_FIELD] = (new StringField('salutation'))->setFlags(new Required());
        $this->fields[self::FIRST_NAME_FIELD] = (new StringField('first_name'))->setFlags(new Required());
        $this->fields[self::LAST_NAME_FIELD] = (new StringField('last_name'))->setFlags(new Required());
        $this->fields[self::PASSWORD_FIELD] = (new StringField('password'))->setFlags(new Required());
        $this->fields[self::EMAIL_FIELD] = (new StringField('email'))->setFlags(new Required());
        $this->fields[self::TITLE_FIELD] = new StringField('title');
        $this->fields[self::ENCODER_FIELD] = new StringField('encoder');
        $this->fields[self::ACTIVE_FIELD] = new BoolField('active');
        $this->fields[self::ACCOUNT_MODE_FIELD] = new IntField('account_mode');
        $this->fields[self::CONFIRMATION_KEY_FIELD] = new StringField('confirmation_key');
        $this->fields[self::FIRST_LOGIN_FIELD] = new DateField('first_login');
        $this->fields[self::LAST_LOGIN_FIELD] = new DateField('last_login');
        $this->fields[self::SESSION_ID_FIELD] = new StringField('session_id');
        $this->fields[self::NEWSLETTER_FIELD] = new BoolField('newsletter');
        $this->fields[self::VALIDATION_FIELD] = new StringField('validation');
        $this->fields[self::AFFILIATE_FIELD] = new BoolField('affiliate');
        $this->fields[self::REFERER_FIELD] = new StringField('referer');
        $this->fields[self::INTERNAL_COMMENT_FIELD] = new LongTextField('internal_comment');
        $this->fields[self::FAILED_LOGINS_FIELD] = new IntField('failed_logins');
        $this->fields[self::LOCKED_UNTIL_FIELD] = new DateField('locked_until');
        $this->fields[self::BIRTHDAY_FIELD] = new DateField('birthday');
        $this->fields['group'] = new ReferenceField('groupUuid', 'uuid', \Shopware\CustomerGroup\Writer\Resource\CustomerGroupResource::class);
        $this->fields['groupUuid'] = (new FkField('customer_group_uuid', \Shopware\CustomerGroup\Writer\Resource\CustomerGroupResource::class, 'uuid'))->setFlags(new Required());
        $this->fields['defaultPaymentMethod'] = new ReferenceField('defaultPaymentMethodUuid', 'uuid', \Shopware\PaymentMethod\Writer\Resource\PaymentMethodResource::class);
        $this->fields['defaultPaymentMethodUuid'] = (new FkField('default_payment_method_uuid', \Shopware\PaymentMethod\Writer\Resource\PaymentMethodResource::class, 'uuid'))->setFlags(new Required());
        $this->fields['shop'] = new ReferenceField('shopUuid', 'uuid', \Shopware\Shop\Writer\Resource\ShopResource::class);
        $this->fields['shopUuid'] = (new FkField('shop_uuid', \Shopware\Shop\Writer\Resource\ShopResource::class, 'uuid'))->setFlags(new Required());
        $this->fields['mainShop'] = new ReferenceField('mainShopUuid', 'uuid', \Shopware\Shop\Writer\Resource\ShopResource::class);
        $this->fields['mainShopUuid'] = (new FkField('main_shop_uuid', \Shopware\Shop\Writer\Resource\ShopResource::class, 'uuid'))->setFlags(new Required());
        $this->fields['lastPaymentMethod'] = new ReferenceField('lastPaymentMethodUuid', 'uuid', \Shopware\PaymentMethod\Writer\Resource\PaymentMethodResource::class);
        $this->fields['lastPaymentMethodUuid'] = (new FkField('last_payment_method_uuid', \Shopware\PaymentMethod\Writer\Resource\PaymentMethodResource::class, 'uuid'));
        $this->fields['defaultBillingAddress'] = new ReferenceField('defaultBillingAddressUuid', 'uuid', \Shopware\CustomerAddress\Writer\Resource\CustomerAddressResource::class);
        $this->fields['defaultBillingAddressUuid'] = (new FkField('default_billing_address_uuid', \Shopware\CustomerAddress\Writer\Resource\CustomerAddressResource::class, 'uuid'));
        $this->fields['defaultShippingAddress'] = new ReferenceField('defaultShippingAddressUuid', 'uuid', \Shopware\CustomerAddress\Writer\Resource\CustomerAddressResource::class);
        $this->fields['defaultShippingAddressUuid'] = (new FkField('default_shipping_address_uuid', \Shopware\CustomerAddress\Writer\Resource\CustomerAddressResource::class, 'uuid'));
        $this->fields['addresses'] = new SubresourceField(\Shopware\CustomerAddress\Writer\Resource\CustomerAddressResource::class);
        $this->fields['orders'] = new SubresourceField(\Shopware\Order\Writer\Resource\OrderResource::class);
        $this->fields['statisticCurrentCustomers'] = new SubresourceField(\Shopware\Framework\Write\Resource\StatisticCurrentCustomerResource::class);
    }

    public function getWriteOrder(): array
    {
        return [
            \Shopware\CustomerGroup\Writer\Resource\CustomerGroupResource::class,
            \Shopware\PaymentMethod\Writer\Resource\PaymentMethodResource::class,
            \Shopware\Shop\Writer\Resource\ShopResource::class,
            \Shopware\CustomerAddress\Writer\Resource\CustomerAddressResource::class,
            \Shopware\Customer\Writer\Resource\CustomerResource::class,
            \Shopware\Order\Writer\Resource\OrderResource::class,
            \Shopware\Framework\Write\Resource\StatisticCurrentCustomerResource::class,
        ];
    }

    public static function createWrittenEvent(array $updates, TranslationContext $context, array $errors = []): ?\Shopware\Customer\Event\CustomerWrittenEvent
    {
        if (empty($updates) || !array_key_exists(self::class, $updates)) {
            return null;
        }

        $event = new \Shopware\Customer\Event\CustomerWrittenEvent($updates[self::class] ?? [], $context, $errors);

        unset($updates[self::class]);

        $event->addEvent(\Shopware\CustomerGroup\Writer\Resource\CustomerGroupResource::createWrittenEvent($updates, $context));
        $event->addEvent(\Shopware\PaymentMethod\Writer\Resource\PaymentMethodResource::createWrittenEvent($updates, $context));
        $event->addEvent(\Shopware\Shop\Writer\Resource\ShopResource::createWrittenEvent($updates, $context));
        $event->addEvent(\Shopware\CustomerAddress\Writer\Resource\CustomerAddressResource::createWrittenEvent($updates, $context));
        $event->addEvent(\Shopware\Customer\Writer\Resource\CustomerResource::createWrittenEvent($updates, $context));
        $event->addEvent(\Shopware\Order\Writer\Resource\OrderResource::createWrittenEvent($updates, $context));
        $event->addEvent(\Shopware\Framework\Write\Resource\StatisticCurrentCustomerResource::createWrittenEvent($updates, $context));

        return $event;
    }
}
