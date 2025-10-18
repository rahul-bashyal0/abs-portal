<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class CertificateController extends Controller
{
    public function downloadCertificate(Submission $submission)
    {
        $submission->load('student.college');
        if (Auth::id() !== $submission->user_id) {
            abort(403);
        }

        $data = [
            'studentName' => $submission->student->name,
            'projectName' => $submission->title,
            'collegeName' => $submission->student->college->name ?? 'N/A',
            'date' => now()->format('F j, Y'),
            'logoPath' => public_path('logo.png'),
        ];

        $pdf = Pdf::loadView('pdf.certificate_test.blade.php', $data)->setPaper('a4', 'landscape');
        return $pdf->download('final-certificate.pdf');
    }
}