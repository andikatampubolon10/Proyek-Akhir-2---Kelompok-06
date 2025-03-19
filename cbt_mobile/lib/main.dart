import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';
import 'src/features/authentications/screens/home_page.dart';  // Jalur impor yang benar  // Mengimpor file home_page.dart

void main() {
  runApp(const MyApp());
}

class MyApp extends StatelessWidget {
  const MyApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Flutter Demo',
      theme: ThemeData(
        fontFamily: GoogleFonts.poppins().fontFamily,
        primarySwatch: Colors.blue,
      ),
      home: const LoginPage(),  // Menggunakan HomePage dari file lain
    );
  }
}
