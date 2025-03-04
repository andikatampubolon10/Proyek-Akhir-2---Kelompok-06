@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <form action="{{ route('course.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <!-- Nama Course -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Nama Course <span class="text-red-500">*</span></label>
            <input type="text" name="name" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label class="block text-gray-700 font-semibold">Password <span class="text-red-500">*</span></label>
            <input type="password" name="password" class="w-full p-2 border border-gray-300 rounded-md" required>
        </div>

        <!-- Upload Image -->
        <div class="mb-4">
            <label class="block text-dark font-semibold mb-2">Upload Foto</label>
            <div id="dropzone" class="border-dashed border-2 border-blue-900 p-6 text-center rounded-lg bg-gray-100 cursor-pointer">
                <input type="file" name="image" class="hidden" id="imageInput" accept="image/*">
                <div class="flex flex-col items-center">
                    <img src="https://media.istockphoto.com/id/2169826086/id/vektor/seret-dan-lepas-ikon-vektor-file-gambar.jpg?s=1024x1024&w=is&k=20&c=Rtszsqzy7Q1v5Team-tEQFTRlu015olBd4ifTtfU5Y0=" width="40" class="mb-2" id="preview-icon">
                    <p class="text-gray-500 text-sm" id="upload-text">Drag n Drop here</p>
                    <p class="text-gray-500 text-sm">Or <span class="text-blue-600 font-semibold cursor-pointer" id="browseBtn">Browse</span></p>
                </div>
            </div>
        </div>
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                let dropzone = document.getElementById("dropzone");
                let fileInput = document.getElementById("imageInput");
                let browseBtn = document.getElementById("browseBtn");
                let previewIcon = document.getElementById("preview-icon");
                let uploadText = document.getElementById("upload-text");
        
                // Klik untuk membuka file explorer
                dropzone.addEventListener("click", function () {
                    fileInput.click();
                });
        
                browseBtn.addEventListener("click", function (event) {
                    event.stopPropagation();
                    fileInput.click();
                });
        
                // Drag & Drop Event
                dropzone.addEventListener("dragover", function (event) {
                    event.preventDefault();
                    dropzone.classList.add("bg-blue-50");
                });
        
                dropzone.addEventListener("dragleave", function () {
                    dropzone.classList.remove("bg-blue-50");
                });
        
                dropzone.addEventListener("drop", function (event) {
                    event.preventDefault();
                    dropzone.classList.remove("bg-blue-50");
        
                    let files = event.dataTransfer.files;
                    if (files.length > 0) {
                        fileInput.files = files;
                        previewImage(files[0]);
                    }
                });
        
                fileInput.addEventListener("change", function () {
                    if (fileInput.files.length > 0) {
                        previewImage(fileInput.files[0]);
                    }
                });
        
                function previewImage(file) {
                    let reader = new FileReader();
                    reader.onload = function (e) {
                        previewIcon.src = e.target.result;
                        previewIcon.style.width = "80px";
                        previewIcon.style.height = "80px";
                        previewIcon.style.objectFit = "cover";
                        uploadText.textContent = file.name;
                    };
                    reader.readAsDataURL(file);
                }
            });
        </script>
        

        <!-- Submit Button -->
        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded-md">
            ✅ Submit
        </button>
    </form>
</div>
@endsection
