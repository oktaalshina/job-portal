{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Daftar Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">

                    <a href="{{ route('jobs.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 mb-6">
                        Tambah Lowongan
                    </a>

                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if($jobs->isEmpty())
                        <p class="text-gray-500 text-center">Belum ada data lowongan.</p>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($jobs as $job)
                                <div class="border rounded-lg shadow-sm p-4 flex flex-col justify-between">
                                    <div>
                                        @if($job->logo)
                                            <img src="{{ asset('storage/' . $job->logo) }}" 
                                                 alt="{{ $job->company }} logo" 
                                                 class="h-20 w-20 object-cover rounded mb-3">
                                        @else
                                            <div class="h-20 w-20 bg-gray-200 rounded flex items-center justify-center mb-3 text-gray-500">
                                                No Logo
                                            </div>
                                        @endif

                                        <h3 class="text-lg font-semibold text-gray-800">{{ $job->title }}</h3>
                                        <p class="text-sm text-gray-600">{{ $job->company }}</p>
                                        <p class="text-sm text-gray-600 mt-1">
                                            <span class="font-medium text-gray-700">Lokasi:</span> {{ $job->location }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium text-gray-700">Jenis:</span> {{ $job->job_type ?? '-' }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            <span class="font-medium text-gray-700">Gaji:</span> 
                                            {{ $job->salary ? 'Rp ' . number_format($job->salary, 0, ',', '.') : '-' }}
                                        </p>
                                    </div>

                                    <div class="mt-4 flex justify-between items-center">
                                        <a href="{{ route('jobs.edit', $job->id) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">Edit</a>
                                        <form action="{{ route('jobs.destroy', $job->id) }}" 
                                              method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="text-red-600 hover:text-red-900 text-sm font-medium">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

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

                    {{-- Tombol Tambah Lowongan --}}
                    <a href="{{ route('jobs.create') }}" 
                       class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150 mb-6">
                        Tambah Lowongan
                    </a>

                    {{-- Form Import Lowongan --}}
                    <form action="{{ route('jobs.import') }}" 
                          method="POST" 
                          enctype="multipart/form-data" 
                          class="mb-6">
                        @csrf
                        <div class="flex items-center gap-2">
                            <input type="file" 
                                   name="file" 
                                   required 
                                   class="border border-gray-300 rounded px-3 py-2 text-sm">
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 transition">
                                Import Lowongan
                            </button>
                        </div>
                    </form>

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    {{-- Table Lowongan --}}
                    <div class="overflow-x-auto border rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Judul
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Perusahaan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Lokasi
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Gaji
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Jenis Pekerjaan
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Logo
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse ($jobs as $job)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $job->title }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $job->company }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $job->location }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $job->salary ? 'Rp ' . number_format($job->salary, 0, ',', '.') : '-' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $job->job_type }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            @if($job->logo)
                                                <img src="{{ asset('storage/' . $job->logo) }}" 
                                                     alt="{{ $job->company }} logo" 
                                                     class="h-12 w-12 object-cover rounded">
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex flex-col gap-2 items-end">
                                                {{-- Tombol Edit & Hapus --}}
                                                <div class="flex gap-2">
                                                    <a href="{{ route('jobs.edit', $job->id) }}" 
                                                       class="text-indigo-600 hover:text-indigo-900">
                                                        Edit
                                                    </a>
                                                    <form action="{{ route('jobs.destroy', $job->id) }}" 
                                                          method="POST" 
                                                          class="inline-block" 
                                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="text-red-600 hover:text-red-900">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>

                                                {{-- Form Lamar --}}
                                                <form action="{{ route('apply.store', $job->id) }}" 
                                                      method="POST" 
                                                      enctype="multipart/form-data" 
                                                      class="flex items-center gap-2">
                                                    @csrf
                                                    <input type="file" 
                                                           name="cv" 
                                                           required 
                                                           class="text-xs border border-gray-300 rounded px-2 py-1">
                                                    <button type="submit" 
                                                            class="inline-flex items-center px-3 py-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 transition">
                                                        Lamar
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Belum ada data lowongan.
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