<div class="modal fade" id="showPayment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog {{-- modal-dialog-centered  --}}modal-md modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment</h5>
                <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @if($payment_show->payment_status == 'confirmed')
                <div class="form-group">
                    <label>Date Confirmed:</label>
                    {{ date('F d, Y h:i A', strtotime($payment_show->updated_at)) }}
                </div>
                <hr>
                @endif
                <div class="form-group text-center">
                    <img src="{{ asset('images/proof-of-payments/'.$payment_show->proof_of_payment) }}" class="img-thumbnail">
                </div>
            </div>
        </div>
    </div>
</div>