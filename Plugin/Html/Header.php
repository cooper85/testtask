<?php
namespace Test\Task\Plugin\Html;

use Magento\Theme\Block\Html\Header as BaseHeader;
use Magento\Customer\Model\Session as CustomerSession;
use Test\Task\Helper\Data as DataHelper;
use Magento\Framework\View\Element\Template\File\Resolver;

class Header
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
     * @var string
     */
    private $template = 'Test_Task::html/header.phtml';

    /**
     * @var \Magento\Framework\View\Element\Template\File\Resolver
     */
    private $resolver;

    /**
     * Constructor
     * @param CustomerSession $customerSession
     * @param DataHelper $dataHelper
     * @param Resolver $resolver
     */
    public function __construct(
        CustomerSession $customerSession,
        DataHelper $dataHelper,
        Resolver $resolver
    ) {
        $this->customerSession = $customerSession;
        $this->dataHelper = $dataHelper;
        $this->resolver = $resolver;
    }

    /**
     * Get relevant template
     * @return string
     */
    public function aroundGetTemplate(
        BaseHeader $subject,
        callable $proceed
    ) {
        return $this->template;
    }

    /**
     * Get relevant template file
     * @param BaseHeader $subject
     * @param callable $proceed
     * @param $template
     * @return bool|string
     */
    public function aroundGetTemplateFile(
        BaseHeader $subject,
        callable $proceed,
        $template = null
    ) {
        $params = ['module' => $this->dataHelper->getModuleName()];
        $area = $subject->getArea();
        if ($area) {
            $params['area'] = $area;
        }
        return $this->resolver->getTemplateFileName($this->template, $params);
    }
}
