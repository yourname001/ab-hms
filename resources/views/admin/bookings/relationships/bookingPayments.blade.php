<div class="card">
    <div class="card-header">
        {{ trans('cruds.payment.title') }}
    </div>
    <div class="card-body">
        @can('payment_create')
            <div style="margin-bottom: 10px;" class="row">
                <div class="col-lg-12">
                    <a href="javascript:void(0)" data-toggle="modal-ajax" data-target="#bookingPayment" data-href="{{ route('admin.payments.create', ['payment_method'=>'cash', 'booking_id'=>$booking->id]) }}" class="btn btn-primary">
                        {{ trans('global.add') }} {{ trans('cruds.payment.title_singular') }}
                    </a>
                </div>
            </div>
        @endcan
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatable datatable-payment">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.payment.fields.id') }}
                        </th>
                        <th>
                            Status
                        </th>
                        <th>
                            Amount
                        </th>
                        <th>
                            {{ trans('cruds.payment.fields.payment_date') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $key => $payment)
                        <tr data-entry-id="{{ $payment->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $payment->id ?? '' }}
                            </td>
                            <td>
                                {!! $payment->getPaymentStatus() !!}
                            </td>
                            <td>
                                ₱ {{ number_format($payment->amount, 2) }}
                            </td>
                            <td>
                                {{ date('F d, Y h:i A', strtotime($payment->created_at)) }}
                            </td>
                            <td>
                                @can('payment_show')
                                    <a class="btn btn-xs btn-primary" href="javascript:void(0)" data-toggle="modal-ajax" data-target="#showPayment" data-href="{{ route('admin.payments.show', $payment->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan
                                @can('payment_edit')
                                    <a class="btn btn-xs btn-info" href="javascript:void(0)" data-toggle="modal-ajax" data-target="#editPayment" data-href="{{ route('admin.payments.edit', $payment->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan
                                @can('payment_delete')
                                    <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
        let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
        @can('payment_delete')
        let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
        let deleteButton = {
            text: deleteButtonTrans,
            url: "{{ route('admin.payments.massDestroy') }}",
            className: 'btn-danger',
            action: function (e, dt, node, config) {
                var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
                    return $(entry).data('entry-id')
                });

                if (ids.length === 0) {
                    alert('{{ trans('global.datatables.zero_selected') }}')

                    return
                }

                if (confirm('{{ trans('global.areYouSure') }}')) {
                    $.ajax({
                        headers: {'x-csrf-token': _token},
                        method: 'POST',
                        url: config.url,
                        data: { 
                            ids: ids, 
                            _method: 'DELETE' 
                        }
                    }).done(function () { 
                        location.reload() 
                    })
                }
            }
        }
        dtButtons.push(deleteButton)
        @endcan

        $.extend(true, $.fn.dataTable.defaults, {
            order: [[ 1, 'desc' ]],
            pageLength: 100,
        });
        $('.datatable-payment:not(.ajaxTable)').DataTable({ buttons: dtButtons })
        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e){
            $($.fn.dataTable.tables(true)).DataTable()
                .columns.adjust();
        });
    })

</script>
@endsection