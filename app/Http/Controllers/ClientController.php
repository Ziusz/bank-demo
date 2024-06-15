<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class ClientController extends Controller
{
    public function index()
    {
        $transactions = Transaction::where('sender_id', auth()->id())
                                    ->orWhere('recipient_id', auth()->id())
                                    ->orderBy('created_at', 'desc')
                                    ->get();
        $balance = auth()->user()->balance;

        return view('dashboard', compact('transactions', 'balance'));
    }    
}
