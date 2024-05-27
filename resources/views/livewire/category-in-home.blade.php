<section class="container py-5">
    <div class="row text-center pt-3">
        <div class="col-lg-6 m-auto">
            <h1 class="h1">Categorias de Destaque</h1>
            <p>
                Algoritmo que seleciona algumas categorias que você pode possuir interesse!!
            </p>
        </div>
    </div>
    <div class="row">
        @if ($products)
            @for ($i = 0; $i < 3; $i++)
                @php
                    $img = $i + 1;

                @endphp
                <div class="col-12 col-md-4 p-5 mt-3">
                    <a href="{{ route('shop.single-product', $products[$i][0]->id) }}">
                        <img src="{{ '/storage/' . $products[$i][0]->imagem }}" class="rounded-circle img-fluid border"
                            data-bs-toggle="tooltip" data-bs-title="{{ $products[$i][0]->nome }}">
                    </a>
                    <h2 class="h5 text-center mt-3 mb-3">{{ $categories[$i]['name'] }}</h2>
                    <p class="text-center">
                        <a class="btn btn-primary" href="{{ route('shop.all-products') }}">Ver todos</a>
                    </p>
                </div>
            @endfor
        @endif
    </div>




</section>
@script
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    </script>
@endscript
