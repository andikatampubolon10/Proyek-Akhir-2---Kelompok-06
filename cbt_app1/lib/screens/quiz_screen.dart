import 'dart:convert';
import 'package:http/http.dart' as http;
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:cbt_app/services/jawaban_siswa_service.dart'; // Import the service

class QuizScreen extends StatefulWidget {
  final String title;
  final String subject;
  final int gradeLevel;
  final String idUjian;
  final int? idSiswa; // Add this parameter to accept a user ID

  const QuizScreen({
    Key? key,
    required this.title,
    required this.subject,
    required this.gradeLevel,
    required this.idUjian,
    this.idSiswa, // Make it optional
  }) : super(key: key);

  @override
  State<QuizScreen> createState() => _QuizScreenState();
}

class _QuizScreenState extends State<QuizScreen> {
  int _currentQuestionIndex = 0;
  List<Map<String, dynamic>> questions = [];
  late List<String?> _selectedAnswers;
  bool _isMenuOpen = false;
  bool _quizCompleted = false;
  bool _isLoading = true;
  bool _hasError = false;
  String _errorMessage = '';
  bool _isSaving = false; // New flag for saving state

  // Create an instance of the JawabanSiswaService
  final JawabanSiswaService _jawabanSiswaService = JawabanSiswaService();

  // Menambahkan status soal yang sudah dilihat
  late List<bool> _viewedQuestions;

  @override
  void initState() {
    super.initState();
    _saveUserIdIfProvided();
    _loadQuestions();
  }

  // Save the user ID if it was provided
  Future<void> _saveUserIdIfProvided() async {
    if (widget.idSiswa != null) {
      try {
        final prefs = await SharedPreferences.getInstance();
        await prefs.setInt('user_id', widget.idSiswa!);
        print('User ID saved: ${widget.idSiswa}');
      } catch (e) {
        print('Error saving user ID: $e');
      }
    }
  }

  Future<void> _loadQuestions() async {
    setState(() {
      _isLoading = true;
      _hasError = false;
    });

    try {
      // Menggunakan endpoint API dari controller Go
      final response = await http.get(
        Uri.parse('http://192.168.190.78:8080/soal-ujian/${widget.idUjian}'),
      );

      if (response.statusCode == 200) {
        final data = json.decode(response.body);
        final List<dynamic> soalData = data['data'];
        
        // Debug: Print the raw response to see its structure
        print("API Response: ${response.body}");
        
        // Transformasi data dari API ke format yang dibutuhkan aplikasi
        List<Map<String, dynamic>> formattedQuestions = [];
        
        for (var item in soalData) {
          // Safely access soal with null checks
          final soal = item['soal'] ?? {};
          final jawabanList = item['jawaban'] as List<dynamic>? ?? [];
          
          // Debug: Print the jawaban list for this question
          print("Question ID: ${soal['id_soal']}, Jawaban: $jawabanList");
          
          // Safely extract id_tipe_soal with a default value
          final idTipeSoal = soal['id_tipe_soal'] ?? 1;
          final idSoal = soal['id_soal']?.toString() ?? '';
          
          // Menentukan tipe soal berdasarkan id_tipe_soal
          String questionType;
          List<String> options = [];
          
          switch (idTipeSoal) {
            case 1: // Multiple Choice
              questionType = 'multiple_choice';
              // Ekstrak opsi jawaban dari jawabanList dengan null safety
              if (jawabanList.isNotEmpty) {
                options = jawabanList.map<String>((jawaban) {
                  // Make sure we're accessing the correct field for the answer text
                  return jawaban['teks_jawaban']?.toString() ?? 'No option text';
                }).toList();
                
                // Debug: Print the extracted options
                print("Extracted options: $options");
              } else {
                print("Warning: No answer options found for question $idSoal");
              }
              break;
            case 2: // True/False
              questionType = 'true_false';
              if (jawabanList.isNotEmpty) {
                options = jawabanList.map<String>((jawaban) {
                  return jawaban['jawaban']?.toString() ?? 'No option text';
                }).toList();
                print("Extracted True/False options: $options");
              } else {
                options = ['Benar', 'Salah']; // fallback default
                print("Warning: No answer options found for True/False question $idSoal");
              }
              break;

            case 3: // Essay
              questionType = 'essay';
              break;
            default:
              questionType = 'multiple_choice';
          }
          
          // Safely access all fields with null checks and default values
          formattedQuestions.add({
            'id': idSoal,
            'question': soal['soal']?.toString() ?? 'No question text',
            'image': soal['gambar_soal']?.toString(), // Can be null
            'options': options,
            'type': questionType,
            'id_tipe_soal': idTipeSoal,
            'jawaban_list': jawabanList, // Store the original jawaban list for reference
          });
        }
        
        setState(() {
          questions = formattedQuestions;
          _selectedAnswers = List<String?>.filled(questions.length, null);
          _viewedQuestions = List<bool>.filled(questions.length, false);
          _viewedQuestions[0] = true; // Menandai soal pertama sebagai telah dilihat
          _isLoading = false;
        });
      } else {
        setState(() {
          _hasError = true;
          _errorMessage = 'Server error: ${response.statusCode}';
          _isLoading = false;
        });
      }
    } catch (e) {
      setState(() {
        _hasError = true;
        _errorMessage = 'Network error: $e';
        _isLoading = false;
      });
      print("Gagal memuat soal: $e");
    }
  }

