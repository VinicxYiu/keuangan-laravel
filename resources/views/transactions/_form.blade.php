@php $t = $transaction ?? null; @endphp

<div class="space-y-4">
    <div>
        <x-input-label for="type" value="Jenis" />
        <select id="type" name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            <option value="expense" @selected(old('type', $t?->type) === 'expense')>Pengeluaran</option>
            <option value="income" @selected(old('type', $t?->type) === 'income')>Pemasukan</option>
        </select>
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="amount" value="Jumlah (Rp)" />
        <x-text-input id="amount" name="amount" type="number" min="1" class="mt-1 block w-full"
                      :value="old('amount', $t?->amount)" required />
        <x-input-error :messages="$errors->get('amount')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="category" value="Kategori" />
        <x-text-input id="category" name="category" type="text" class="mt-1 block w-full"
                      :value="old('category', $t?->category)" required />
        <x-input-error :messages="$errors->get('category')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="note" value="Catatan (opsional)" />
        <x-text-input id="note" name="note" type="text" class="mt-1 block w-full"
                      :value="old('note', $t?->note)" />
        <x-input-error :messages="$errors->get('note')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="date" value="Tanggal" />
        <x-text-input id="date" name="date" type="date" class="mt-1 block w-full"
                      :value="old('date', $t?->date?->format('Y-m-d') ?? now()->format('Y-m-d'))" required />
        <x-input-error :messages="$errors->get('date')" class="mt-2" />
    </div>

    <div class="flex items-center gap-4">
        <x-primary-button>Simpan</x-primary-button>
        <a href="{{ route('transactions.index') }}" class="text-sm text-gray-600">Batal</a>
    </div>
</div>
