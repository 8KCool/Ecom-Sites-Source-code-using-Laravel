# Paiaki.com Ecom Source code

<a href="https://paiaki.com/"><img src="https://paiaki.com/images/logopaiaki.svg" alt="Build Status"></a>

> A Laravel-Vue SPA starter kit.

<p align="center">
<img src="https://i.imgur.com/NHFTsGt.png">
</p>

## Features

"require": {
		"php": "^7.3",
		"ext-curl": "*",
		"ext-json": "*",
		"aws/aws-sdk-php": "~3.0",
		"bileto/omnipay-payu": "dev-master",
		"chriskonnertz/open-graph": "~2",
		"cocur/slugify": "^4.0",
		"creativeorange/gravatar": "~1.0",
		"cviebrock/eloquent-sluggable": "^8.0",
		"doctrine/dbal": "^2.10",
		"facebook/graph-sdk": "~5.0",
		"fakerphp/faker": "^1.11.0",
		"fideloper/proxy": "^4.2",
		"florianv/laravel-swap": "^2.0",
		"fruitcake/laravel-cors": "^2.0",
		"graham-campbell/flysystem": "^7.1",
		"guzzlehttp/guzzle": "^7.0.1",
		"ignited/laravel-omnipay": "^3.3",
		"intervention/image": "^2.5",
		"iyzico/iyzipay-php": "^2.0",
		"jackiedo/dotenv-editor": "1.*",
		"jaybizzle/crawler-detect": "1.*",
		"jaybizzle/laravel-crawler-detect": "1.*",
		"lab404/laravel-impersonate": "^1.7",
		"laracasts/flash": "^3.2",
		"laravel-notification-channels/twilio": "^3.1",
		"laravel/framework": "^8.0",
		"laravel/helpers": "^1.3",
		"laravel/nexmo-notification-channel": "^2.4",
		"laravel/sanctum": "^2.9",
		"laravel/slack-notification-channel": "^2.2",
		"laravel/socialite": "^5.0",
		"laravel/tinker": "^2.0",
		"laravelcollective/html": "^6.2",
		"league/csv": "^9.6",
		"league/flysystem-aws-s3-v3": "^1.0",
		"league/flysystem-cached-adapter": "^1.0",
		"league/flysystem-sftp": "^1.0",
		"league/omnipay": "^3.2",
		"livecontrol/eloquent-datatable": "dev-master",
		"mews/purifier": "3.3.*",
		"mhetreramesh/flysystem-backblaze": "^1.5",
		"omnipay/paypal": "^3.0",
		"omnipay/stripe": "~3.1@dev",
		"php-http/guzzle6-adapter": "^2.0",
		"php-http/message": "^1.7",
		"predis/predis": "^1.1",
		"prologue/alerts": "^0.4.8",
		"propaganistas/laravel-phone": "4.*",
		"pulkitjalan/geoip": "5.*",
		"spatie/flysystem-dropbox": "^1.2",
		"spatie/laravel-backup": "^6.11",
		"spatie/laravel-cookie-consent": "^2.12",
		"spatie/laravel-feed": "^2.7",
		"spatie/laravel-permission": "^3.17",
		"spatie/laravel-translatable": "^4.6",
		"srmklive/paypal": "^3.0",
		"therobfonz/laravel-mandrill-driver": "^3.0",
		"torann/laravel-meta-tags": "^3.0",
		"unicodeveloper/laravel-paystack": "1.0.*",
		"vemcogroup/laravel-sparkpost-driver": "^4.0",
		"watson/sitemap": "4.0.*"
	},

# EloquentDataTable [![Build status](https://travis-ci.org/LiveControl/EloquentDataTable.svg?branch=master)](https://travis-ci.org/LiveControl/EloquentDataTable)
Eloquent compatible DataTable plugin for server side ajax call handling.

