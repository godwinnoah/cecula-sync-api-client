<?php

namespace CeculaSyncApiClient;

use JetBrains\PhpStorm\Pure;

class RecipientValidator
{
    protected static int $lengthNigerianMobileNumberWithCountryCode = 13;
    protected static int $lengthNigerianMobileNumberWithoutCountryCode = 11;
    protected static int $minLengthMobileNumber = 7;
    protected static int $maxLengthMobileNumber = 15;

    /**
     * @param string $commaSeperatedNumbers
     * @return bool
     * @throws \Exception
     */
    public function validateAll(string $commaSeperatedNumbers): bool
    {
        if (empty($commaSeperatedNumbers))
        {
            throw new \Exception("Receivers not submitted", 404);
        }

        $numbersList = explode(",", $commaSeperatedNumbers);
        $invalidNumbers = [];

        foreach ($numbersList as $recipient)
        {
            try {
                $x = $this->validate($recipient);
            } catch (\Exception $e)
            {
                array_push($invalidNumbers, $recipient);
            }
        }

        if (count($invalidNumbers) > 0)
        {
            throw new \Exception(sprintf("The following numbers are invalid: %s", implode(",", $invalidNumbers)), 100);
        }
        return true;
    }

    /**
     * @param $receiver
     * @return bool
     * @throws \Exception
     */
    public function validate($receiver): bool
    {
        if (empty($receiver))
        {
            throw new \Exception("Receiver not submitted", 404);
        }

        if (!is_numeric($receiver))
        {
            throw new \Exception(sprintf("%s in not a valid recipient", $receiver), 100);
        }

        //  Finally, Check that number matches internation number requirement
        if ($this->isInvalidMobileNumberLength($receiver))
        {
            throw new \Exception(sprintf("%s in not a valid mobile Number. Number length: %d", $receiver, strlen($receiver)), 100);
        }

        // Rewrite Nigerian Numbers that begin with zero
        $receiver = $this->rewriteNigerianNumberOrReturnDefault($receiver);

        // If number is a Nigerian number, check that it is valid
        if (str_starts_with($receiver, '234') && $this->isInvalidNigerianNumber($receiver))
        {
            throw new \Exception(sprintf("%s in not a valid Nigerian Number", $receiver), 100);
        }

        return true;
    }


    /**
     * @param string $suppliedNumber
     * @return string
     */
    #[Pure] public function rewriteNigerianNumberOrReturnDefault(string $suppliedNumber): string
    {
        $suppliedNumber = str_replace([' ', '-', '.'], '', $suppliedNumber);
        return $this->isShortNigerianNumber($suppliedNumber) ? "234".substr($suppliedNumber, 1) : $suppliedNumber;
    }


    /**
     * @param string $suppliedNumber
     * @return bool
     */
    private function isShortNigerianNumber(string $suppliedNumber): bool
    {
        return in_array(substr($suppliedNumber, 0, 2), ['07', '08', '09']) &&
            strlen($suppliedNumber) === self::$lengthNigerianMobileNumberWithoutCountryCode;
    }


    /**
     * @param string $suppliedNumber
     * @return bool
     */
    #[Pure] public function isInvalidNigerianNumber(string $suppliedNumber): bool
    {
        return strlen($this->rewriteNigerianNumberOrReturnDefault($suppliedNumber)) != self::$lengthNigerianMobileNumberWithCountryCode;
    }

    /**
     *
     */
    public function isInvalidMobileNumberLength(string $suppliedNumber): bool
    {
        return !in_array(strlen($suppliedNumber), range(self::$minLengthMobileNumber, self::$maxLengthMobileNumber));
    }
}