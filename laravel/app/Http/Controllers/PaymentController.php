<?php

namespace App\Http\Controllers;

use App\Payment;
use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = DB::table('payments as c')
            ->join('users as a', 'c.who_pay_the_money', '=', 'a.id')
            ->select('c.id',
                'a.name as ödemeyi_yapan',
                'c.amount as ücret',
                'c.description as açıklama',
                'c.date as tarih')
            ->get();

        return response()->json( compact('payments') );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'amount' => 'required|min:1|max:64'
        ]);
        $payment = new Payment();
        $payment->who_pay_the_money = $request->input('who_pay_the_money');
        $payment->amount = $request->input('amount');
        $payment->date = $request->input('date');
        $payment->description = $request->input('description');
        $payment->save();


        return response()->json( array('success' => true) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = DB::table('payments')
            ->select('id',
                'date as Tarih',
                'amount as Ücret',
                'who_pay_the_money as Parayı_Ödeyen',
                'description as Açıklama',
                'created_at as İşlem_Tarihi')
            ->where('id', '=', $id)
            ->first();
        return response()->json( $payment );
    }

    public function report()
    {
        $payment = new stdClass();
        $payment->gokhan_payment = Payment::whereWhoPayTheMoney(10)->sum('amount');
        $payment->yusuf_payment = Payment::whereWhoPayTheMoney(20)->sum('amount');
        return response()->json( $payment );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $payment = DB::table('payments')
            ->select(
                'payments.id',
                'payments.who_pay_the_money',
                'payments.amount',
                'payments.date',
                'payments.description')
            ->where('payments.id', '=', $id)
            ->first();
        return response()->json( $payment );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $validatedData = $request->validate([
//            'name'       => 'required|min:1|max:256',
//            'email'      => 'required|email|max:256'
//        ]);
        $payment = Payment::find($id);
        $payment->who_pay_the_money       = $request->input('who_pay_the_money');
        $payment->amount      = $request->input('amount');
        $payment->date      = $request->input('date');
        $payment->description = $request->input('description');
        $payment->save();
        //$request->session()->flash('message', 'Successfully updated user');
        return response()->json( ['status' => 'success'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);
        if($payment){
            $payment->delete();
        }
        return response()->json( ['status' => 'success'] );
    }
}
