import 'package:flutter/material.dart';
import 'package:google_fonts/google_fonts.dart';

class CourseCard extends StatelessWidget {
  final String imageUrl;
  final String classLevel;
  final String academicYear;
  final String courseName;
  final bool isSmallScreen;
  final bool isMediumScreen;

  const CourseCard({
    Key? key,
    required this.imageUrl,
    required this.classLevel,
    required this.academicYear,
    required this.courseName,
    required this.isSmallScreen,
    required this.isMediumScreen,
  }) : super(key: key);

  @override
  Widget build(BuildContext context) {
    return Container(
      width: isMediumScreen ? double.infinity : 360,
      height: isSmallScreen ? 140 : 156,
      decoration: BoxDecoration(
        color: Colors.white,
        borderRadius: BorderRadius.circular(11),
        border: Border.all(
          color: Colors.black.withOpacity(0.35),
          width: 1,
        ),
      ),
      clipBehavior: Clip.antiAlias,
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          // Course image
          Image.network(
            imageUrl,
            width: double.infinity,
            height: isSmallScreen ? 90 : 107,
            fit: BoxFit.cover,
          ),

          // Course details
          Padding(
            padding: const EdgeInsets.all(10),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                // Class level
                Text(
                  classLevel,
                  style: GoogleFonts.poppins(
                    fontSize: 11,
                    fontWeight: FontWeight.w300,
                    color: Colors.black.withOpacity(0.75),
                  ),
                ),

                // Academic year and course name
                const SizedBox(height: 1),
                Row(
                  children: [
                    Text(
                      '$academicYear - ',
                      style: GoogleFonts.poppins(
                        fontSize: 11,
                        fontWeight: FontWeight.w300,
                        color: Colors.black,
                      ),
                    ),
                    Text(
                      courseName,
                      style: GoogleFonts.poppins(
                        fontSize: 11,
                        fontWeight: FontWeight.w300,
                        color: Colors.black,
                      ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class InputDesign extends StatelessWidget {
  const InputDesign({Key? key}) : super(key: key);

  @override
  Widget build(BuildContext context) {
    final screenWidth = MediaQuery.of(context).size.width;
    final isSmallScreen = screenWidth <= 640;
    final isMediumScreen = screenWidth <= 991;

    // Calculate width based on screen size
    final containerWidth = isMediumScreen ? screenWidth : 440.0;

    return Scaffold(
      body: Container(
        width: containerWidth,
        height: isSmallScreen ? null : 956,
        color: Colors.white,
        child: SingleChildScrollView(
          child: Column(
            children: [
              // Header section
              Container(
                width: containerWidth,
                height: isSmallScreen ? null : 157,
                padding: EdgeInsets.symmetric(
                  horizontal: isSmallScreen ? 20 : 33,
                  vertical: isSmallScreen ? 40 : 60,
                ),
                color: const Color(0xFF036BB9),
                child: Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    // User greeting
                    Text.rich(
                      TextSpan(
                        children: [
                          TextSpan(text: 'Hello,\n'),
                          TextSpan(text: 'Natan Hutahaean'),
                        ],
                      ),
                      style: GoogleFonts.poppins(
                        fontSize: 21,
                        fontWeight: FontWeight.w300,
                        color: Colors.white,
                      ),
                    ),
                    // Profile picture
                    Container(
                      width: 50,
                      height: 50,
                      decoration: BoxDecoration(
                        shape: BoxShape.circle,
                        border: Border.all(
                          color: Colors.black.withOpacity(0.5),
                          width: 0.5,
                        ),
                        image: const DecorationImage(
                          image: NetworkImage('https://cdn.builder.io/api/v1/image/assets/TEMP/bf3d14eafc796eaff53986af9adb49ee0e13b1d9'),
                          fit: BoxFit.cover,
                        ),
                      ),
                    ),
                  ],
                ),
              ),

              // Search bar section
              Container(
                padding: EdgeInsets.symmetric(
                  horizontal: isSmallScreen ? 20 : 40,
                  vertical: isSmallScreen ? 15 : 20,
                ),
                child: Container(
                  width: isMediumScreen ? double.infinity : 360,
                  height: 48,
                  padding: const EdgeInsets.symmetric(horizontal: 17),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(15),
                    border: Border.all(
                      color: Colors.black.withOpacity(0.75),
                      width: 1,
                    ),
                  ),
                  child: Row(
                    children: [
                      Text(
                        'Search your course',
                        style: GoogleFonts.poppins(
                          fontSize: 14,
                          color: const Color(0xFF191919).withOpacity(0.5),
                        ),
                      ),
                      const Spacer(),
                      Icon(
                        Icons.search,
                        color: Colors.black.withOpacity(0.75),
                      ),
                    ],
                  ),
                ),
              ),

              // Course cards section
              Container(
                padding: EdgeInsets.symmetric(
                  horizontal: isSmallScreen ? 20 : 40,
                ),
                child: Column(
                  children: [
                    // Science course card
                    CourseCard(
                      imageUrl: 'https://cdn.builder.io/api/v1/image/assets/TEMP/bf3d14eafc796eaff53986af9adb49ee0e13b1d9',
                      classLevel: 'Kelas 9',
                      academicYear: '2024/2025',
                      courseName: 'Ilmu Pengetahuan Alam',
                      isSmallScreen: isSmallScreen,
                      isMediumScreen: isMediumScreen,
                    ),
                    const SizedBox(height: 16),

                    // Arts course card
                    CourseCard(
                      imageUrl: 'https://cdn.builder.io/api/v1/image/assets/TEMP/52c43bb916248a0c95a480e7e83c8bd19f65a21a',
                      classLevel: 'Kelas 9',
                      academicYear: '2024/2025',
                      courseName: 'Seni Budaya',
                      isSmallScreen: isSmallScreen,
                      isMediumScreen: isMediumScreen,
                    ),
                    const SizedBox(height: 16),

                    // Religion course card
                    CourseCard(
                      imageUrl: 'https://cdn.builder.io/api/v1/image/assets/TEMP/4733de0f008b25b246627df824fc31043a2f0d6d',
                      classLevel: 'Kelas 9',
                      academicYear: '2024/2025',
                      courseName: 'Pendidikan Agama',
                      isSmallScreen: isSmallScreen,
                      isMediumScreen: isMediumScreen,
                    ),
                  ],
                ),
              ),

              // Add bottom padding for scrolling
              const SizedBox(height: 20),
            ],
          ),
        ),
      ),
    );
  }
}