import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'package:cbt_app/services/kursus_service.dart'; // Import KursusService
import 'package:cbt_app/services/user_service.dart';
import '../widgets/course_card.dart'; // Make sure to import the CourseCard widget
import 'package:shared_preferences/shared_preferences.dart';

class HomeScreen extends StatefulWidget {
  final String idSiswa; // id_siswa passed to HomeScreen

  const HomeScreen({super.key, required this.idSiswa});

  @override
  _HomeScreen1State createState() => _HomeScreen1State();
}

class _HomeScreen1State extends State<HomeScreen> {
  String? _namaSiswa;
  late Future<List<Course>> _kursus;
  final KursusService _kursusService = KursusService();

  @override
  void initState() {
    super.initState();
    // Fetch courses for the student when the screen is loaded
    _refreshCourses();
    _getUserInfo();
  }

  // Method to refresh courses - can be called after enrollment
  Future<void> _refreshCourses() async {
    setState(() {
      _kursus = _kursusService.getKursusBySiswa(context, widget.idSiswa);
    });
  }

  Future<void> _getUserInfo() async {
    try {
      String? name = await UserService().fetchUserName(widget.idSiswa);  // Fetch name using the id_siswa
      setState(() {
        _namaSiswa = name ?? 'Unknown User';  // If name is null, display 'Unknown User'
      });
    } catch (e) {
      setState(() {
        _namaSiswa = 'Error fetching name';  // In case of failure, show an error message
      });
    }
  }

  String searchQuery = ''; // To hold search query text

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Column(
        children: [
          _buildHeader(),
          _buildSearchBar(),
          Expanded(
            child: FutureBuilder<List<Course>>(
              future: _kursus,
              builder: (context, snapshot) {
                if (snapshot.connectionState == ConnectionState.waiting) {
                  return Center(child: CircularProgressIndicator());
                } else if (snapshot.hasError) {
                  return Center(child: Text('Error: ${snapshot.error}'));
                } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
                  return Center(child: Text('Tidak ada kursus tersedia.'));
                } else {
                  var kursusList = snapshot.data!;
                  // Filter courses based on search query
                  final filteredCourses = kursusList.where((course) {
                    return course.namaKursus.toLowerCase().contains(searchQuery.toLowerCase());
                  }).toList();

                  return RefreshIndicator(
                    onRefresh: _refreshCourses,
                    child: ListView.builder(
                      padding: const EdgeInsets.symmetric(horizontal: 16.0, vertical: 8.0),
                      itemCount: filteredCourses.length,
                      itemBuilder: (context, index) {
                        var kursus = filteredCourses[index];
                        return Padding(
                          padding: const EdgeInsets.only(bottom: 16.0), // Space between cards
                          child: CourseCard(
                            idKursus: kursus.idKursus.toString(),
                            namaKursus: kursus.namaKursus,
                            imageUrl: kursus.image,
                            grade: 'Kelas 9', // Update with actual class data if needed
                            year: '2024/2025', // Update with actual year data if needed
                            subject: kursus.namaKursus, // Course name
                          ),
                        );
                      },
                    ),
                  );
                }
              },
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildHeader() {
    return Container(
      padding: const EdgeInsets.fromLTRB(24, 50, 24, 24),
      decoration: const BoxDecoration(
        color: Color(0xFF036BB9),
      ),
      child: Row(
        mainAxisAlignment: MainAxisAlignment.spaceBetween,
        children: [
          Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              const Text(
                'Hello,',
                style: TextStyle(color: Colors.white, fontSize: 24, fontWeight: FontWeight.w400),
              ),
              // Ensure _namaSiswa is either displayed or show 'Loading...'
              Text(
                _namaSiswa ?? 'Loading...',  // If _namaSiswa is null, show 'Loading...'
                style: const TextStyle(color: Colors.white, fontSize: 24, fontWeight: FontWeight.w600),
              ),
            ],
          ),
          Container(
            width: 50,
            height: 50,
            decoration: BoxDecoration(
              shape: BoxShape.circle,
              border: Border.all(color: Colors.white, width: 2),
              image: const DecorationImage(
                image: AssetImage('assets/images/profile.png'),  // Profile image
                fit: BoxFit.cover,
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildSearchBar() {
    return Container(
      padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 16),
      child: Container(
        decoration: BoxDecoration(
          color: Colors.white,
          borderRadius: BorderRadius.circular(30),
          border: Border.all(color: Colors.grey.shade300),
        ),
        child: TextField(
          onChanged: (value) {
            setState(() {
              searchQuery = value;
            });
          },
          decoration: InputDecoration(
            hintText: 'Search your course',
            hintStyle: TextStyle(color: Colors.grey),
            prefixIcon: Icon(Icons.search, color: Colors.grey),
            border: InputBorder.none,
            contentPadding: EdgeInsets.symmetric(vertical: 15),
          ),
        ),
      ),
    );
  }
}

