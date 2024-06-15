<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function create()
    {
        $users = User::all();
        return view('transactions.create', compact('users'));
    }

    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'recipient_id' => 'required|exists:users,id',
                'amount' => 'required|numeric|min:0.01',
                'description' => 'nullable|string|max:255',
            ], [
                'recipient_id.required' => 'Recipient is required.',
                'recipient_id.exists' => 'Recipient does not exist.',
                'amount.required' => 'Amount is required.',
                'amount.numeric' => 'Amount must be a number.',
                'amount.min' => 'Amount must be at least :min.',
                'description.max' => 'Description may not be greater than :max characters.',
            ]);

            $sender = auth()->user();
            $recipient = User::findOrFail($data['recipient_id']);

            if ($sender->balance < $data['amount']) {
                throw ValidationException::withMessages(['amount' => 'Amount exceeds your current balance ('.$sender->balance.').']);
            }

            if ($sender->id == $recipient->id) {
                throw ValidationException::withMessages(['recipient_id' => 'You cannot send transaction to yourself.']);
            }            

            DB::transaction(function () use ($sender, $recipient, $data) {
                $sender->balance -= $data['amount'];
                $sender->save();

                $recipient->balance += $data['amount'];
                $recipient->save();

                Transaction::create([
                    'sender_id' => $sender->id,
                    'recipient_id' => $recipient->id,
                    'amount' => $data['amount'],
                    'description' => $data['description'],
                    'completed_at' => now(),
                ]);
            });

            return redirect()->route('dashboard');
        } catch (ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
    }
}
