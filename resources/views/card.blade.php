<div class="col-sm-6 col-md-4">
    <div class="thumbnail">
        @isset($category)
        {{$category->name}}
        @endisset
        <div class="labels">
        </div>
        <img src="http://internet-shop.tmweb.ru/storage/products/iphone_x_silver.jpg" alt="iPhone X 256GB">

        <div class="caption">
            <h3>{{$product->name}}</h3>
            <p>{{$product->price}} ₽</p>
            {{ $product->category->name }}
            <p>
            <form action="{{route('basket')}}" method="GET">
                <button type="submit" class="btn btn-primary" role="button">В корзину</button>
                <a href="{{route('product', [$product->category->code, $product->code])}}"
                    class="btn btn-default"
                    role="button">
                    Подробнее
                </a>

                <input type="hidden" name="_token" value="kkXCBAowA7qbbRuJoQBAyB6fH7WGKrQKJnmaaMM3">            </form>
            </p>
        </div>
    </div>
</div>
