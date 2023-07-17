<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class ExpenseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response(['expenses' => Expense::orderBy('id','desc')->get()]);
    }

    /**
     * Store a newly created resource in storage.
     * @throws ValidationException
     */
    public function store(Request $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->validate($request, [
            'newRecord.comment' => 'string|max:255',
            'newRecord.sum' => 'required|numeric',
            'newRecord.date' => 'date|required',
        ]);

        $newRecord = new Expense();
        $newRecord->comment = $request->input('newRecord')['comment'];
        $newRecord->sum = Str::slug($request->input('newRecord')['sum']);
        $newRecord->date = Carbon::parse($request->input('newRecord')['date']);
        $newRecord->save();
        return response(['newRecord' => $newRecord]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $this->validate($request, [

            'editExpense.comment' => 'string|max:255',
            'editExpense.sum' => 'required|numeric',
            'editExpense.date' => 'date|required',
        ]);
        Expense::find($id)->update($request->input(['editExpense']));
        return response(['expense' => Expense::orderBy('id','desc')->get()]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Expense::find($id)->delete();
        return response(['message' => 'record deleted']);
    }
}
