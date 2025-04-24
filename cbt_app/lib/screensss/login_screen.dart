import 'package:flutter/material.dart';
import 'package:cbt_app/services/auth_services.dart'; // Pastikan import ke file auth_service.dart
import 'ui/home.dart';  // Pastikan HomeScreen sudah sesuai

class LoginScreenss extends StatefulWidget {
  @override
  _LoginScreenState createState() => _LoginScreenState();
}

class _LoginScreenState extends State<LoginScreen> {
  final TextEditingController _emailController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();
  String? _errorMessage = ''; // Menyimpan pesan error

  // Fungsi untuk menangani login
  void _login() async {
    String email = _emailController.text;
    String password = _passwordController.text;

    // Menjalankan proses login
    Map<String, String>? loginResponse = await AuthService().loginUser(email, password);

    // Cek jika loginResponse tidak null dan berisi token serta id_siswa
    if (loginResponse != null && loginResponse.containsKey('token') && loginResponse.containsKey('idSiswa')) {
      String idSiswa = loginResponse['idSiswa']!; // Mendapatkan id_siswa dari respons

      // Arahkan ke HomeScreen dengan id_siswa
      Navigator.pushReplacement(
        context,
        MaterialPageRoute(
          builder: (context) => HomeScreen(idSiswa: idSiswa),
        ),
      );
    } else {
      // Jika login gagal, tampilkan error message
      setState(() {
        _errorMessage = 'Invalid email or password'; // Tampilkan pesan error
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: Text('Login'),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            TextField(
              controller: _emailController,
              decoration: InputDecoration(labelText: 'Email'),
            ),
            TextField(
              controller: _passwordController,
              obscureText: true,
              decoration: InputDecoration(labelText: 'Password'),
            ),
            SizedBox(height: 20),
            ElevatedButton(
              onPressed: _login,
              child: Text('Login'),
            ),
            if (_errorMessage != null) ...[
              SizedBox(height: 20),
              Text(
                _errorMessage!,
                style: TextStyle(color: Colors.red),
              ),
            ]
          ],
        ),
      ),
    );
  }
}
