<?php

$lowerLetters = 'abcdefghijklmnopqrstuvwxyz';
$symbols = '!@#$%^&*(){}":?><|';
$lettersLen = strlen($lowerLetters);

/**
 * <p>Validates the input field that removes extra spaces, slashes and special characters</p>
 * @param string $fieldValue the value of the input field coming from the html inputs
 * @return string the validated and sanitized string ready to be used and inserted into databae
 */
function validateField(string $fieldValue): string {
    $fieldValue = trim($fieldValue);
    $fieldValue = stripslashes($fieldValue);
    return htmlspecialchars($fieldValue);
}

/**
 * <p>generates the random string of certain length with given parameters. Only alphabets are included</p>
 *
 * @param int $length the length of the variable
 * @param int $case the 0 and other integers, 0 for lowercase, and others for uppercasse, default is 0
 * @return string the generated random string without having the special characters
 * @throws Exception random_int() throws the exception when generating random number
 */
function getRandomStr(int $length = 10, int $case = 0): string {
    global $lowerLetters;
    global $lettersLen;
    $length = abs($length);
    $masterString = '';
    if ($case === 0) {
        for ($i = 0; $i < $length; $i++) {
            $masterString .= $lowerLetters[random_int(0, $lettersLen - 1)];
        }
    } else {
        $upperCaseLetters = strtoupper($lowerLetters);
        for ($i = 0; $i < $length; $i++) {
            $masterString .= $upperCaseLetters[random_int(0, $lettersLen - 1)];
        }
    }
    return $masterString;
}




