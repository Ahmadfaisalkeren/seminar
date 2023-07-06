<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\User;
use Hashids\Hashids;
use App\Models\Seminar;
use App\Models\Pendaftaran;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class HomeController extends Controller
{
    public function index()
    {
        $users = User::all();
        $seminar = Seminar::all();

        if (Auth::check()) {
            $userRole = Auth::user()->role;
            if ($userRole == 1) {
                return view('client.template.master', compact('users', 'seminar'));
            } elseif ($userRole == 2) {
                return view('admin.dashboard.index', compact('seminar', 'users'));
            }
        }

        return view('client.template.master', compact('seminar', 'users'));
    }

    public function profile()
    {
        $user = User::get();

        return view('client.profile', compact('user'));
    }

    public function card()
    {
        $seminar = Seminar::all();

        return view('client.master', compact('seminar'));
    }

    public function storeSeminar(Request $request)
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
                'quota' => $request->get('quota'),
            ]);
        }

        $pendaftaran = new Pendaftaran([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'phone' => $request->get('phone'),
            'id_user' => auth()->user()->id,
            'id_seminar' => $seminar->id,
        ]);

        if ($pendaftaran->save()) {
            $seminar->decrement('quota');
            alert()->success('Success', 'Pendaftaran Seminar Sukses');
            return redirect()->route('myseminar.index');
        } else {
            alert()->error('Error', 'Gagal Melakukan Pendaftaran Seminar.');
            return redirect()->back();
        }
    }

    public function checkRegistration($id)
    {
        $user = auth()->user();
        $seminar = Seminar::find($id);

        if ($user && $seminar) {
            $registration = Pendaftaran::where('id_user', $user->id)
                ->where('id_seminar', $seminar->id)
                ->first();

            if ($registration) {
                return response()->json(['registered' => true]);
            } else {
                return response()->json(['registered' => false]);
            }
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    public function editProfile(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'password' => ['nullable', 'string', 'min:8'],
            'address' => ['nullable', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
        ]);

        $user = User::findOrFail($id);
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        if ($validatedData['password']) {
            $user->password = Hash::make($validatedData['password']);
        }
        $user->address = $validatedData['address'];
        $user->phone = $validatedData['phone'];

        if ($user->save()) {
            alert()->success('Success', 'Profile has been updated successfully!');
            return redirect()->back();
        } else {
            alert()->error('Error', 'Failed to update profile data.');
            return redirect()->back();
        }
    }

    public function mySeminar()
    {
        $userId = auth()->id();

        $currentSeminars = Pendaftaran::where('id_user', $userId)
            ->with('seminars', 'yuser', 'statuses')
            ->whereHas('seminars', function ($query) {
                $query->where('seminar_date', '>=', Carbon::today());
            })
            ->get();

        $pastSeminars = Pendaftaran::where('id_user', $userId)
            ->with('seminars', 'yuser', 'statuses')
            ->whereHas('seminars', function ($query) {
                $query->where('seminar_date', '<', Carbon::today());
            })
            ->get();

        return view('client.pendaftaran.index', compact('currentSeminars', 'pastSeminars'));
    }

    public function imagePayment(Request $request, $id)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpg,png,jpeg,svg|max:3000',
            'id_status' => 'require',
        ]);

        $pendaftaran = Pendaftaran::find($id);
        // $pendaftaran->id_status = $request->get('id_status');

        if ($request->hasFile('image')) {
            if (File::exists($pendaftaran->image)) {
                File::delete($pendaftaran->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();

            $image->move(public_path('images/pendaftaran'), $imageName);
            $imagePath = 'images/pendaftaran/' . $imageName;

            $pendaftaran->image = $imagePath;
        }

        $pendaftaran->id_status = 2;

        if ($pendaftaran->save()) {
            alert()->success('Success', 'Image Uploaded Successfully, Wait for the admin to check');
            return redirect()->back();
        } else {
            alert()->error('Error', 'Failed to Upload Image.');
            return redirect()->back();
        }
    }

    public function certificate(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::with('seminars', 'yuser')
            ->where('id', $id)
            ->where('id_status', 3)
            ->get();

        if ($pendaftaran->isEmpty()) {
            abort(404);
        }

        $hashids = new Hashids('your-salt-string', 8);
        $hashed_id = $hashids->encode($id);
        $pdf_name = 'certificate-' . $hashed_id . '.pdf';

        $pdf = PDF::loadView('client.pendaftaran.certificate', compact('pendaftaran'));
        $pdf->setPaper('letter', 'landscape');

        return $pdf->download($pdf_name);
    }

    public function invoice(Request $request, $id)
    {
        $pendaftaran = Pendaftaran::with('seminars')
            ->where('id', $id)
            ->where('id_status', 3)
            ->get();

        if ($pendaftaran->isEmpty()) {
            abort(404);
        }

        // Generate a unique random string for the invoice URL
        $hashids = new Hashids('your_salt', 8);
        $invoice_id = $hashids->encode($id);

        $pdf = PDF::loadView('client.pendaftaran.invoice', compact('pendaftaran'));
        $pdf->setPaper('a4', 'potrait');

        // Set the Content-Disposition header to force the browser to download the PDF
        $headers = [
            'Content-Disposition' => 'attachment; filename="' . $invoice_id . '.pdf"',
        ];

        // Return the PDF as a download with the unique random string as the filename
        return response($pdf->output(), 200, $headers);
    }

    public function buttonDate(Request $request)
    {
        $seminar = Seminar::findOrFail($request->id);
        $seminar_date = Carbon::parse($seminar->date);
        $button_date = $seminar_date->addDay();

        $current_date = Carbon::now();

        $show_button = $current_date->gte($button_date);

        return view('client.pendaftaran.index', [
            'show_button' => $show_button,
            'item' => $seminar,
        ]);
    }
}
