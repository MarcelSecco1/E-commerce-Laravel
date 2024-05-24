<div class="col-md-4 pt-5">
    <h2 class="h2 text-light border-bottom pb-3 border-light">Products</h2>
    <ul class="list-unstyled text-light footer-link-list">
        @if ($categories)
            @foreach ($categories as $category)
                <li>
                    <a class="text-decoration-none"
                        href="{{ route('shop.all-products', ['category_id' => $category->id]) }}">
                        {{ $category->name }}
                    </a>
                </li>
            @endforeach
        @endif
    </ul>
</div>
