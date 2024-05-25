<section class="bg-light">
    <div class="container py-5">
        <div class="row text-center py-3">
            <div class="col-lg-6 m-auto">
                <h1 class="h1">Produtos selecionados</h1>
                <p>
                    O Algoritmo selecionou alguns produtos que podem combinar com você!!
                </p>
            </div>
        </div>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <a href="{{ route('shop.single-product', $product->id) }}">
                            <img src="{{ '/storage/' . $product->imagem }}" class="card-img-top" alt="...">
                        </a>
                        <div class="card-body">
                            <ul class="list-unstyled d-flex justify-content-between">
                                {{-- <li>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                </li> --}}
                                <li class="text-right">
                                    <span class="text-primary">R$</span>
                                    {{ $product->preco }}
                                </li>
                            </ul>
                            <a href="shop-single.html"
                                class="h2 text-decoration-none text-dark">{{ $product->nome }}</a>
                            <p class="card-text mt-2">
                                {{ $product->descricao }}
                            </p>
                            {{-- <p class="text-muted">Reviews (24)</p> --}}
                        </div>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
