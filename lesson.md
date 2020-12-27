# Laravel shop

[intro video](https://www.youtube.com/watch?v=D3Ds8tpaICA&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy)

```sh
touch resources/views/index.blade.php
```

[time15:30](https://www.youtube.com/watch?v=D3Ds8tpaICA&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&t=930s)

```sh
mkdir public/css
```

### Add categories template

```sh
touch resources/views/categories.blade.php
```

## [Laravel: интернет магазин ч.2: Роутинг, Контроллеры](https://www.youtube.com/watch?v=-iuhVrRbBJc&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=2)

```sh
php artisan make:controller MainController
```

### Debug methods

**dd()** ends script execution, **dump()** doesn't.

[time 4:30](https://www.youtube.com/watch?v=-iuhVrRbBJc&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=2&t=270s)

### Add dynamic urls

`routes/web.php`

```php
Route::get('/', [MainController::class, 'index']);
Route::get('/categories', [MainController::class, 'categories']);
Route::get('/{category}', [MainController::class, 'category']);
Route::get('/mobiles/{product?}', [MainController::class, 'product']);
```

`app/Http/Controllers/MainController.php`

```php
class MainController extends Controller
{
    public function index() {
        return view('index');
    }

    public function categories() {
        return view('categoriy', );
    }

    public function category($category) {
        // dd($category);
        return view('category', compact('category'));
    }

    public function product($product = null) {
        // dump($product);
        // dump(request());
        return view('product', compact('product'));
    }
}

```

## [Laravel: интернет магазин ч.3: Работа с БД: Миграции, Модели](https://www.youtube.com/watch?v=mB3R4AHDJFU&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=3)

### Create DB

```sql
create database larshop;
CREATE USER 'larshop'@localhost IDENTIFIED BY 'shop124lar';
SELECT User FROM mysql.user;
GRANT ALL PRIVILEGES ON larshop.* TO 'larshop'@'localhost' IDENTIFIED BY 'shop124lar';
-- or
-- GRANT ALL PRIVILEGES ON larshop.* TO 'larshop'@'localhost';
FLUSH PRIVILEGES;
SHOW GRANTS FOR 'larshop'@localhost;
```

fill `.env` file:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=larshop
DB_USERNAME=larshop
DB_PASSWORD=shop124lar
```

run 

```sh
php artisan migrate
```

### Create migration fro products table

```
php artisan make:migration create_products_table
```

we'll get answer:

Created Migration: 2020_12_26_144523_create_products_table

`database/migrations/2020_12_26_144523_create_products_table.php`

```
public function up()
{
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->integer('category_id');
        $table->string('name');
        $table->string('code');
        $table->text('description')->nullable();
        $table->text('image')->nullable();
        $table->double('price')->default(0);
        $table->timestamps();
    });
}
```

run: 

```sh
php artisan migrate
```

### Create model

```
php artisan make:model Product
```

### Create model with migration

```
php artisan make:model -m Category
```

[time 7:40](https://www.youtube.com/watch?v=mB3R4AHDJFU&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=3&t=460s)

### Rollback migrations

```sh
php artisan migrate:rollback
```

### Creating categories migration

```php
public function up()
{
    Schema::create('categories', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('code');
        $table->text('description')->nullable();
        $table->text('image')->nullable();
        $table->timestamps();
    });
}
```

So, fill some records to **Categories** table

| id   | name                | code     | description                               | image | created_at | updated_at |
| ---- | ------------------- | -------- | ----------------------------------------- | ----- | ---------- | ---------- |
| 1    | Мобильные телефоны  | mobiles  | Описание мобильных телефонов              |       |            |            |
| 2    | Портативная техника | portable | Описание для раздела портативной техники. |       |            |            |
| 3    | Бытовая техника     | technics | Описание бытовой техники.                 |       |            |            |

[time 14:00](https://www.youtube.com/watch?v=mB3R4AHDJFU&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=3&t=840s)

## [Laravel: интернет магазин ч.4: Мастер шаблон](https://www.youtube.com/watch?v=0Aspgkw2JUM&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=4)

```sh
touch resources/views/master.blade.php
```

use **@section('name')** construction. use second parameter. Optional we can send parameters from each template to master:

`resources/views/categories.blade.php`

```php
@extends('master', ['tile' => 'cats'])
```

`resources/views/master.blade.php`

```php+HTML
<a class="navbar-brand" href="http://internet-shop.tmweb.ru">Интернет Магазин {{$tile ?? ''}}</a>
```



### Separate product card template.

So, product templates are the same in most of places.

```
touch resources/views/card.blade.php
```

take card from index:

```php+HTML
<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        <div class="labels">
        </div>
        <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x_silver.jpg" alt="iPhone X 256GB">
        <div class="caption">
            <h3>iPhone X 256GB</h3>
            <p>89990 ₽</p>
            <p>
            <form action="http://internet-shop.tmweb.ru/basket/add/2" method="POST">
                <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                <a href="http://internet-shop.tmweb.ru/mobiles/iphone_x_256"
                    class="btn btn-default"
                    role="button">Подробнее</a>
                <input type="hidden" name="_token" value="kkXCBAowA7qbbRuJoQBAyB6fH7WGKrQKJnmaaMM3">            </form>
            </p>
        </div>
    </div>
</div>

```

in `resources/views/index.blade.php` and `resources/views/index.blade.php` include card using **@include()** directive:

```php
@include('card')
```

### Adjusting routes

in `routes/web.php` give names to routes.

```php
Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/categories', [MainController::class, 'categories'])->name('categories');
Route::get('/categories/{category}', [MainController::class, 'category'])->name('category');
Route::get('/mobiles/{product?}', [MainController::class, 'product'])->name('product');
```

