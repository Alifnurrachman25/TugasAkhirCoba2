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
            'foods' => $menu->where('category','food')->orderBy('order')->get(),
            'drinks' => $menu->where('category','drink')->orderBy('order')->get(),
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
            'price' => 'required|regex:/([0-9]+[.,]*)+/',
            'category' => 'required',
            'image' => 'required|image|file|max:3048',
            'description' => 'required'
        ]);

        // Bersihkan format harga
        // $validateddata["modal"] = filter_var($request->modal, FILTER_SANITIZE_NUMBER_INT);
        $validateddata["price"] = filter_var($request->price, FILTER_SANITIZE_NUMBER_INT);

        // Proses crop gambar
        $image = $request->file('image');
        $filename = uniqid() . '.' . $image->getClientOriginalExtension();

        // Path tempat menyimpan hasil crop
        $resizePath = public_path('storage/menu/' . $filename);

        // Resize dan crop ke ukuran 300x300
        Image::make($image)
            ->fit(300, 300, function ($constraint) {
                $constraint->upsize();
            })
            ->save($resizePath);

        // Simpan juga file ke storage/public agar bisa diakses lewat Storage::url
        $storagePath = 'menu/' . $filename;
        copy($resizePath, storage_path('app/public/' . $storagePath));

        // Simpan path ke database
        $validateddata["picture"] = $storagePath;

        // Simpan data ke database
        Menu::create($validateddata);

        // Simpan activity log
        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'added a menu ' . strtolower($request->name)
        ]);

        return redirect('/menu')->with('success', 'New menu has been added!');
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->diff = $menu->created_at->diffForHumans();
        return response()->json($menu);
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
            'price' => 'required|regex:/([0-9]+[.,]*)+/',
            'category' => 'required',
            'image' => 'image|file|max:3048', // optional
            'description' => 'required'
        ]);

        // Bersihkan format harga
        $validateddata["price"] = filter_var($request->price, FILTER_SANITIZE_NUMBER_INT);

        // Proses jika ada gambar baru di-upload
        if ($request->hasFile('image')) {

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

            // Buat nama file unik
            $filename = uniqid() . '.' . $request->file('image')->getClientOriginalExtension();

            // Path tujuan hasil resize crop
            $resizePath = public_path('storage/menu/' . $filename);

            // Resize dan crop ke ukuran 300x300
            Image::make($request->file('image'))
                ->fit(300, 300, function ($constraint) {
                    $constraint->upsize();
                })
                ->save($resizePath);

            // Simpan juga ke storage agar bisa diakses via Storage::url()
            $storagePath = 'menu/' . $filename;
            copy($resizePath, storage_path('app/public/' . $storagePath));

            // Simpan path hasil ke database
            $validateddata["picture"] = $storagePath;
        }

        // Update data ke database
        $menu->update($validateddata);

        // Simpan activity log
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

    public function updateOrder(Request $request)
    {
        $order = $request->order;

        foreach ($order as $index => $menuId) {
            Menu::where('id', $menuId)->update(['order' => $index]);
        }

        return response()->json(['status' => 'success']);
    }


}
