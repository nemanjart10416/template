<?php

/**
 *
 */
class Validator {
    /**
     * @var array
     */
    protected array $data = [];
    /**
     * @var array
     */
    protected array $rules = [];
    /**
     * @var array
     */
    protected array $errors = [];

    /**
     * @param array $data
     * @param array $rules
     */
    public function __construct(array $data, array $rules) {
        $this->data = $data;
        $this->rules = $rules;
    }

    /**
     * @return bool
     */
    public function validate(): bool {
        foreach ($this->rules as $field => $rule) {
            $rules = explode('|', $rule);

            foreach ($rules as $singleRule) {
                $this->applyRule($field, $singleRule);
            }
        }

        return empty($this->errors);
    }

    /**
     * @param string $field
     * @param string $rule
     * @return void
     */
    protected function applyRule(string $field, string $rule): void {
        $parts = explode(':', $rule);
        $ruleName = $parts[0];
        $ruleValue = isset($parts[1]) ? $parts[1] : null;

        if ($ruleName === 'required') { //OK
            if (empty($this->data[$field])) {
                $this->addError($field, 'Field is required.');
            }
        } elseif ($ruleName === 'min') { //OK
            /* Required: Ensures that a field must be provided and not empty. */
            if (isset($this->data[$field]) && strlen($this->data[$field]) < $ruleValue) {
                $this->addError($field, "Field must be at least $ruleValue characters.");
            }
        }elseif ($ruleName === 'max') { //OK
            /* Max Length: Requires a field's value to have a maximum length. */
            if (isset($this->data[$field]) && strlen($this->data[$field]) > $ruleValue) {
                $this->addError($field, "Field must not exceed $ruleValue characters.");
            }
        } elseif ($ruleName === 'email') { //OK
            /* Email: Validates that a field's value is a valid email address. */
            if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                $this->addError($field, 'Invalid email format.');
            }
        } elseif ($ruleName === 'numeric') { //OK
            /* Numeric: Validates that a field's value is a number. */
            if (!is_numeric($this->data[$field])) {
                $this->addError($field, 'Field must be numeric.');
            }
        } elseif ($ruleName === 'integer') { //OK
            /* Integer: Validates that a field's value is an integer. */
            if (!filter_var($this->data[$field], FILTER_VALIDATE_INT)) {
                $this->addError($field, 'Field must be an integer.');
            }
        } elseif ($ruleName === 'url') { // OK
            /* URL: Validates that a field's value is a valid URL. */
            if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_URL)) {
                $this->addError($field, 'Invalid URL format.');
            }
        } elseif ($ruleName === 'date') { //OK
            /* Date: Validates that a field's value is a valid date. */
            if (isset($this->data[$field]) && !strtotime($this->data[$field])) {
                $this->addError($field, 'Invalid date format.');
            }
        } elseif ($ruleName === 'alpha') { //OK
            /* Alpha: Validates that a field's value contains only letters. */
            if (isset($this->data[$field]) && !ctype_alpha($this->data[$field])) {
                $this->addError($field, 'Field must contain only letters.');
            }
        } elseif ($ruleName === 'alpha_numeric') {//OK
            /* Alpha-Numeric: Validates that a field's value contains only letters and numbers. */
            if (isset($this->data[$field]) && !ctype_alnum($this->data[$field])) {
                $this->addError($field, 'Field must contain only letters and numbers.');
            }
        } elseif ($ruleName === 'regex') {//TODO
            /* Regex: Validates a field's value using a regular expression pattern. */
            if (isset($this->data[$field]) && !preg_match($ruleValue, $this->data[$field])) {
                $this->addError($field, 'Field format is invalid.');
            }
        } elseif ($ruleName === 'unique') {//TODO
            /* Unique: Validates that a field's value is unique within a database table. */
            /*if (isset($this->data[$field]) && $this->isUnique($field, $this->data[$field], $ruleValue)) {
                $this->addError($field, 'Field value must be unique.');
            }*/
        } elseif ($ruleName === 'in') {//OK
            /* In: Validates that a field's value is in a predefined list of values. */
            if (isset($this->data[$field]) && !in_array($this->data[$field], explode(',', $ruleValue))) {
                $this->addError($field, 'Invalid selection.');
            }
        } elseif ($ruleName === 'not_in') {//OK
            /* Not In: Validates that a field's value is not in a predefined list of values. */
            if (isset($this->data[$field]) && in_array($this->data[$field], explode(',', $ruleValue))) {
                $this->addError($field, 'Invalid selection.');
            }
        } elseif ($ruleName === 'confirmed') {//TODO
            /* Confirmed: Validates that a field's value matches a confirmation field (e.g., password confirmation). */
            $confirmedField = "{$field}_confirmation";
            if (isset($this->data[$field]) && isset($this->data[$confirmedField]) && $this->data[$field] !== $this->data[$confirmedField]) {
                $this->addError($field, 'Confirmation does not match.');
            }
        } elseif ($ruleName === 'date_format') {//TODO
            /* Date Format: Validates that a field's value matches a specific date format. */
            if (isset($this->data[$field]) && !DateTime::createFromFormat($ruleValue, $this->data[$field])) {
                $this->addError($field, 'Invalid date format.');
            }
        }elseif ($ruleName === 'phone_number') { // phone_number
            /* Phone Number: Validates that a field's value is a valid phone number. */
            if (isset($this->data[$field])) {
                $phoneNumber = $this->data[$field];
                // Define a regular expression pattern for a valid phone number
                $pattern = '/^(?:\+?\d{1,3}[-.●]?)?\(?(?:\d{2,3})?\)?[-.●]?\d{3,4}[-.●]?\d{4}$/';

                if (!preg_match($pattern, $phoneNumber)) {
                    $this->addError($field, 'Invalid phone number format.');
                }
            }
        }elseif ($ruleName === 'birthday') { // birthday:18
            /* Birthday: Validates that a field's value is a valid date of birth, in the past, and the person is at least the specified age. */
            if (isset($this->data[$field])) {
                $birthday = $this->data[$field];

                // Check if the birthday is a valid date
                if (!strtotime($birthday)) {
                    $this->addError($field, 'Invalid date format for birthday.');
                } else {
                    // Calculate age based on the provided birthday
                    $birthdate = new DateTime($birthday);
                    $currentDate = new DateTime();
                    $age = $currentDate->diff($birthdate)->y;

                    // Check if the birthday is in the past
                    if ($birthdate > $currentDate) {
                        $this->addError($field, 'Birthday must be in the past.');
                    }

                    // Check if the age is less than the required minimum age
                    $requiredAge = isset($ruleValue) ? intval($ruleValue) : 18;
                    if ($age < $requiredAge) {
                        $this->addError($field, "Must be at least $requiredAge years old.");
                    }
                }
            }
        }elseif ($ruleName === 'pib_format' || $ruleName === 'id_card_num') {
            /* PIB Format: Validates that a PIB (Personal Identification Number) consists of only numbers and is 9 digits long. */
            /* ID card number: Validates that a card number consists of only numbers and is 9 digits long. */
            if (isset($this->data[$field])) {
                $pib = $this->data[$field];

                if (!ctype_digit($pib) || strlen($pib) !== 9) {
                    $this->addError($field, 'Field must consist of 9 digits.');
                }
            }
        }elseif ($ruleName === 'jmbg_format') {
            /* PIB Format: Validates that a PIB (Personal Identification Number) consists of only numbers and is 9 digits long. */
            /* ID card number: Validates that a card number consists of only numbers and is 9 digits long. */
            if (isset($this->data[$field])) {
                $pib = $this->data[$field];

                if (!ctype_digit($pib) || strlen($pib) !== 13) {
                    $this->addError($field, 'Field must consist of 13 digits.');
                }
            }
        } elseif ($ruleName === 'mb_format') {
            /* MB Format: Validates that a company registration number (MB) consists of only numbers and is 8 digits long. */
            if (isset($this->data[$field])) {
                $mb = $this->data[$field];

                if (!ctype_digit($mb) || strlen($mb) !== 8) {
                    $this->addError($field, 'Field must consist of 8 digits.');
                }
            }
        }

        // Add more rule implementations here
    }

    /**
     * @param string $field
     * @param string $message
     * @return void
     */
    protected function addError(string $field, string $message): void {
        $this->errors[$field][] = $message;
    }

    /**
     * @return array
     */
    public function getErrors(): array {
        return $this->errors;
    }
}