@extends('layouts.dashboard')

@section('header')
    <i class="fas fa-tag"></i> Novo cupom
@endsection

@section('content')
    <script>
        function GenerateCode(element, segments = 3, segment_length = 4)
        {
            const getLetters = () =>
                Array.from({ length: segment_length }, () =>
                String.fromCharCode(65 + Math.floor(Math.random() * 26))
                ).join('');

            $(element).val(Array.from({ length: segments }, getLetters).join('-'));
        }

        function UpdateType()
        {
            let is_percentage = $("select[name='is_percentage']").val() == 0;

            $("#discount_fixed_value > input").prop("disabled", !is_percentage);
            $("#discount_fixed_value").toggleClass("d-none", !is_percentage);

            $("#discount_percent_value > input").prop("disabled", is_percentage);
            $("#discount_percent_value").toggleClass("d-none", is_percentage);
        }
    </script>
    <form id="create_form" action="{{ route('coupons.store') }}" method="post">
        @csrf
        <div class="row">
            <div class="col-md-6 mb-2">
                <label class="w-100">
                    Nome*
                    <input class="w-100 form-control" type="text" maxlength="64" required name="name">
                </label>
            </div>
            <div class="col-md-3 mb-2">
                <label class="w-100">
                    Código*
                    <div class="input-group">
                        <input id="coupon_code" class="form-control" type="text" maxlength="16" required name="code">
                        <button title="Gerar aleatório" role="button" onclick="GenerateCode('#coupon_code');" type="button" class="btn btn-primary">
                            <i class="fas fa-random"></i>
                        </button>
                    </div>
                </label>
            </div>
            <div class="col-md-3 mb-2">
                <label class="w-100">
                    Tipo*
                    <select onchange="UpdateType();" class="w-100 form-control" name="is_percentage">
                        <option value="0">Fixo</option>
                        <option value="1">Porcentagem</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 mb-2">
                <label class="w-100">
                    Quantidade de desconto*
                    <div id="discount_fixed_value" class="input-group">
                        <input class="form-control mask-money" type="text" value="R$ 0,00" required name="discount_value">
                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-dollar-sign"></i></span>
                    </div>

                    <div id="discount_percent_value" class="input-group d-none">
                        <input class="form-control" disabled type="number" min="0" max="99" step="1" required name="discount_value">
                        <span class="input-group-text" id="basic-addon2"><i class="fas fa-percentage"></i></span>
                    </div>
                </label>
            </div>
            <div class="col-md-3 mb-2">
                <label class="w-100">
                    Valor minimo
                    <input class="w-100 form-control mask-money" type="text" name="minimum_price" value="R$ 0,00">
                </label>
            </div>
            <div class="col-md-3 mb-2">
                <label class="w-100">
                    Maximo de usos (Zero para ilimitado)
                    <input class="w-100 form-control" type="text" name="max_uses" value="0">
                </label>
            </div>
            <div class="col-md-3 mb-2">
                <label class="w-100">
                    Expira em*
                    <input class="w-100 form-control" type="datetime-local" required name="expires_at" value="{{ date_create()->modify('+7 days')->format('Y-m-d') . " 23:59" }}">
                </label>
            </div>
        </div>
        <div class="row mt-4">
            <div class="col-md-6">
                <a href="{{ route('coupons.index') }}" class="btn btn-danger w-100">Voltar</a>
            </div>
            <div class="col-md-6">
                <input type="submit" class="btn btn-success w-100" value="Criar cupom">
            </div>
        </div>
    </form>
@endsection

@section('footer')
    <p class="text-muted mb-0">Campos marcados com * são obrigatórios.</p>
@endsection
