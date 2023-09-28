<?php
namespace Test\Task\Plugin\Customer;

use Magento\Customer\Api\Data\CustomerInterface;
use Magento\CustomerGraphQl\Model\Customer\SaveCustomer as BaseSaveCustomer;
use Magento\Customer\Model\Session as CustomerSession;
use Test\Task\Helper\Data as DataHelper;
use Test\Task\Model\Config\Hobby as ConfigHobby;

class SaveCustomer
{
    /**
     * @var Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var Test\Task\Helper\Data
     */
    private $dataHelper;

    /**
     * @param CustomerSession $customerSession
     * @param DataHelper $dataHelper
     */
    public function __construct(
        CustomerSession $customerSession,
        DataHelper $dataHelper
    ) {
        $this->customerSession = $customerSession;
        $this->dataHelper = $dataHelper;
    }

    /**
     * Normalize custom attribute behaviour in structure
     * @param BaseSaveCustomer $subject
     * @param CustomerInterface $customer
     * @return CustomerInterface[]
     */
    public function beforeExecute(
        BaseSaveCustomer $subject,
        CustomerInterface $customer
    ) {
        $hobby = $customer->getCustomAttribute(ConfigHobby::HOBBY_ATTRIBUTE) ?
            $customer->getCustomAttribute(ConfigHobby::HOBBY_ATTRIBUTE)->getValue() : '';
        if (is_array($hobby)) {
            $customer->setCustomAttribute(ConfigHobby::HOBBY_ATTRIBUTE, implode(',', $hobby));
        }
        return [$customer];
    }
}
