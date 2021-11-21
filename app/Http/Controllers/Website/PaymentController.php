<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Auth;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()){
            $data = [
                'payment_method' => request()->get('payment_method'),
                'booking' => Booking::find(request()->get('booking_id')),
                // 'pay_with_cash' => request()->get('pay_with_cash')
            ];
            return response()->json([
                'modal_content' => view('website.payments.create', $data)->render()
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
			'booking_id' => 'required',
			'payment_method' => 'required',
            'proof_of_payment' => 'required|image|mimes:jpeg,png,jpg',
        ]);
        if(Booking::where('id', $request->get('booking_id'))){
            $booking = Booking::find($request->get('booking_id'));

            if($request->get('payment_method') == 'cash'){
                $amount = $request->get('amount');
            
                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'payment_status' => 'confirmed',
                    'mode_of_payment' => 'cash',
                    'amount' => $request->get('amount'),
                ]);
                $amount = Payment::where([
                    ['booking_id', $booking->id],
                    ['payment_status', 'confirmed'],
                ])->sum('amount');
                $payment_status = 'paid';
                if($amount < $payment->booking->amount){
                    $payment_status = 'partial';
                }
                $payment->booking->update([
                    'payment_status' => $payment_status
                ]);

                return redirect()->route('admin.bookings.show', $booking->id)->with('alert-success', 'Saved');

            }elseif($request->get('payment_method') == 'gcash'){
                $payment = Payment::create([
                    'booking_id' => $booking->id,
                    'payment_status' => 'pending',
                    'mode_of_payment' => 'gcash',
                    'amount' => 0,
                ]);
                if($request->file('proof_of_payment')){
                    $file = $request->file('proof_of_payment');
                    $fileName = 'Booking-Payment['.$request->get('name') . '][' . $request->get('payment_method') . '] ' . date('F d,Y h-i-A') . '.' . $file->getClientOriginalExtension();
                    Storage::disk('upload')->putFileAs('images/proof-of-payments', $file, $fileName);
                    $payment->update([
                        'proof_of_payment' => $fileName
                    ]);
                }

                return redirect()->route('client_bookings.index')->with('alert-success', 'Saved');
            }

        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        if(request()->ajax()){
            $data = [
                'payment_show' => $payment,
            ];
            return response()->json([
                'modal_content' => view('website.payments.show', $data)->render()
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        if(request()->ajax()){
            $data = [
                'payment_edit' => $payment,
            ];
            return response()->json([
                'modal_content' => view('website.payments.edit', $data)->render()
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'remarks' => 'required'
        ]);
        
        if($request->get('remarks') == 'confirmed'){
            $request->validate([
                'amount_confirmed' => 'required'
            ]);
            $amount = $request->get('amount_confirmed');
            $payment->update([
                'payment_status' => $request->get('remarks'),
                'amount' => $amount,
            ]);
            $amount = Payment::where([
                ['booking_id', $payment->booking->id],
                ['payment_status', 'confirmed'],
            ])->sum('amount');
            $payment_status = 'paid';
            if($amount < $payment->booking->amount){
                $payment_status = 'partial';
            }
            $payment->booking->update([
                'payment_status' => $payment_status
            ]);
        }else{
            $payment->update([
                'payment_status' => 'denied',
            ]);
        }

        return redirect()->route('admin.bookings.show', $payment->booking_id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }
}
