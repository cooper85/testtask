<?php
namespace Test\Task\Controller\Index;

use Magento\Customer\Api\CustomerRepositoryInterface as CustomerRepository;
use Magento\Customer\Controller\AbstractAccount;
use Test\Task\Controller\Hobby\CustomerInterface;

/**
 * Customer's hobby save controller
 */
class Save extends AbstractAccount
{
    /**
     * @var \Magento\Framework\Data\Form\FormKey\Validator
     */
    protected $formKeyValidator;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CustomerRepository
     */
    protected $customerRepository;

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
        $this->customerRepository = $customerRepository;
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface
     */
    public function execute()
    {
        if (!$this->formKeyValidator->validate($this->getRequest())) {
            return $this->_redirect('customer/account/');
        }

        $customerId = $this->_customerSession->getCustomerId();
        if ($customerId === null) {
            $this->messageManager->addErrorMessage(__('Something went wrong while saving your hobbies.'));
        } else {
            try {
                $customer = $this->customerRepository->getById($customerId);
                $storeId = (int)$this->storeManager->getStore()->getId();
                $customer->setStoreId($storeId);
                $isSubscribedState = $customer->getExtensionAttributes()->getIsSubscribed();
                $isSubscribedParam = (boolean)$this->getRequest()->getParam('is_subscribed', false);
                /**if ($isSubscribedParam !== $isSubscribedState) {
                    // No need to validate customer and customer address while saving subscription preferences
                    $this->setIgnoreValidationFlag($customer);
                    $this->customerRepository->save($customer);
                    if ($isSubscribedParam) {
                        $subscribeModel = $this->subscriptionManager->subscribeCustomer((int)$customerId, $storeId);
                        $subscribeStatus = (int)$subscribeModel->getStatus();
                        if ($subscribeStatus === Subscriber::STATUS_SUBSCRIBED) {
                            $this->messageManager->addSuccess(__('We have saved your subscription.'));
                        } else {
                            $this->messageManager->addSuccess(__('A confirmation request has been sent.'));
                        }
                    } else {
                        $this->subscriptionManager->unsubscribeCustomer((int)$customerId, $storeId);
                        $this->messageManager->addSuccess(__('We have removed your newsletter subscription.'));
                    }
                } else {
                    $this->messageManager->addSuccess(__('We have updated your subscription.'));
                }*/
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while saving your subscription.'));
            }
        }
        return $this->_redirect('customer/account/');
    }

    /**
     * Set ignore_validation_flag to skip unnecessary address and customer validation
     *
     * @param CustomerInterface $customer
     * @return void
     */
    private function setIgnoreValidationFlag(CustomerInterface $customer): void
    {
        $customer->setData('ignore_validation_flag', true);
    }
}
