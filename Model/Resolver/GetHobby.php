<?php
namespace Test\Task\Model\Resolver;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Test\Task\Model\Config\Hobby as ConfigHobby;

/**
 * Customer hobby attribute field resolver
 */
class GetHobby implements ResolverInterface
{
    /**
     * @var Magento\Customer\Api\CustomerRepositoryInterface
     */
    protected $customerRepositoryInterface;

    /**
     * @var ConfigHobby
     */
    private $configHobby;

    /**
     * Constructor
     * @param \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface
     * @param ConfigHobby $configHobby
     */
    public function __construct(
        \Magento\Customer\Api\CustomerRepositoryInterface $customerRepositoryInterface,
        ConfigHobby $configHobby
    ) {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->configHobby = $configHobby;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        if (!isset($value['model'])) {
            throw new LocalizedException(__('"model" value should be specified'));
        }
        /** @var CustomerInterface $customer */
        $customer = $value['model'];
        $customerId = (int) $customer->getId();
        $customerData = $this->customerRepositoryInterface->getById($customerId);

        /* Get hobby attribute value */
        $hobbies = [];
        if ($customer->getCustomAttribute(ConfigHobby::HOBBY_ATTRIBUTE)) {
            $hobby = $customer->getCustomAttribute(ConfigHobby::HOBBY_ATTRIBUTE)->getValue();
            $hobbies = is_string($hobby) ? explode(',', $hobby) : $hobby;
        }

        return $hobbies;
    }
}
