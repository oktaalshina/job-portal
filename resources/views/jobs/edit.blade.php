<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Lowongan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <form action="{{ route('jobs.update', $job->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label for="title" class="block text-sm font-medium text-gray-700">Judul Lowongan</label>
                            <input type="text" name="title" id="title" placeholder="Judul Lowongan" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   value="{{ old('title', $job->title) }}">
                        </div>

                        <div class="mb-4">
                            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                            <textarea name="description" id="description" placeholder="Deskripsi" rows="4"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $job->description) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="location" class="block text-sm font-medium text-gray-700">Lokasi</label>
                            <input type="text" name="location" id="location" placeholder="Lokasi" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   value="{{ old('location', $job->location) }}">
                        </div>

                        <div class="mb-4">
                            <label for="company" class="block text-sm font-medium text-gray-700">Nama Perusahaan</label>
                            <input type="text" name="company" id="company" placeholder="Nama Perusahaan" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   value="{{ old('company', $job->company) }}">
                        </div>

                        <div class="mb-4">
                            <label for="salary" class="block text-sm font-medium text-gray-700">Gaji (Opsional)</label>
                            <input type="number" name="salary" id="salary" placeholder="Gaji" 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" 
                                   value="{{ old('salary', $job->salary) }}">
                        </div>

                        <div class="mb-4">
                            <label for="job_type" class="block text-sm font-medium text-gray-700">Jenis Pekerjaan</label>
                            <select name="job_type" id="job_type" 
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                                <option value="">Pilih Jenis Pekerjaan</option>
                                <option value="Full-time">Full-time</option>
                                <option value="Part-time">Part-time</option>
                            </select>
                        </div>


                        <div class="mb-4">
                            <label for="logo" class="block text-sm font-medium text-gray-700">Logo Perusahaan (Opsional)</label>
                            
                            @if ($job->logo)
                                <img src="{{ asset('storage/' . $job->logo) }}" class="w-20 h-20 rounded mb-2" alt="Logo Lama">
                            @endif
                            
                            <input type="file" name="logo" id="logo" 
                                   class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none">
                            <small class="text-gray-500">Kosongkan jika tidak ingin mengubah logo.</small>
                        </div>

                        <div>
                            <button type="submit" 
                                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Simpan Perubahan
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>