<?php

namespace App\Services;

use App\Events\TransactionBroadcasted;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionService
{
    const COMMISSION_RATE = 0.015;

    public function transfer(User $sender, int $receiverId, float $amount): Transaction
    {
        $receiver = User::findOrFail($receiverId);
        $commission = round($amount * self::COMMISSION_RATE, 2);
        $totalDebit = $amount + $commission;

        if ($sender->id === $receiver->id) {
            throw ValidationException::withMessages(['receiver_id' => 'Cannot transfer to self']);
        }

        if ($sender->balance < $totalDebit) {
            throw ValidationException::withMessages(['amount' => 'Insufficient balance']);
        }

        return DB::transaction(function () use ($sender, $receiver, $amount, $commission, $totalDebit) {
            // Lock rows for update
            $sender->lockForUpdate();
            $receiver->lockForUpdate();

            // Update balances
            $sender->decrement('balance', $totalDebit);
            $receiver->increment('balance', $amount);

            // Record transaction
            $transaction = Transaction::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'amount' => $amount,
                'commission_fee' => $commission,
                'created_at' => now(),
            ]);

            //send to pusher
            broadcast(new TransactionBroadcasted($transaction));
            return $transaction;
        });
    }

   public function getUserTransactions()
    {
        $perPage = request('per_page', 5);
        $user = auth()->user();

        $transactions = Transaction::with('sender', 'receiver')
            ->where('sender_id', $user->id)
            ->orWhere('receiver_id', $user->id)
            ->latest()
            ->paginate($perPage);

        return ([
            'balance' => $user->balance,
            'transactions' => $transactions
        ]);
    }
}
