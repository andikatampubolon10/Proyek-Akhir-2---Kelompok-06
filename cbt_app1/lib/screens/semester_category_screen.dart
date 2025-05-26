import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'dart:convert'; // Untuk decoding JSON
import 'course_list_screen.dart';

class MataPelajaranCategoryScreen extends StatelessWidget {
  final String year;
  final String className;
  final String idKurikulum;  // Tambahkan parameter idKurikulum

  const MataPelajaranCategoryScreen({
    super.key,
    required this.year,
    required this.className,
    required this.idKurikulum,  // Pastikan idKurikulum diterima dengan benar
  });

  // Fungsi untuk mengambil data mata pelajaran berdasarkan id_kurikulum
  Future<List<String>> fetchMataPelajaran(String idKurikulum) async {
    try {
      final response = await http.get(
        Uri.parse('http://192.168.190.78:8080/mata-pelajaran/$idKurikulum'), // Ganti dengan URL API yang sesuai
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        
        if (data['mata_pelajaran'] != null) {
          // Extract the list of mata pelajaran from the response
          final mataPelajaranList = List<String>.from(data['mata_pelajaran'].map((mapel) {
            // Mengambil nama mata pelajaran dengan aman
            return mapel['nama_mata_pelajaran'] ?? ''; // Pastikan nama_mata_pelajaran tidak null
          }));

          return mataPelajaranList;
        } else {
          throw Exception('No mata pelajaran found in response');
        }
      } else {
        throw Exception('Failed to load mata pelajaran');
      }
    } catch (e) {
      print('Error fetching mata pelajaran: $e');
      return [];
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Mata Pelajaran'),
        backgroundColor: const Color(0xFF0078D4),
      ),
      body: FutureBuilder<List<String>>(
        future: fetchMataPelajaran(idKurikulum), // Menggunakan idKurikulum yang diterima
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const Center(child: Text('No mata pelajaran found'));
          } else {
            // Menampilkan mata pelajaran dari API
            List<String> mataPelajaranList = snapshot.data!;

            return ListView.builder(
              padding: const EdgeInsets.all(16),
              itemCount: mataPelajaranList.length,
              itemBuilder: (context, index) {
                return Card(
                  color: const Color(0xFFF0F8FF),
                  child: ListTile(
                    leading: const Icon(Icons.book, size: 32, color: Color(0xFF0078D4)),
                    title: Text(mataPelajaranList[index]),
                    onTap: () {
                      // Pindah ke CourseListScreen dengan mata pelajaran yang dipilih
                      // Navigator.push(
                      //   context,
                      //   MaterialPageRoute(
                      //     builder: (context) => CourseListScreen(
                      //       year: year,
                      //       className: className,
                      //       // mataPelajaran: mataPelajaranList[index], // Pass mata pelajaran ke screen berikutnya
                      //     ),
                      //   ),
                      // );
                    },
                  ),
                );
              },
            );
          }
        },
      ),
    );
  }
}
