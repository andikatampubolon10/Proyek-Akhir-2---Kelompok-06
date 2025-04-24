import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';
import 'MateriDetailScreen.dart';  // Import MateriDetailScreen
import 'introduction_screen.dart';  // Import IntroductionScreen

class HomeDetailScreen extends StatefulWidget {
  final String idKursus;
  final String? kelas;
  final String? tahunAjaran;
  final String? mataPelajaran;
  final String? namaKursus;

  const HomeDetailScreen({
    super.key,
    required this.idKursus, // Receive id_kursus
    this.kelas = 'Kelas 9',
    this.tahunAjaran = '2024/2025',
    this.mataPelajaran,
    this.namaKursus,
  });

  @override
  State<HomeDetailScreen> createState() => _HomeDetailScreenState();
}

class _HomeDetailScreenState extends State<HomeDetailScreen> {
  late Future<List<Map<String, dynamic>>> _items; // Future for API data
  late Future<Map<String, dynamic>> _kursusData;
  bool _isLoading = true;
  String _namaKursus = '';
  String _errorMessage = '';
  int _courseId = 0;

  @override
  void initState() {
    super.initState();
    _initializeScreen();
  }

  Future<void> _initializeScreen() async {
    setState(() {
      _isLoading = true;
      _errorMessage = '';
    });

    try {
      // Parse the course ID to ensure it's an integer
      _courseId = _parseKursusId(widget.idKursus);
      print("Parsed id_kursus: $_courseId");

      if (_courseId <= 0) {
        throw Exception("Invalid course ID: $_courseId");
      }

      // First try to get course data from cache
      final cachedData = await _getCachedCourseData(_courseId);
      if (cachedData != null) {
        setState(() {
          _namaKursus = cachedData['nama_kursus'] ?? widget.namaKursus ?? 'Unknown Course';
          _isLoading = false;
        });
      } else if (widget.namaKursus != null && widget.namaKursus!.isNotEmpty) {
        // Use the provided course name if available
        setState(() {
          _namaKursus = widget.namaKursus!;
        });
      } else {
        // Fetch course name from API if not cached
        _kursusData = fetchKursusData(_courseId.toString());
        final data = await _kursusData;
        setState(() {
          _namaKursus = data['nama_kursus'] ?? 'Unknown Course';
        });
      }

      // Fetch items (materials and exams)
      _items = fetchData(_courseId.toString());
      setState(() {
        _isLoading = false;
      });
    } catch (e) {
      print("Error initializing screen: $e");
      setState(() {
        _errorMessage = e.toString();
        _isLoading = false;
      });
    }
  }

  int _parseKursusId(String idKursus) {
    try {
      // Try to parse the ID as an integer
      return int.parse(idKursus);
    } catch (e) {
      print("Error parsing course ID: $e");
      // Return 0 or another default value to indicate an error
      return 0;
    }
  }

  Future<Map<String, dynamic>?> _getCachedCourseData(int courseId) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      
      // Try to get the specific course
      final courseJson = prefs.getString('course_$courseId');
      if (courseJson != null) {
        return jsonDecode(courseJson);
      }
      
      // Try to get from cached courses list
      final coursesJson = prefs.getString('cached_courses');
      if (coursesJson != null) {
        final List<dynamic> courses = jsonDecode(coursesJson);
        final course = courses.firstWhere(
          (c) => c['id_kursus'] == courseId,
          orElse: () => null,
        );
        return course;
      }
      
