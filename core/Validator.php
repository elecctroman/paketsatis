<?php

namespace Core;

class Validator
{
    private array $data;
    private array $rules;
    private array $errors = [];

    public function __construct(array $data, array $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    public function fails(): bool
    {
        $this->errors = [];
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;
            foreach (explode('|', $rules) as $rule) {
                $params = [];
                if (str_contains($rule, ':')) {
                    [$rule, $param] = explode(':', $rule, 2);
                    $params = explode(',', $param);
                }
                $method = 'validate' . ucfirst($rule);
                if (!method_exists($this, $method)) {
                    continue;
                }
                if (!$this->$method($field, $value, $params)) {
                    $this->errors[$field][] = $rule;
                }
            }
        }
        return !empty($this->errors);
    }

    public function errors(): array
    {
        return $this->errors;
    }

    private function validateRequired(string $field, $value): bool
    {
        return !($value === null || $value === '' || (is_array($value) && empty($value)));
    }

    private function validateEmail(string $field, $value): bool
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    private function validateMin(string $field, $value, array $params): bool
    {
        $min = (int) ($params[0] ?? 0);
        if (is_numeric($value)) {
            return (float) $value >= $min;
        }
        return mb_strlen((string) $value) >= $min;
    }

    private function validateMax(string $field, $value, array $params): bool
    {
        $max = (int) ($params[0] ?? PHP_INT_MAX);
        if (is_numeric($value)) {
            return (float) $value <= $max;
        }
        return mb_strlen((string) $value) <= $max;
    }

    private function validateNumeric(string $field, $value): bool
    {
        return is_numeric($value);
    }

    private function validateBetween(string $field, $value, array $params): bool
    {
        $min = (int) ($params[0] ?? 0);
        $max = (int) ($params[1] ?? PHP_INT_MAX);
        return $value >= $min && $value <= $max;
    }

    private function validateIn(string $field, $value, array $params): bool
    {
        return in_array($value, $params, true);
    }

    private function validateRegex(string $field, $value, array $params): bool
    {
        $pattern = $params[0] ?? '';
        return (bool) preg_match($pattern, (string) $value);
    }
}
