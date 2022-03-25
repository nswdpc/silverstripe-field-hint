<?php

namespace NSWPDC\Forms;

use SilverStripe\Core\Extension;
use Silverstripe\View\ViewableData;

/**
 * Applies hints to {@link Silverstripe\Form\FormField} that have this extension configured
 * @author James
 */
class Hintable extends Extension {

    /**
     * Add a hint to a form field
     * @param string $hint eg. 'secondary'
     * @param bool $isClass
     * @return self
     */
    public function setHint(string $hint, bool $isClass = false) : ViewableData {
        if($hint == '') {
            throw new \Exception("Cannot supply an empty hint");
        }
        $this->owner->formFieldHint = $hint;
        if($isClass) {
            $mapping = $this->owner->config()->get('hint_class_mapping');
            if(!empty($mapping) && is_array($mapping)) {
                if(!empty($mapping[ $hint ])) {
                    $this->owner->addExtraClass( trim(strval($mapping[ $hint ])) );
                }
            }
        }
        return $this->owner;
    }

    /**
     * Add a hint icon to a form field, an icon can be a CSS class, font ligature or ...
     * Your theme template should handle how the icon is used
     * @param string $hintIcon
     * @return self
     */
    public function setHintIcon(string $hintIcon) : ViewableData {
        $this->owner->formFieldHintIcon = $hintIcon;
        return $this->owner;
    }

    /**
    * Return the hint for use in templates
     * @return string
     */
    public function FormFieldHint() : string {
        if($this->owner->formFieldHint) {
            return $this->owner->formFieldHint;
        } else {
            return '';
        }
    }

    /**
    * Return the hint icon for use in templates
     * @return string
     */
    public function FormFieldHintIcon() : string {
        if($this->owner->formFieldHintIcon) {
            return $this->owner->formFieldHintIcon;
        } else {
            return '';
        }
    }
}
