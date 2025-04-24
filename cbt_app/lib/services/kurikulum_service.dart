import 'dart:convert';
import 'package:http/http.dart' as http;

class KurikulumService {
  final String baseUrl = 'http://192.168.56.1:8080'; // URL API

  Future<List<Kurikulum>> fetchKurikulum() async {
    var url = Uri.parse('$baseUrl/kurikulum');  // Endpoint for kurikulum data

    try {
      var response = await http.get(url);

      if (response.statusCode == 200) {
        var data = jsonDecode(response.body);
        List<dynamic> kurikulumData = data['kurikulum'];  // Get the kurikulum list

        // Map the response to Kurikulum objects
        return kurikulumData.map((kurikulum) => Kurikulum.fromJson(kurikulum)).toList();
      } else {
        throw Exception('Failed to load kurikulum');
      }
    } catch (e) {
      throw Exception('Error fetching data: $e');
    }
  }
}


class Kurikulum {
  final int idKurikulum;
  final String namaKurikulum;

  Kurikulum({
    required this.idKurikulum,
    required this.namaKurikulum,
  });

  factory Kurikulum.fromJson(Map<String, dynamic> json) {
    return Kurikulum(
      idKurikulum: json['id_kurikulum'],
      namaKurikulum: json['nama_kurikulum'],
    );
  }
}
