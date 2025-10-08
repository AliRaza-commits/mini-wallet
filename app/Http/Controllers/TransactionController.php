<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Services\TransactionService;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected TransactionService $service;

    public function __construct(TransactionService $service)
    {
        $this->service = $service;
    }

    public function index(Request $request)
    {
        $user = $request->user();
        return response()->json($this->service->getUserTransactions($user));
    }

    public function store(StoreTransactionRequest $request)
    {
        $user = auth()->user();
        $transaction = $this->service->transfer(
            $user,
            $request->receiver_id,
            $request->amount
        );

        return response()->json(['message' => 'Transfer successful', 'transaction' => $transaction]);
    }
}
