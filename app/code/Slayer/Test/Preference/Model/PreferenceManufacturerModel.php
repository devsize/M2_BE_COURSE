<?php

namespace Slayer\Test\Preference\Model;

use Slayer\Test\Model\ManufacturerModel;

/**
 * Class PreferenceCustomerModel
 */
class PreferenceManufacturerModel extends ManufacturerModel
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
//        return '<span class="preference">From Preference Customer Model: </span>' . $this->getData(self::NAME);
        return $this->getData(self::NAME);
//        return __('FromPreferenceCustomerModel: ')->render() . $this->getData(self::NAME);
    }
}
