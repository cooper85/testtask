<?php
namespace Test\Task\Block\Widget;

use Magento\Customer\Api\CustomerMetadataInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Api\Data\CustomerInterface;
use Magento\Customer\Api\Data\OptionInterface;
use Magento\Customer\Block\Widget\AbstractWidget;
use Test\Task\Model\Config\Hobby as ConfigHobby;

/**
 * Block to render customer's gender attribute
 *
 * @SuppressWarnings(PHPMD.DepthOfInheritance)
 */
class Hobby extends AbstractWidget
{
    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $_customerSession;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * Create an instance of the Gender widget
     *
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Magento\Customer\Helper\Address $addressHelper
     * @param CustomerMetadataInterface $customerMetadata
     * @param CustomerRepositoryInterface $customerRepository
     * @param \Magento\Customer\Model\Session $customerSession
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Customer\Helper\Address $addressHelper,
        CustomerMetadataInterface $customerMetadata,
        CustomerRepositoryInterface $customerRepository,
        \Magento\Customer\Model\Session $customerSession,
        array $data = []
    ) {
        $this->_customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        parent::__construct($context, $addressHelper, $customerMetadata, $data);
        $this->_isScopePrivate = true;
    }

    /**
     * Initialize block
     *
     * @return void
     */
    public function _construct()
    {
        parent::_construct();
        $this->setTemplate('Test_Task::widget/hobby.phtml');
    }

    /**
     * Check if hobby attribute enabled in system
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->_getAttribute(ConfigHobby::HOBBY_ATTRIBUTE) ?
            (bool)$this->_getAttribute('hobby')->isVisible() : false;
    }

    /**
     * Check if hobby attribute marked as required
     *
     * @return bool
     */
    public function isRequired()
    {
        return $this->_getAttribute(ConfigHobby::HOBBY_ATTRIBUTE) ?
            (bool)$this->_getAttribute('hobby')->isRequired() : false;
    }

    /**
     * Retrieve store attribute label
     *
     * @param string $attributeCode
     *
     * @return string
     */
    public function getStoreLabel($attributeCode)
    {
        $attribute = $this->_getAttribute($attributeCode);
        return $attribute ? __($attribute->getStoreLabel()) : '';
    }

    /**
     * Get current customer from session
     *
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customerRepository->getById($this->_customerSession->getCustomerId());
    }

    /**
     * Returns options from hobby attribute
     *
     * @return OptionInterface[]
     */
    public function getHobbyOptions()
    {
        return $this->_getAttribute(ConfigHobby::HOBBY_ATTRIBUTE)->getOptions();
    }
}
