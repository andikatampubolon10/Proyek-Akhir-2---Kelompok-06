@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-6 py-8">
        <!-- Topic Title with a blue border below -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-4xl font-semibold text-gray-800 border-b-4 border-blue-500 pb-4">{{ $topic->name }}</h1>
        </div>

        <!-- Topic Description with static icons -->
        <div class="flex items-center border border-gray-300 rounded-lg p-4 mb-6">
            <h3 class="flex-1 text-lg text-gray-800">{{ $topic->description }}</h3>
            <div class="relative">
                <!-- Add Icon with Link to Create Page -->
                <a href="{{ route('guru.course.quiz.soal.create') }}" class="text-gray-600 cursor-pointer hover:text-gray-900 ml-4">
                    <i class="fas fa-plus" title="Add Question"></i>  <!-- Add Question Icon -->
                </a>
                <!-- Edit Icon (static for now, to be implemented later) -->
                <i class="fas fa-edit text-gray-600 cursor-pointer hover:text-gray-900 ml-4" id="edit-icon" title="Edit Question"></i>
                <!-- Delete Icon (static for now, to be implemented later) -->
                <i class="fas fa-trash text-gray-600 cursor-pointer hover:text-gray-900 ml-4" id="delete-icon" title="Delete Question"></i>
            </div>
        </div>

        <!-- Upload Button -->
        <div class="text-right mt-6">
            <button type="submit" class="bg-green-600 text-white px-8 py-3 rounded-md hover:bg-green-500 transition duration-200">Tambahkan</button>
        </div>
    </div>  
@endsection
