# UploadableBehavior

[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/it-blaster/uploadable-behavior/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/it-blaster/uploadable-behavior/?branch=master) [![Build Status](https://scrutinizer-ci.com/g/it-blaster/uploadable-behavior/badges/build.png?b=master)](https://scrutinizer-ci.com/g/it-blaster/uploadable-behavior/build-status/master) [![License](https://poser.pugx.org/it-blaster/uploadable-behavior/license.svg)](https://packagist.org/packages/it-blaster/uploadable-behavior) [![Total Downloads](https://poser.pugx.org/it-blaster/uploadable-behavior/downloads)](https://packagist.org/packages/it-blaster/uploadable-behavior) [![Latest Unstable Version](https://poser.pugx.org/it-blaster/uploadable-behavior/v/unstable.svg)](https://packagist.org/packages/it-blaster/uploadable-behavior) [![Latest Stable Version](https://poser.pugx.org/it-blaster/uploadable-behavior/v/stable.svg)](https://packagist.org/packages/it-blaster/uploadable-behavior)

The UploadableBehavior helps you handle uploaded files with Propel.

## Installation

Add it-blaster/uploadable-behavior to your `composer.json` file and run `composer`

```json
...
"require": {
    "it-blaster/uploadable-behavior": "1.0.*"
}
...
```

Register the behavior in your `config.yml`

```json
...
propel:
    behaviors:
        uploadable: Fenrizbes\UploadableBehavior\Behavior\UploadableBehavior
...
```

## Usage

Add the behavior to your table:

```xml
...
    <behavior name="uploadable" />
</table>
...
```

By default it finds or creates a varchar column named `file`, but you can configure your own columns:

```xml
...
    <behavior name="uploadable">
        <parameter name="columns" value="image, document" />
    </behavior>
</table>
...
```

## Extending

The behavior adds a few methods to the base class that help it, and you can override and extend any of them.
- `getUploadRoot` returns an absolute path to the web directory of your project. By default it returns the most
common path, but the best way is setting this path to a model in your controller.
- `getUploadDir` returns a relative path from the root dir to the file's folder. By default it's
`/uploads/<model_name>/<year>/<month>/<day>`.
- `makeFileName` generates the name for the file randomly.
- `moveUploadedFile` moves the file and sets new value to its column. If you're overriding this method, remember
that it has to return a web path to the uploaded file (of course if you don't want to change its behavior).

## Notes

Remember that this behavior handles uploaded files (moves them and sets columns' values) and does nothing more.
So:
- if you don't have a view transformer or overridden getters that convert string file paths to `File` objects,
set `null` to the `data_class` option of form fields;
- if you send an empty value for file field and don't want to erase column's value, handle it yourself;
- if you want to have a way to delete uploaded files, do it yourself;
- if you need anything else... well, you know.
