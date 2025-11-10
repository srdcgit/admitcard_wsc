<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Student::with('center');
        
        // Filter by center if selected
        if ($request->has('center_id') && $request->center_id != '') {
            $query->where('center_detail', $request->center_id);
        }
        
        // Filter by download status if selected
        if ($request->has('download_status') && $request->download_status != '') {
            $query->where('is_download', $request->download_status);
        }
        
        $students = $query->get();
        $centers = Center::all();
        $selectedCenter = $request->center_id ?? '';
        $selectedDownloadStatus = $request->download_status ?? '';
        
        return view('admin.student.index',compact('students', 'centers', 'selectedCenter', 'selectedDownloadStatus'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $centers = Center::all();
        return view('admin.student.create', compact('centers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'center_detail' => 'required|exists:centers,id',
            ]);
            
            $studentData = $request->all();
            $studentData['is_download'] = 0; // Set default download status
            
            Student::create($studentData);
            toastr()->success('Student Added Successfully');
            return redirect()->route('admin.student.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function show(Student $student)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function edit(Student $student)
    {
        $centers = Center::all();
        return view('admin.student.edit', compact('student', 'centers'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Student $student)
    {
        try {
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'center_detail' => 'required|exists:centers,id',
            ]);
            
            $student->update($request->all());
            toastr()->success('Student Updated Successfully');
            return redirect()->route('admin.student.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        try {
            $student->delete();
            toastr()->success('Student Deleted Successfully');
            return redirect()->route('admin.student.index');
        } catch (\Exception $e) {
            toastr()->error($e->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Show the import form
     *
     * @return \Illuminate\Http\Response
     */
    public function importForm()
    {
        $centers = Center::all();
        return view('admin.student.import', compact('centers'));
    }

    /**
     * Export demo CSV template (empty template with headers only)
     *
     * @return \Illuminate\Http\Response
     */
    public function exportTemplate()
    {
        $filename = "student_import_template_" . date('Y-m-d') . ".csv";
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'name',
            'application_id',
            'father_name',
            'mother_name',
            'dob_pass',
            'dob',
            'gender',
            'phone',
            'email',
            'app_number',
            'physically_challanged_category',
            'roll_number'
        ];

        $callback = function() use ($columns) {
            $file = fopen('php://output', 'w');
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            // Add headers
            fputcsv($file, $columns);
            // Add one empty row as example
            fputcsv($file, array_fill(0, count($columns), ''));
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export students to CSV
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function exportDemo(Request $request)
    {
        $centerId = $request->get('center_id');
        
        // Query students based on center filter
        $query = Student::with('center');
        if ($centerId) {
            $query->where('center_detail', $centerId);
            $center = Center::find($centerId);
            $centerName = $center ? str_replace(' ', '_', $center->name) : 'Center_' . $centerId;
            $filename = "students_" . $centerName . "_" . date('Y-m-d') . ".csv";
        } else {
            $filename = "all_students_" . date('Y-m-d') . ".csv";
        }
        
        $students = $query->get();
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $columns = [
            'name',
            'application_id',
            'father_name',
            'mother_name',
            'dob_pass',
            'dob',
            'gender',
            'phone',
            'email',
            'app_number',
            'physically_challanged_category',
            'roll_number',
            'center_detail'
        ];

        $callback = function() use ($columns, $students) {
            $file = fopen('php://output', 'w');
            // Add BOM for UTF-8
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            // Add headers
            fputcsv($file, $columns);
            
            // Add student data
            foreach ($students as $student) {
                // Combine center name and address with comma
                $centerDetail = '';
                if ($student->center) {
                    $centerParts = array_filter([$student->center->name, $student->center->address]);
                    $centerDetail = implode(', ', $centerParts);
                }
                
                fputcsv($file, [
                    $student->name ?? '',
                    $student->application_id ?? '',
                    $student->father_name ?? '',
                    $student->mother_name ?? '',
                    $student->dob_pass ?? '',
                    $student->dob ?? '',
                    $student->gender ?? '',
                    $student->phone ?? '',
                    $student->email ?? '',
                    $student->app_number ?? '',
                    $student->physically_challanged_category ?? '',
                    $student->roll_number ?? '',
                    $centerDetail
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Import students from CSV
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'center_id' => 'required|exists:centers,id',
                'csv_file' => 'required|mimes:csv,txt|max:10240', // 10MB max
            ]);

            if ($validator->fails()) {
                toastr()->error('Please select a center and upload a valid CSV file.');
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $centerId = $request->center_id;
            $file = $request->file('csv_file');
            
            // Read CSV file with proper encoding handling
            $filePath = $file->getRealPath();
            
            // Detect encoding and convert to UTF-8 if needed
            $content = file_get_contents($filePath);
            $encoding = mb_detect_encoding($content, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
            if ($encoding && $encoding !== 'UTF-8') {
                $content = mb_convert_encoding($content, 'UTF-8', $encoding);
                // Create temporary file with UTF-8 encoding
                $tempFile = tempnam(sys_get_temp_dir(), 'csv_import_');
                file_put_contents($tempFile, $content);
                $filePath = $tempFile;
            }
            
            // Read CSV data
            $handle = fopen($filePath, 'r');
            $csvData = [];
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $csvData[] = $row;
            }
            fclose($handle);
            
            // Clean up temp file if created
            if (isset($tempFile) && file_exists($tempFile)) {
                unlink($tempFile);
            }
            
            if (count($csvData) < 2) {
                toastr()->error('CSV file is empty or invalid.');
                return redirect()->back();
            }

            // Get headers (first row)
            $headers = array_map('trim', $csvData[0]);
            
            // Remove BOM if present
            $headers[0] = preg_replace('/\x{EF}\x{BB}\x{BF}/u', '', $headers[0]);
            
            // Expected columns mapping
            $columnMap = [
                'name' => ['name', 'Name', 'NAME'],
                'application_id' => ['application_id', 'application id', 'Application ID', 'APPLICATION_ID'],
                'father_name' => ['father_name', 'father name', 'Father Name', 'FATHER_NAME'],
                'mother_name' => ['mother_name', 'mother name', 'Mother Name', 'MOTHER_NAME'],
                'dob_pass' => ['dob_pass', 'dob pass', 'DOB Pass', 'DOB_PASS'],
                'dob' => ['dob', 'DOB', 'date of birth', 'Date of Birth'],
                'gender' => ['gender', 'Gender', 'GENDER'],
                'phone' => ['phone', 'Phone', 'PHONE', 'contact', 'Contact'],
                'email' => ['email', 'Email', 'EMAIL'],
                'app_number' => ['app_number', 'app number', 'App Number', 'APP_NUMBER'],
                'physically_challanged_category' => ['physically_challanged_category', 'physically challanged category', 'Physically Challanged Category', 'PHYSICALLY_CHALLANGED_CATEGORY'],
                'roll_number' => ['roll_number', 'roll number', 'Roll Number', 'ROLL_NUMBER'],
            ];

            // Map headers to column indices
            $columnIndices = [];
            foreach ($columnMap as $dbColumn => $possibleHeaders) {
                foreach ($possibleHeaders as $header) {
                    $index = array_search($header, $headers);
                    if ($index !== false) {
                        $columnIndices[$dbColumn] = $index;
                        break;
                    }
                }
            }

            // Check if name column exists (required)
            if (!isset($columnIndices['name'])) {
                toastr()->error('CSV file must contain a "name" column.');
                return redirect()->back();
            }

            // Process data rows (skip header row)
            $imported = 0;
            $skipped = 0;
            $duplicates = 0;
            $errors = [];

            DB::beginTransaction();
            
            try {
                for ($i = 1; $i < count($csvData); $i++) {
                    $row = $csvData[$i];
                    
                    // Skip empty rows
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    $studentData = [
                        'center_detail' => $centerId,
                        'is_download' => 0,
                    ];

                    // Map CSV columns to database fields
                    foreach ($columnIndices as $dbColumn => $csvIndex) {
                        if (isset($row[$csvIndex]) && trim($row[$csvIndex]) !== '') {
                            $studentData[$dbColumn] = trim($row[$csvIndex]);
                        }
                    }

                    // Skip if name is empty
                    if (empty($studentData['name'])) {
                        $skipped++;
                        continue;
                    }

                    // Check for duplicates
                    $existingStudent = null;
                    
                    // First, check by application_id if available
                    if (!empty($studentData['application_id'])) {
                        $existingStudent = Student::where('application_id', $studentData['application_id'])
                            ->where('center_detail', $centerId)
                            ->first();
                    }
                    
                    // If not found, check by email if available
                    if (!$existingStudent && !empty($studentData['email'])) {
                        $existingStudent = Student::where('email', $studentData['email'])
                            ->where('center_detail', $centerId)
                            ->first();
                    }
                    
                    // If still not found, check by roll_number if available
                    if (!$existingStudent && !empty($studentData['roll_number'])) {
                        $existingStudent = Student::where('roll_number', $studentData['roll_number'])
                            ->where('center_detail', $centerId)
                            ->first();
                    }
                    
                    // If still not found, check by name + dob + center (last resort)
                    if (!$existingStudent && !empty($studentData['dob'])) {
                        $existingStudent = Student::where('name', $studentData['name'])
                            ->where('dob', $studentData['dob'])
                            ->where('center_detail', $centerId)
                            ->first();
                    }
                    
                    // If duplicate found, skip this record
                    if ($existingStudent) {
                        $duplicates++;
                        continue;
                    }

                    // Create student if not duplicate
                    Student::create($studentData);
                    $imported++;
                }

                DB::commit();
                
                $message = "Successfully imported {$imported} student(s).";
                if ($duplicates > 0) {
                    $message .= " {$duplicates} duplicate(s) skipped.";
                }
                if ($skipped > 0) {
                    $message .= " {$skipped} row(s) skipped (empty or invalid).";
                }
                
                toastr()->success($message);
                return redirect()->route('admin.student.index');

            } catch (\Exception $e) {
                DB::rollBack();
                toastr()->error('Error importing students: ' . $e->getMessage());
                return redirect()->back();
            }

        } catch (\Exception $e) {
            toastr()->error('Error processing file: ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
