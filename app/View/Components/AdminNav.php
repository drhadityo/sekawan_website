<?php

namespace App\View\Components;

use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class AdminNav extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $navLinks = [
            'admin.dashboard' => ['Dashboard', 'fas fa-tachometer-alt'],
            'admin.patients' => ['Data Pasien TBC', 'fas fa-database'],
            'admin.screening' => ['Data Screening', 'fas fa-stethoscope'],
            'admin.fasyankes' => ['Fasyankes', 'fas fa-notes-medical'],
        ];

        // Navigasi khusus untuk role: adminps
        if (Auth::user()->role === 'adminps') {
            return view('components.admin-nav', compact('navLinks'));
        }

        // Navigasi khusus untuk role: admin
        $navLinks += [
            'admin.sekawans' => ['Tentang', 'fas fa-users'],
            'admin.infotbc' => ['Informasi TBC', 'fas fa-circle-info'],
            'admin.messages' => ['Pesan', 'fas fa-envelope'],
            'admin.articles' => ['Artikel', 'fas fa-newspaper'],
            'admin.kegiatan' => ['Kegiatan', 'fas fa-square-person-confined'],
            'admin.documents' => ['Dokumen', 'fas fa-file-alt'],
        ];

        return view('components.admin-nav', compact('navLinks'));
    }
}
