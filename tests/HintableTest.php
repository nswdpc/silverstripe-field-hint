<?php

namespace NSWDPC\FieldHint\Tests;

use SilverStripe\Core\Config\Config;
use SilverStripe\Dev\SapphireTest;
use SilverStripe\Forms\CompositeField;
use SilverStripe\Forms\FormAction;
use SilverStripe\Forms\HTMLReadonlyField;
use SilverStripe\View\SSViewer;

/**
 * Unit tests for Hintable extension
 * @author James
 */
class HintableTest extends SapphireTest
{
    /**
     * Set up for tests
     */
    #[\Override]
    protected function setUp(): void
    {
        parent::setUp();
        SSViewer::set_themes(['$public', '$default']);
        Config::modify()->set(
            FormAction::class,
            'hint_class_mapping',
            [
                'primary-button' => 'btn-primary'
            ]
        );
    }

    /**
     * Tear down for tests
     */
    #[\Override]
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /**
     * Test FormAction hint match
     */
    public function testFormActionHintable(): void
    {
        $hint = 'test-hint';
        $field = FormAction::create(
            'doTestFormAction',
            'Test form action'
        );
        $field->setHint($hint, false);
        $this->assertEquals($hint, $field->FormFieldHint());
    }

    /**
     * Test CompositeField hint match
     */
    public function testCompositeFieldHintable(): void
    {
        $hint = 'composite-test-hint';
        $field = CompositeField::create();
        $field->setHint($hint, false);
        $this->assertEquals($hint, $field->FormFieldHint());
    }

    /**
     * Test HTMLReadonlyField hint match
     */
    public function testHTMLReadonlyHintable(): void
    {
        $hint = 'htmlreadonly-test-hint';
        $field = HTMLReadonlyField::create(
            'HTMLReadonlyTestField',
            'Test htmlreadonly field'
        );
        $field->setHint($hint, false);
        $this->assertEquals($hint, $field->FormFieldHint());
    }

    /**
     * Test FormAction hint match -with class
     */
    public function testFormActionClassHintable(): void
    {
        $hint = 'primary-button';
        $field = FormAction::create(
            'doTestFormAction',
            'Test form action with class mapping'
        );
        $field->setHint($hint, true);
        $this->assertEquals($hint, $field->FormFieldHint());
        $this->assertTrue($field->hasExtraClass('btn-primary'));
    }



    /**
     * Test FormAction hint icon
     */
    public function testFormActionHintIcon(): void
    {
        $ligature = 'hamburger';
        $hint = 'hungry';
        $field = FormAction::create(
            'doTestFormAction',
            'Test form action with class mapping'
        );
        $field->setHint($hint);
        $field->setHintIcon($ligature);
        $this->assertEquals($hint, $field->FormFieldHint());
        $this->assertEquals($ligature, $field->FormFieldHintIcon());
    }
}
