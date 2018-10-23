<?php
/**
 * Copyright © Magefan (support@magefan.com). All rights reserved.
 * See LICENSE.txt for license details (http://opensource.org/licenses/osl-3.0.php).
 *
 * Glory to Ukraine! Glory to the heroes!
 */

namespace Magefan\Blog\Controller\Adminhtml\Tag;

/**
 * Blog tag save controller
 */
class Save extends \Magefan\Blog\Controller\Adminhtml\Tag
{
    /**
     * @return bool return allowed key
     */
    protected function _isAllowed()
    {
        $id = $this->getRequest()->getParam('tag_id');
        if ($id) {
            $key = 'Magefan_Blog::tag_update';
        } else {
            $key = 'Magefan_Blog::tag_create';
        }
        return $this->_authorization->isAllowed($key);
    }

    /**
     * Filter request params
     * @param  array $data
     * @return array
     */
    protected function filterParams($data)
    {
        /* Prepare dates */
        $dateFilter = $this->_objectManager->create(\Magento\Framework\Stdlib\DateTime\Filter\Date::class);

        $filterRules = [];
        foreach (['custom_theme_from', 'custom_theme_to'] as $dateField) {
            if (!empty($data[$dateField])) {
                $filterRules[$dateField] = $dateFilter;
            }
        }

        $inputFilter = new \Zend_Filter_Input(
            $filterRules,
            [],
            $data
        );

        $data = $inputFilter->getUnescaped();

        return $data;
    }
}
