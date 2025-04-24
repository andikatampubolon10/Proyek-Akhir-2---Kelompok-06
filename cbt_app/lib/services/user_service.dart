import 'dart:convert';
import 'package:http/http.dart' as http;

class UserService {
  final String baseUrl = 'http://192.168.56.1:8080'; // Your backend base URL

  Future<String?> fetchUserName(String idSiswa) async {
    var url = Uri.parse('$baseUrl/profil/$idSiswa');

    try {
      final response = await http.get(url);

      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        return data['nama_siswa']; // Return the name of the student
      } else {
        throw Exception('Failed to load user info');
      }
    } catch (e) {
      throw Exception('Error fetching user info: $e');
    }
  }
}
