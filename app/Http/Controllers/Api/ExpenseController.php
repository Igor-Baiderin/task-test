<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpenseRequest;
use App\Models\Expense;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Foundation\Application;
use Illuminate\Http\Response;
use Illuminate\Support\Carbon;
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
    public function store(ExpenseRequest $request): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        $newRecord = new Expense();
        $newRecord->comment = $request->input('data')['comment'];
        $newRecord->sum = Str::slug($request->input('data')['sum']);
        $newRecord->date = Carbon::parse($request->input('data')['date']);
        $newRecord->save();
        return response(['success' => true, 'notification' => ['title' => 'Позиция добавлена', 'type' => 'success']]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        return response(['expenses' => Expense::find($id)->get()]);
    }

    /**
     * Update the specified resource in storage.
     * @throws ValidationException
     */
    public function update(ExpenseRequest $request, string $id): Application|Response|\Illuminate\Contracts\Foundation\Application|ResponseFactory
    {
        Expense::find($id)->update($request->input(['data']));
        return response(['success' => true, 'notification' => ['title' => 'Изменения сохранены', 'type' => 'success']]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Expense::find($id)->delete();
        return response(['success' => true, 'notification' => ['title' => 'Позиция удалена', 'type' => 'success']]);
    }
}
