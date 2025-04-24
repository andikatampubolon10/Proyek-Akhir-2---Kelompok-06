import 'package:flutter/material.dart';

class RaportDetailScreen extends StatelessWidget {
  final String year;
  final String grade;
  final String subject;

  const RaportDetailScreen({
    super.key,
    required this.year,
    required this.grade,
    required this.subject,
  });

  @override
  Widget build(BuildContext context) {
    return SingleChildScrollView(
      padding: const EdgeInsets.all(16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.center,
        children: [
          Text(year, style: const TextStyle(fontSize: 16)),
          const SizedBox(height: 4),
          Text(grade, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w600)),
          const SizedBox(height: 4),
          Text(subject, style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w600)),
          const SizedBox(height: 24),
          _buildProgressItem('Quiz 1 - Sistem Pencernaan', 45),
          _buildProgressItem('Quiz 2 - Sistem Pernapasan', 50),
          _buildProgressItem('Ujian Tengah Semester', 75),
          _buildProgressItem('Ujian Akhir Semester', 80),
          const SizedBox(height: 32),
          _buildFinalScoreBox(65, 'B'),
        ],
      ),
    );
  }

  Widget _buildProgressItem(String title, int score) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(title, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.w500)),
          const SizedBox(height: 8),
          Row(
            children: [
              Expanded(
                child: ClipRRect(
                  borderRadius: BorderRadius.circular(8),
                  child: LinearProgressIndicator(
                    value: score / 100,
                    minHeight: 8,
                    backgroundColor: Colors.grey.shade300,
                    valueColor: const AlwaysStoppedAnimation<Color>(Color(0xFF0078D4)),
                  ),
                ),
              ),
              const SizedBox(width: 8),
              Text('$score/100', style: const TextStyle(fontSize: 14)),
            ],
          ),
        ],
      ),
    );
  }

  Widget _buildFinalScoreBox(int finalScore, String grade) {
    return Container(
      decoration: BoxDecoration(
        border: Border.all(color: Colors.blue.shade300),
        borderRadius: BorderRadius.circular(8),
      ),
      child: Row(
        children: [
          Expanded(
            child: Container(
              padding: const EdgeInsets.symmetric(vertical: 16),
              child: Column(
                children: [
                  const Text('Nilai Akhir', style: TextStyle(fontSize: 14)),
                  const SizedBox(height: 8),
                  Text(
                    '$finalScore',
                    style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
            ),
          ),
          Container(
            width: 1,
            height: 60,
            color: Colors.blue.shade300,
          ),
          Expanded(
            child: Container(
              padding: const EdgeInsets.symmetric(vertical: 16),
              child: Column(
                children: [
                  const Text('Grade', style: TextStyle(fontSize: 14)),
                  const SizedBox(height: 8),
                  Text(
                    grade,
                    style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
