<?php
namespace Test\Task\Plugin\CustomerData;

use Magento\Customer\Helper\Session\CurrentCustomer;
use Test\Task\Helper\Config as ConfigHelper;
use Test\Task\Helper\Data as DataHelper;
use Magento\Customer\CustomerData\Customer as Customer;

class HobbySection
{
    const HOBBY_SECTION_NAME = 'hobby';

    /**
     * @var ConfigHelper
     */
    private $configHelper;

    /**
     * @var DataHelper
     */
    private $dataHelper;

    /**
     * @var CurrentCustomer
     */
    private $customer;

    /**
     * Constructor
     * @param DataHelper $dataHelper
     * @param ConfigHelper $configHelper
     * @param CustomerSession $customerSession
     */
    public function __construct(
        DataHelper $dataHelper,
        ConfigHelper $configHelper,
        CurrentCustomer $customer
    ) {
        $this->dataHelper = $dataHelper;
        $this->configHelper = $configHelper;
        $this->customer = $customer;
    }

    /**
     * Add additional required attributes to customerData
     * @param Customer $subject
     * @param $result
     * @return mixed
     */
    public function afterGetSectionData(
        Customer $subject,
        $result
    ) {
        if ($this->configHelper->isEnabled() && $this->customer->getCustomerId()) {
            $customer = $this->customer->getCustomer();
            $result[self::HOBBY_SECTION_NAME] = $this->dataHelper->getFormattedHobbyList($customer);
        }

        return $result;
    }
}