If you are familiar with eloquent and would like to use it in combination with [datatables](https://www.datatables.net/) this is what you are looking for.

## Usage

### Step 1: Install through composer
```composer require livecontrol/eloquent-datatable```

### Step 2: Add DataTables javascript and set it up
For more information check out the [datatables manual](http://datatables.net/manual/index).
Make sure you have [csrf requests](http://laravel.com/docs/master/routing#csrf-protection) working with jquery ajax calls.
```javascript
var table = $('#example').DataTable({
  "processing": true,
  "serverSide": true,
  "ajax": {
    "url": "<url to datatable route>",
    "type": "POST"
  }
});
```

### Step 3: Use it
```php
$users = new Models\User();
$dataTable = new LiveControl\EloquentDataTable\DataTable($users, ['email', 'firstname', 'lastname']);
echo json_encode($dataTable->make());
```

### Optional step 4: Set versions of DataTables plugin.
Just initialize the DataTable object as you would normally and call the setVersionTransformer function as in the following example (for version 1.09 of DataTables):
```php
$dataTable->setVersionTransformer(new LiveControl\EloquentDataTable\VersionTransformers\Version109Transformer());
```
By default the plugin will be loading the transformer which is compatible with DataTables version 1.10.

## Examples

- [Basic setup](#basic-example)
- [Combining columns](#combining-columns)
- [Using raw column queries](#using-raw-column-queries)
- [Return custom row format](#return-custom-row-format)
- [Showing results with relations](#showing-results-with-relations)

### Basic example
```php
use LiveControl\EloquentDataTable\DataTable;

class UserController {
  ...
  public function datatable()
  {
    $users = new User();
    $dataTable = new DataTable(
      $users->where('city', '=', 'London'),
      ['email', 'firstname', 'lastname']
    );
    
    return $dataTable->make();
  }
}
```
In this case we are making a datatable response with all users who live in London.

### Combining columns
If you want to combine the firstname and lastname into one column, you can wrap them into an array.
```php
use LiveControl\EloquentDataTable\DataTable;

class UserController {
  ...
  public function datatable()
  {
    $users = new User();
    $dataTable = new DataTable(
      $users,
      ['email', ['firstname', 'lastname'], 'city']
    );
    
    return $dataTable->make();
  }
}
```
### Using raw column queries
Sometimes you want to use custom sql statements on a column to get specific results,
this can be achieved using the `ExpressionWithName` class.
```php
use LiveControl\EloquentDataTable\DataTable;
use LiveControl\EloquentDataTable\ExpressionWithName;

class UserController {
  ...
  public function datatable()
  {
    $users = new User();
    $dataTable = new DataTable(
      $users,
      [
        'email',
        new ExpressionWithName('`id` + 1000', 'idPlus1000'),
        'city'
      ]
    );
    
    return $dataTable->make();
  }
}
```

### Return custom row format
If you would like to return a custom row format you can do this by adding an anonymous function as an extra argument to the make method.
```php
use LiveControl\EloquentDataTable\DataTable;

class UserController {
  ...
  public function datatable()
  {
    $users = new User();
    $dataTable = new DataTable($users, ['id', ['firstname', 'lastname'], 'email', 'city']);
    
    $dataTable->setFormatRowFunction(function ($user) {
      return [
        $user->id,
        '<a href="/users/' . $user->id . '">' . $user->firstnameLastname . '</a>',
        '<a href="mailto:' . $user->email . '">' . $user->email . '</a>',
        $user->city,
        '<a href="/users/delete/' . $user->id . '">&times;</a>'
      ];
    });
    
    return $dataTable->make();
  }
}
```


### Showing results with relations
```php
use LiveControl\EloquentDataTable\DataTable;

class UserController {
  ...
  public function datatable()
  {
    $users = new User();
    $dataTable = new DataTable(
    	$users->with('country'),
    	['name', 'country_id', 'email', 'id']
    );
    
    $dataTable->setFormatRowFunction(function ($user) {
    	return [
    		'<a href="/users/'.$user->id.'">'.$user->name.'</a>',
    		$user->country->name,
    		'<a href="mailto:'.$user->email.'">'.$user->email.'</a>',
    		'<a href="/users/delete/'.$user->id.'">&times;</a>'
    	];
    });
    
    return $dataTable->make();
  }
}
```
