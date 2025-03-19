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