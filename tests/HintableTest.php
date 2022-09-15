<?php

namespace NSWDPC\Forms\Tests;

use SilverStripe\Core\Config\Config;
use SilverStripe\Core\Config\Configurable;
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
    protected function setUp() : void
    {
        parent::setUp();
        SSViewer::set_themes(['$public', '$default']);
        Config::inst()->update(
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
    protected function tearDown() : void
    {
        parent::tearDown();
    }

    /**
     * Test FormAction hint match
     */
    public function testFormActionHintable()
    {
        $hint = 'test-hint';
        $field = FormAction::create(
            'doTestFormAction',
            'Test form action'
        )->setHint($hint, false);
        $this->assertEquals($hint, $field->FormFieldHint());
    }

    /**
     * Test CompositeField hint match
     */
    public function testCompositeFieldHintable()
    {
        $hint = 'composite-test-hint';
        $field = CompositeField::create()->setHint($hint, false);
        $this->assertEquals($hint, $field->FormFieldHint());
    }

    /**
     * Test HTMLReadonlyField hint match
     */
    public function testHTMLReadonlyHintable()
    {
        $hint = 'htmlreadonly-test-hint';
        $field = HTMLReadonlyField::create(
            'HTMLReadonlyTestField',
            'Test htmlreadonly field'
        )->setHint($hint, false);
        $this->assertEquals($hint, $field->FormFieldHint());
    }

    /**
     * Test FormAction hint match -with class
     */
    public function testFormActionClassHintable()
    {
        $hint = 'primary-button';
        $field = FormAction::create(
            'doTestFormAction',
            'Test form action with class mapping'
        )->setHint($hint, true);
        $this->assertEquals($hint, $field->FormFieldHint());
        $this->assertTrue($field->hasExtraClass('btn-primary'));
    }



    /**
     * Test FormAction hint icon
     */
    public function testFormActionHintIcon()
    {
        $ligature = 'hamburger';
        $hint = 'hungry';
        $field = FormAction::create(
            'doTestFormAction',
            'Test form action with class mapping'
        )->setHint($hint)->setHintIcon($ligature);
        $this->assertEquals($hint, $field->FormFieldHint());
        $this->assertEquals($ligature, $field->FormFieldHintIcon());
    }
}
