# Field hinting for Silverstripe forms

This module allows developers to add usage hints to form fields. The hints can be used by themes and templates to render the field in a specific way, to be interpreted by whatever frontend UI-kit is in use for your site.

This avoids polluting module code with theme-specific CSS classes.

Out-of-the-box the two fields supported are `FormAction` (for action priorities) and `CompositeField` (for hints on how to render child fields).

### Usage

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

The second parameter is whether a class should be added as a field `extraClass` based on the hint provided. Configuration provides mapping between hints and class(es).

```
<div class="form-action"<% if $FormFieldHint == 'secondary' %> custom-secondary<% end_if %>
```

## Configuration

There is none, unless you want to add the `Hintable` extension to another field.

If you need to add hint->class mapping, add it to our project configuration here:

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
