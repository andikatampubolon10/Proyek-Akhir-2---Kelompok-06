@extends('layouts.app')

@section('content')
    <div class="w-full bg-white p-6 shadow-md">
        <!-- Title of the Page -->
        <h1 class="text-2xl font-bold mb-4">Create Question</h1>

        <!-- Form for Creating a Question -->
        <form action="{{ route('Guru.Ujian.create') }}" method="POST">
            @csrf
            <!-- Question Text Area -->
            <div class="border p-4 mb-6">
                <label for="question" class="block text-lg font-semibold mb-2">Question</label>
                <textarea id="question" name="question" class="w-full border p-2 h-32" required></textarea>
            </div>

            <!-- Choices Section -->
            <h2 class="text-lg font-semibold mb-4">Choices</h2>
            <div class="space-y-4">
                @foreach (['A', 'B', 'C', 'D', 'E'] as $choice)
                    <div class="border p-4">
                        <div class="flex items-center mb-2">
                            <span class="w-20">{{ $choice }}</span>
                            <div class="flex space-x-2 ml-4">
                                <button type="button" class="border p-2"><i class="fas fa-list"></i></button>
                                <button type="button" class="border p-2"><i class="fas fa-list-ol"></i></button>
                                <button type="button" class="border p-2"><i class="fas fa-bold"></i></button>
                            </div>
                        </div>
                        <textarea name="choices[{{ $choice }}]" class="w-full border p-2 h-16 mb-2" placeholder="Enter choice {{ $choice }}" required></textarea>
                        <div class="flex items-center">
                            <span class="w-20">Grade</span>
                            <select name="grades[{{ $choice }}]" class="border p-2" required>
                                <option value="100">100%</option>
                                <option value="50">50%</option>
                                <option value="33">33%</option>
                                <option value="25">25%</option>
                                <option value="20">20%</option>
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Submit Button -->
            <div class="mt-6 flex justify-end">
                <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-md hover:bg-green-500 transition duration-200">Submit Question</button>
            </div>
        </form>
    </div>
@endsection
