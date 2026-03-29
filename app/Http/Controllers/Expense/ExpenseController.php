<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExpenseController extends Controller
{
    //

        /**
     * Display a listing of the expenses.
     */
    public function index()
    {
        $expenses = Expense::orderBy('date', 'desc')->get();
        return view('Backend.Expense.index', compact('expenses'));
    }

    /**
     * Store a newly created expense in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'date' => 'required|date',
            'note' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'The expense title is required.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'amount.min' => 'The amount must be at least 0.',
            'amount.regex' => 'The amount can have up to 2 decimal places.',
            'date.required' => 'The date is required.',
            'date.date' => 'Please provide a valid date.',
            'note.max' => 'The note cannot exceed 1000 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the expense
        Expense::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense added successfully!');
    }

    /**
     * Update the specified expense in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the expense
        $expense = Expense::findOrFail($id);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0|regex:/^\d+(\.\d{1,2})?$/',
            'date' => 'required|date',
            'note' => 'nullable|string|max:1000',
        ], [
            'title.required' => 'The expense title is required.',
            'amount.required' => 'The amount is required.',
            'amount.numeric' => 'The amount must be a valid number.',
            'amount.min' => 'The amount must be at least 0.',
            'amount.regex' => 'The amount can have up to 2 decimal places.',
            'date.required' => 'The date is required.',
            'date.date' => 'Please provide a valid date.',
            'note.max' => 'The note cannot exceed 1000 characters.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update the expense
        $expense->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'date' => $request->date,
            'note' => $request->note,
        ]);

        return redirect()->route('expenses.index')
            ->with('success', 'Expense updated successfully!');
    }

    /**
     * Remove the specified expense from storage.
     */
    public function destroy($id)
    {
        try {
            $expense = Expense::findOrFail($id);
            $expense->delete();

            return redirect()->route('expenses.index')
                ->with('success', 'Expense deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('expenses.index')
                ->with('error', 'Failed to delete expense. Please try again.');
        }
    }



}
