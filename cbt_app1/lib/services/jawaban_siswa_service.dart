import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:shared_preferences/shared_preferences.dart';

class JawabanSiswa {
  final String jawabanSiswa;
  final int idSoal;
  final int idSiswa;
  final int? idJawabanSoal;

  JawabanSiswa({
    required this.jawabanSiswa,
    required this.idSoal,
    required this.idSiswa,
    this.idJawabanSoal,
  });

  Map<String, dynamic> toJson() {
    return {
      'jawaban_siswa': jawabanSiswa,
      'id_soal': idSoal,
      'id_siswa': idSiswa,
      'id_jawaban_soal': idJawabanSoal,
    };
  }
}

class JawabanSiswaService {
  // Base URL for the API
  final String baseUrl = 'http://192.168.190.78:8080/api';

  // Create a single jawaban siswa
  Future<bool> createJawabanSiswa(JawabanSiswa jawabanSiswa) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/jawaban-siswa'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode(jawabanSiswa.toJson()),
      );

      if (response.statusCode == 201) {
        print('Jawaban siswa created successfully');
        return true;
      } else {
        print('Failed to create jawaban siswa: ${response.body}');
        return false;
      }
    } catch (e) {
      print('Error creating jawaban siswa: $e');
      return false;
    }
  }

  // Create multiple jawaban siswa at once
  Future<bool> createBatchJawabanSiswa(List<JawabanSiswa> jawabanList) async {
    try {
      final response = await http.post(
        Uri.parse('$baseUrl/jawaban-siswa/batch'),
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({
          'jawaban_list': jawabanList.map((jawaban) => jawaban.toJson()).toList(),
        }),
      );

      if (response.statusCode == 201) {
        print('Batch jawaban siswa created successfully');
        return true;
      } else {
        print('Failed to create batch jawaban siswa: ${response.body}');
        return false;
      }
    } catch (e) {
      print('Error creating batch jawaban siswa: $e');
      return false;
    }
  }

  // Get jawaban siswa by ID
  Future<Map<String, dynamic>?> getJawabanSiswaById(int id) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/jawaban-siswa/$id'),
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return data['data'];
      } else {
        print('Failed to get jawaban siswa: ${response.body}');
        return null;
      }
    } catch (e) {
      print('Error getting jawaban siswa: $e');
      return null;
    }
  }

  // Get all jawaban siswa by siswa ID
  Future<List<Map<String, dynamic>>?> getJawabanSiswaBySiswaId(int siswaId) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/jawaban-siswa/siswa/$siswaId'),
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return List<Map<String, dynamic>>.from(data['data']);
      } else {
        print('Failed to get jawaban siswa by siswa ID: ${response.body}');
        return null;
      }
    } catch (e) {
      print('Error getting jawaban siswa by siswa ID: $e');
      return null;
    }
  }

  // Get all jawaban siswa by ujian ID
  Future<List<Map<String, dynamic>>?> getJawabanSiswaByUjianId(int ujianId) async {
    try {
      final response = await http.get(
        Uri.parse('$baseUrl/jawaban-siswa/ujian/$ujianId'),
      );

      if (response.statusCode == 200) {
        final data = jsonDecode(response.body);
        return List<Map<String, dynamic>>.from(data['data']);
      } else {
        print('Failed to get jawaban siswa by ujian ID: ${response.body}');
        return null;
      }
    } catch (e) {
      print('Error getting jawaban siswa by ujian ID: $e');
      return null;
    }
  }

  // Helper method to get the current user ID from SharedPreferences
  Future<int?> getCurrentUserId() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      // Try different keys that might store the user ID
      int? userId = prefs.getInt('user_id');
      if (userId == null) {
        userId = prefs.getInt('id_siswa');
      }
      if (userId == null) {
        userId = prefs.getInt('siswa_id');
      }
      if (userId == null) {
        // Try to get it as a string and convert to int
        String? userIdStr = prefs.getString('user_id');
        if (userIdStr != null) {
          userId = int.tryParse(userIdStr);
        }
      }
      
      // If still null, check if we have a user object stored as JSON
      if (userId == null) {
        String? userJson = prefs.getString('user');
        if (userJson != null) {
          try {
            Map<String, dynamic> userData = jsonDecode(userJson);
            userId = userData['id'] ?? userData['id_siswa'] ?? userData['siswa_id'];
          } catch (e) {
            print('Error parsing user JSON: $e');
          }
        }
      }
      
      return userId;
    } catch (e) {
      print('Error getting current user ID: $e');
      return null;
    }
  }

  // Submit quiz answers
// Helper method for handling answers
Future<bool> submitQuizAnswers({
    required String idUjian,
    required List<Map<String, dynamic>> questions,
    required List<String?> selectedAnswers,
  }) async {
    try {
      // Get current user ID
      final userId = await getCurrentUserId();
      final int siswaId = userId ?? 1;  // Fallback for testing

      if (userId == null) {
        print('User ID not found, using fallback ID: $siswaId');
        final prefs = await SharedPreferences.getInstance();
        await prefs.setInt('user_id', siswaId);
      }

      // Prepare a list of JawabanSiswa objects
      List<JawabanSiswa> jawabanList = [];

      for (int i = 0; i < questions.length; i++) {
        // Skip if no answer is selected
        if (selectedAnswers[i] == null) continue;

        final question = questions[i];
        final selectedAnswer = selectedAnswers[i]!;

        // Safe parsing of question ID
        int idSoal;
        try {
          idSoal = int.parse(question['id'] ?? '0');
        } catch (e) {
          print('Error parsing question ID: ${question['id']}');
          idSoal = 0;
        }

        // Extract idJawabanSoal for Multiple Choice
        int? idJawabanSoal;
        if (question['id_tipe_soal'] == 1) { // Multiple Choice
          final jawabanListData = question['jawaban_list'] as List<dynamic>? ?? [];
          for (var jawaban in jawabanListData) {
            final teksJawaban = jawaban['teks_jawaban']?.toString() ?? 
                               jawaban['jawaban']?.toString() ?? 
                               jawaban['text']?.toString();
            if (teksJawaban == selectedAnswer) {
              idJawabanSoal = jawaban['id_jawaban_soal'] ?? jawaban['id'];
              break;
            }
          }
        } else if (question['id_tipe_soal'] == 2) { // True/False
          final jawabanListData = question['jawaban_list'] as List<dynamic>? ?? [];
          // Here, we dynamically fetch idJawabanSoal for True/False
          for (var jawaban in jawabanListData) {
            if (jawaban['jawaban'] == selectedAnswer) {
              idJawabanSoal = jawaban['id_jawaban_soal']; // Or the correct ID field
              break;
            }
          }
        }

        jawabanList.add(JawabanSiswa(
          jawabanSiswa: selectedAnswer,
          idSoal: idSoal,
          idSiswa: siswaId,
          idJawabanSoal: idJawabanSoal,
        ));
      }

      // If no answers are available
      if (jawabanList.isEmpty) {
        print('No answers to submit');
        return false;
      }

      // Print data being submitted for debugging
      print('Submitting ${jawabanList.length} answers for user ID: $siswaId');
      for (var jawaban in jawabanList) {
        print('Answer: ${jawaban.toJson()}');
      }

      // Send the answers to the server
      return await createBatchJawabanSiswa(jawabanList);
    } catch (e) {
      print('Error submitting quiz answers: $e');
      return false;
    }
  }
}