<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $userId = auth()->id();
        // $pendaftaran = Seminar::where('seminar_date', '>=', now()->toDateString())
        //     ->with('pendaftarans')
        //     ->get();

        // $pendaftaran2 = Seminar::where('seminar_date', '<', now()->toDateString())
        //     ->with('pendaftarans')
        //     ->get();

        // return view('client.pendaftaran.index', compact('pendaftaran', 'pendaftaran2'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user_id = auth()->id(); // get the current authenticated user's ID
        $pendaftaran = Pendaftaran::where('id_user', $user_id)
            ->with('seminars')
            ->get();

        return view('frontend.card', compact('pendaftaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|email',
            'phone' => 'required|string|max:255',
            'seminar_name' => 'required|string|max:255',
            'seminar_date' => 'required|date',
            'price' => 'required|numeric',
        ]);

        $seminar = Seminar::where('seminar_name', $request->get('seminar_name'))
            ->where('seminar_date', $request->get('seminar_date'))
            ->where('price', $request->get('price'))
            ->first();

        if (!$seminar) {
            $seminar = Seminar::create([
                'seminar_name' => $request->get('seminar_name'),
                'seminar_date' => $request->get('seminar_date'),
                'price' => $request->get('price'),
            ]);
        }

        $pendaftaran = new Pendaftaran([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'id_seminar' => $seminar->id,
        ]);
        $pendaftaran->save();

        return redirect()
            ->back()
            ->with('status', 'Data Stored Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        //
    }
}
