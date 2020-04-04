<?php


namespace Slayer\Test\Api\Data;

/**
 * Interface CustomerInterface
 */
interface CustomerInterface
{
    const ENTITY_ID = 'entity_id';
    const NAME = 'name';
    const SURNAME = 'surname';
    const EMAIL = 'email';
    const PHONE_NUMBER = 'phone_number';
    const CREATED_AT = 'created_at';

    /**
     * Get entity id
     *
     * @return int
     */
    public function getId();

    /**
     * Get customer name
     *
     * @return string
     */
    public function getName();

    /**
     * Get  customer surname
     *
     * @return string
     */
    public function getSurname();

    /**
     * Get customer email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get customer phone number
     *
     * @return int
     */
    public function getPhoneNumber();

    /**
     * Set entity id
     *
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Set customer email
     *
     * @param string $email
     * @return CustomerInterface
     */
    public function setEmail(string $email): CustomerInterface;

    /**
     * Set customer name
     *
     * @param string $name
     * @return CustomerInterface
     */
    public function setName(string $name): CustomerInterface;

    /**
     * Set customer surname
     *
     * @param string $surname
     * @return CustomerInterface
     */
    public function setSurname(string $surname): CustomerInterface;

    /**
     * Set some id
     *
     * @param int $phoneNumber
     * @return CustomerInterface
     */
    public function setPhoneNumber(int $phoneNumber): CustomerInterface;
}