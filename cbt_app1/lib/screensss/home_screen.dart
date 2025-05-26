import 'package:flutter/material.dart';
import 'package:cbt_app/services/get_kursus_siswa_services.dart';

class HomeScreen extends StatefulWidget {
  @override
  _HomeScreenState createState() => _HomeScreenState();
}

class _HomeScreenState extends State<HomeScreen> {
  late Future<List<String>> _kursusList;

  @override
  void initState() {
    super.initState();
    // Gantilah id_siswa dengan id_siswa yang sesuai dari token atau parameter lain
    _kursusList = ApiService().getKursusBySiswa('1');  // Ganti dengan id_siswa yang sesuai
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text("Kursus Siswa"),
      ),
      body: FutureBuilder<List<String>>(
        future: _kursusList,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return Center(child: CircularProgressIndicator());
          } else if (snapshot.hasError) {
            return Center(child: Text('Error: ${snapshot.error}'));
          } else if (!snapshot.hasData || snapshot.data!.isEmpty) {
            return Center(child: Text('No courses found.'));
          } else {
            List<String> kursusList = snapshot.data!;
            return ListView.builder(
              itemCount: kursusList.length,
              itemBuilder: (context, index) {
                return ListTile(
                  title: Text(kursusList[index]),
                );
              },
            );
          }
        },
      ),
    );
  }
}
