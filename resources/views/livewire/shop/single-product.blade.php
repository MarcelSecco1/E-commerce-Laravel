<!-- Open Content -->
<section class="bg-light">
    {{-- @dd($product) --}}
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-5 mt-5">
                {{-- <div class="card mb-3">
                    <img class="card-img img-fluid" src="assets/img/product_single_10.jpg" alt="Card image cap"
                        id="product-detail">
                </div> --}}
                <div class="row">

                    <img src="{{ '/storage/' . $product['imagem'] }}" class="img-fluid" alt="..." </div>
                </div>
            </div>
            <!-- col end -->
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h2">{{ $product['nome'] }}</h1>
                        <p class="h3 py-2">{{ "R$ " . $product['preco'] }}</p>

                        <h6>Descrição:</h6>
                        <p>{{ $product['descricao'] }}</p>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Categoria:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>{{ $category['name'] }}</strong></p>
                            </li>
                        </ul>



                        <form wire:submit='addToCart'>
                            <div class="row">
                                <div class="col-auto">
                                    <ul class="list-inline pb-3">
                                        <li class="list-inline-item text-right">
                                            Quantidade

                                        </li>
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                wire:click='decrement'>-</span></li>
                                        <li class="list-inline-item"><span class="badge bg-secondary" id="var-value"
                                                wire:model='quantity'>{{ $quantity }}</span></li>
                                        <li class="list-inline-item"><span class="btn btn-success"
                                                wire:click='increment'>+</span></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="row pb-3">
                                <div class="col d-grid">
                                    <a href="{{ route('shop.all-products') }}" class="btn btn-secondary btn-lg">
                                        <i class="fa fa-reply" aria-hidden="true"></i>

                                        Voltar para os produtos
                                    </a>
                                </div>
                                <div class="col d-grid">

                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fa fa-plus-square" aria-hidden="true"></i>
                                        Adicionar ao carrinho
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@script
    <script>
        $wire.on('addToCart', ($message) => {
            Swal.fire({
                title: "Sucesso!",
                text: $message,
                icon: "success",
                footer: '<a href="/cart" class="text-decoration-none">Ir para carrinho!!</a>'
            });
        });
    </script>
@endscript
<!-- Close Content -->
