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
        $table->string('name');
        $table->string('code');
        $table->text('description')->nullable();
        $table->text('image')->nullable();
        $table->timestamps();
    });
}
```

run: 

```sh
php artisan migrate
```

