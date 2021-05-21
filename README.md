![banner-nova](https://user-images.githubusercontent.com/7728097/57463952-16783a80-727c-11e9-87f7-94aae5284bfc.jpg)

<p align="center">
  <a href="https://styleci.io/repos/146120416">
    <img src="https://styleci.io/repos/146120416/shield?branch=1.1" alt="StyleCI">
  </a> 
  
   <a href="https://packagist.org/packages/maatwebsite/laravel-nova-excel">
      <img src="https://poser.pugx.org/maatwebsite/laravel-nova-excel/v/stable.png" alt="Latest Stable Version">
  </a> 
  
  <a href="https://packagist.org/packages/maatwebsite/laravel-nova-excel">
      <img src="https://poser.pugx.org/maatwebsite/laravel-nova-excel/downloads.png" alt="Total Downloads">
  </a> 
  
  <a href="https://packagist.org/packages/maatwebsite/laravel-nova-excel">
    <img src="https://poser.pugx.org/maatwebsite/laravel-nova-excel/license.png" alt="License">
  </a>
</p>


<h3 align="center">Supercharge your Laravel Nova resource exports</h3>

<h4 align="center">
  <a href="https://docs.laravel-excel.com/nova/1.1/getting-started/">Quickstart</a>
  <span> · </span>
  <a href="https://docs.laravel-excel.com/nova/1.1/">Documentation</a>
  <span> · </span>
  <a href="https://docs.laravel-excel.com/blog/">Blog</a>
  <span> · </span>
  <a href="https://docs.laravel-excel.com/3.1/getting-started/contributing.html">Contributing</a>
  <span> · </span>
  <a href="https://docs.laravel-excel.com/3.1/getting-started/support.html">Support</a>
</h4>

## ✨ Features

- **Easily export resources to Excel.** Supercharge your Nova resources and export them directly to an Excel or CSV document. Exporting has never been so easy.

- **Supercharged resource exports.** Export resources with automatic chunking for better performance. You provide us the query, we handle the performance. Exporting even larger resources? No worries, Laravel Nova Excel has your back. You can queue your exports so all of this happens in the background.

- **Export based on filters and selection.** Select or filter only certain resources and export only those to Excel!

- **Export lenses.** Got custom lenses defined? When exporting from a lens, it will use the query of the lens to determine which data needs to be exported!

## :rocket: 5 minutes quick start

:bulb: Require this package in the `composer.json` of your Laravel project. This will download the package and Laravel-Excel.

```
composer require maatwebsite/laravel-nova-excel
```

:muscle: Go to your resource. As example we'll use the `app/Nova/User.php`. Add `DownloadExcel` action to your `actions()` list.

```php
<?php

namespace App\Nova;

use Illuminate\Http\Request;
use Maatwebsite\LaravelNovaExcel\Actions\DownloadExcel;

class User extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\\User';
    
    // Other default resource methods
    
    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            new DownloadExcel,
        ];
    }
}
```

:fire: Go to your resource in your Nova admin panel, select all or some users and click "Download Excel"

![Laravel-Nova-Excel](https://user-images.githubusercontent.com/7728097/44807515-0dea4300-abca-11e8-9396-9bd969f6a6c9.png)

:page_facing_up: Find your `users.xlsx` in your downloads folder!

More installation instructions can be found at: [https://docs.laravel-excel.com/nova/1.1/getting-started/installation.html](https://docs.laravel-excel.com/nova/1.1/getting-started/installation.html)

## Modify your export

Currently the export is based on the index fields but this might not be what you want to do.  
You can modify with ease the query and the exported fields this way:

```php
    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [
            (new DownloadExcel)
                ->alterateQuery(function ($query) {
                    $query->select('id', 'first_name');
                })
                ->exportFields(['first_name', 'id']),
        ];
    }
```

Feel free to join tables if necessary but you should always select the fields you want to export to avoid confusions.

## 🎓 Learning Laravel Excel

You can find the full documentation of Laravel Nova Excel [on the website](https://docs.laravel-excel.com/nova).

We welcome suggestions for improving our docs. The documentation repository can be found at [https://github.com/Maatwebsite/laravel-excel-docs](https://github.com/Maatwebsite/laravel-excel-docs).

Some articles and tutorials can be found on our blog: https://medium.com/maatwebsite/laravel-excel/home

## 🎥 Video Course

![1_bzlh2ituv5x7yu2wenhxxw](https://user-images.githubusercontent.com/7728097/53638298-188f9e80-3c26-11e9-82c8-baf057271013.jpeg)

We are currently building a video course called "Advanced Laravel Excel". In this video course we’ll build a small application with real-life, complex imports and exports that go beyond simple user imports and exports. We’ll go step-by-step and tackle implementing Laravel Excel in a performant way.

If you sign up now, you’ll get notified when the course launches and get it for the early bird price of $69 instead of ~~$99~~.

## :mailbox_with_mail: License & Postcardware

![1_5nblgs68uarg0wxxejozdq](https://user-images.githubusercontent.com/7728097/53638144-9e5f1a00-3c25-11e9-9f4a-fc71c9d94562.jpg)

Laravel Excel is completely free (MIT license) to use, however the package is licensed as Postcardware. This means that if it makes it to your production environment, we would very much appreciate receiving a postcard from your hometown.

**Maatwebsite**  
Markt 2  
6231 LS Meerssen  
The Netherlands 

More about the license can be found at: [https://docs.laravel-excel.com/3.1/getting-started/license.html](https://docs.laravel-excel.com/3.1/getting-started/license.html)