  void _handleAnswer(String answer) {
    setState(() {
      _selectedAnswers[_currentQuestionIndex] = answer;
    });
  }

  void _nextQuestion() {
    if (_currentQuestionIndex < questions.length - 1) {
      setState(() {
        _currentQuestionIndex++;
        _viewedQuestions[_currentQuestionIndex] = true; // Menandai soal telah dilihat
      });
    } else {
      // Jika sudah di soal terakhir, tampilkan dialog konfirmasi
      _showConfirmationDialog();
    }
  }

  void _previousQuestion() {
    if (_currentQuestionIndex > 0) {
      setState(() {
        _currentQuestionIndex--;
        _viewedQuestions[_currentQuestionIndex] = true; // Menandai soal telah dilihat
      });
    }
  }

  void _showConfirmationDialog() {
    showDialog(
      context: context,
      builder: (BuildContext context) {
        return AlertDialog(
          title: const Text('Selesaikan Ujian?'),
          content: const Text('Apakah Anda yakin ingin menyelesaikan ujian ini?'),
          actions: [
            TextButton(
              onPressed: () => Navigator.of(context).pop(),
              child: const Text('Batal'),
            ),
            ElevatedButton(
              onPressed: () {
                Navigator.of(context).pop();
                _submitAnswersAndShowResult();
              },
              child: const Text('Ya, Selesaikan'),
            ),
          ],
        );
      },
    );
  }

