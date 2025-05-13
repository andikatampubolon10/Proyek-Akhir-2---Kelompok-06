<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Preview Soal Essay</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
</head>

<body class="bg-gray-100">
    <!-- Modal backdrop -->
    <div id="previewModal" tabindex="-1" aria-labelledby="previewModalLabel" aria-hidden="true"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 opacity-0 pointer-events-none transition-opacity duration-300">
        <div class="bg-white rounded-lg shadow-lg max-w-4xl w-full mx-4 sm:mx-6 md:mx-0" role="dialog"
            aria-modal="true" aria-labelledby="previewModalLabel">
            <div class="flex justify-between items-center border-b border-gray-200 px-6 py-4">
                <h2 id="previewModalLabel" class="text-xl font-semibold text-gray-800">
                    Preview Soal Essay
                </h2>
                <button type="button" aria-label="Close modal" id="closeModalBtn"
                    class="text-gray-500 hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 rounded">
                    <i class="fas fa-times fa-lg"></i>
                </button>
            </div>
            <div id="previewContent" class="p-6">
                <div class="bg-gray-50 rounded-md shadow-inner p-6">
                    <p class="mb-4 text-gray-700">
                        <span class="font-semibold">Pertanyaan:</span>
                        <span class="whitespace-pre-line">{{ $soal->soal }}</span>
                    </p>
                    <p class="text-gray-600 italic">
                        <span class="font-semibold">Catatan:</span> Jawaban akan dikoreksi manual oleh guru.
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Show modal function (for demonstration, you can trigger this as needed)
        function showModal() {
            const modal = document.getElementById('previewModal');
            modal.classList.remove('opacity-0', 'pointer-events-none');
            modal.classList.add('opacity-100');
        }

        // Close modal function
        document.getElementById('closeModalBtn').addEventListener('click', () => {
            const modal = document.getElementById('previewModal');
            modal.classList.add('opacity-0', 'pointer-events-none');
            modal.classList.remove('opacity-100');
        });

        // Optional: close modal on backdrop click
        document.getElementById('previewModal').addEventListener('click', (e) => {
            if (e.target === e.currentTarget) {
                const modal = document.getElementById('previewModal');
                modal.classList.add('opacity-0', 'pointer-events-none');
                modal.classList.remove('opacity-100');
            }
        });

        // For demonstration, automatically show modal on page load
        window.addEventListener('load', () => {
            showModal();
        });
    </script>
</body>

</html>
