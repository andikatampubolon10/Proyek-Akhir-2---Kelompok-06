import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class ApiService {
  // URL endpoint API yang dilindungi
  final String _baseUrl = 'http://192.168.56.1:8080/login'; // Ganti dengan URL API Anda

  // Fungsi untuk mengambil data dari API yang dilindungi dengan token
  Future<Map<String, dynamic>?> fetchData() async {
    // Mengambil token yang disimpan di SharedPreferences
    SharedPreferences prefs = await SharedPreferences.getInstance();
    String? token = prefs.getString('token');

    if (token == null) {
      // Jika token tidak ada, kembalikan null atau error
      return {'error': 'No token found'};
    }

    // Membuat URL dan header dengan token
    var url = Uri.parse('$_baseUrl/api/protected');
    var headers = {
      'Authorization': 'Bearer $token', // Menambahkan token di header Authorization
    };

    // Melakukan request GET
    var response = await http.get(url, headers: headers);

    if (response.statusCode == 200) {
      // Proses data jika berhasil
      var data = jsonDecode(response.body);
      return {'data': data}; // Mengembalikan data jika berhasil
    } else {
      // Menangani error jika request gagal
      return {'error': 'Failed to load data'};
    }
  }
}
