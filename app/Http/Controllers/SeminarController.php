<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Seminar;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class SeminarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Seminar::latest()->get();

            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $deleteBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Delete" class="btn btn-danger btn-sm mt-1 deleteSeminar">Delete</a>';

                    // Check if any users have registered for the seminar
                    $registeredUsersCount = $row->users()->count();
                    if ($registeredUsersCount > 0) {
                        // Hide the delete button
                        $deleteBtn = '<button class="btn btn-sm mt-1 btn-secondary disabled">Delete</button>';
                    }

                    $editBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Edit" class="edit btn btn-primary btn-sm mt-1 editSeminar">Edit</a>';
                    $pesertaBtn = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="' . $row->id . '" data-original-title="Detail" class="btn btn-info btn-sm text-white mt-1 daftarPeserta">Detail Peserta</a>';

                    return $editBtn . ' ' . $pesertaBtn . ' ' . $deleteBtn;
                })

                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.seminar.index');
    }

    // public function detailSeminar($id)
    // {
    //     $seminar = Seminar::findOrFail($id)
    //     ->orderBy('created_at', 'ASC')
    //     ->get();

    //     dd($seminar);
    //     return view('admin.seminar.detailSeminar', compact('seminar'));
    // }

    public function getUserData($seminar_id)
    {
        $pendaftaran = Pendaftaran::where('id_seminar', $seminar_id)
            ->with('yuser')
            ->orderBy('created_at', 'ASC')
            ->get();

        return DataTables::of($pendaftaran)
            ->addColumn('DT_RowIndex', function ($pendaftaran) {
                return '';
            })
            ->addColumn('name', function ($pendaftaran) {
                return $pendaftaran->yuser->name;
            })
            ->addColumn('email', function ($pendaftaran) {
                return $pendaftaran->yuser->email;
            })
            ->addColumn('imageButton', function ($pendaftaran) {
                $button = '';
                if ($pendaftaran->id_status == 2) {
                    $button = '<button type="button" class="btn btn-sm btn-info" data-toggle="modal" data-target="#imageModal-' . $pendaftaran->id . '">View Image</button>';
                } elseif ($pendaftaran->id_status == 1) {
                    $button = '<button type="button" class="btn btn-sm btn-secondary" disabled>Waiting For Payment</button>';
                } else {
                    $button = '<button type="button" class="btn btn-sm btn-success" disabled>Payment Success</button>';
                }

                $button .= '<div class="modal fade" id="imageModal-' . $pendaftaran->id . '" tabindex="-1" role="dialog" aria-labelledby="imageModalLabel-' . $pendaftaran->id . '" aria-hidden="true">';
                $button .= '<div class="modal-dialog modal-lg" role="document">';
                $button .= '<div class="modal-content">';
                $button .= '<div class="modal-header">';
                $button .= '<h5 class="modal-title" id="imageModalLabel-' . $pendaftaran->id . '">Image</h5>';
                $button .= '<button type="button" class="close" data-dismiss="modal" aria-label="Close">';
                $button .= '<span aria-hidden="true">&times;</span>';
                $button .= '</button>';
                $button .= '</div>';
                $button .= '<div class="modal-body">';
                $button .= '<img src="' . asset($pendaftaran->image) . '" class="img-fluid">';
                $button .= '</div>';
                $button .= '<div class="modal-footer">';
                $button .= '<button type="button" class="btn btn-success acceptBtn" data-id="' . $pendaftaran->id . '">Accept</button>';
                $button .= '<button type="button" class="btn btn-danger rejectBtn" data-id="' . $pendaftaran->id . '">Reject</button>';
                $button .= '</div>';
                $button .= '</div>';
                $button .= '</div>';
                $button .= '</div>';

                return $button;
            })
            ->rawColumns(['DT_RowIndex', 'name', 'email', 'imageButton'])
            ->make(true);
    }

    public function approve($id)
    {
        $pendaftaran = Pendaftaran::find($id);
        $pendaftaran->id_status = 3;
        $pendaftaran->save();

        return response()->json(['success' => true, 'message' => 'Pendaftaran berhasil diterima.']);
    }

    public function reject($id)
    {
        $pendaftaran = Pendaftaran::find($id);
        $pendaftaran->id_status = 1;
        $pendaftaran->save();

        return response()->json(['success' => true, 'message' => 'Pendaftaran ditolak.']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'seminar_name' => 'required|string|max:255',
            'organizer' => 'required|string|max:255',
            'contact' => 'required|string|max:255',
            'place' => 'required|string|max:255',
            'speaker' => 'required|string|max:255',
            'seminar_date' => 'required',
            'price' => 'required',
            'quota' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,svg|max:3000',

        ]);

        $image = $request->file('image');
        $imageName = time() . '.' . $image->getClientOriginalExtension();

        $image->move(public_path('images/seminar'), $imageName);
        $imagePath = '/images/seminar/' . $imageName;

        Seminar::create([
            'id' => $request->seminar_id,
            'seminar_name' => $request->seminar_name,
            'organizer' => $request->organizer,
            'contact' => $request->contact,
            'place' => $request->place,
            'speaker' => $request->speaker,
            'seminar_date' => $request->seminar_date,
            'price' => $request->price,
            'quota' => $request->quota,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json(['success' => 'Record saved successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $seminar = Seminar::find($id);
        return response()->json($seminar);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Seminar $seminar)
    {
        try {
            $request->validate([
                'seminar_name' => 'nullable|string|max:255',
                'organizer' => 'nullable|string|max:255',
                'contact' => 'nullable|string|max:255',
                'place' => 'nullable|string|max:255',
                'speaker' => 'nullable|string|max:255',
                'seminar_date' => 'nullable',
                'price' => 'nullable',
                'quota' => 'nullable|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:3000',
            ]);

            $seminar->seminar_name = $request->input('seminar_name');
            $seminar->organizer = $request->input('organizer');
            $seminar->contact = $request->input('contact');
            $seminar->place = $request->input('place');
            $seminar->speaker = $request->input('speaker');
            $seminar->seminar_date = $request->input('seminar_date');
            $seminar->price = $request->input('price');
            $seminar->description = $request->input('description');
            $seminar->quota = $request->input('quota');

            $seminar->save();

            if ($request->hasFile('image')) {
                if (File::exists(public_path($seminar->image))) {
                    File::delete(public_path($seminar->image));
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->getClientOriginalExtension();

                $image->move(public_path('images/seminar'), $imageName);
                $imagePath = 'images/seminar/' . $imageName;

                $seminar->image = $imagePath;
                $seminar->save();
            }

            return response()->json(['success' => 'Record updated successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error updating record: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $seminar = Seminar::findOrFail($id);
        $imagePath = public_path($seminar->image);

        if (File::exists($imagePath)) {
            File::delete($imagePath);
        }

        $seminar->delete();

        return response()->json(['success' => 'Record deleted successfully.']);
    }
}
