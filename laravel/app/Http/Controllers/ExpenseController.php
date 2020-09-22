<?php

namespace App\Http\Controllers;

use App\Expense;
use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $expenses = DB::table('expenses as c')
            ->join('users as a', 'c.who_pay_the_money', '=', 'a.id')
            ->select('c.id',
                'a.name as ödemeyi_yapan',
                'c.amount as ücret',
                'c.description as açıklama',
                'c.date as tarih')
            ->get();

        return response()->json( compact('expenses') );
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
        $expense = new Expense();
        $expense->who_pay_the_money = $request->input('who_pay_the_money');
        $expense->amount = $request->input('amount');
        $expense->date = $request->input('date');
        $expense->description = $request->input('description');
        $expense->save();


        return response()->json( array('success' => true) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $expense = DB::table('expenses')
            ->select('id',
                        'date as Tarih',
                        'amount as Ücret',
                        'who_pay_the_money as Parayı_Ödeyen',
                        'description as Açıklama',
                'created_at as İşlem_Tarihi')
            ->where('id', '=', $id)
            ->first();
        return response()->json( $expense );
    }

    public function report()
    {
        $expense = new stdClass();
        $expense->daily_expense = Expense::where("date",">=",date("Y-m-d 00:00:00"))->sum('amount');
        $expense->weekly_expense = Expense::where("date",">=",date("Y-m-d 00:00:00",strtotime('1 weeks ago')))->sum('amount');
        $expense->monthly_expense = Expense::where("date",">=",date("Y-m-d 00:00:00",strtotime('1 months ago')))->sum('amount');
        $expense->yearly_expense = Expense::where("date",">=",date("Y-m-d 00:00:00",strtotime('1 years ago')))->sum('amount');
        $expense->all_expense = Expense::sum('amount');
        $expense->gokhan_expense = Expense::whereWhoPayTheMoney(10)->sum('amount');
        $expense->yusuf_expense = Expense::whereWhoPayTheMoney(20)->sum('amount');
        return response()->json( $expense );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $expense = DB::table('expenses')
            ->select(
                'expenses.id',
                'expenses.who_pay_the_money',
                'expenses.amount',
                'expenses.date')
            ->where('expenses.id', '=', $id)
            ->first();
        return response()->json( $expense );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $validatedData = $request->validate([
//            'name'       => 'required|min:1|max:256',
//            'email'      => 'required|email|max:256'
//        ]);
        $expense = Expense::find($id);
        $expense->who_pay_the_money       = $request->input('who_pay_the_money');
        $expense->amount      = $request->input('amount');
        $expense->date      = $request->input('date');
        $expense->description = $request->input('description');
        $expense->save();
        //$request->session()->flash('message', 'Successfully updated user');
        return response()->json( ['status' => 'success'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Expense  $expense
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $expense = Expense::find($id);
        if($expense){
            $expense->delete();
        }
        return response()->json( ['status' => 'success'] );
    }
}
