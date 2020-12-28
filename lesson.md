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
Route::get('/basket', [MainController::class, 'basket'])->name('basket');
Route::get('/basket/place', [MainController::class, 'basketPlace'])->name('basket-place');
```

### Add some views

```
touch resources/views/basket.blade.php
touch resources/views/order.blade.php
```

### Check for routes

```sh
php artisan route:list
```

### Using route names in views

```php+HTML
<a href="{{ route('index') }}">Все товары</a>
```

#### placing route name with additional parameters

`resources/views/categories.blade.php`

```php+HTML
<!-- <a href="/categories/{{$cat->code}}"> -->
<a href="{{ route('category', $cat->code)}}">
```

### Parameters to included views

in `resources/views/category.blade.php`

```php
@include('card', ['category' => $category])
```

## [Laravel: интернет магазин ч.5: Eloquent связи](https://www.youtube.com/watch?v=V0XhLmxlVF4&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=5)

add some data

```sql
INSERT INTO `products` (`id`, `name`, `code`, `category_id`, `image`, `description`, `price`, `created_at`, `updated_at`) VALUES
(1, 'iPhone X 64GB', 'iphone_x_64', 1, NULL, 'Отличный продвинутый телефон с памятью на 64 gb', 71990, NULL, NULL),
(2, 'iPhone X 256GB', 'iphone_x_256', 1, NULL, 'Отличный продвинутый телефон с памятью на 256 gb', 89990, NULL, NULL),
(3, 'HTC One S', 'htc_one_s', 1, NULL, 'Зачем платить за лишнее? Легендарный HTC One S', 12490, NULL, NULL),
(4, 'iPhone 5SE', 'iphone_5se', 1, NULL, 'Отличный классический iPhone', 17221, NULL, NULL),
(5, 'Наушники Beats Audio', 'beats_audio', 2, NULL, 'Отличный звук от Dr. Dre', 20221, NULL, NULL),
(6, 'Камера GoPro', 'gopro', 2, NULL, 'Снимай самые яркие моменты с помощью этой камеры', 12000, NULL, NULL),
(7, 'Камера Panasonic HC-V770', 'panasonic_hc-v770', 2, NULL, 'Для серьёзной видео съемки нужна серьёзная камера. Panasonic HC-V770 для этих целей лучший выбор!', 27900, NULL, NULL),
(8, 'Кофемашина DeLongi', 'delongi', 3, NULL, 'Хорошее утро начинается с хорошего кофе!', 25200, NULL, NULL),
(9, 'Холодильник Haier', 'haier', 3, NULL, 'Для большой семьи большой холодильник!', 40200, NULL, NULL),
(10, 'Блендер Moulinex', 'moulinex', 3, NULL, 'Для самых смелых идей', 4200, NULL, NULL),
(11, 'Мясорубка Bosch', 'bosch', 3, NULL, 'Любите домашние котлеты? Вам определенно стоит посмотреть на эту мясорубку!', 9200, NULL, NULL);
```

in `app/Http/Controllers/MainController.php`

```php
public function index() {
    $products = Product::get();
    return view('index', compact('products'));
}
```

in `resources/views/index.blade.php`

```php+HTML
<div class="row">
    @foreach($products as $product)
    @include('card', compact('product'))
    @endforeach
</div>
```

in `resources/views/card.blade.php`

```php+HTML
<h3>{{$product->name}}</h3>
<p>{{$product->price}} ₽</p>
```

in Product model: ``

```php
public function getCategory() {
    // $category = Category::where('id', $this->category_id)->first();
    return Category::find($this->category_id);
}
```

again, in `resources/views/card.blade.php`

```php+HTML
{{ $product->getCategory()->name}}
```

#### do same for category...

`app/Http/Controllers/MainController.php`

```php
public function category($code) {
    $category = Category::where('code', $code)->first();
    $products = Product::where('category_id', $category->id)->get();
    return view('category', compact('category', 'products'));
}
```

### [Single responsibility principle](https://www.youtube.com/watch?v=V0XhLmxlVF4&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=5&t=355s)

### Add relation to Product 

in `app/Models/Product.php`

```php
// public function getCategory() {
//     // $category = Category::where('id', $this->category_id)->first();
//     return Category::find($this->category_id);
// }

