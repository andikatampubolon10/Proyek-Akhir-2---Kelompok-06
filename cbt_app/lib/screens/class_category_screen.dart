import 'package:flutter/material.dart';
import 'semester_category_screen.dart';
import 'package:cbt_app/services/kelas_service.dart';  // Import the KelasService

class ClassCategoryScreen extends StatefulWidget {
  final String year;
  final int idKurikulum;  // This is where you pass idKurikulum from the previous screen

  const ClassCategoryScreen({super.key, 
    required this.year,
    required this.idKurikulum,
  });

  @override
  _ClassCategoryScreenState createState() => _ClassCategoryScreenState();
}

class _ClassCategoryScreenState extends State<ClassCategoryScreen> {
  late Future<List<String>> _kelasList;

  @override
  void initState() {
    super.initState();
    // Fetch the Kelas data when the screen loads
    _kelasList = KelasService().fetchKelas();
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Course Categories'),
        backgroundColor: const Color(0xFF0078D4),
      ),
      body: FutureBuilder<List<String>>(
        future: _kelasList,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return const Center(child: Text('No classes available.'));
          } else {
            final classes = snapshot.data!;

            return ListView.builder(
              padding: const EdgeInsets.all(16),
              itemCount: classes.length,
              itemBuilder: (context, index) {
                return Card(
                  color: const Color(0xFFF0F8FF),
                  child: ListTile(
                    leading: const Icon(Icons.folder, size: 32, color: Color(0xFF0078D4)),
                    title: Text(classes[index]),
                    onTap: () {
                      Navigator.push(
                        context,
                        MaterialPageRoute(
                          builder: (context) => MataPelajaranCategoryScreen(
                            year: widget.year,  // Pass the year
                            className: classes[index],  // Pass the selected class
                            idKurikulum: widget.idKurikulum.toString(),  // Pass the idKurikulum from widget
                          ),
                        ),
                      );
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
