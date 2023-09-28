<?php
namespace Test\Task\Controller\Manage;

use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Controller\AbstractAccount;
use Test\Task\Controller\Hobby\CustomerInterface;
use Test\Task\Model\Config\Hobby as ConfigHobby;

/**
 * Customer's hobby save controller
 */
class Save extends AbstractAccount
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    private $formKeyValidator;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CustomerRepository
     */
    private $customerRepository;

    /**
     * @var CustomerSession
     */
    private $customerSession;

    /**
     * Initialize dependencies.
     *
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Customer\Model\Session $customerSession
     * @param \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator
     * @param \Magento\Store\Model\StoreManagerInterface $storeManager
     * @param CustomerRepository $customerRepository
     */
    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        CustomerRepository $customerRepository
    ) {
        $this->storeManager = $storeManager;
        $this->formKeyValidator = $formKeyValidator;
        $this->customerSession = $customerSession;
        $this->customerRepository = $customerRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->_redirect('customer/account/');
        }
        $customerId = $this->customerSession->getCustomerId();
        if ($customerId === null) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving your hobbies.'));
        } else {
            try {
                $customer = $this->customerRepository->getById($customerId);
                $storeId = (int)$this->storeManager->getStore()->getId();
                $hobby = $this->getRequest()->getParam('hobby', []);
                $customer->setStoreId($storeId)
                    ->setCustomAttribute(ConfigHobby::HOBBY_ATTRIBUTE, implode(',', $hobby))
                    ->setData('ignore_validation_flag', true);
                $this->customerRepository->save($customer);
                $this->messageManager->addSuccess(__('Hobby list is updated.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while updating your hobbies.'));
            }
        }
        return $this->_redirect('hobby/manage/index');
    }
}
