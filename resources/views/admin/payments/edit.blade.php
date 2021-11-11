<form action="{{ route('payments.update', $payment_edit->id) }}" method="POST" autocomplete="off">
    @csrf
    @method('PUT')
    <div class="modal fade" id="editPayment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog {{-- modal-dialog-centered  --}}modal-md modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @if(!is_null($payment_edit->proof_of_payment))
                    <div class="form-group text-center">
                        <img src="{{ asset('images/proof-of-payments/'.$payment_edit->proof_of_payment) }}" class="img-thumbnail">
                    </div>
                    <hr>
                    @endif
                    <div class="form-group">
                        <label>Remarks: </label>
                        <div class="radio">
                            <div class="custom-control custom-radio">
                                <input required type="radio" class="custom-control-input" name="remarks" @if($payment_edit->payment_status == 'confirmed') checked @endif value="confirmed" id="paymentConfirmed">
                                <label class="custom-control-label" for="paymentConfirmed">Confirmed</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input required type="radio" class="custom-control-input" name="remarks" @if($payment_edit->payment_status == 'denied') checked @endif value="denied" id="paymentDenied">
                                <label class="custom-control-label" for="paymentDenied">Denied</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="amount">
                        <label for="amountConfirmed">Amount Confirmed:</label>
                        <input type="number" class="form-control" name="amount_confirmed" id="amountConfirmed" value="{{ $payment_edit->amount }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    // $(function(){

        $('input[type="radio"][name="remarks"]').on('change', function(){
            updateAmountInput()
        })

        function updateAmountInput() {
            if($('#paymentConfirmed').prop('checked')){
                $('#amountConfirmed').prop('disabled', false)
                // $('#amount').addClass('d-none')
            }else{
                $('#amountConfirmed').prop('disabled', true)
                // $('#amount').removeClass('d-none')
            }
        }

        updateAmountInput()
    // })
</script>