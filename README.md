# Field hinting for Silverstripe forms

This module allows developers to add usage hints to form fields. Hints are just arbitrary string values.

The hints can be used by themes and templates in a project to render the field in a specific way, to be interpreted by whatever frontend UI-kit is in use for your site.

This avoids polluting module PHP code with theme-specific CSS classes.

Instead of this: `$field->addExtraClass('btn btn-danger')`

...do this `$field->setHint('danger', true)`.

In your project configuration:
```yml
---
Name: 'app-field-hint'
After:
  - '#nswdpc-field-hint'
---
# add hint/class mapping
SilverStripe\Forms\FormAction:
  hint_class_mapping:
    # setting a hint of 'danger' adds this class
    # when the second parameter is true
    danger: 'btn btn-danger'
```

## Default fields

Out-of-the-box the following fields are configured to support the `Hintable` extension:

+ `FormAction` - for action priorities
+ `CompositeField` - to assist in rendering child fields in a certain way
+ `HTMLReadonlyField` - to display the value and title in a specific way

No changes are made to the field itself, the extension just exposes some methods on the field to use in module code.

## Form fields

Set field hints on your form fields:

```php
<?php
/**
 * Add a hint that the action is a 'secondary' button/input
 * This will set an attribute data-hint with the value 'secondary'
 */
\SilverStripe\Forms\FormAction::create(
    'doSecondary',
    _t('some.i18n_key', 'Complete secondary action')
)->setHint('secondary');

/**
 * Add a hint as above, and also add any class mapped to the 'secondary' hint in config
 * (See Sample project configuration, below)
 */
\SilverStripe\Forms\FormAction::create(
    'doSecondary',
    _t('some.i18n_key', 'Complete secondary action')
)->setHint('secondary', true);
```

The first parameter to setHint is a string, it can be any value that a template can use via the `$FormFieldHint` template variable.

The second parameter to setHint is a boolean, when true CSS class(es) mapped to the hint value is added, if available in configuration. See below for an example.

### Templates

Use the value of `$FormFieldHint` to modify how your theme/project templates render the field.

Here's an example using the `HTMLReadonlyField` holder template and the hints 'callout' and 'alert':

```html
<%-- path: themes/my-theme/templates/SilverStripe/Forms/HTMLReadonlyField_holder.ss --%>
<% if $FormFieldHint == 'callout' %>
    <%-- render as callout --%>
    <div class="my-callout">
        <% if $FormFieldHintIcon %>
            <span class="icon">{$FormFieldHintIcon}</span>
        <% end_if %>
        <div class="content">
            <% if $Title %>
            <h4>{$Title.XML}</h4>
            <% end_if %>
            {$Value}
        </div>
    </div>
<% else_if $FormFieldHint == 'alert' %>
    <%-- render an alert message --%>
<% else %>
    <%-- Important: allow for default rendering if no hint supplied --%>
    {$Field}
<% end_if %>
```

### Icons

Set a field hint icon of 'delete' on a supporting field. This will also set an attribute `data-hint-icon` with the value `delete`.

```php
<?php
\SilverStripe\Forms\FormAction::create(
    'doSecondary',
    _t('some.i18n_key', 'Complete secondary action')
)->setHint('secondary', true)
->setHintIcon('delete');
```

```html
<%-- theme template: SilverStripe/Forms/FormAction.ss --%>
<% if $UseButtonTag %>
    <button {$AttributesHTML}>
        <% if $FormFieldHintIcon %>
        <span class="material-icons-outlined">{$FormFieldHintIcon}</span>
        <% end_if %>
        <% if $ButtonContent %>{$ButtonContent}<% else %><span>{$Title}</span><% end_if %>
    </button>
<% else %>
	<input {$AttributesHTML}>
<% end_if %>
```

## Configuration

There is none, unless:

+ you want to add the `Hintable` extension to another field.
+ you need to add hint -> CSS class mapping

### Sample project configuration

```yaml
---
Name: 'app-field-hint'
After:
  - '#nswdpc-field-hint'
---
# your project requires TextField to be hintable
SilverStripe\Forms\TextField:
  extensions:
    - 'NSWPDC\FieldHint\Extensions\Hintable'
# add hint/class mapping to form actions
SilverStripe\Forms\FormAction:
  hint_class_mapping:
    # a hint of danger sets these classes from the NSW Design System
    danger: 'nsw-button nsw-button--danger'
    # a hint of secondary applies the "Brand Dark Outline Solid" style
    secondary: 'nsw-button nsw-button--dark-outline-solid'
```

Code:

```php
<?php
\SilverStripe\Forms\FormAction::create(
    'doDangerousAction',
    _t('some.dangerous_i18n_key', 'Complete dangerous action')
)->setHint('danger', true);

\SilverStripe\Forms\FormAction::create(
    'doSecondaryAction',
    _t('some.secondary_i18n_key', 'Start something else')
)->setHint('secondary', true);
```

HTML rendered in the template:
```html
<input type="submit" name="action_doDangerousAction" value="Dangerous Action" class="action nsw-button nsw-button--danger" id="some_form_id">
```

CSS classes are added as extra classes, which by default in Silverstripe are added to both the field holder and the field input element. Your templates should take that into account.

## Templating

Custom themes may need to be updated to support `$FormFieldHint` and `$FormFieldHintIcon`. [Read: template inheritance](https://docs.silverstripe.org/en/6/developer_guides/templates/template_inheritance/).

## Installation

The only supported way of installing this module is via [composer](https://getcomposer.org/download/)

```sh
composer require nswdpc/silverstripe-field-hint
```

You may need to add a repositories entry to you composer.json, depending on packagist status.

## License

[BSD-3-Clause](./LICENSE.md)

## Configuration

See `_config/config.yml`

## Maintainers

+ PD Web Team

## Bugtracker

We welcome bug reports, pull requests and feature requests on the Github Issue tracker for this project.

Please review the [code of conduct](./code-of-conduct.md) prior to opening a new issue.

## Security

If you have found a security issue with this module, please email digital[@]dpc.nsw.gov.au in the first instance, detailing your findings.

## Development and contribution

If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.

Please review the [code of conduct](./code-of-conduct.md) prior to completing a pull request.
