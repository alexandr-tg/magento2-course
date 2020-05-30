<?php

namespace Vendor\ProductAttribute\Model\Attribute\Source;

class ProductAttribute extends \Magento\Eav\Model\Entity\Attribute\Source\AbstractSource
{
    /**
     * Get all options
     * @return array
     */
    public function getAllOptions()
    {
        if (!$this->_options) {
            $this->_options = [
                ['label' => __('Yes'), 'value' => 'Yes'],
                ['label' => __('No'), 'value' => 'No'],
            ];
        }
        return $this->_options;
    }
}
