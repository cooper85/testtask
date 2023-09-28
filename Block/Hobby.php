<?php

namespace Test\Task\Block;

use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session as CustomerSession;
use Test\Task\Helper\Config;

/**
 * Customer edit form block
 *
 * @api
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 * @since 100.0.2
 */
class Hobby extends Template
{
    /**
     * @var Config
     */
    private $helperConfig;

    /**
     * @var \Magento\Customer\Model\Session
     */
    private $customerSession;

    /**
     * @var \Magento\Customer\Api\Data\CustomerInterface
     */
    private $customerRepository;

    /**
     * Constructor
     * @param Context $context
     * @param Config $helperConfig
     * @param CustomerRepositoryInterface $customerRepository
     * @param CustomerSession $customerSession
     * @param array $data
     */
    public function __construct(
        Context $context,
        Config $helperConfig,
        CustomerRepositoryInterface $customerRepository,
        CustomerSession $customerSession,
        array $data = []
    ) {
        $this->helperConfig = $helperConfig;
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        parent::__construct($context, $data);
    }

    /**
     * Get current customer from session
     *
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customerRepository->getById($this->customerSession->getCustomerId());
    }

    /**
     * Get configuration helper
     *
     * @return Config
     */
    public function getHelperConfig()
    {
        return $this->helperConfig;
    }
}
