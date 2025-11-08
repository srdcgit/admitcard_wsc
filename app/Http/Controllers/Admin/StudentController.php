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
    public function index()
    {
        $students = Student::with('center')->get();
        return view('admin.student.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Student  $student
     * @return \Illuminate\Http\Response
     */
    public function destroy(Student $student)
    {
        //
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
     * Export demo CSV template
     *
     * @return \Illuminate\Http\Response
     */
    public function exportDemo()
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
            'folder_number',
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
                'folder_number' => ['folder_number', 'folder number', 'Folder Number', 'FOLDER_NUMBER'],
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

                    // Create student
                    Student::create($studentData);
                    $imported++;
                }

                DB::commit();
                toastr()->success("Successfully imported {$imported} student(s). " . ($skipped > 0 ? "{$skipped} row(s) skipped." : ""));
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
