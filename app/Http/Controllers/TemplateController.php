<?php

namespace App\Http\Controllers;

use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{

    public function index()
    {
        $this->authorize('is_admin');

        $template = Template::all();
        $template->load('categories');
        return response($template);
    }

    public function show(Request $request, Template $template)
    {
        $this->authorize('is_admin');

        $template->load('categories');
        return response($template);
    }


    public function store(Request $request)
    {
        $this->authorize('is_admin');

        $request->validate([
            'name' => ['required','string', 'max:100'],
            'description'=> ['required', 'string', 'max:255'],
            'image' => ['image', 'max:5']
        ]);

        $payload = $request->only(['name', 'description']);
        $payload['slug'] = str()->slug($payload['name']);
        $image = $request->file('image');

        if($image){
            $payload['image'] = $image->store('/uploads/templates/');
        }

        $template = Template::create($payload);

        return response($template, 201);
    }


    public function update(Request $request, Template $template)
    {
        $this->authorize('is_admin');

        $request->validate([
            'name' => ['string', 'max:100'],
            'description'=> ['string', 'max:255'],
            'image' => ['image', 'max:5']
        ]);

        $payload = $request->only(['name', 'description']);
        $image = $request->file('image');
        if($image){
            Storage::delete($template->image_url);

            $payload['image_url'] = $image->store('/uploads/templates/');
        }

        $template->update($payload);
        $template->fresh();

        return response($template);
    }

    public function destroy(Template $template)
    {
        $this->authorize('is_admin');

        $template->delete();

        return response()->noContent();
    }
}
