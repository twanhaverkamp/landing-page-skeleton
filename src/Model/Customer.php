<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Twan Haverkamp <twan@mailcampaigns.nl>
 */
class Customer
{
    /**
     * @var string
     */
    public const DATE_OF_BIRTH_FORMAT = 'Y-m-d';

    /**
     * @var string
     */
    public const GENDER_MALE = 'male';

    /**
     * @var string
     */
    public const GENDER_FEMALE = 'female';

    /**
     * @var int
     */
    public const MIN_AGE = 18;

    /**
     * @var int
     */
    public const MAX_AGE = 99;

    /**
     * @Assert\Choice(choices={
     *     Customer::GENDER_MALE,
     *     Customer::GENDER_FEMALE
     * }, message="error.invalid_choice")
     */
    public ?string $gender;

    /**
     * @Assert\Length(min=1, max=50, minMessage="error.invalid_min_length", maxMessage="error.invalid_max_length")
     * @Assert\Regex(pattern="/^([\p{L}]+[\.\-\s]?)+$/", message="error.invalid_pattern")
     */
    public ?string $firstName;

    /**
     * @Assert\Length(min=1, max=50, minMessage="error.invalid_min_length", maxMessage="error.invalid_max_length")
     * @Assert\Regex(pattern="/^([\p{L}]+[\.\-\s]?)+$/", message="error.invalid_pattern")
     */
    public ?string $lastName;

    /**
     * @Assert\Email(message="error.invalid")
     */
    public ?string $emailAddress;

    /**
     * @Assert\Date(message="error.invalid")
     */
    public ?string $dateOfBirth;
}
