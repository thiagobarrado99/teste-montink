@extends('layouts.dashboard')

@section('header')
<i class="fas fa-box"></i> Pedidos
@endsection

@section('content')
<script>
    function ChangeStatus(id, current)
    {
        $("#edit_modal").modal("show");
        $("#edit_form").attr("action", `{{ route('orders.index') }}/${id}`);
        $("#order_status_select").val(current);
    }
</script>
@include('dataTable', [
    'table_id' => 'table_orders',
    'models' => $data,
    'column_defs' => '[{"targets": [1, 2], "responsivePriority": 90}, {"targets": [0, 3], "responsivePriority": 1}]',
    'columns' => [
        "id" => [
            "header" => "ID"
        ],
        "client_id" => [
            "header" => "Cliente",
            "model_function" => function ($model) { 
                return "Nome: " . $model->client->name .
                        ($model->client->tax_id ? "<br>Documento: " . $model->client->tax_id : "") .
                        ($model->client->email ? "<br>Email: " . $model->client->email : "") .
                        ($model->client->phone ? "<br>Telefone: " . $model->client->phone : "");
            }
        ],
        "address" => [
            "header" => "Endereço",
            "model_function" => function ($model) {
                return $model->client->address . ", " . $model->client->number . 
                        "<br>".$model->client->neighborhood . 
                        "<br>".$model->client->city . " - " . $model->client->state .
                        "<br>".$model->client->zipcode;
            }
        ],
        "order" => [
            "header" => "Valores",
            "model_function" => function ($model) {
                $result = "";
                foreach($model->orderTotals as $total)
                {
                    $result .= $total->description . "<span class='fw-bold ".($total->is_discount ? "text-success" : "")."'>&nbsp;(".money_format($total->total).")</span><br>";
                }
                return $result;
            }
        ],
        "total" => [
            "header" => "Valor final",
            "model_function" => function ($model) {
                return money_format($model->total);
            }
        ],
        "status" => [
            "header" => "Status",
            "model_function" => function ($model) {
                return $model->statusLabel();
            }
        ]
    ],
    'action_column' => function ($model){ return '
    <button onclick="ChangeStatus(`'.$model->id.'`, `'.$model->status.'`)" title="Alterar status" class="btn btn-sm btn-primary"><i class="fas fa-pen"></i></button>
    '; },
])
<div class="modal fade" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="edit_modal" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Alterar status</h5>
            </div>
            <form id="edit_form" method="post">
                @method("PUT")
                @csrf
                <div class="modal-body">
                    <label class="w-100">
                        Status
                        <select id="order_status_select" class="form-control" name="status">
                            @foreach (\App\Models\Order::$statusLabels as $id => $label)
                                <option value="{{ $id }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="modal-footer">
                    <button type="button" data-bs-dismiss="modal" class="btn btn-danger">Voltar</button>
                    <input type="submit" class="btn btn-success" value="Alterar status">
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer')
<p class="text-muted mb-0">Os dados são atualizados junto com a pagina.</p>
@endsection
