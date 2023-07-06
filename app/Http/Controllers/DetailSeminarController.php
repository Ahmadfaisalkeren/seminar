<?php

namespace App\Http\Controllers;

use App\Models\Seminar;
use Illuminate\Http\Request;

class DetailSeminarController extends Controller
{
    public function detail($id)
    {
        $seminar = Seminar::findOrFail($id);

        return view('admin.seminar.detailSeminar', compact('seminar'));
    }
}
