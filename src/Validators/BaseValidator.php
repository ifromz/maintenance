<?php

namespace Stevebauman\Maintenance\Validators;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Input;
use Stevebauman\CoreHelper\Validators\AbstractValidator;

class BaseValidator extends AbstractValidator
{
    /**
     * Holds the input to be passed to the validator
     *
     * @var array
     */
    protected $input;

    /**
     * Holds the error messages of the current request
     *
     * @var \Illuminate\Support\MessageBag
     */
    protected $errors;

    /**
     * Holds the rules for the validator
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Holds the current validator object
     *
     * @var \Illuminate\Validation\Validator
     */
    protected $validator;

    /**
     * Constructor.
     *
     * @param array $input
     */
    public function __construct($input = [])
    {
        if(count($input) > 0)
        {
            $this->setInput($input);
        } else
        {
            $this->setInput(Input::all());
        }
    }

    /**
     * Allows rules to be set on the fly if needed
     *
     * @param array $rules
     *
     * @return $this
     */
    public function setRules(array $rules = [])
    {
        $this->rules = $rules;

        return $this;
    }

    /**
     * Sets the input property
     *
     * @param array $input
     *
     * @return $this
     */
    public function setInput(array $input = [])
    {
        $this->input = $input;

        return $this;
    }

    /**
     * Sets the errors property.
     *
     * @param array|\Illuminate\Support\MessageBag $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Sets the validator property.
     *
     * @param \Illuminate\Validation\Validator $validator
     */
    public function setValidator(\Illuminate\Validation\Validator $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Returns the current validator object and creates a new validator
     * instance if it does not exist
     *
     * @return \Illuminate\Validation\Validator
     */
    public function validator()
    {
        if (!$this->validator)
        {
            $validator = Validator::make($this->input, $this->rules);

            $this->setValidator($validator);
        }

        return $this->validator;
    }

    /**
     * Quick helper for validating input. Returns boolean on success/failure
     *
     * @return bool
     */
    public function passes()
    {
        $validator = $this->validator();

        if ($validator->passes()) return true;

        $this->setErrors($validator->messages());

        return false;
    }

    /**
     * Returns errors from the validator. This will return only messages
     * if the request is from ajax.
     *
     * @return array|\Illuminate\Support\MessageBag
     */
    public function getErrors()
    {
        if (Request::ajax())
        {
            return $this->errors->getMessages();
        } else {
            return $this->errors;
        }
    }

    /**
     * Adds an ignore validation to be able to dynamically ignore a specific
     * table value
     *
     * @param string $field
     * @param string $table
     * @param string $column
     * @param string $value
     */
    public function ignore($field, $table, $column, $value = 'NULL')
    {
        $this->rules[$field] .= sprintf('|unique:%s,%s,%s', $table, $column, $value);
    }

    /**
     * Adds a unique validation to the specified field
     *
     * @param string $field
     * @param string $table
     * @param string $column
     * @param NULL $ignore
     */
    public function unique($field, $table, $column, $ignore = null)
    {
        if(array_key_exists($field, $this->rules))
        {
            if($ignore)
            {
                $this->ignore($field, $table, $column, $ignore);
            } else
            {
                $this->rules[$field] .= sprintf('|unique:%s,%s', $table, $column);
            }
        }
    }

    /**
     * Allows dynamic adding of rules to a field under validation
     *
     * @param string $field
     * @param string $rule
     */
    public function addRule($field, $rule)
    {
        if (array_key_exists($field, $this->rules))
        {
            $this->rules[$field] .= sprintf('|%s', $rule);
        } else
        {
            $this->rules[$field] = $rule;
        }
    }

    /**
     * Allows dynamic removal of rules to a field under validation
     *
     * @param $field
     * @param $rule
     */
    public function removeRule($field, $rule)
    {
        if (array_key_exists($field, $this->rules))
        {
            $newRule = str_replace($rule, '', $this->rules[$field]);

            $this->rules[$field] = $newRule;
        }
    }
}
