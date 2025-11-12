<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Center;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\IOFactory;

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

        return view('admin.student.index', compact('students', 'centers', 'selectedCenter', 'selectedDownloadStatus'));
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
            // ✅ Validate only existing table columns
            $this->validate($request, [
                'application_id'          => 'nullable|string|max:255',
                'candidate_first_name'    => 'required|string|max:255',
                'candidate_last_name'     => 'required|string|max:255',
                'candidate_mobile_number' => 'required|string|max:20',
                'dob'                     => 'nullable|string|max:205',
                'email'                   => 'nullable|email|max:255',
                'gender'                  => 'nullable|string|max:255',
                'category'                => 'nullable|string|max:255',
                'skill_name'              => 'nullable|string|max:255',
                'team_individual'         => 'nullable|string|max:255',
                'current_state'           => 'nullable|string|max:255',
                'current_district'        => 'nullable|string|max:255',
                'center_detail'           => 'required|exists:centers,id',
            ]);

            // ✅ Prepare student data safely
            $studentData = $request->only([
                'application_id',
                'candidate_first_name',
                'candidate_last_name',
                'candidate_mobile_number',
                'dob',
                'email',
                'gender',
                'category',
                'skill_name',
                'team_individual',
                'current_state',
                'current_district',
                'center_detail'
            ]);

            $studentData['is_download'] = 0; // Default value

            // ✅ Save record
            Student::create($studentData);

            toastr()->success('Student Added Successfully');
            return redirect()->route('admin.student.index');
        } catch (\Exception $e) {
            toastr()->error('Error: ' . $e->getMessage());
            return redirect()->back()->withInput();
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
                'application_id' => 'nullable|string|max:255',
                'candidate_first_name' => 'required|string|max:255',
                'candidate_last_name' => 'required|string|max:255',
                'candidate_mobile_number' => 'required|string|max:255',
                'dob' => 'nullable|string|max:205',
                'email' => 'required|email|max:255',
                'gender' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'skill_name' => 'required|string|max:255',
                'team_individual' => 'required|string|max:255',
                'current_state' => 'required|string|max:255',
                'current_district' => 'required|string|max:255',
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
            'application_id',
            'candidate_first_name',
            'candidate_last_name',
            'candidate_mobile_number',
            'dob',
            'email',
            'gender',
            'category',
            'skill_name',
            'team_individual',
            'current_state',
            'current_district'
        ];

        $callback = function () use ($columns) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF)); // UTF-8 BOM
            fputcsv($file, $columns);
            fputcsv($file, array_fill(0, count($columns), '')); // Example empty row
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
            'application_id',
            'candidate_first_name',
            'candidate_last_name',
            'candidate_mobile_number',
            'dob',
            'email',
            'gender',
            'category',
            'skill_name',
            'team_individual',
            'current_state',
            'current_district',
            'center_detail'
        ];

        $callback = function () use ($columns, $students) {
            $file = fopen('php://output', 'w');
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($file, $columns);

            foreach ($students as $student) {
                $centerName = $student->center->name ?? 'N/A';
                fputcsv($file, [
                    $student->application_id,
                    $student->candidate_first_name,
                    $student->candidate_last_name,
                    $student->candidate_mobile_number,
                    $student->dob,
                    $student->email,
                    $student->gender,
                    $student->category,
                    $student->skill_name,
                    $student->team_individual,
                    $student->current_state,
                    $student->current_district,
                    $centerName
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
            'csv_file' => 'required|mimes:csv,txt,xlsx,xls|max:10240',
        ]);

        if ($validator->fails()) {
            toastr()->error('Please select a center and upload a valid CSV or Excel file.');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $centerId = $request->center_id;
        $file = $request->file('csv_file');
        $extension = strtolower($file->getClientOriginalExtension());
        $csvData = [];

        /** 1️⃣ Handle Excel file (.xlsx / .xls) **/
        if (in_array($extension, ['xlsx', 'xls'])) {
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $csvData = $sheet->toArray(null, true, true, true);
            $csvData = array_map('array_values', $csvData);
        } else {
            /** 2️⃣ Handle CSV file **/
            $filePath = $file->getRealPath();
            $content = file_get_contents($filePath);
            $encoding = mb_detect_encoding($content, ['UTF-8', 'ISO-8859-1', 'Windows-1252'], true);
            if ($encoding && $encoding !== 'UTF-8') {
                $content = mb_convert_encoding($content, 'UTF-8', $encoding);
                $tempFile = tempnam(sys_get_temp_dir(), 'csv_import_');
                file_put_contents($tempFile, $content);
                $filePath = $tempFile;
            }

            $handle = fopen($filePath, 'r');
            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                $csvData[] = $row;
            }
            fclose($handle);

            if (isset($tempFile) && file_exists($tempFile)) unlink($tempFile);
        }

        // ✅ Basic sanity check
        if (count($csvData) < 2) {
            toastr()->error('The file appears to be empty or invalid.');
            return redirect()->back();
        }

        /** 3️⃣ Get headers from first row exactly as in demo template **/
        $headers = array_map('trim', $csvData[0]);

        /** 4️⃣ Define expected headers from demo template **/
        $expectedHeaders = [
            'application_id',
            'candidate_first_name',
            'candidate_last_name',
            'candidate_mobile_number',
            'dob',
            'email',
            'gender',
            'category',
            'skill_name',
            'team_individual',
            'current_state',
            'current_district'
        ];

        /** 5️⃣ Compare uploaded headers with expected headers **/
        $normalizedHeaders = array_map(function ($h) {
            $h = strtolower(trim($h));
            $h = preg_replace('/[^a-z0-9_]+/', '_', $h);
            return $h;
        }, $headers);

        if ($normalizedHeaders !== $expectedHeaders) {
            toastr()->error('Invalid CSV structure. Please use the exported demo template format.');
            return redirect()->back();
        }

        /** 6️⃣ Process data rows **/
        $imported = 0;
        $duplicates = 0;
        $skipped = 0;

        DB::beginTransaction();

        try {
            for ($i = 1; $i < count($csvData); $i++) {
                $row = $csvData[$i];
                if (empty(array_filter($row))) continue;

                // Map each value to its respective column from expectedHeaders
                $data = array_combine($expectedHeaders, array_slice($row, 0, count($expectedHeaders)));
                $data['center_detail'] = $centerId;
                $data['is_download'] = 0;

                // Skip empty names
                if (empty($data['candidate_first_name']) || empty($data['candidate_last_name'])) {
                    $skipped++;
                    continue;
                }

                // Check for duplicates (by app_id, email, or mobile)
                $exists = Student::where(function ($q) use ($data, $centerId) {
                    if (!empty($data['application_id'])) {
                        $q->where('application_id', $data['application_id']);
                    }
                    if (!empty($data['email'])) {
                        $q->orWhere('email', $data['email']);
                    }
                    if (!empty($data['candidate_mobile_number'])) {
                        $q->orWhere('candidate_mobile_number', $data['candidate_mobile_number']);
                    }
                })->where('center_detail', $centerId)->first();

                if ($exists) {
                    $duplicates++;
                    continue;
                }

                Student::create($data);
                $imported++;
            }

            DB::commit();

            $msg = "{$imported} imported, {$duplicates} duplicate(s), {$skipped} skipped.";
            toastr()->success("Import completed successfully: $msg");
            return redirect()->route('admin.student.index');

        } catch (\Exception $e) {
            DB::rollBack();
            toastr()->error("Error importing: " . $e->getMessage());
            return redirect()->back();
        }

    } catch (\Exception $e) {
        toastr()->error("Error processing file: " . $e->getMessage());
        return redirect()->back();
    }
}

    
}
