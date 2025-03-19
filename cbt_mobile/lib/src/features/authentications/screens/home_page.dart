import 'package:flutter/material.dart';
import 'beranda.dart'; // Import halaman Beranda
import 'package:google_fonts/google_fonts.dart';

class LoginPage extends StatefulWidget {
  const LoginPage({super.key});

  @override
  _LoginPageState createState() => _LoginPageState(); // Membuat state untuk LoginPage
}

class _LoginPageState extends State<LoginPage> {
  final TextEditingController _usernameController = TextEditingController();
  final TextEditingController _passwordController = TextEditingController();

  void _login() {
    // Logika login atau validasi
    if (_usernameController.text == 'admin' && _passwordController.text == '1234') {
      // Jika login berhasil, pindah ke halaman Beranda
      Navigator.push(
        context,
        MaterialPageRoute(builder: (context) => const InputDesign()),
      );
    } else {
      // Menampilkan pesan kesalahan jika login gagal
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Invalid username or password')),
      );
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      backgroundColor: const Color(0xFF036BB9),
      body: SafeArea(
        child: Center(
          child: SizedBox(
            width: 300, // Menentukan lebar Card
            height: 400, // Menentukan tinggi Card
            child: Card(
              elevation: 8, // Efek bayangan pada Card
              shape: RoundedRectangleBorder(
                borderRadius: BorderRadius.circular(16), // Membuat sudut Card membulat
              ),
              child: SingleChildScrollView( // Memungkinkan scrolling jika konten melebihi batas
                child: Padding(
                  padding: const EdgeInsets.all(10.0), // Memberikan padding di dalam Card
                  child: Column(
                    mainAxisSize: MainAxisSize.min, // Menyesuaikan ukuran dengan konten
                    children: [
                      Image.asset(
                        'assets/images/quiz-hub.png', // Pastikan jalur gambar sesuai
                        width: 100, // Atur lebar gambar sesuai kebutuhan
                        height: 100, // Atur tinggi gambar sesuai kebutuhan
                      ),
                      const SizedBox(height: 20),
                      const Align(
                        alignment: Alignment.centerLeft, // Menempatkan teks di kiri
                        child: Text(
                          'Username',
                          style: TextStyle(color: Colors.black),
                        ),
                      ),
                      Container(
                        width: 280,
                        height: 35, // Mengatur lebar TextField
                        child: TextField(
                          controller: _usernameController, // Menggunakan controller
                          style: const TextStyle(fontSize: 14),
                          decoration: const InputDecoration(
                            hintText: 'Enter your username',
                            hintStyle: TextStyle(fontSize: 14, color: Color.fromARGB(255, 68, 68, 68)),
                            border: OutlineInputBorder(),
                            filled: true,
                            fillColor: Colors.white,
                            contentPadding: EdgeInsets.symmetric(vertical: 8, horizontal: 10),
                          ),
                        ),
                      ),
                      const SizedBox(height: 20), // Jarak antara kolom username dan password
                      const Align(
                        alignment: Alignment.centerLeft, // Menempatkan teks di kiri
                        child: Text(
                          'Password',
                          style: TextStyle(color: Colors.black),
                        ),
                      ),
                      Container(
                        width: 280,
                        height: 35, // Mengatur lebar TextField
                        child: TextField(
                          controller: _passwordController, // Menggunakan controller
                          obscureText: true,
                          style: const TextStyle(fontSize: 14),
                          decoration: const InputDecoration(
                            hintText: 'Enter your password',
                            hintStyle: TextStyle(fontSize: 14, color: Color.fromARGB(255, 68, 68, 68)),
                            border: OutlineInputBorder(),
                            filled: true,
                            fillColor: Colors.white,
                            contentPadding: EdgeInsets.symmetric(vertical: 8, horizontal: 10),
                          ),
                        ),
                      ),
                      const SizedBox(height: 30), // Jarak antara kolom password dan tombol login
                      ElevatedButton(
                        onPressed: _login, // Panggil fungsi _login saat tombol ditekan
                        child: const Text('Login'),
                        style: ElevatedButton.styleFrom(
                          backgroundColor: Colors.blue, // Ganti 'primary' dengan 'backgroundColor'
                          foregroundColor: Colors.white, // Ganti 'onPrimary' dengan 'foregroundColor'
                          padding: const EdgeInsets.symmetric(horizontal: 50, vertical: 15),
                        ),
                      ),
                    ],
                  ),
                ),
              ),
            ),
          ),
        ),
      ),
    );
  }
}

void main() {
  runApp(MaterialApp(
    home: const LoginPage(), // Menggunakan widget yang baru dibuat
  ));
}
