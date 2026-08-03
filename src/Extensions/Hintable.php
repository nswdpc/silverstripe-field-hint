<?php

namespace NSWPDC\FieldHint\Extensions;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\FormField;

/**
 * Applies hints to {@link Silverstripe\Form\FormField} that have this extension configured
 * @author James
 * @extends \SilverStripe\Core\Extension<((\SilverStripe\Forms\CompositeField & static) | (\SilverStripe\Forms\FormAction & static) | (\SilverStripe\Forms\HTMLReadonlyField & static))>
 */
class Hintable extends Extension
{
    /**
     * Add a hint to a form field
     */
    public function setHint(string $hint, bool $isClass = false): FormField
    {
        if ($hint === '') {
            throw new \InvalidArgumentException("Cannot supply an empty hint");
        }

        $formField = $this->getOwner();
        $formField->formFieldHint = $hint;
        if ($isClass) {
            $mapping = $formField->config()->get('hint_class_mapping');
            if (!empty($mapping) && is_array($mapping) && !empty($mapping[ $hint ])) {
                $formField->addExtraClass(trim(strval($mapping[ $hint ])));
            }
        }

        return $formField;
    }

    /**
     * Add a hint icon to a form field, an icon can be a CSS class, font ligature or ...
     * Your theme template should handle how the icon is used
     */
    public function setHintIcon(string $hintIcon): FormField
    {
        $formField = $this->getOwner();
        $formField->formFieldHintIcon = $hintIcon;
        return $formField;
    }

    /**
     * Return the hint for use in templates
     */
    public function FormFieldHint(): string
    {
        $formField = $this->getOwner();
        if ($formField->formFieldHint) {
            return $formField->formFieldHint;
        } else {
            return '';
        }
    }

    /**
     * Return the hint icon for use in templates
     */
    public function FormFieldHintIcon(): string
    {
        $formField = $this->getOwner();
        if ($formField->formFieldHintIcon) {
            return $formField->formFieldHintIcon;
        } else {
            return '';
        }
    }
}
