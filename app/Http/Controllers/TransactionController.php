<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $transactions = $user->transactions()
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->paginate(10);

        $income = $user->transactions()->where('type', 'income')->sum('amount');
        $expense = $user->transactions()->where('type', 'expense')->sum('amount');

        return view('transactions.index', [
            'transactions' => $transactions,
            'income' => $income,
            'expense' => $expense,
            'balance' => $income - $expense,
        ]);
    }

    public function create(): View
    {
        return view('transactions.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->user()->transactions()->create($this->validated($request));

        return redirect()->route('transactions.index')->with('status', 'Catatan disimpan.');
    }

    public function edit(Transaction $transaction): View
    {
        $this->ensureOwner($transaction);

        return view('transactions.edit', ['transaction' => $transaction]);
    }

    public function update(Request $request, Transaction $transaction): RedirectResponse
    {
        $this->ensureOwner($transaction);
        $transaction->update($this->validated($request));

        return redirect()->route('transactions.index')->with('status', 'Catatan diperbarui.');
    }

    public function destroy(Transaction $transaction): RedirectResponse
    {
        $this->ensureOwner($transaction);
        $transaction->delete();

        return redirect()->route('transactions.index')->with('status', 'Catatan dihapus.');
    }

    private function ensureOwner(Transaction $transaction): void
    {
        abort_unless($transaction->user_id === auth()->id(), 403);
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'type' => ['required', 'in:income,expense'],
            'amount' => ['required', 'integer', 'min:1'],
            'category' => ['required', 'string', 'max:50'],
            'note' => ['nullable', 'string', 'max:255'],
            'date' => ['required', 'date'],
        ]);
    }
}
