<?php

namespace Slayer\Test\Model;

use Magento\Framework\Model\AbstractModel;
use Slayer\Test\Api\Data\CustomerInterface;
use Slayer\Test\Model\ResourceModel\Customer as CustomerResourceModel;

/**
 * Class CarCustomerModel
 */
class CustomerModel extends AbstractModel implements CustomerInterface
{

//    const ENTITY_ID = 'entity_id';
//    const NAME = 'name';
//    const SURNAME = 'surname';
//    const EMAIL = 'email';
//    const PHONE_NUMBER = 'phone_number';

    /**
     * {@inheritdoc}
     */
    public function _construct()
    {
        $this->_init(CustomerResourceModel::class);
    }

    /**
     * GETTERS
     */

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getData(self::ENTITY_ID);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getSurname()
    {
        return $this->getData(self::SURNAME);
    }
    /**
     * {@inheritdoc}
     */
    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * {@inheritdoc}
     */
    public function getPhoneNumber()
    {
        return $this->getData(self::PHONE_NUMBER);
    }

    /**
     * SETTERS
     */

    /**
     * {@inheritdoc}
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    /**
     * {@inheritdoc}
     */
    public function setName(string $name): CustomerInterface
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * {@inheritdoc}
     */
    public function setSurname(string $surname): CustomerInterface
    {
        return $this->setData(self::SURNAME, $surname);
    }

    /**
     * {@inheritdoc}
     */
    public function setEmail(string $email): CustomerInterface
    {
        return $this->setData(self::EMAIL, $email);
    }

    /**
     * {@inheritdoc}
     */
    public function setPhoneNumber(int $phoneNumber): CustomerInterface
    {
        return $this->setData(self::PHONE_NUMBER, $phoneNumber);
    }
}
