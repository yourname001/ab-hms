<form action="{{ route('payments.store') }}" method="POST" autocomplete="off" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="booking_id" value="{{ $booking->id }}">
    <div class="modal fade" id="bookingPayment" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog {{-- modal-dialog-centered  --}}modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Payment</h5>
                    <button type="button" class="close" data-dismiss="modal-ajax" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body text-center">
                    <legend>Amount: ₱ {{ number_format($booking->amount, 2) }}</legend>
                    @if($payment_method == 'gcash')
                    <input type="hidden" name="payment_method" value="gcash">
                    <div class="form-group text-center">
                        <strong>Scan the qrcode below.</strong>
                        <br>
                        <br>
                        <img src="{{ asset('images/qrcode.jpg') }}" alt="" class="img-thumbnail" style="border: none; background-color: transparent" width="250px">
                        <br>
                        <br>
                    </div>
                    @endif
                    <div class="form-group">
                        <strong>Take a screenshot of your payment and upload the image using the button below.</strong>
                        <br>
                        <label class="btn btn-primary btn-sm">
                            Upload image here&hellip;<input value="" type="file" name="proof_of_payment" style="display: none;" accept="image/*" required/>
                        </label>
                        {{-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addImage">Upload Image</button>
                        <div class="modal fade" id="addImage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <img id="img" width="100%" class="img-thumbnail" style="border: none; background-color: transparent" src="{{ asset('images/image-icon.png') }}" />
                                            <label class="btn btn-primary btn-block">
                                                Browse&hellip;<input value="" type="file" name="image" style="display: none;" id="upload" accept="image/*" />
                                            </label>
                                        </div>
                                        <hr>
                                        <button type="button" class="btn btn-primary close-modal" data-dismiss="#addImage" aria-hidden="true">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal-ajax">Cancel</button>
                    <button class="btn btn-default text-success" type="submit"><i class="fas fa-save"></i> Save</button>
                </div>
            </div>
        </div>
    </div>
</form>
{{-- <script>
    $(function(){
        $('.close-modal').click(function() {
            $($(this).attr('data-dismiss')).modal('hide');
        });
    })
</script> --}}