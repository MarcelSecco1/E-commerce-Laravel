<div class="container">
    <div class="py-5 text-center">
        {{-- <img class="d-block mx-auto mb-4" src="/public/assets/img/favicon.ico" alt="" width="72" height="57"> --}}
        <h2>Estamos quase terminando!!</h2>
        <p class="lead">Below is an example form built entirely with Bootstrap’s form controls. Each required form
            group has a validation state that can be triggered by attempting to submit the form without completing it.
        </p>
    </div>

    <div class="row g-5">
        <div class="col-md-5 col-lg-4 order-md-last">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-primary">Meu carrinho</span>
                <span class="badge bg-primary rounded-pill">
                    <livewire:cart />
                </span>
            </h4>
            <ul class="list-group mb-3">
                @if (session()->has('cart'))
                    @foreach (session()->get('cart') as $product)
                        <li class="list-group-item d-flex justify-content-between lh-sm">
                            <div>
                                <h6 class="my-0">{{ $product['name'] }}</h6>
                                <small class="text-body-secondary">x{{ $product['quantity'] }}</small>
                            </div>
                            <span class="text-body-secondary">R$ {{ $product['price'] * $product['quantity'] }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between">
                        <span>Total (BRL)</span>
                        <strong>R$ {{ $total }}</strong>
                    </li>
                @else
                    <div class="alert alert-danger" role="alert">
                        Seu carrinho está vazio!
                    </div>
                @endif

               

            </ul>

            <livewire:code-promotion />



            @if (session()->has('cart'))
                <button class="btn btn-danger w-100 my-3" @click="$dispatch('clearCart')">
                    Limpar carrinho
                </button>
            @endif
        </div>
        <div class="col-md-7 col-lg-8 mb-5">
            @if (auth()->user() && auth()->user()->pessoa)
                <h3 class="text-primary">Minha conta</h3>
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="justify-content-start me-auto">
                                <p class="fw-bold">
                                    <i class="bi bi-people text-primary"></i> -
                                    {{ auth()->user()->pessoa->nome . ' ' . auth()->user()->pessoa->sobrenome }}
                                </p>
                                <p>
                                    <i class="bi bi-geo-alt-fill text-primary"></i>
                                    -
                                    {{ auth()->user()->pessoa->endereco .
                                        ', ' .
                                        auth()->user()->pessoa->cep .
                                        ' - ' .
                                        auth()->user()->pessoa->cidade }}


                                </p>
                            </div>
                            <div class="justify-content-end">
                                <a class="btn btn-warning rounded-pill"
                                    href="{{ route('people.edit', auth()->user()->pessoa->id) }}">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-danger rounded-pill"
                                    wire:click='deletePessoa({{ auth()->user()->pessoa->id }})'>
                                    <i class="bi bi-trash3"></i>
                                </button>

                            </div>
                        </div>
                    </div>
                </div>
                <button class="w-50 btn btn-primary btn-md mt-3" wire:click='pagar'>
                    Finalizar Pagamento
                </button>
            @else
                <h4 class="mb-3">Informações necessárias</h4>
                <form class="needs-validation" wire:submit='salvarPessoa'>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="firstName" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="firstName" placeholder="" value=""
                                required wire:model='nome'>
                            @error('nome')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-sm-6">
                            <label for="lastName" class="form-label">Sobrenome</label>
                            <input type="text" class="form-control" id="lastName" placeholder="" value=""
                                required wire:model='sobrenome'>
                            @error('sobrenome')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>



                        {{-- <div class="col-12">
                        <label for="email" class="form-label">Email <span
                                class="text-body-secondary">(Optional)</span></label>
                        <input type="email" class="form-control" id="email" placeholder="you@example.com">
                        <div class="invalid-feedback">
                            Please enter a valid email address for shipping updates.
                        </div>
                    </div> --}}

                        <div class="col-12">
                            <label for="address" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="address" placeholder="1234 Main St"
                                required wire:model='endereco'>
                            @error('endereco')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="cpf" class="form-label">CPF</label>
                            <input type="text" class="form-control" id="cpf" placeholder="000.000.000-00"
                                required wire:model='cpf'>
                            @error('cpf')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="zip" class="form-label">CEP</label>
                            <input type="" id="zip" name="cep" maxlength="8" pattern="[0-9]{8}"
                                class="form-control" placeholder="15530000" required wire:model.live='cep'
                                wire:change="atualizarCep">
                            @error('cep')
                                <div class="text-danger mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        <div class="col-md-4">
                            <label for="cidade" class="form-label">Cidade</label>
                            <input type="text" class="form-control" id="cidade" disabled wire:model.live='cidade'>

                        </div>

                        <div class="col-md-4">
                            <label for="estado" class="form-label">Estado</label>
                            <input type="text" class="form-control" id="estado" disabled
                                wire:model.live='estado'>
                        </div>
                        <div class="col-md-4">
                            <label for="bairro" class="form-label">Bairro</label>
                            <input type="text" class="form-control" id="bairro" disabled
                                wire:model.live='bairro'>
                        </div>

                    </div>

                    {{-- <hr class="my-4">

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="same-address">
                    <label class="form-check-label" for="same-address">Shipping address is the same as my billing
                        address</label>
                </div>

                <div class="form-check">
                    <input type="checkbox" class="form-check-input" id="save-info">
                    <label class="form-check-label" for="save-info">Save this information for next time</label>
                </div>

                <hr class="my-4"> --}}

                    {{-- <h4 class="mb-3">Payment</h4>

                <div class="my-3">
                    <div class="form-check">
                        <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked
                            required>
                        <label class="form-check-label" for="credit">Credit card</label>
                    </div>
                    <div class="form-check">
                        <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required>
                        <label class="form-check-label" for="debit">Debit card</label>
                    </div>
                    <div class="form-check">
                        <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required>
                        <label class="form-check-label" for="paypal">PayPal</label>
                    </div>
                </div>

                <div class="row gy-3">
                    <div class="col-md-6">
                        <label for="cc-name" class="form-label">Name on card</label>
                        <input type="text" class="form-control" id="cc-name" placeholder="" required>
                        <small class="text-body-secondary">Full name as displayed on card</small>
                        <div class="invalid-feedback">
                            Name on card is required
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="cc-number" class="form-label">Credit card number</label>
                        <input type="text" class="form-control" id="cc-number" placeholder="" required>
                        <div class="invalid-feedback">
                            Credit card number is required
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="cc-expiration" class="form-label">Expiration</label>
                        <input type="text" class="form-control" id="cc-expiration" placeholder="" required>
                        <div class="invalid-feedback">
                            Expiration date required
                        </div>
                    </div>

                    <div class="col-md-3">
                        <label for="cc-cvv" class="form-label">CVV</label>
                        <input type="text" class="form-control" id="cc-cvv" placeholder="" required>
                        <div class="invalid-feedback">
                            Security code required
                        </div>
                    </div>
                </div> --}}

                    {{-- <hr class="my-4"> --}}
                    <div class="d-flex justify-content-center my-5">
                        <button class="w-50 btn btn-primary btn-lg" type="submit" wire:loading.attr="disabled">
                            Salvar Informações
                        </button>
                    </div>
                </form>
            @endif

            {{-- <button class="w-50 btn btn-primary btn-lg mt-5" wire:click='salvarPessoa'>
                Salvar Pessoa
            </button> --}}
        </div>

    </div>

</div>
@script
    <script>
        $wire.on('clearCart', () => {
            Swal.fire({
                title: "Você tem certeza?",
                text: "Essa ação não poderá ser desfeita!",
                icon: "info",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Sim, pode limpar."
            }).then((result) => {
                if (result.isConfirmed) {
                    $wire.dispatch('limparCarrinho');
                    Swal.fire({
                        title: "Limpo!",
                        text: "Seu carrinho está totalmente limpo.",
                        icon: "success"
                    });
                }
            });
        });
        $wire.on('enviado', ($message) => {
            Swal.fire({
                title: "Sucesso!",
                text: $message,
                icon: "success"
            });
        });
        $wire.on('error', ($message) => {
            Swal.fire({
                title: "Erro!",
                text: $message,
                icon: "error"
            });
        });
    </script>
@endscript
