<?php
namespace Test\Task\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Customer\Model\Data\Customer;
use Magento\Framework\App\Helper\Context;
use Test\Task\Model\Config\Hobby;

class Data extends AbstractHelper
{
    /**
     * @var Hobby
     */
    private $configHobby;

    /**
     * Constructor
     * @param Context $context
     */
    public function __construct(
        Context $context,
        Hobby $configHobby
    ) {
        $this->configHobby = $configHobby;
        parent::__construct($context);
    }
    /**
     * Get formatted hobby list
     * @param Customer $customer
     * @return string
     */
    public function getFormattedHobbyList(
        Customer $customer
    ) {
        $hobbyAttr = $customer->getCustomAttribute('hobby');
        if (empty($hobbyAttr)) {
            return '';
        }
        $hobbyList = $hobbyAttr->getValue();
        $hobbyList = explode(',', $hobbyList);
        $options = array_reduce($this->configHobby->getAllOptions(), function ($result, $item) {
            $result[$item['value']] = $item['label'];
            return $result;
        }, []);
        $result = [];
        foreach ($hobbyList as $hobby) {
            if (isset($options[$hobby])) {
                $result[] = $options[$hobby];
            } else {
                $result = $hobby;
            }
        }
        return ' (' . implode(', ', $result) . ')';
    }

    /**
     * Returns current module name
     * @return string
     */
    public function getModuleName()
    {
        return $this->_getModuleName();
    }

    /**
     * Returns current module name
     * @return string
     */
    public function getArea()
    {
        return $this->_getModuleName();
    }
}
