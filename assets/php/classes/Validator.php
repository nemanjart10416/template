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
     * @return void
     */
    public static function usage_example() {
        $data = [
            'title' => '',
            'body' => '',
            'name' => 'John Doe',
            'email' => 'invalidemail',
            'age' => '30',
            'website' => 'https://example.com',
            'date' => '2023-08-12',
            'alphaField' => 'abcd',
            'alphaNumericField' => '123abc',
            'regexField' => 'ABC123',
            'uniqueField' => 'unique@example.com',
            'inField' => 'option1',
            'notInField' => 'option3',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'customDate' => '2023-08-12',
        ];

        $rules = [
            'title' => 'required|min10|max:255',
            'body' => 'required|min:10|max:500',
            'name' => 'required|min:3|max:50',
            'email' => 'required|email',
            'age' => 'numeric',
            'website' => 'url',
            'date' => 'date',
            'alphaField' => 'alpha',
            'alphaNumericField' => 'alpha_numeric',
            'regexField' => 'regex:/^[A-Z0-9]+$/',
            'uniqueField' => 'unique:users,email',
            'inField' => 'in:option1,option2,option3',
            'notInField' => 'not_in:option1,option2',
            'password' => 'required|confirmed|min:8',
            'customDate' => 'date_format:Y-m-d',
        ];

        $validator = new Validator($data, $rules);

        if ($validator->validate()) {
            echo "Validation successful.";
        } else {
            $errors = $validator->getErrors();

            foreach ($errors as $field => $fieldErrors) {
                foreach ($fieldErrors as $error) {
                    echo Message::danger("Error in $field: $error");
                }
            }
        }
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

        if ($ruleName === 'required') {
            if (empty($this->data[$field])) {
                $this->addError($field, 'Field is required.');
            }
        } elseif ($ruleName === 'min') {
            /* Required: Ensures that a field must be provided and not empty. */
            if (isset($this->data[$field]) && strlen($this->data[$field]) < $ruleValue) {
                $this->addError($field, "Field must be at least $ruleValue characters.");
            }
        } elseif ($ruleName === 'min') {
            /* Min Length: Requires a field's value to have a minimum length. */
            if (isset($this->data[$field]) && strlen($this->data[$field]) < $ruleValue) {
                $this->addError($field, "Field must be at least {$ruleValue} characters.");
            }
        } elseif ($ruleName === 'max') {
            /* Max Length: Requires a field's value to have a maximum length. */
            if (isset($this->data[$field]) && strlen($this->data[$field]) > $ruleValue) {
                $this->addError($field, "Field must not exceed $ruleValue characters.");
            }
        } elseif ($ruleName === 'email') {
            /* Email: Validates that a field's value is a valid email address. */
            if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_EMAIL)) {
                $this->addError($field, 'Invalid email format.');
            }
        } elseif ($ruleName === 'numeric') {
            /* Numeric: Validates that a field's value is a number. */
            if (!is_numeric($this->data[$field])) {
                $this->addError($field, 'Field must be numeric.');
            }
        } elseif ($ruleName === 'integer') {
            /* Integer: Validates that a field's value is an integer. */
            if (!filter_var($this->data[$field], FILTER_VALIDATE_INT)) {
                $this->addError($field, 'Field must be an integer.');
            }
        } elseif ($ruleName === 'url') {
            /* URL: Validates that a field's value is a valid URL. */
            if (isset($this->data[$field]) && !filter_var($this->data[$field], FILTER_VALIDATE_URL)) {
                $this->addError($field, 'Invalid URL format.');
            }
        } elseif ($ruleName === 'date') {
            /* Date: Validates that a field's value is a valid date. */
            if (isset($this->data[$field]) && !strtotime($this->data[$field])) {
                $this->addError($field, 'Invalid date format.');
            }
        } elseif ($ruleName === 'alpha') {
            /* Alpha: Validates that a field's value contains only letters. */
            if (isset($this->data[$field]) && !ctype_alpha($this->data[$field])) {
                $this->addError($field, 'Field must contain only letters.');
            }
        } elseif ($ruleName === 'alpha_numeric') {
            /* Alpha-Numeric: Validates that a field's value contains only letters and numbers. */
            if (isset($this->data[$field]) && !ctype_alnum($this->data[$field])) {
                $this->addError($field, 'Field must contain only letters and numbers.');
            }
        } elseif ($ruleName === 'regex') {
            /* Regex: Validates a field's value using a regular expression pattern. */
            if (isset($this->data[$field]) && !preg_match($ruleValue, $this->data[$field])) {
                $this->addError($field, 'Field format is invalid.');
            }
        } elseif ($ruleName === 'unique') {
            /* Unique: Validates that a field's value is unique within a database table. */
            /*if (isset($this->data[$field]) && $this->isUnique($field, $this->data[$field], $ruleValue)) {
                $this->addError($field, 'Field value must be unique.');
            }*/
        } elseif ($ruleName === 'in') {
            /* In: Validates that a field's value is in a predefined list of values. */
            if (isset($this->data[$field]) && !in_array($this->data[$field], explode(',', $ruleValue))) {
                $this->addError($field, 'Invalid selection.');
            }
        } elseif ($ruleName === 'not_in') {
            /* Not In: Validates that a field's value is not in a predefined list of values. */
            if (isset($this->data[$field]) && in_array($this->data[$field], explode(',', $ruleValue))) {
                $this->addError($field, 'Invalid selection.');
            }
        } elseif ($ruleName === 'confirmed') {
            /* Confirmed: Validates that a field's value matches a confirmation field (e.g., password confirmation). */
            $confirmedField = "{$field}_confirmation";
            if (isset($this->data[$field]) && isset($this->data[$confirmedField]) && $this->data[$field] !== $this->data[$confirmedField]) {
                $this->addError($field, 'Confirmation does not match.');
            }
        } elseif ($ruleName === 'date_format') {
            /* Date Format: Validates that a field's value matches a specific date format. */
            if (isset($this->data[$field]) && !DateTime::createFromFormat($ruleValue, $this->data[$field])) {
                $this->addError($field, 'Invalid date format.');
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