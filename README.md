# Field hinting for Silverstripe forms

This module allows developers to add usage hints to form fields. Hints are just arbitrary string values.

The hints can be used by themes and templates in a project to render the field in a specific way, to be interpreted by whatever frontend UI-kit is in use for your site.

This avoids polluting module PHP code with theme-specific CSS classes.

Instead of this `$field->addExtraClass('btn btn-danger')`, do this `$field->setHint('danger')`.

## Default fields

Out-of-the-box the following fields are configured to support the `Hintable` extension:

+ `FormAction` - for action priorities
+ `CompositeField` - to assist in rendering child fields in a certain way
+ `HTMLReadonlyField` - to display the value and title in a specific way

No changes are made to the field itself, the extension just exposes some methods on the field to use in module code.

## Usage

**Important**: In your theme or project, you need to provide a template that is used by the class using the Hintable extension. [Read: template inheritance](https://docs.silverstripe.org/en/4/developer_guides/templates/template_inheritance/).

### Forms

Set field hints on your forms:

```php
<?php
use SilverStripe\Forms\FormAction;

//...

FormAction::create(
    'doSecondary',
    _t('some.i18n_key', 'Complete secondary action')
)->setHint('secondary');

FormAction::create(
    'doSecondary',
    _t('some.i18n_key', 'Complete secondary action')
)->setHint('secondary', true);
```

The value of setHint is a string, it can be any value that a template can interpret.

The second parameter is whether a class should be added as an `extraClass` on the field based on the hint provided. Configuration provides mapping between hints and class(es).

In your FormAction template, you might add this:
```
<div class="form-action"<% if $FormFieldHint == 'secondary' %> custom-secondary<% end_if %>
```

### Templates

Use the value of `$FormFieldHint` to modify how your theme/project templates render the field.

Here's an example using `HTMLReadonlyField`:
    
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

Set a field hint icon on a supporting field:

```php
FormAction::create(
    'doSecondary',
    _t('some.i18n_key', 'Complete secondary action')
)->setHint('secondary', true)->setFieldHintIcon('delete')
```

```html
<%-- theme template: SilverStripe/Forms/FormAction.ss --%>
<% if $UseButtonTag %>
    <button $AttributesHTML>
        <% if $FormFieldHintIcon %>
        <span class="material-icons-outlined">{$FormFieldHintIcon}</span>
        <% end_if %>
        <% if $ButtonContent %>$ButtonContent<% else %><span>$Title.XML</span><% end_if %>
    </button>
<% else %>
	<input $AttributesHTML />
<% end_if %>
```

## Configuration

There is none, unless:

+ you want to add the `Hintable` extension to another field.
+ you need to add hint->class mapping

### Sample project configuration

```yaml
---
Name: 'app-field-hint'
After:
  - '#nswdpc-field-hint'
---
# you require TextField to be hintable
SilverStripe\Forms\TextField:
  extensions:
    - 'NSWPDC\Forms\Hintable'
# add hint/class mapping
SilverStripe\Forms\FormField:
  hint_class_mapping:
    'secondary': 'nsw-button--secondary'
```

Note that classes are added as extra classes, which by default in Silverstripe are added to both the field holder and the field input element. Your templates should take that into account.


## Installation

The only supported way of installing this module is via [composer](https://getcomposer.org/download/)

```
composer require nswdpc/silverstripe-field-hint
```

You may need to add a repositories entry to you composer.json, depending on packagist status.

## License

[BSD-3-Clause](./LICENSE.md)

## Configuration

See `_config/config.yml`

## Maintainers

+ [dpcdigital@NSWDPC:~$](https://dpc.nsw.gov.au)


## Bugtracker

We welcome bug reports, pull requests and feature requests on the Github Issue tracker for this project.

Please review the [code of conduct](./code-of-conduct.md) prior to opening a new issue.

## Security

If you have found a security issue with this module, please email digital[@]dpc.nsw.gov.au in the first instance, detailing your findings.

## Development and contribution

If you would like to make contributions to the module please ensure you raise a pull request and discuss with the module maintainers.

Please review the [code of conduct](./code-of-conduct.md) prior to completing a pull request.
