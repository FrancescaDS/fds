<?php

/**
 * Fds_Yourproduct
 * Fds - fdallserra 2018
 */

namespace Fds\Yourproduct\Model;

use Magento\Framework\Option\ArrayInterface;

class Multiselect implements ArrayInterface
{
    const STATUS_YES = 1;

    const STATUS_NO = 0;

    /**
     * @return array
     */
    public function toOptionArray()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * @return array
     */
    public static function getOptionArray()
    {
        return [
            self::STATUS_YES => __('Yes'),
            self::STATUS_NO => __('No')
        ];
    }

    /**
     * @return array
     */
    public function getAllOptions()
    {
        $result = [];

        foreach (self::getOptionArray() as $index => $value) {
            $result[] = ['value' => $index, 'label' => $value];
        }

        return $result;
    }

    /**
     * @param $optionId
     * @return mixed|null
     */
    public function getOptionText($optionId)
    {
        $options = self::getOptionArray();

        return isset($options[$optionId]) ? $options[$optionId] : null;
    }
}
