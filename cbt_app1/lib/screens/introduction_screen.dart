import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:http/http.dart' as http;
import 'quiz_screen.dart'; // Import QuizScreen

class IntroductionScreen extends StatefulWidget {
  final String idUjian; // id_ujian passed to this screen
  final String title;
  final String subject;
  final int gradeLevel;

  const IntroductionScreen({
    super.key,
    required this.idUjian,
    required this.title,
    required this.subject,
    required this.gradeLevel,
  });

  @override
  State<IntroductionScreen> createState() => _IntroductionScreenState();
}

class _IntroductionScreenState extends State<IntroductionScreen> {
  final TextEditingController _passwordController = TextEditingController();
  bool _obscurePassword = true;
  bool _isLoading = false;
  String _errorMessage = '';

  // Function to validate the entered password by calling the API
  Future<void> _validatePassword() async {
    final password = _passwordController.text;

    if (password.isEmpty) {
      setState(() {
        _errorMessage = 'Password tidak boleh kosong.';
      });
      return;
    }

    setState(() {
      _isLoading = true;
      _errorMessage = '';
      print("Received id_ujian: ${widget.idUjian}");
    });

    var url = Uri.parse('http://192.168.190.78:8080/login-ujian/${widget.idUjian}');
    try {
      var response = await http.post(
        url,
        headers: {'Content-Type': 'application/json'},
        body: jsonEncode({'password': password}),
      );

      setState(() {
        _isLoading = false;
      });

      if (response.statusCode == 200) {
        // Password benar, navigasi ke QuizScreen
        Navigator.push(
          context,
          MaterialPageRoute(
            builder: (context) => QuizScreen(
              title: widget.title,
              subject: widget.subject,
              gradeLevel: widget.gradeLevel,
              idUjian: widget.idUjian.toString(),
            ),
          ),
        );
      } else {
        // Password salah
        setState(() {
          _errorMessage = 'Password salah, silakan coba lagi.';
        });
      }
    } catch (e) {
      setState(() {
        _isLoading = false;
        _errorMessage = 'Terjadi kesalahan koneksi: $e';
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        backgroundColor: const Color(0xFF036BB9),
        title: Text(
          widget.title,
          style: const TextStyle(
            fontSize: 20.0,
            color: Colors.white,
            fontWeight: FontWeight.w400,
            fontFamily: 'Poppins',
          ),
        ),
        toolbarHeight: 70,
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: Colors.white),
          onPressed: () {
            Navigator.pop(context);
          },
        ),
      ),
      body: Padding(
        padding: const EdgeInsets.all(24.0),
        child: SingleChildScrollView(
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.center,
            children: [
              _buildInstructions(),
              const SizedBox(height: 24),
              _buildScheduleInfo(),
              const SizedBox(height: 24),
              _buildPasswordField(),
              const SizedBox(height: 24),
              _buildStartButton(),
              if (_errorMessage.isNotEmpty)
                Padding(
                  padding: const EdgeInsets.only(top: 20),
                  child: Text(
                    _errorMessage,
                    style: const TextStyle(color: Colors.red, fontSize: 16),
                  ),
                ),
            ],
          ),
        ),
      ),
    );
  }

  Widget _buildInstructions() {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        border: Border.all(color: Colors.black45),
        borderRadius: BorderRadius.circular(8),
      ),
      child: const Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text('Petunjuk', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
          SizedBox(height: 12),
          Text('1. Kerjakan Quiz ini dengan jujur'),
          Text('2. Soal Bersifat Pilihan Berganda'),
          Text('3. Jika ketahuan mencontek, nilai akan 0'),
        ],
      ),
    );
  }

  Widget _buildScheduleInfo() {
    return const Column(
      children: [
        Text(
          'Kuis dibuka pada Kamis,\n10 Oktober 2024, 18:00 WIB',
          textAlign: TextAlign.center,
          style: TextStyle(fontSize: 16),
        ),
        SizedBox(height: 12),
        Text(
          'Kuis ditutup pada Kamis,\n10 Oktober 2024, 20:00 WIB',
          textAlign: TextAlign.center,
          style: TextStyle(fontSize: 16),
        ),
      ],
    );
  }

  Widget _buildPasswordField() {
    return Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        const Text('Masukkan Password', style: TextStyle(fontSize: 16)),
        const SizedBox(height: 12),
        TextFormField(
          controller: _passwordController,
          obscureText: _obscurePassword,
          decoration: InputDecoration(
            hintText: 'Password',
            border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
            suffixIcon: IconButton(
              icon: Icon(_obscurePassword ? Icons.visibility_off : Icons.visibility),
              onPressed: () {
                setState(() {
                  _obscurePassword = !_obscurePassword;
                });
              },
            ),
          ),
        ),
      ],
    );
  }

  Widget _buildStartButton() {
    return ElevatedButton(
      onPressed: _isLoading ? null : _validatePassword,
      style: ElevatedButton.styleFrom(
        backgroundColor: const Color(0xFF0078D4),
        minimumSize: const Size(double.infinity, 50),
      ),
      child: _isLoading
          ? const CircularProgressIndicator()
          : const Text(
              'Mulai Quiz',
              style: TextStyle(
                color: Colors.white,
              ),
            ),
    );
  }
}
