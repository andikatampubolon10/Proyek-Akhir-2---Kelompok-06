import 'package:flutter/material.dart';
import 'raport_detail_screen.dart'; 

class RaportCourseScreen extends StatefulWidget {
  const RaportCourseScreen({super.key});

  @override
  State<RaportCourseScreen> createState() => _RaportCourseScreenState();
}

class _RaportCourseScreenState extends State<RaportCourseScreen> {
  bool _showDetail = false;
  String _selectedYear = '';
  String _selectedGrade = '';
  String _selectedSubject = '';

  void _openDetail(String year, String grade, String subject) {
    setState(() {
      _showDetail = true;
      _selectedYear = year;
      _selectedGrade = grade;
      _selectedSubject = subject;
    });
  }

  void _backToCourse() {
    setState(() {
      _showDetail = false;
      _selectedYear = '';
      _selectedGrade = '';
      _selectedSubject = '';
    });
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text(_showDetail ? 'Detail Raport' : 'Raport Course', 
        style: TextStyle(color: Colors.white)
        ),
        leading: _showDetail
            ? IconButton(
                icon: const Icon(Icons.arrow_back, color: Colors.white),
                onPressed: _backToCourse,
              )
            : null,
        backgroundColor: const Color(0xFF0078D4),
        elevation: 0,
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: _showDetail
            ? RaportDetailScreen(
                year: _selectedYear,
                grade: _selectedGrade,
                subject: _selectedSubject,
              )
            : ListView(
                children: [
                  _buildCourseCard('2024 / 2025', 'Kelas 9', 'Ilmu Pengetahuan Alam'),
                  _buildCourseCard('2024 / 2025', 'Kelas 9', 'Matematika'),
                  _buildCourseCard('2024 / 2025', 'Kelas 9', 'Ilmu Pengetahuan Sosial'),
                  _buildCourseCard('2024 / 2025', 'Kelas 9', 'Bahasa Indonesia'),
                  _buildCourseCard('2024 / 2025', 'Kelas 9', 'Bahasa Inggris'),
                ],
              ),
      ),
    );
  }

  Widget _buildCourseCard(String year, String grade, String subject) {
    return GestureDetector(
      onTap: () => _openDetail(year, grade, subject),
      child: Container(
        margin: const EdgeInsets.symmetric(vertical: 8.0),
        padding: const EdgeInsets.all(16.0),
        decoration: BoxDecoration(
          color: Colors.blue.shade50,
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: Colors.blue.shade200),
        ),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Image.asset(
              'assets/images/medali.png',
              width: 48,
              height: 48,
            ),
            const SizedBox(width: 16),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(year, style: const TextStyle(fontSize: 12, color: Colors.grey)),
                  const SizedBox(height: 4),
                  Text(grade, style: const TextStyle(fontSize: 16, fontWeight: FontWeight.bold)),
                  const SizedBox(height: 4),
                  Text(subject, style: const TextStyle(fontSize: 14)),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
