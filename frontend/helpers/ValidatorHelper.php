<?php

namespace frontend\helpers;

use yii\base\Model;
use yii\validators\BooleanValidator;
use yii\validators\CompareValidator;
use yii\validators\EmailValidator;
use yii\validators\NumberValidator;
use yii\validators\RangeValidator;
use yii\validators\RegularExpressionValidator;
use yii\validators\RequiredValidator;
use yii\validators\StringValidator;
use yii\validators\UrlValidator;

class ValidatorHelper
{
    /**
     * Legge le rules() del model per un attributo
     * e restituisce un array di attributi data-* da passare all'input.
     *
     * @param Model  $model
     * @param string $attribute
     * @return array
     */
    public static function attributes(Model $model, string $attribute): array
    {
        $data = [];

        foreach ($model->getActiveValidators($attribute) as $validator) {

            // required
            if ($validator instanceof RequiredValidator) {
                $data['data-required'] = 'true';
            }

            // string — min/max length
            if ($validator instanceof StringValidator) {
                if ($validator->min !== null) {
                    $data['data-min-length'] = (string) $validator->min;
                }
                if ($validator->max !== null) {
                    $data['data-max-length'] = (string) $validator->max;
                }
            }

            // email
            if ($validator instanceof EmailValidator) {
                $data['data-type'] = 'email';
            }

            // url
            if ($validator instanceof UrlValidator) {
                $data['data-type'] = 'url';
            }

            // number / integer
            if ($validator instanceof NumberValidator) {
                $data['data-type'] = $validator->integerOnly ? 'integer' : 'number';
                if ($validator->min !== null) {
                    $data['data-min'] = (string) $validator->min;
                }
                if ($validator->max !== null) {
                    $data['data-max'] = (string) $validator->max;
                }
            }

            // boolean (checkbox)
            if ($validator instanceof BooleanValidator) {
                $data['data-type'] = 'boolean';
            }

            // range (select/radio)
            if ($validator instanceof RangeValidator) {
                $data['data-range'] = implode(',', $validator->range);
            }

            // match (regex)
            if ($validator instanceof RegularExpressionValidator) {
                $pattern = $validator->pattern;
                if (preg_match('/^(.)(.*)\1[a-z]*$/i', $pattern, $m)) {
                    $pattern = $m[2];
                }
                $data['data-pattern'] = $pattern;
            }

            // compare
            if ($validator instanceof CompareValidator) {
                $compareAttr = $validator->compareAttribute
                    ?? ($attribute . '_repeat');
                $compareId = \yii\helpers\Html::getInputId($model, $compareAttr);
                $data['data-compare'] = '#' . $compareId;
            }
        }

        return $data;
    }
}
