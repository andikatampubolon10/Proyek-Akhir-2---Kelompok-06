@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        /* Custom button styles */
        .add-activity-btn {
            display: flex;
            align-items: center;
            padding: 12px 24px;
            background-color: white;
            border: 2px solid #14A098;
            color: #14A098;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease-in-out;
            cursor: pointer;
        }

        .add-activity-btn i {
            margin-right: 10px;
        }

        .add-activity-btn:hover {
            background-color: #14A098;
            color: white;
            transform: scale(1.05);
        }

        /* Styling for buttons (Edit and Delete) */
        .edit-btn, .delete-btn {
            padding: 8px 16px;
            font-weight: 600;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease-in-out;
        }

        .edit-btn {
            background-color: #4CAF50; /* Green color for Edit button */
            color: white;
            border: none;
        }

        .edit-btn:hover {
            background-color: #45a049;
        }

        .delete-btn {
            background-color: #D32F2F; /* Red color for Delete button */
            color: white;
            border: none;
        }

        .delete-btn:hover {
            background-color: #9C2717;
        }

        /* Styling for the list */
        .latihan-soal-list {
            margin-top: 30px;
        }

        li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            transition: all 0.3s ease-in-out;
        }

        li:hover {
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
            transform: scale(1.05);
        }
    </style>

<div class="container">
    <h1 class="text-2xl font-bold mb-4">Daftar Topic</h1>
    
    <!-- Button for creating a new topic -->
    <a href="{{ route('quiz.create') }}" class="add-activity-btn">Add an activity or resource</a>

    <!-- List of topics -->
    <div class="mt-6">
        <ul>
            @foreach ($topics as $topic)
                <li class="flex justify-between items-center mb-4 p-4 border rounded-lg shadow-sm">
                    <!-- Link to the show page for each topic -->
                    <a href="{{ route('guru.course.quiz.soal.index', $topic->id) }}" class="text-lg font-semibold text-blue-500 ">
                        {{ $topic->name }}
                    </a>
                    
                    <div class="actions flex">
                        
                        <!-- Edit Button -->
                        <a href="{{ route('guru.course.quiz.edit', $topic->id) }}" class="edit-btn">Edit</a>
                        
                        <!-- Delete Button -->
                        <form action="{{ route('guru.course.quiz.destroy', $topic->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="delete-btn">Delete</button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>
</div>
@endsection