  // New method to submit answers and show result
  Future<void> _submitAnswersAndShowResult() async {
    setState(() {
      _isSaving = true;
      _quizCompleted = true; // Set this to true to show the completion screen with loading indicator
    });

    try {
      // Use the service to submit the answers
      final success = await _jawabanSiswaService.submitQuizAnswers(
        idUjian: widget.idUjian,
        questions: questions,
        selectedAnswers: _selectedAnswers,
      );

      if (success) {
        print('Answers submitted successfully');
      } else {
        print('Failed to submit answers');
        // Show a snackbar or toast message
        ScaffoldMessenger.of(context).showSnackBar(
          const SnackBar(
            content: Text('Gagal menyimpan jawaban ke server'),
            backgroundColor: Colors.red,
          ),
        );
      }
    } catch (e) {
      print('Error submitting answers: $e');
      // Show a snackbar or toast message
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text('Error: $e'),
          backgroundColor: Colors.red,
        ),
      );
    } finally {
      // Even if there's an error, we still want to show the completion screen
      setState(() {
        _isSaving = false;
      });
    }
  }

  void _navigateToHomeDetail() {
    Navigator.of(context).pop();
  }

  void _toggleMenu() {
    setState(() {
      _isMenuOpen = !_isMenuOpen;
    });
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return Scaffold(
        appBar: AppBar(
          backgroundColor: Colors.white,
          elevation: 0,
          title: Text(
            widget.title,
            style: const TextStyle(
              color: Colors.black,
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
        body: const Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              CircularProgressIndicator(),
              SizedBox(height: 16),
              Text('Memuat soal ujian...'),
            ],
          ),
        ),
      );
    }

    if (_hasError) {
      return Scaffold(
        appBar: AppBar(
          backgroundColor: Colors.white,
          elevation: 0,
          title: Text(
            widget.title,
            style: const TextStyle(
              color: Colors.black,
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
        body: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              const Icon(Icons.error_outline, size: 60, color: Colors.red),
              const SizedBox(height: 16),
              Text('Error: $_errorMessage'),
              const SizedBox(height: 16),
              ElevatedButton(
                onPressed: _loadQuestions,
                child: const Text('Coba Lagi'),
              ),
            ],
          ),
        ),
      );
    }

    if (questions.isEmpty) {
      return Scaffold(
        appBar: AppBar(
          backgroundColor: Colors.white,
          elevation: 0,
          title: Text(
            widget.title,
            style: const TextStyle(
              color: Colors.black,
              fontWeight: FontWeight.bold,
            ),
          ),
        ),
        body: const Center(
          child: Text(
            'Tidak ada soal tersedia',
            style: TextStyle(fontSize: 24),
          ),
        ),
      );
    }

    if (_quizCompleted) {
      return _buildCompletionScreen();
    }

    return Scaffold(
      appBar: AppBar(
        backgroundColor: Colors.white,
        elevation: 0,
        title: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(
              widget.title,
              style: const TextStyle(
                color: Colors.black,
                fontWeight: FontWeight.bold,
                fontSize: 18,
              ),
            ),
            Text(
              '${widget.gradeLevel} - ${widget.subject}',
              style: const TextStyle(
                color: Colors.black,
                fontSize: 14,
              ),
            ),
          ],
        ),
        actions: [
          IconButton(
            icon: const Icon(Icons.menu, color: Colors.blue),
            onPressed: _toggleMenu,
          ),
        ],
      ),
      body: Stack(
        children: [
          _buildMainContent(),
          if (_isMenuOpen) _buildMenuOverlay(),
        ],
      ),
    );
  }

  Widget _buildMainContent() {
    final question = questions[_currentQuestionIndex];

    return SingleChildScrollView(
      padding: const EdgeInsets.all(16.0),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            children: [
              Text(
                'Soal ${_currentQuestionIndex + 1} dari ${questions.length}',
                style: const TextStyle(
                  fontSize: 18,
                  fontWeight: FontWeight.bold,
                  color: Colors.black,
                ),
              ),
              const SizedBox(width: 16),
              const Expanded(
                child: Center(
                  child: Text(
                    '20 : 45',
                    style: TextStyle(
                      color: Colors.black,
                      fontWeight: FontWeight.bold,
                      fontSize: 20,
                    ),
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),
          if (question['id_tipe_soal'] == 1) 
            _buildMultipleChoiceQuestion(question),
          if (question['id_tipe_soal'] == 2) 
            _buildTrueFalseQuestion(question),
          if (question['id_tipe_soal'] == 3) 
            _buildEssayQuestion(question),
          Padding(
            padding: const EdgeInsets.symmetric(vertical: 24.0),
            child: Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                ElevatedButton.icon(
                  onPressed: _currentQuestionIndex > 0 ? _previousQuestion : null,
                  icon: const Icon(Icons.arrow_back),
                  label: const Text('Sebelumnya'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.grey[300],
                    foregroundColor: Colors.black,
                    disabledBackgroundColor: Colors.grey[200],
                    disabledForegroundColor: Colors.grey[400],
                  ),
                ),
                ElevatedButton.icon(
                  onPressed: _nextQuestion,
                  icon: const Icon(Icons.arrow_forward),
                  label: Text(_currentQuestionIndex == questions.length - 1 ? 'Selesai' : 'Selanjutnya'),
                  style: ElevatedButton.styleFrom(
                    backgroundColor: Colors.blue,
                    foregroundColor: Colors.white,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }

  // Widget untuk soal pilihan ganda
  Widget _buildMultipleChoiceQuestion(Map<String, dynamic> question) {
    // Get the original jawaban list to extract the correct options
    final jawabanList = question['jawaban_list'] as List<dynamic>? ?? [];
    
    // Extract options from the jawaban list
    List<String> options = [];
    if (jawabanList.isNotEmpty) {
      options = jawabanList.map<String>((jawaban) {
        // Try different field names that might contain the answer text
        String optionText = jawaban['teks_jawaban']?.toString() ?? 
                           jawaban['jawaban']?.toString() ?? 
                           jawaban['text']?.toString() ?? 
                           'No option text';
        return optionText;
      }).toList();
    } else {
      // Fallback to the options we already processed
      options = question['options'] as List<String>? ?? ['No options available'];
    }

    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: const Color(0xFFE6F4FA),
        borderRadius: BorderRadius.circular(16),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            question['question'] ?? 'No question text',
            style: const TextStyle(fontSize: 18),
          ),
          if (question['image'] != null && question['image'].toString().isNotEmpty)
            Padding(
              padding: const EdgeInsets.symmetric(vertical: 16.0),
              child: Image.network(
                question['image'],
                errorBuilder: (context, error, stackTrace) {
                  return Container(
                    height: 150,
                    color: Colors.grey[200],
                    child: const Center(
                      child: Text('Gambar tidak tersedia'),
                    ),
                  );
                },
              ),
            ),
          const SizedBox(height: 16),
          ...options.asMap().entries.map((entry) {
            final index = entry.key;
            final option = entry.value;
            final optionLetter = String.fromCharCode(97 + index); // a, b, c, d, ...
            final isSelected = _selectedAnswers[_currentQuestionIndex] == option;

            return Padding(
              padding: const EdgeInsets.only(bottom: 12.0),
              child: InkWell(
                onTap: () => _handleAnswer(option),
                child: Container(
                  padding: const EdgeInsets.symmetric(vertical: 16, horizontal: 20),
                  decoration: BoxDecoration(
                    color: Colors.white,
                    borderRadius: BorderRadius.circular(12),
                    boxShadow: [
                      BoxShadow(
                        color: Colors.grey.withOpacity(0.1),
                        spreadRadius: 1,
                        blurRadius: 3,
                        offset: const Offset(0, 2),
                      ),
                    ],
                    border: isSelected
                        ? Border.all(color: Colors.blue, width: 2)
                        : null,
                  ),
                  child: Row(
                    mainAxisAlignment: MainAxisAlignment.spaceBetween,
                    children: [
                      Expanded(
                        child: Text(
                          '$optionLetter. $option',
                          style: TextStyle(
                            fontSize: 16,
                            fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
                          ),
                        ),
                      ),
                      if (isSelected)
                        const Icon(Icons.check_circle, color: Colors.blue),
                    ],
                  ),
                ),
              ),
            );
          }).toList(),
        ],
      ),
    );
  }

  // Widget untuk soal benar/salah
Widget _buildTrueFalseQuestion(Map<String, dynamic> question) {
  final soal = question['question'] ?? 'No question available';
  final options = question['options'] as List<String>? ?? ['Benar', 'Salah']; // Defaulting to True/False options if none

  return Container(
    width: double.infinity,
    padding: const EdgeInsets.all(24),
    decoration: BoxDecoration(
      color: const Color(0xFFE6F4FA),
      borderRadius: BorderRadius.circular(16),
    ),
    child: Column(
      crossAxisAlignment: CrossAxisAlignment.start,
      children: [
        // Display question text
        Text(
          soal,
          style: const TextStyle(fontSize: 18),
        ),

        // Display an image if available
        if (question['image'] != null && question['image'].toString().isNotEmpty)
          Padding(
            padding: const EdgeInsets.symmetric(vertical: 16.0),
            child: Image.network(
              question['image'],
              errorBuilder: (context, error, stackTrace) {
                return Container(
                  height: 150,
                  color: Colors.grey[200],
                  child: const Center(
                    child: Text('Gambar tidak tersedia'),
                  ),
                );
              },
            ),
          ),

        // Options for True/False answers (dynamic based on database)
        const SizedBox(height: 16),
        Row(
          children: [
            // Option for the first answer (display based on database values)
            Expanded(
              child: AspectRatio(
                aspectRatio: 2.55,  // Ensures both options have equal width-to-height ratio
                child: InkWell(
                  onTap: () => _handleAnswer(options[0]), // Handle dynamic 'option' answer
                  child: Container(
                    padding: const EdgeInsets.symmetric(vertical: 16),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(
                        color: _selectedAnswers[_currentQuestionIndex] == options[0]
                            ? Colors.blue
                            : Colors.grey.shade300,
                        width: _selectedAnswers[_currentQuestionIndex] == options[0] ? 2 : 1,
                      ),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.grey.withOpacity(0.1),
                          spreadRadius: 1,
                          blurRadius: 3,
                          offset: const Offset(0, 2),
                        ),
                      ],
                    ),
                    child: Center(
                      child: Text(
                        options[0],  // Display dynamic option text
                        style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.bold,
                          color: _selectedAnswers[_currentQuestionIndex] == options[0]
                              ? Colors.blue
                              : Colors.black,
                        ),
                      ),
                    ),
                  ),
                ),
              ),
            ),
            const SizedBox(width: 16),
            // Option for the second answer (display based on database values)
            Expanded(
              child: AspectRatio(
                aspectRatio: 2.55,  // Ensures both options have equal width-to-height ratio
                child: InkWell(
                  onTap: () => _handleAnswer(options[1]), // Handle dynamic 'option' answer
                  child: Container(
                    padding: const EdgeInsets.symmetric(vertical: 16),
                    decoration: BoxDecoration(
                      color: Colors.white,
                      borderRadius: BorderRadius.circular(12),
                      border: Border.all(
                        color: _selectedAnswers[_currentQuestionIndex] == options[1]
                            ? Colors.blue
                            : Colors.grey.shade300,
                        width: _selectedAnswers[_currentQuestionIndex] == options[1] ? 2 : 1,
                      ),
                      boxShadow: [
                        BoxShadow(
                          color: Colors.grey.withOpacity(0.1),
                          spreadRadius: 1,
                          blurRadius: 3,
                          offset: const Offset(0, 2),
                        ),
                      ],
                    ),
                    child: Center(
                      child: Text(
                        options[1],  // Display dynamic option text
                        style: TextStyle(
                          fontSize: 16,
                          fontWeight: FontWeight.bold,
                          color: _selectedAnswers[_currentQuestionIndex] == options[1]
                              ? Colors.blue
                              : Colors.black,
                        ),
                      ),
                    ),
                  ),
                ),
              ),
            ),
          ],
        ),
      ],
    ),
  );
}



  // Widget untuk soal esai
  Widget _buildEssayQuestion(Map<String, dynamic> question) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(24),
      decoration: BoxDecoration(
        color: const Color(0xFFE6F4FA),
        borderRadius: BorderRadius.circular(16),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Text(
            question['question'] ?? 'No question text',
            style: const TextStyle(fontSize: 18),
          ),
          if (question['image'] != null && question['image'].toString().isNotEmpty)
            Padding(
              padding: const EdgeInsets.symmetric(vertical: 16.0),
              child: Image.network(
                question['image'],
                errorBuilder: (context, error, stackTrace) {
                  return Container(
                    height: 150,
                    color: Colors.grey[200],
                    child: const Center(
                      child: Text('Gambar tidak tersedia'),
                    ),
                  );
                },
              ),
            ),
          const SizedBox(height: 16),
          TextField(
            onChanged: (value) {
              _handleAnswer(value);
            },
            controller: TextEditingController(
              text: _selectedAnswers[_currentQuestionIndex] ?? '',
            ),
            maxLines: 5,
            decoration: InputDecoration(
              hintText: 'Ketik jawaban Anda...',
              border: OutlineInputBorder(
                borderRadius: BorderRadius.circular(12),
              ),
              focusedBorder: OutlineInputBorder(
                borderRadius: BorderRadius.circular(12),
                borderSide: const BorderSide(color: Colors.blue, width: 2),
              ),
              filled: true,
              fillColor: Colors.white,
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildMenuOverlay() {
    return Dialog(
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(12),
      ),
      child: Container(
        padding: const EdgeInsets.all(16.0),
        constraints: BoxConstraints(
          maxWidth: MediaQuery.of(context).size.width * 0.9,
          maxHeight: MediaQuery.of(context).size.height * 0.8,
        ),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'Jumlah Soal (${questions.length})',
                  style: const TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
                ),
                IconButton(
                  icon: const Icon(Icons.close),
                  onPressed: () => setState(() => _isMenuOpen = false),
                ),
              ],
            ),
            const SizedBox(height: 8),
            Row(
              children: [
                _buildLegendItem(Colors.white, 'Belum dijawab'),
                const SizedBox(width: 16),
                _buildLegendItem(Colors.green, 'Sudah dijawab'),
                const SizedBox(width: 16),
                _buildLegendItem(Colors.yellow, 'Dilihat belum dijawab'),
              ],
            ),
            const SizedBox(height: 16),
            Expanded(
              child: SingleChildScrollView(
                physics: const BouncingScrollPhysics(),
                child: Wrap(
                  spacing: 8,
                  runSpacing: 8,
                  children: List.generate(
                    questions.length,
                    (index) {
                      final isAnswered = _selectedAnswers[index] != null;
                      final isCurrent = index == _currentQuestionIndex;
                      final isViewed = _viewedQuestions[index];

                      return GestureDetector(
                        onTap: () {
                          setState(() {
                            _currentQuestionIndex = index;
                            _viewedQuestions[index] = true;
                            _isMenuOpen = false;
                          });
                        },
                        child: Container(
                          width: 50,
                          height: 50,
                          decoration: BoxDecoration(
                            color: isCurrent 
                                ? Colors.blue[100]
                                : isAnswered 
                                    ? Colors.green
                                    : isViewed
                                        ? Colors.yellow[100]
                                        : Colors.white,
                            borderRadius: BorderRadius.circular(8),
                            border: Border.all(
                              color: isCurrent 
                                  ? Colors.blue
                                  : Colors.grey.shade300,
                              width: isCurrent ? 2 : 1,
                            ),
                            boxShadow: [
                              BoxShadow(
                                color: Colors.grey.withOpacity(0.2),
                                spreadRadius: 1,
                                blurRadius: 2,
                                offset: const Offset(0, 1),
                              ),
                            ],
                          ),
                          child: Center(
                            child: Text(
                              '${index + 1}',
                              style: TextStyle(
                                color: isCurrent 
                                    ? Colors.blue 
                                    : isAnswered 
                                        ? Colors.white 
                                        : Colors.black,
                                fontWeight: FontWeight.bold,
                                fontSize: 16,
                              ),
                            ),
                          ),
                        ),
                      );
                    },
                  ),
                ),
              ),
            ),
            const SizedBox(height: 16),
            ElevatedButton(
              onPressed: () {
                // Cek apakah semua soal sudah dijawab
                final allAnswered = !_selectedAnswers.contains(null);
                if (allAnswered) {
                  _submitAnswersAndShowResult();
                } else {
                  // Tampilkan dialog peringatan
                  showDialog(
                    context: context,
                    builder: (BuildContext context) {
                      return AlertDialog(
                        title: const Text('Perhatian'),
                        content: const Text('Masih ada soal yang belum dijawab. Apakah Anda yakin ingin menyelesaikan ujian?'),
                        actions: [
                          TextButton(
                            onPressed: () => Navigator.of(context).pop(),
                            child: const Text('Batal'),
                          ),
                          ElevatedButton(
                            onPressed: () {
                              Navigator.of(context).pop();
                              _submitAnswersAndShowResult();
                            },
                            child: const Text('Ya, Selesaikan'),
                          ),
                        ],
                      );
                    },
                  );
                }
              },
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.blue,
                minimumSize: const Size(double.infinity, 50),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(8),
                ),
              ),
              child: const Text(
                'Selesaikan Ujian',
                style: TextStyle(
                  color: Colors.white,
                  fontSize: 16,
                  fontWeight: FontWeight.bold,
                ),
              ),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildLegendItem(Color color, String label) {
    return Row(
      children: [
        Container(
          width: 16,
          height: 16,
          decoration: BoxDecoration(
            color: color,
            border: Border.all(color: Colors.grey.shade300),
            borderRadius: BorderRadius.circular(4),
          ),
        ),
        const SizedBox(width: 4),
        Text(label, style: const TextStyle(fontSize: 12)),
      ],
    );
  }

  Widget _buildCompletionScreen() {
    // If still saving answers, show loading indicator
    if (_isSaving) {
      return Scaffold(
        body: Center(
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: const [
              CircularProgressIndicator(),
              SizedBox(height: 16),
              Text('Menyimpan jawaban...'),
            ],
          ),
        ),
      );
    }

    // Hitung jumlah jawaban yang benar (untuk contoh saja)
    int answeredCount = _selectedAnswers.where((answer) => answer != null).length;
    
    return Scaffold(
      body: Center(
        child: Column(
          mainAxisAlignment: MainAxisAlignment.center,
          children: [
            Container(
              width: 100,
              height: 100,
              decoration: BoxDecoration(
                shape: BoxShape.circle,
                border: Border.all(color: Colors.green, width: 4),
              ),
              child: const Icon(Icons.check, color: Colors.green, size: 60),
            ),
            const SizedBox(height: 24),
            const Text(
              'Selamat Anda Telah',
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold)),
            const Text(
              'Menyelesaikan Ujian',
              style: TextStyle(fontSize: 24, fontWeight: FontWeight.bold)),
            const SizedBox(height: 24),
            Text(
              'Mata Pelajaran: ${widget.subject}',
              style: const TextStyle(fontSize: 16),
            ),
            const SizedBox(height: 8),
            Text(
              'Jumlah Soal: ${questions.length}',
              style: const TextStyle(fontSize: 16),
            ),
            Text(
              'Soal Dijawab: $answeredCount dari ${questions.length}',
              style: const TextStyle(fontSize: 16),
            ),
            const SizedBox(height: 48),
            ElevatedButton(
              onPressed: _navigateToHomeDetail,
              style: ElevatedButton.styleFrom(
                backgroundColor: Colors.blue,
                padding: const EdgeInsets.symmetric(horizontal: 32, vertical: 12),
                shape: RoundedRectangleBorder(
                  borderRadius: BorderRadius.circular(30)),
              ),
              child: const Text(
                'Kembali ke Beranda',
                style: TextStyle(
                  fontSize: 16,
                  color: Colors.white,
                  fontWeight: FontWeight.bold),
              ),
            ),
          ],
        ),
      ),
    );
  }
}