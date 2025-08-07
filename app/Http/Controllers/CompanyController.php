<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;

class CompanyController extends Controller
{
    public function show()
    {
        $company = Company::first();
        return view('pages.company.show', compact('company'));
    }

    public function edit()
    {
        $company = Company::first();
        return view('pages.company.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'email' => 'required|string|max:255', // sesuaikan dengan field input
            'time_in' => 'required',
            'time_out' => 'required',
        ]);

        $company = Company::first();

        if ($company) {
            $company->update([
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
            ]);
        } else {
            Company::create([
                'name' => $request->name,
                'address' => $request->address,
                'email' => $request->email,
                'time_in' => $request->time_in,
                'time_out' => $request->time_out,
            ]);
        }

        return redirect()->route('company.show')->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}