      return null;
    } catch (e) {
      print("Error getting cached course data: $e");
      return null;
    }
  }

  Future<Map<String, dynamic>> fetchKursusData(String idKursus) async {
    var url = Uri.parse('http://192.168.56.1:8080/kursus/$idKursus'); // API endpoint for kursus

    try {
      var response = await http.get(url);
      print("Kursus API response status: ${response.statusCode}");
      print("Kursus API response body: ${response.body}");
      
      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        
        // Cache the course data
        _cacheCourseData(idKursus, data);
        
        return data;
      } else {
        throw Exception('Failed to load kursus data');
      }
    } catch (e) {
      print("Error fetching kursus data: $e");
      throw Exception('Error fetching kursus data: $e');
    }
  }

  Future<void> _cacheCourseData(String idKursus, Map<String, dynamic> data) async {
    try {
      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('course_$idKursus', jsonEncode(data));
    } catch (e) {
      print("Error caching course data: $e");
    }
  }

  Future<List<Map<String, dynamic>>> fetchData(String idKursus) async {
    // Replace this URL with your actual endpoint for fetching materi and ujian by id_kursus
    var url = Uri.parse('http://192.168.56.1:8080/ujian-materi-kursus/$idKursus'); // Example URL

    try {
      var response = await http.get(url);
      print("Items API response status: ${response.statusCode}");
      print("Items API response body: ${response.body}");
      
      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        List<dynamic> materiData = data['materi'] ?? [];
        List<dynamic> ujianData = data['ujian'] ?? [];

        // Combine both lists into one
        List<Map<String, dynamic>> combinedList = [];

        for (var materi in materiData) {
          combinedList.add({
            'title': materi['judul_materi'] ?? 'No Title',  // Add default value if null
            'type': 'material',
            'icon': Icons.menu_book,
            'description': materi['deskripsi'] ?? 'No Description',  // Add default value if null
            'file': materi['file_path'] ?? '',  // Handle file path null as well
          });
        }

        for (var ujian in ujianData) {
          combinedList.add({
            'title': ujian['nama_ujian'] ?? 'No Title',  // Add default value if null
            'type': ujian['tipe_ujian'] == 1 ? 'quiz' : 'exam', // Handle quiz and exam types
            'icon': ujian['tipe_ujian'] == 1 ? Icons.assignment : Icons.assessment,
            'id_ujian': ujian['id_ujian'],
          });
        }

        return combinedList;
      } else {
        throw Exception('Failed to load data');
      }
    } catch (e) {
      print("Error fetching data: $e");
      throw Exception('Error fetching data: $e');
    }
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return Scaffold(
        appBar: AppBar(
          backgroundColor: Color(0xFF036BB9),
          leading: IconButton(
            icon: Icon(Icons.arrow_back, color: Colors.white),
            onPressed: () => Navigator.pop(context),
          ),
          title: Text('Loading...', style: TextStyle(color: Colors.white)),
        ),
        body: Center(child: CircularProgressIndicator()),
      );
    }

    if (_errorMessage.isNotEmpty) {
      return Scaffold(
        appBar: AppBar(
          backgroundColor: Color(0xFF036BB9),
          leading: IconButton(
            icon: Icon(Icons.arrow_back, color: Colors.white),
            onPressed: () => Navigator.pop(context),
          ),
          title: Text('Error', style: TextStyle(color: Colors.white)),
        ),
        body: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Text('Error: $_errorMessage'),
              SizedBox(height: 20),
              ElevatedButton(
                onPressed: _initializeScreen,
                child: Text('Retry'),
              ),
            ],
          ),
        ),
      );
    }

    return Scaffold(
      appBar: AppBar(
        leading: IconButton(
          icon: Icon(Icons.arrow_back, color: Colors.white),
          onPressed: () {
            Navigator.pop(context);
          },
        ),
        title: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              _namaKursus, // Use the fetched or provided course name
              style: TextStyle(
                fontSize: 20.0,
                color: Colors.white,
                fontWeight: FontWeight.w400,
                fontFamily: 'Poppins',
              ),
            ),
          ],
        ),
        backgroundColor: Color(0xFF036BB9),
        toolbarHeight: 70,
      ),
      body: Container(
        color: const Color(0xFFF0F8FF),
        padding: const EdgeInsets.all(16),
        child: FutureBuilder<List<Map<String, dynamic>>>(  // Fetch data asynchronously
          future: _items,
          builder: (context, snapshot) {
            if (snapshot.connectionState == ConnectionState.waiting) {
              return const Center(child: CircularProgressIndicator());  // Loading indicator
            } else if (snapshot.hasError) {
              return Center(
                child: Column(
                  mainAxisAlignment: MainAxisAlignment.center,
                  children: [
                    Text('Error: ${snapshot.error}'),  // Error message
                    SizedBox(height: 20),
                    ElevatedButton(
                      onPressed: _initializeScreen,
                      child: Text('Retry'),
                    ),
                  ],
                ),
              );
            } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
              return const Center(child: Text('Tidak ada materi atau ujian tersedia.'));  // No data message
            } else {
              var items = snapshot.data!;
              return ListView.separated(
                itemCount: items.length,
                separatorBuilder: (_, __) => const SizedBox(height: 12),
                itemBuilder: (context, index) {
                  final item = items[index];
                  final bool isExam = item['type'] == 'exam';  // Check if it's a quiz or an exam
                  return GestureDetector(
                    onTap: () {
                      // Navigate based on the type of item
                      if (item['type'] == 'material') {
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => MateriDetailScreen(
                              title: item['title'],
                              description: item['description'],
                              file: item['file'],
                            ),
                          ),
                        );
                      } else if (item['type'] == 'quiz' || item['type'] == 'exam') {
                        final idUjian = item['id_ujian']?.toString() ?? '0';
                        print("Navigating with id_ujian: $idUjian");
                        Navigator.push(
                          context,
                          MaterialPageRoute(
                            builder: (context) => IntroductionScreen(
                              title: item['title'],
                              subject: widget.mataPelajaran ?? _namaKursus,
                              gradeLevel: 10,  // Pass the grade level if necessary
                              idUjian: idUjian,
                            ),
                          ),
                        );
                      }
                    },
                    child: Container(
                      padding: const EdgeInsets.all(12),
                      decoration: BoxDecoration(
                        color: Colors.white.withOpacity(0.95),
                        borderRadius: BorderRadius.circular(10),
                        border: Border.all(color: isExam ? Colors.red.shade200 : Colors.blue.shade200),
                      ),
                      child: Row(
                        children: [
                          // Icon representing material or quiz/exam
                          Container(
                            padding: const EdgeInsets.all(8),
                            decoration: BoxDecoration(
                              color: isExam ? Colors.red.shade100 : Colors.blue.shade100,
                              borderRadius: BorderRadius.circular(8),
                            ),
                            child: Icon(
                              item['icon'],
                              color: isExam ? Colors.red : Colors.blue,
                            ),
                          ),
                          const SizedBox(width: 16),
                          // Course Title
                          Expanded(
                            child: Text(
                              item['title'],
                              style: const TextStyle(
                                fontSize: 16,
                                fontWeight: FontWeight.w500,
                                color: Colors.black87,
                              ),
                            ),
                          ),
                        ],
                      ),
                    ),
                  );
                },
              );
            }
          },
        ),
      ),
    );
  }
}