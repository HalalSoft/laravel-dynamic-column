# Trait to Manage an MariaDB dynamic columns blob

[![Latest Version on Packagist](https://img.shields.io/packagist/v/halalsoft/laravel-dynamic-column.svg?style=flat-square)](https://packagist.org/packages/halalsoft/laravel-dynamic-column)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Quality Score](https://img.shields.io/scrutinizer/g/halalsoft/laravel-dynamic-column.svg?style=flat-square)](https://scrutinizer-ci.com/g/halalsoft/laravel-dynamic-column)
[![Total Downloads](https://img.shields.io/packagist/dt/halalsoft/laravel-dynamic-column.svg?style=flat-square)](https://packagist.org/packages/halalsoft/laravel-dynamic-column)

The `laravel-dynamic-column` package provides a `HasDynamicColumn` trait, which allows you to easily handle MariaDB dynamic column using Eloquent or Query Builder.

```php
// The `Author` class uses the `HasDynamicColumn` trait and `Dynamic` cast attribute on the `option` column
$author = Author::where('option->vehicle','car')->first();


$author = $author->option;
// => Array containing `option` dynamic  column
$option = $author->option;
$option['vehicle_brand'] = 'Esemka';
$author->option = $option;
$author->save();

//You can also create data field as array
$newData = MyModel::create([
    'other_column' => 'this just another column data',
    'the_column' => ['data1'=>'value1','data2'=>'value2']
]);

//to update a json field/key you use, you may use the `->` operator when calling the update method:

$page->update(['content->data1' => 'value1new']);
    
//or you can still update whole column using normal array:
$page->update(['content' => ['data1'=>'value1new','data2'=>'value2new']]);
//You can set as array using other method like `updateOrCreate()`, `firstOrCreate()`,  etc.

//This package also support query builder using:
Model::query()->where('the_column->data1', 'value1')->first();
```


## Install

You can install the package via composer:

```bash
composer require halalsoft/laravel-dynamic-column
```

## Usage

You can start using the package by adding the `HasDynamicColumn` trait and use `Dynamic` as attribute cast  to your models.

```php
use Illuminate\Database\Eloquent\Model;
use Halalsoft\LaravelDynamicColumn\Dynamic;
use Halalsoft\LaravelDynamicColumn\HasDynamicColumn;

class Post extends Model
{
    use HasDynamicColumn;
    protected $casts
        = [
            'content' => Dynamic::class,
        ];
}
```

### Other explain will be added soon

## Security

If you discover any security related issues, just open an issue on this git or email me to dyas@yaskur.com .


## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
