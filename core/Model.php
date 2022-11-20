<?php

namespace app\core;

abstract class Model
{
    public const RULE_REQUIRED = 'required';
    public const RULE_EMAIL = 'email';
    public const RULE_MIN = 'min';
    public const RULE_MAX = 'max';
    public const RULE_MATCH = 'match';

    public array $errors = [];

    public function load_data($data)
    {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    abstract public function rules(): array;

    public function validate()
    {
        foreach ($this->rules() as $attribute => $rules) {
            $value = $this->{$attribute};
            foreach ($rules as $rule) {
                $rule_name = $rule;
                if (!is_string($rule_name)) {
                    $rule_name = $rule[0];
                }
                if ($rule_name === self::RULE_REQUIRED && !$value) {
                    $this->add_error($attribute, self::RULE_REQUIRED);
                }
                if ($rule_name === self::RULE_EMAIL && filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
                    $this->add_error($attribute, self::RULE_EMAIL);
                }
                if ($rule_name === self::RULE_MIN && strlen($value) < $rule['min']) {
                    $this->add_error($attribute, self::RULE_MIN, $rule);
                }
                if ($rule_name === self::RULE_MAX && strlen($value) < $rule['min']) {
                    $this->add_error($attribute, self::RULE_MAX, $rule);
                }
                if ($rule_name === self::RULE_MATCH && $value !== $this->{$rule['match']}) {
                    $this->add_error($attribute, self::RULE_MATCH, $rule);
                }
            }
        }
        return empty($this->errors);
    }

    public function add_error(string $attribute, string $rule,  $params = [])
    {
        $message = $this->error_messages()[$rule] ?? '';
        foreach ($params as $key => $value) {
            $message = str_replace("{{$key}}", $value, $message);
        }
        $this->errors[$attribute][] = $message;
    }

    public function error_messages(): array
    {
        return [
            self::RULE_REQUIRED => 'This field is required',
            self::RULE_EMAIL => 'This field must be a valid email address',
            self::RULE_MIN => 'Min length of this field must be {min}',
            self::RULE_MAX => 'Max length of this field must be {max}',
            self::RULE_MATCH => 'This field must be the same as {match}',
        ];
    }

    public function has_error($attribute)
    {
        return $this->errors[$attribute] ?? false;
    }

    public function get_first_attribute($attribute)
    {
        return $this->errors[$attribute][0] ?? false;
    }
}