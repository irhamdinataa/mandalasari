<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use Illuminate\Support\Str;
use App\Models\Announcement;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Cviebrock\EloquentSluggable\Services\SlugService;

class AdminAnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.pengumuman.index', [
            'announcements' => Announcement::orderBy('id', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pengumuman.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'judul'             => 'required|max:255',
            'slug'              => 'required|unique:announcements',
            'isi_pengumuman'    => 'required',
        ], [
            'judul.required'            => 'Wajib menambahkan judul !',
            'slug.required'             => 'Wajib menambahkan slug !',
            'slug.unique'               => 'Slug sudah digunakan',
            'isi_pengumuman.required'   => 'Wajib menambahkan isi berita !',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        Announcement::create([
            'judul'             => $request->judul,
            'slug'              => $request->slug,
            'isi_pengumuman'    => $request->isi_pengumuman,
            'excerpt'           => Str::limit(strip_tags($request->isi_pengumuman), 200),
            'user_id'           => auth()->user()->id
        ]);

        return redirect('/admin/pengumuman')->with('success', 'Berhasil menambahkan data baru');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $announcement = Announcement::find($id);
        return view('admin.pengumuman.edit', [
            'announcement' => $announcement
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $announcement = Announcement::find($id);
        $validator = Validator::make($request->all(), [
            'judul'             => 'required|max:255',
            'slug'              => 'required',
            'isi_pengumuman'    => 'required',
        ], [
            'judul.required'            => 'Wajib menambahkan judul !',
            'slug.required'             => 'Wajib menambahkan slug !',
            'isi_pengumuman.required'   => 'Wajib menambahkan isi pengumuman !',
        ]);

        $announcement->slug = ($request->slug != $announcement->slug) ? 'required|unique:announcements' : $announcement->slug;

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $announcement->update([
            'judul'             => $request->judul,
            'slug'              => $request->slug,
            'isi_pengumuman'    => $request->isi_pengumuman,
            'excerpt'           => Str::limit(strip_tags($request->isi_pengumuman), 200),
            'user_id'           => auth()->user()->id
        ]);

        return redirect('/admin/pengumuman')->with('success', 'Berhasil memperbarui data');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $announcement = Announcement::find($id);
        $announcement->delete();

        return redirect()->back()->with('success', 'Berhasil menghapus data');
    }

    /**
     * Generate slug / permalink by Judul.
     */
    public function slug(Request $request)
    {
        $slug = SlugService::createSlug(Berita::class, 'slug', $request->judul);
        return response()->json(['slug' => $slug]);
    }

    /**
     * Create method upload image body.
     */
    public function imageBody(Request $request)
    {
        if ($request->hasFile('upload') && $request->file('upload')->isValid()) {
            $path = 'img-pengumuman/';
            $file = $request->file('upload');
            $extension = $file->getClientOriginalExtension();
            $fileName = uniqid() . '.' . $extension;
            $gambar = $file->storeAs($path, $fileName, 'public');

            $url = Storage::url($gambar);
            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        } else {
            return response()->json(['error' => 'Gagal mengunggah gambar.']);
        }
    }

    /**
     * Create method Delete image body.
     */
    public function deleteImage(Request $request)
    {
        $fileName = $request->input('fileName');

        try {
            Storage::disk('public')->delete('img-pengumuman/' . $fileName);

            return response()->json(['deleted' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Gagal menghapus gambar.']);
        }
    }
}