public function category() {
    return $this->belongsTo(Category::class);
}
```

in ``

```php+HTML
{{ $product->getCategory()->name}}
```

change to

```
{{ $product->category->name }}
```

### Add relation to Category

`app/Models/Category.php`

```php
public function products() {
    return $this->hasMany(Product::class);
}
```

`resources/views/category.blade.php`

```
@foreach($category->products as $product)
@include('card', compact('product'))
@endforeach
```

now, in `app/Http/Controllers/MainController.php`->category() we can remove getting products:

```
public function category($code) {
    $category = Category::where('code', $code)->first();
    $products = Product::where('category_id', $category->id)->get();
    return view('category', compact('category', 'products'));
}
```

to

```
public function category($code) {
    $category = Category::where('code', $code)->first();
    return view('category', compact('category'));
}
```

### Use some other possibilities of relations

in `resources/views/category.blade.php` we can get count of products of each category...

```php+HTML
<h1>{{$category->name}} {{$category->products->count()}}</h1>
```

in `resources/views/card.blade.php`

```php+HTML
<a href="{{route('product', [$product->category->code, $product->code])}}"
    class="btn btn-default"
    role="button">
    Подробнее
</a>
```

## [Laravel: интернет магазин ч.6: Многие-ко-многим, Сессия](https://www.youtube.com/watch?v=60DbUa82TMw&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=6)

### Let's make basket

```sh
php artisan make:model -m Order
```

in `database/migrations/2020_12_27_162744_create_orders_table.php` add fields:

```php
public function up()
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->tinyInteger('status')->default(0);
        $table->string('name')->nullable();
        $table->string('phone')->nullable();
        $table->timestamps();
    });
}
```

then

```sh
php artisan migrate
```

and then

```
php artisan make:migration create_order_product_table
```

in `database/migrations/2020_12_27_163336_create_order_product_table.php` add two fields:

```php
Schema::create('order_product', function (Blueprint $table) {
    $table->id();
    $table->integer('order_id');
    $table->integer('product_id');
    $table->timestamps();
});
```

again

```
php artisan migrate
```

why 'order_product', not 'product_order'? Just in alphabet order...

OK, then...

#### Add order to products many relation

in `app/Models/Order.php`

```php
public function products() {
    return $this->belongsToMany(Product::class);
}
```

### Move some methods from MainController

```
php artisan make:controller BasketController
```

move basket actions in it and configure `routes/web.php` accordingly.

### Add link and route to basket-add

`routes/web.php`

```php
Route::post('/basket/add/{id}', [BasketController::class, 'basketAdd'])->name('basket-add');
```

### CSRF token

when we go to basket via POST, we get 419. to fix it, we need to use **@csrf** helper.

`resources/views/card.blade.php`

```php+HTML
<form action="{{route('basket-add', $product)}}" method="POST">
    ...
    @csrf
```

### Processing order

`app/Http/Controllers/BasketController.php`

```php
public function basketAdd($productId) {
    $orderId = session('orderId');
    if(is_null($orderId)) {
        $order = Order::create();
        session(['orderId' => $order->id]);
    } else {
        $order = Order::find($orderId);
    }
    $order->products()->attach($productId);
    return view('basket', compact('order'));
}
```

for POST and

```php
public function basket() {
    $orderId = session('orderId');
    if(!is_null($orderId)){
        $order = Order::findOrFail($orderId);
    }
    return view('basket', compact('order'));
}
```

for GET. Accordingly, update `resources/views/basket.blade.php`

## [Laravel: интернет магазин ч.7: Pivot table](https://www.youtube.com/watch?v=ZxQJyT_ydGQ&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=7)

### Complete basketRemove action

`app/Http/Controllers/BasketController.php`

```php
public function basketRemove($productId) {
    $orderId = session('orderId');

    if(is_null($orderId)) {
        return redirect(route('basket'));
    }
    $order = Order::find($orderId);
    $order->products()->detach($productId);
    return redirect(route('basket'));
}
```

### Implement product counting on basket page

```
php artisan make:migration update_order_product_table
```

`database/migrations/2020_12_28_113544_update_order_product_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrderProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->integer('count')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropColumn('count');
        });
    }
}

```

then

```sh
php artisan migrate
```

[time 6:10](https://www.youtube.com/watch?v=ZxQJyT_ydGQ&list=PL5RABzpdpqAlSRJS1KExmJsaPFQc161Dy&index=7&t=430s)

update migration:

```php
$table->integer('count')->default(1)->after('product_id');
```

then

```
php artisan migrate:rollback --step=1
php artisan migrate
```

