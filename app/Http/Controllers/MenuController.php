<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Menu $menu)
    {
        $user = Auth::user();

        if ($user->level_id === 2 || $user->level_id === 3) {
            return redirect()->back();
        }

        return view('menu.index', [
            'foods' => $menu->where('category','food')->latest()->get(),
            'drinks' => $menu->where('category', 'drink')->latest()->get(),
            'dessert' => $menu->where('category', 'dessert')->latest()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();

        if ($user->level_id === 2 || $user->level_id === 3) {
            return redirect()->back();
        }

        return view('menu.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $validateddata = $request->validate([
        'name' => 'required|min:3',
        // 'modal' => 'required|regex:/([0-9]+[.,]*)+/',
        'price' => 'required|regex:/([0-9]+[.,]*)+/|gte:modal',
        'category' => 'required',
        'image' => 'required|image|file|max:3048',
        'description' => 'required'
    ]);

    // $validateddata["modal"] = filter_var($request->modal, FILTER_SANITIZE_NUMBER_INT);
    $validateddata["price"] = filter_var($request->price, FILTER_SANITIZE_NUMBER_INT);

    // Proses image resize
    $image = $request->file('image');
    $filename = uniqid() . '.' . $image->getClientOriginalExtension();
    $resizePath = public_path('storage/menu/' . $filename);

    // Resize to 600x400 (ubah sesuai kebutuhan)
    Image::make($image)->resize(300, 300, function ($constraint) {
        $constraint->aspectRatio(); // menjaga rasio
        $constraint->upsize();      // mencegah membesarkan gambar kecil
    })->save($resizePath);

    // Store the image in the 'menu' directory
    $validateddata["picture"] = $request->file('image')->store('/menu');
    // Copy the image to the 'public/menu' directory
    $imagePath = storage_path('app/' . $validateddata["picture"]);
    $publicPath = storage_path('app/public/menu/' . basename($validateddata["picture"]));
    copy($imagePath, $publicPath);

    Menu::create($validateddata);

    $activity = [
        'user_id' => Auth::id(),
        'action' => 'added a menu ' . strtolower($request->name)
    ];

    ActivityLog::create($activity);

    return redirect('/menu')->with('success', 'New menu has been added!');
}


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Menu $menu)
    {
        $id = $request->id;
        $menu = $menu->find($id);
        $menu->diff = $menu->created_at->diffForHumans();;
        return $menu;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        $user = Auth::user();

        if ($user->level_id === 2 || $user->level_id === 3) {
            return redirect()->back();
        }

        return view('menu.edit', [
            'menu' => $menu
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Menu $menu)
    {
      $validateddata = $request->validate([
        'name' => 'required|min:3',
        // 'modal' => 'required|regex:/([0-9]+[.,]*)+/',
        'price' => 'required|regex:/([0-9]+[.,]*)+/|gte:modal',
        'category' => 'required',
        'image' => 'image|file|max:3048', // opsional
        'description' => 'required'
    ]);

    // $validateddata["modal"] = filter_var($request->modal, FILTER_SANITIZE_NUMBER_INT);
    $validateddata["price"] = filter_var($request->price, FILTER_SANITIZE_NUMBER_INT);

    if ($request->hasFile('picture')) {
        // Hapus gambar lama jika ada
        if ($menu->picture) {
            $oldPublicPath = 'public/' . $menu->picture;
            $oldPrivatePath = $menu->picture;

            if (Storage::exists($oldPublicPath)) {
                Storage::delete($oldPublicPath);
            }

            if (Storage::exists($oldPrivatePath)) {
                Storage::delete($oldPrivatePath);
            }
        }

        // Simpan gambar baru di storage/app/menu
        $validateddata["picture"] = $request->file('picture')->store('/menu');

        // Resize dan simpan versi tampil ke public_path
        $filename = basename($validateddata["picture"]);
        $resizePath = public_path('storage/menu/' . $filename);

        Image::make($request->file('picture'))->resize(600, 400, function ($constraint) {
            $constraint->aspectRatio();
            $constraint->upsize();
        })->save($resizePath);

        // Copy file ke storage/app/public/menu
        $imagePath = storage_path('app/' . $validateddata["picture"]);
        $publicCopyPath = storage_path('app/public/menu/' . $filename);
        copy($imagePath, $publicCopyPath);
    }

    $menu->update($validateddata);

    ActivityLog::create([
        'user_id' => Auth::id(),
        'action' => 'updated a menu ' . strtolower($request->name)
    ]);

    return redirect('/menu')->with('success', 'Menu has been updated!');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy(Menu $menu)
    {
        $menu->delete(); // Soft delete

        $activity = [
            'user_id' => Auth::id(),
            'action' => 'deleted a menu '.strtolower($menu->name)
        ];
        ActivityLog::create($activity);

        return redirect('/menu');
    }

}
