{{-- resources/views/jobs/show.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $job->title }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    {{-- Logo Perusahaan --}}
                    @if($job->logo)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $job->logo) }}" 
                                 alt="{{ $job->company }}" 
                                 class="h-24 w-24 object-cover rounded-lg shadow">
                        </div>
                    @endif

                    {{-- Info Perusahaan --}}
                    <div class="mb-6">
                        <h3 class="text-3xl font-bold text-gray-900 mb-2">{{ $job->title }}</h3>
                        <p class="text-xl text-indigo-600 font-semibold">{{ $job->company }}</p>
                    </div>

                    {{-- Detail Lowongan --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8 bg-gray-50 p-6 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Lokasi</p>
                            <p class="text-base text-gray-900 font-semibold">{{ $job->location }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Jenis Pekerjaan</p>
                            <p class="text-base text-gray-900 font-semibold">{{ $job->job_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Gaji</p>
                            <p class="text-base text-gray-900 font-semibold">
                                {{ $job->salary ? 'Rp ' . number_format($job->salary, 0, ',', '.') : 'Negosiasi' }}
                            </p>
                        </div>
                        {{-- <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Diposting</p>
                            <p class="text-base text-gray-900 font-semibold">{{ $job->created_at->diffForHumans() }}</p>
                        </div> --}}
                    </div>

                    {{-- Deskripsi --}}
                    <div class="mb-8">
                        <h4 class="text-xl font-bold text-gray-900 mb-4 border-b-2 border-indigo-600 pb-2">
                            Deskripsi Pekerjaan
                        </h4>
                        <div class="prose max-w-none">
                            <p class="text-gray-700 whitespace-pre-line leading-relaxed">{{ $job->description }}</p>
                        </div>
                    </div>

                    {{-- Form Lamar --}}
                    <div class="border-t-2 border-gray-200 pt-8">
                        <h4 class="text-xl font-bold text-gray-900 mb-4">Lamar Pekerjaan Ini</h4>
                        
                        @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 border-l-4 border-green-500 text-green-700 rounded">
                                <p class="font-semibold">✅ {{ session('success') }}</p>
                            </div>
                        @endif

                        <form action="{{ route('apply.store', $job->id) }}" 
                              method="POST" 
                              enctype="multipart/form-data"
                              class="bg-gray-50 p-6 rounded-lg">
                            @csrf
                            <div class="mb-6">
                                <label for="cv" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Upload CV Anda (PDF, max 2MB)
                                </label>
                                <input type="file" 
                                       name="cv" 
                                       id="cv" 
                                       required 
                                       accept=".pdf"
                                       class="block w-full text-sm text-gray-900 border-2 border-gray-300 rounded-lg cursor-pointer bg-white hover:bg-gray-50 focus:outline-none focus:border-indigo-500 p-2.5">
                                @error('cv')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-2 text-xs text-gray-500">Format: PDF | Ukuran maksimal: 2MB</p>
                            </div>
                            
                            <div class="flex gap-3">
                                <button type="submit" 
                                        class="inline-flex items-center px-6 py-3 bg-green-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition">
                                    Kirim Lamaran
                                </button>
                                <a href="{{ route('jobs.index') }}" 
                                   class="inline-flex items-center px-6 py-3 bg-gray-600 border border-transparent rounded-lg font-bold text-sm text-white uppercase tracking-widest hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition">
                                    ← Kembali
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>