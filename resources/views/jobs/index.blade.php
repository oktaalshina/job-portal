<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    {{-- Tombol Admin Only --}}
                    @if(Auth::check() && Auth::user()->role === 'admin')
                        <div class="mb-6 space-y-4">
                            {{-- Tombol Tambah Lowongan --}}
                            <a href="{{ route('jobs.create') }}" 
                            class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 transition">
                                Tambah Lowongan
                            </a>
                            <a href="{{ route('jobs.template') }}" 
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Download Template Import
                            </a>

                            {{-- Form Import Lowongan --}}
                            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                                <h3 class="text-sm font-semibold text-gray-700 mb-3">Import Data Lowongan</h3>
                                <form action="{{ route('jobs.import') }}" 
                                    method="POST" 
                                    enctype="multipart/form-data" 
                                    class="flex items-center gap-2">
                                    @csrf
                                    <input type="file" 
                                        name="file" 
                                        required 
                                        accept=".xlsx,.csv"
                                        class="flex-1 text-sm border border-gray-300 rounded-lg cursor-pointer bg-white p-2">
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                        📤 Import
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endif



                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                            <p class="font-semibold">✅ {{ session('success') }}</p>
                        </div>
                    @endif

                    {{-- Table Lowongan --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perusahaan</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Lokasi</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gaji</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Logo</th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($jobs as $job)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $job->title }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $job->company }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">{{ $job->location }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            {{ $job->salary ? 'Rp ' . number_format($job->salary, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">
                                                {{ $job->job_type }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-500">
                                            @if($job->logo)
                                                <img src="{{ asset('storage/' . $job->logo) }}" 
                                                     alt="{{ $job->company }}" 
                                                     class="h-12 w-12 object-cover rounded shadow">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-right text-sm font-medium">
                                            <div class="flex flex-col gap-2 items-end">
                                                
                                                @if(auth()->user() && auth()->user()->role === 'admin')
                                                    <div class="flex gap-2">
                                                        <a href="{{ route('jobs.edit', $job->id) }}" 
                                                        class="text-indigo-600 hover:text-indigo-900 font-semibold">
                                                            Edit
                                                        </a>
                                                        <form action="{{ route('jobs.destroy', $job->id) }}" 
                                                            method="POST" 
                                                            class="inline-block" 
                                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="text-red-600 hover:text-red-900 font-semibold">
                                                                Hapus
                                                            </button>
                                                        </form>
                                                        <a href="{{ route('applications.export', $job->id) }}" 
                                                        class="inline-flex items-center rounded-md bg-green-600 px-3 py-2 text-xs font-semibold text-white hover:bg-green-700">
                                                            Export Pelamar
                                                        </a>
                                                    </div>
                                                @endif



                                                {{-- Tombol Lihat Detail (SEMUA USER) --}}
                                                <a href="{{ route('jobs.show', $job->id) }}" 
                                                   class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                                    Lihat Detail & Lamar
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-8 text-center text-sm text-gray-500">
                                            <p class="text-lg">Belum ada data lowongan.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>