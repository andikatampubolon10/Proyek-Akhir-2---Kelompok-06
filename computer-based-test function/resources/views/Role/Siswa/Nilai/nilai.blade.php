<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raport Course</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .header {
            background-color: #0056b3;
            color: white;
            padding: 15px;
            font-size: 20px;
            font-weight: bold;
            text-align: left;
        }
        .container {
            text-align: center;
            margin-top: 20px;
        }
        .card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin: 10px auto;
            max-width: 600px;
            width: 90%;
            cursor: pointer;
            transition: transform 0.3s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .progress {
            height: 8px;
            border-radius: 5px;
            transition: width 0.5s ease-in-out;
        }
        .progress-bar {
            background-color: #007bff;
        }
        .nilai-box {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 20px;
            border: 1px solid #007bff;
            padding: 10px;
            border-radius: 10px;
            width: fit-content;
            margin: 20px auto;
            text-align: center;
        }
        .expanded {
            transform: scale(1.1);
            background-color: #007bff;
            color: white;
        }
        @media (max-width: 768px) {
            .nilai-box {
                flex-direction: column;
                gap: 10px;
            }
            .card {
                width: 100%;
            }
        }
    </style>
</head>
<body>

    <div class="header">Raport Course</div>

    <div class="container">
        <h5>{{ $data['tahun_ajaran'] }}</h5>
        <p>{{ $data['kelas'] }}</p>
        <h6>{{ $data['mata_pelajaran'] }}</h6>
    </div>

    <div class="container">
        @foreach ($data['nilai'] as $item)
            <div class="card" onclick="expandCard(this)">
                <p class="mb-2">{{ $item['nama'] }}</p>
                <div class="progress w-100">
                    <div class="progress-bar" role="progressbar" 
                        data-score="{{ $item['skor'] }}" 
                        data-total="{{ $item['total'] }}"
                        style="width: {{ ($item['skor'] / $item['total']) * 100 }}%;" 
                        aria-valuenow="{{ $item['skor'] }}" 
                        aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <span class="d-block mt-2 score-text">{{ $item['skor'] }} / {{ $item['total'] }}</span>
            </div>
        @endforeach
    </div>

    <div class="nilai-box">
        <div>
            <p class="mb-0">Nilai Akhir</p>
            <h4 class="mb-0">{{ $data['nilai_akhir'] }}</h4>
        </div>
        <div>
            <p class="mb-0">Grade</p>
            <h4 class="mb-0">{{ $data['grade'] }}</h4>
        </div>
    </div>

    <script>
        function expandCard(element) {
            // Hilangkan efek dari card lain
            document.querySelectorAll('.card').forEach(card => {
                card.classList.remove('expanded');
            });

            // Tambahkan efek membesar pada card yang ditekan
            element.classList.add('expanded');

            // Ambil progress bar dan nilai
            let progressBar = element.querySelector('.progress-bar');
            let scoreText = element.querySelector('.score-text');
            let score = progressBar.getAttribute('data-score');
            let total = progressBar.getAttribute('data-total');

            // Animasi progress bar
            let targetWidth = (score / total) * 100;
            progressBar.style.width = "0%";
            setTimeout(() => {
                progressBar.style.width = targetWidth + "%";
            }, 100);

            // Perbesar teks nilai
            scoreText.style.fontSize = "20px";
            scoreText.style.fontWeight = "bold";
        }
    </script>

</body>
</html>
