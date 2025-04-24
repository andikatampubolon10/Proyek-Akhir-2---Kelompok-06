import 'package:flutter/material.dart';

class MateriDetailScreen extends StatelessWidget {
  final String title;
  final String description;
  final String file;

  const MateriDetailScreen({
    super.key,
    required this.title,
    required this.description,
    required this.file,
  });

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        // Back button (leading icon) and title setup
        leading: IconButton(
          icon: const Icon(Icons.arrow_back, color: Colors.white), // Back icon in white
          onPressed: () {
            Navigator.pop(context); // Go back when the back icon is pressed
          },
        ),
        title: Text(
          "Materi", // Title of the page
          style: const TextStyle(
            fontSize: 24, // Larger font size for the title
            fontWeight: FontWeight.bold,
            color: Colors.white, // White color for the title
          ),
        ),
        backgroundColor: const Color(0xFF0078D4),
      ),
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Title of the material (Sistem Pencernaan or any title)
            Text(
              'Sistem Pencernaan',  // Title passed from the previous screen
              style: const TextStyle(
                fontSize: 32,  // Larger font size for the title
                fontWeight: FontWeight.bold,
                color: Colors.black87, // Black color for the material title
              ),
            ),
            const SizedBox(height: 16),  // Space between the title and description

            // Description Section
            Text(
              'Deskripsi: $description',  // The description of the material
              style: const TextStyle(
                fontSize: 16,
                color: Colors.black87,
              ),
            ),
            const SizedBox(height: 16),

            // File Name Section
            Text(
              'Nama file: $file',  // File name (e.g., Sistem_pencernaan.pdf)
              style: const TextStyle(
                fontSize: 16,
                color: Colors.blue
              ),
            ),
          ],
        ),
      ),
    );
  }
}