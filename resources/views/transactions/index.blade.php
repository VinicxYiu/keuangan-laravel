<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Catatan Keuangan</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if (session('status'))
                <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('status') }}</div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 px-4 sm:px-0">
                <div class="bg-white shadow sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Pemasukan</p>
                    <p class="text-xl font-semibold text-green-600">Rp {{ number_format($income, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Pengeluaran</p>
                    <p class="text-xl font-semibold text-red-600">Rp {{ number_format($expense, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white shadow sm:rounded-lg p-4">
                    <p class="text-sm text-gray-500">Saldo</p>
                    <p class="text-xl font-semibold text-gray-900">Rp {{ number_format($balance, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white shadow sm:rounded-lg p-6">
                <a href="{{ route('transactions.create') }}"
                   class="inline-block bg-gray-800 text-white rounded-md px-4 py-2 text-sm font-semibold hover:bg-gray-700">
                    Tambah catatan
                </a>

                <div class="overflow-x-auto mt-4">
                    <table class="w-full text-sm text-left">
                        <thead class="text-gray-500">
                            <tr>
                                <th class="py-2">Tanggal</th>
                                <th>Kategori</th>
                                <th>Catatan</th>
                                <th class="text-right">Jumlah</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($transactions as $t)
                                <tr class="border-t">
                                    <td class="py-2 whitespace-nowrap">{{ $t->date->format('d M Y') }}</td>
                                    <td>{{ $t->category }}</td>
                                    <td>{{ $t->note }}</td>
                                    <td class="text-right whitespace-nowrap {{ $t->type === 'income' ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $t->type === 'income' ? '+' : '-' }} Rp {{ number_format($t->amount, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right whitespace-nowrap">
                                        <a href="{{ route('transactions.edit', $t) }}" class="text-indigo-600">Ubah</a>
                                        <form method="POST" action="{{ route('transactions.destroy', $t) }}" class="inline"
                                              onsubmit="return confirm('Hapus catatan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 ml-3">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-6 text-center text-gray-500">
                                        Belum ada catatan. Tambahkan yang pertama.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">{{ $transactions->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>
