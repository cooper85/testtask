<?php
namespace Test\Task\Model\Config;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Hobby extends AbstractSource
{
    public const HOBBY_ATTRIBUTE = 'hobby';

    public const HOBBY_YOGA = 'yoga';
    public const HOBBY_TRAVELING = 'travelling';
    public const HOBBY_HIKING = 'hiking';

    /**
     * Prepare display options.
     *
     * @return array
     */
    public function getAvailableOptions()
    {
        return [
            '' => '',
            self::HOBBY_YOGA => __('Yoga'),
            self::HOBBY_TRAVELING => __('Travelling'),
            self::HOBBY_HIKING => __('Hiking')
        ];
    }

    /**
     * Retrieve All options
     *
     * @return array
     */
    public function getAllOptions()
    {
        $result = [];
        foreach ($this->getAvailableOptions() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }
        return $result;
    }
}
