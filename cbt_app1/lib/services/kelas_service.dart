import 'dart:convert';
import 'package:http/http.dart' as http;

class KelasService {
  final String baseUrl = 'http://192.168.190.78:8080'; // Change to your API base URL

  // Fetch all classes from the API
  Future<List<String>> fetchKelas() async {
    try {
      final response = await http.get(Uri.parse('$baseUrl/kelas'));

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        // Extract the list of kelas from the response
        final kelasList = List<String>.from(data['kelas'].map((kelas) => kelas['nama_kelas']));

        return kelasList;
      } else {
        throw Exception('Failed to load Kelas');
      }
    } catch (e) {
      print('Error fetching kelas: $e');
      return [];
    }
  }
}
