import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'enroll_screen.dart';

// Gantilah URL ini dengan URL yang sesuai dengan API Anda
const String apiUrl = 'http://192.168.190.78:8080/all-kursus';

class CourseListScreen extends StatefulWidget {
  const CourseListScreen({super.key});

  @override
  _CourseListScreenState createState() => _CourseListScreenState();
}

class _CourseListScreenState extends State<CourseListScreen> {
  String searchQuery = '';
  late Future<List<Map<String, String>>> _courses;

  @override
  void initState() {
    super.initState();
    _courses = fetchCourses(); // Memanggil fungsi untuk fetch data kursus
  }

  Future<List<Map<String, String>>> fetchCourses() async {
    try {
      final response = await http.get(Uri.parse(apiUrl));

      // Debugging: Cek status code dan body dari response
      print("Response status: ${response.statusCode}");
      print("Response body: ${response.body}");

      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        List<Map<String, String>> courses = [];

        // Proses data untuk dimasukkan ke dalam list kursus
        for (var kursus in data['kursus']) {
          courses.add({
            'id_kursus': kursus['id_kursus'].toString(), // Tambahkan id_kursus
            'image': kursus['image'] ?? '', // Ambil image dan tambahkan fallback empty string jika null
            'title': kursus['nama_kursus'], // Ambil nama kursus
          });
        }
        return courses;
      } else {
        throw Exception('Failed to load courses');
      }
    } catch (e) {
      print("Error fetching courses: $e"); // Menampilkan pesan error
      throw Exception('Error fetching courses: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('List Course'),
        backgroundColor: const Color(0xFF0078D4),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            // Search Bar
            Container(
              decoration: BoxDecoration(
                color: Colors.white,
                border: Border.all(color: Colors.grey.shade400),
                borderRadius: BorderRadius.circular(12),
              ),
              padding: const EdgeInsets.symmetric(horizontal: 12),
              child: TextField(
                onChanged: (value) {
                  setState(() {
                    searchQuery = value;
                  });
                },
                decoration: InputDecoration(
                  hintText: 'Search course',
                  border: InputBorder.none,
                  prefixIcon: Icon(Icons.search),
                ),
              ),
            ),
            const SizedBox(height: 20),

            // List Courses
            Expanded(
              child: FutureBuilder<List<Map<String, String>>>( 
                future: _courses, // Menampilkan data dari API
                builder: (context, snapshot) {
                  if (snapshot.connectionState == ConnectionState.waiting) {
                    return const Center(child: CircularProgressIndicator()); // Menampilkan loading saat data sedang diambil
                  } else if (snapshot.hasError) {
                    return Center(child: Text('Error: ${snapshot.error}')); // Menampilkan error jika terjadi kesalahan
                  } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                    return const Center(child: Text('No courses available')); // Menampilkan pesan jika tidak ada data
                  } else {
                    final courses = snapshot.data!.where((course) {
                      return course['title']!.toLowerCase().contains(searchQuery.toLowerCase()); // Filter data berdasarkan search query
                    }).toList();

                    return ListView.builder(
                      itemCount: courses.length,
                      itemBuilder: (context, index) {
                        final course = courses[index];
                        return Container(
                          margin: const EdgeInsets.only(bottom: 16),
                          decoration: BoxDecoration(
                            color: Colors.white,
                            borderRadius: BorderRadius.circular(12),
                            border: Border.all(color: Colors.grey.shade300),
                          ),
                          child: Column(
                            children: [
                              // Course Image
                              ClipRRect(
                                borderRadius: const BorderRadius.only(
                                  topLeft: Radius.circular(12),
                                  topRight: Radius.circular(12),
                                ),
                                child: course['image']!.isNotEmpty
                                    ? Image.network(
                                        course['image']!,
                                        fit: BoxFit.cover,
                                        height: 120,
                                        width: double.infinity,
                                        errorBuilder: (context, error, stackTrace) {
                                          return Container(
                                            height: 120,
                                            color: Colors.grey[200],
                                            child: const Center(
                                              child: Icon(Icons.image_not_supported, size: 40),
                                            ),
                                          );
                                        },
                                      )
                                    : Container(
                                        height: 120,
                                        color: Colors.blue[100],
                                        child: const Center(
                                          child: Icon(Icons.menu_book, size: 40, color: Colors.blue),
                                        ),
                                      ),
                              ),
                              const SizedBox(height: 8),

                              // Course Information
                              Padding(
                                padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 8),
                                child: Row(
                                  mainAxisAlignment: MainAxisAlignment.spaceBetween, // Menyebar elemen secara horisontal
                                  children: [
                                    // Title di kiri
                                    Text(
                                      course['title']!,
                                      style: const TextStyle(
                                        fontSize: 16,
                                        fontWeight: FontWeight.bold,
                                      ),
                                    ),
                                    // Enroll Button di kanan
                                    ElevatedButton(
                                      onPressed: () {
                                        Navigator.push(
                                          context,
                                          MaterialPageRoute(
                                            builder: (context) => EnrollScreen(
                                              courseName: course['title']!,
                                              courseId: course['id_kursus']!,
                                            ),
                                          ),
                                        );
                                      },
                                      style: ElevatedButton.styleFrom(
                                        backgroundColor: const Color(0xFF0078D4),
                                      ),
                                      child: const Text('Enroll'),
                                    ),
                                  ],
                                ),
                              ),
                            ],
                          ),  
                        );
                      },
                    );
                  }
                },
              ),
            ),
          ],
        ),
      ),
    );
  }
}
