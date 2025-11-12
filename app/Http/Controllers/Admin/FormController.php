<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Form;
use App\Models\FormSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class FormController extends Controller
{
	public function index()
	{
		return view('admin.forms.form_builder');
	}

	public function list()
	{
		$forms = Form::orderByDesc('created_at')->get();
		return view('admin.forms.index', compact('forms'));
	}

	public function store(Request $request)
	{
		$form = new Form();
		$form->title = $request->input('title', 'Untitled Form');
		$form->slug = $this->generateUniqueSlug($form->title);
		$form->json_data = $request->input('form_data');
		$form->is_active = true;
		$form->save();

		return response()->json([
			'success' => true,
			'id' => $form->id,
			'slug' => $form->slug,
			'public_url' => route('form.public.show', ['slug' => $form->slug]),
		]);
	}

	public function show($id)
	{
		$form = Form::findOrFail($id);
		return view('admin.forms.show', compact('form'));
	}

	private function generateUniqueSlug(string $title): string
	{
		$base = Str::slug($title) ?: 'form';
		$slug = $base;
		$counter = 1;
		while (Form::where('slug', $slug)->exists()) {
			$slug = $base . '-' . $counter++;
		}
		return $slug;
	}

	public function submit(Request $request, $id)
	{
		$form = Form::findOrFail($id);

		$payload = $request->except(['_token']);

		FormSubmission::create([
			'form_id' => $form->id,
			'submission_data' => $payload,
			'submitted_by' => Auth::user()->id ?? $request->ip(),
		]);

		if ($request->wantsJson()) {
			return response()->json(['success' => true]);
		}

		return back()->with('success', 'Response submitted successfully.');
	}

	public function submissions($id)
	{
		$form = Form::findOrFail($id);
		$submissions = FormSubmission::where('form_id', $form->id)->orderByDesc('created_at')->get();
		return view('admin.forms.submissions', compact('form', 'submissions'));
	}

	public function toggleStatus($id)
	{
		$form = Form::findOrFail($id);
		$form->is_active = !$form->is_active;
		$form->save();

		if (request()->wantsJson()) {
			return response()->json(['success' => true, 'is_active' => $form->is_active]);
		}

		return back()->with('success', 'Status updated.');
	}

	public function destroy($id)
	{
		$form = Form::findOrFail($id);
		$form->delete();

		if (request()->wantsJson()) {
			return response()->json(['success' => true]);
		}

		return redirect()->route('admin.forms.index')->with('success', 'Form deleted.');
	}

	public function edit($id)
	{
		$form = Form::findOrFail($id);
		return view('admin.forms.edit', compact('form'));
	}

	public function update(Request $request, $id)
	{
		$form = Form::findOrFail($id);
		$title = $request->input('title', $form->title);
		$json = $request->input('form_data', $form->json_data);

		$form->title = $title;
		$form->json_data = $json;
		$form->save();

		if ($request->wantsJson()) {
			return response()->json(['success' => true]);
		}

		return redirect()->route('admin.forms.index')->with('success', 'Form updated.');
	}
}


