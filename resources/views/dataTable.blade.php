<table id="{{ $table_id }}" data-table="true"
    @if (isset($data_columns)) data-columns="{!! $data_columns !!}" @endif
    @if (isset($order)) data-order="{!! $order !!}" @endif
    @if (isset($searching)) data-searching="{!! $searching !!}" @endif
    @if (isset($paging)) data-paging="{!! $paging !!}" @endif
    @if (isset($info)) data-info="{!! $info !!}" @endif
    @if (isset($column_defs)) data-column-defs='{!! $column_defs !!}' @endif
    @if (isset($order_type)) data-order-type="{!! $order_type !!}" @endif>
    <thead>
        @foreach ($columns as $column)
            <th>{{ $column['header'] }}</th>
        @endforeach
        @if (isset($action_column))
            <th>Ações</th>
        @endif
    </thead>
    <tbody>
        @foreach ($models as $model)
            <tr id="model_{{ $model->id }}">
                @foreach ($columns as $column => $content)
                    @if (isset($content['model_function']) && is_callable($content['model_function']))
                        <td @if (isset($content['order'])) data-order="{!! call_user_func($content['order'], $model) !!}" @endif>
                            {!! call_user_func($content['model_function'], $model) !!}
                        </td>
                    @else
                        <td @if (isset($content['order'])) data-order="{!! call_user_func($content['order'], $model) !!}" @endif>
                            {{ $model->{$column} }}
                        </td>
                    @endif
                @endforeach

                @if (isset($action_column))
                    <td>
                        {!! is_callable($action_column) ? call_user_func($action_column, $model) : $action_column !!}
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
