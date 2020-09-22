<?php

namespace App\Http\Controllers;

use App\Income;
use App\User;
use stdClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $incomes = DB::table('incomes as c')
            ->join('users as a', 'c.job_done_by', '=', 'a.id')
            ->join('users as b', 'c.who_take_the_money', '=', 'b.id')
            ->select('c.id',
            'b.name as ücreti_alan',
            'a.name as işi_yapan',
            'c.amount as ücret',
            'c.description as açıklama',
            'c.date as tarih')
            ->get();

//        $incomes->each(function ($item) {
//            $item->işi_yapan = User::find($item->job_done_by)->name;
//            $item->ücreti_alan = User::find($item->who_take_the_money)->name;
//        });

        return response()->json( compact('incomes') );
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
        $income = new Income();
        $income->job_done_by = $request->input('job_done_by');
        if ($request->has('who_take_the_money')) {
            $income->who_take_the_money = $request->input('who_take_the_money');
        }
        $income->amount = $request->input('amount');
        $income->date = $request->input('date');
        $income->description = $request->input('description');
        $income->save();


        return response()->json( array('success' => true) );
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $income = DB::table('incomes')
            ->select('id',
                'who_take_the_money as Parayı_Alan',
                'date as Tarih',
                'amount as Ücret',
                'job_done_by as İşi_Yapan',
                'description as Açıklama',
                'created_at as İşlem_Tarihi')
            ->where('id', '=', $id)
            ->first();
        return response()->json( $income );
    }

    public function report()
    {
        $expense = new stdClass();
        $expense->daily_income = Income::where("date",">=",date("Y-m-d 00:00:00"))->sum('amount');
        $expense->weekly_income = Income::where("date",">=",date("Y-m-d 00:00:00",strtotime('1 weeks ago')))->sum('amount');
        $expense->monthly_income = Income::where("date",">=",date("Y-m-d 00:00:00",strtotime('1 months ago')))->sum('amount');
        $expense->yearly_income = Income::where("date",">=",date("Y-m-d 00:00:00",strtotime('1 years ago')))->sum('amount');
        $expense->all_income = Income::sum('amount');
        $expense->gokhan_income = Income::whereWhoTakeTheMoney(10)->sum('amount');
        $expense->yusuf_income = Income::whereWhoTakeTheMoney(20)->sum('amount');
        return response()->json( $expense );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $income = DB::table('incomes')
            ->select(
                'incomes.id',
                'incomes.job_done_by',
                'incomes.who_take_the_money',
                'incomes.amount',
                'incomes.date')
            ->where('incomes.id', '=', $id)
            ->first();
        return response()->json( $income );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
//        $validatedData = $request->validate([
//            'name'       => 'required|min:1|max:256',
//            'email'      => 'required|email|max:256'
//        ]);
        $income = Income::find($id);
        $income->job_done_by       = $request->input('job_done_by');
        empty($request->input('who_take_the_money'))? '':$income->who_take_the_money = $request->input('who_take_the_money');
        $income->amount      = $request->input('amount');
        $income->date      = $request->input('date');
        $income->description = $request->input('description');
        $income->save();
        //$request->session()->flash('message', 'Successfully updated user');
        return response()->json( ['status' => 'success'] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Income  $income
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $income = Income::find($id);
        if($income){
            $income->delete();
        }
        return response()->json( ['status' => 'success'] );
    }
}
