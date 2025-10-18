<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Certificate of Participation</title>
    <style>
        @page { margin: 0; }
        body { font-family: 'Helvetica', 'Arial', sans-serif; margin: 0; padding: 0; }
        .container { width: 1050px; height: 740px; margin: 20px auto; border: 25px solid #4f46e5; padding: 40px; position: relative; background-color: #f9fafb; }
        .text-center { text-align: center; }
        .logo { width: 180px; }
        .main-heading { font-size: 52px; color: #3730a3; margin-top: 30px; margin-bottom: 25px; font-weight: bold; letter-spacing: 2px; }
        .sub-text { font-size: 20px; color: #4b5563; margin: 15px 0; }
        .student-name { font-size: 40px; color: #1e293b; font-weight: bold; margin: 20px 0; border-bottom: 2px solid #e5e7eb; padding-bottom: 10px; }
        .project-name { font-size: 28px; color: #1e293b; font-weight: bold; margin-top: 10px; margin-bottom: 10px; }
        .footer { position: absolute; bottom: 60px; left: 40px; right: 40px; width: 100%; }
        .footer-table { width: 100%; border-collapse: collapse; }
        .footer-cell { width: 50%; text-align: center; font-size: 16px; color: #4b5563; }
        .signature-line { border-bottom: 1px solid #4b5563; width: 250px; margin: 40px auto 5px auto; }
    </style>
</head>
<body>
    <div class="container">
        <div class="text-center">
            <img src="{{ $logoPath }}" class="logo" alt="ABS Soft Logo">
        </div>
        <h1 class="text-center main-heading">CERTIFICATE OF PARTICIPATION</h1>
        <p class="text-center sub-text">This certificate is proudly presented to</p>
        <h2 class="text-center student-name">{{ $studentName }}</h2>
        <p class="text-center sub-text">from {{ $collegeName }} for their successful shortlisting in the<br/>ABS Soft Project Partnership Program for the project titled:</p>
        <h3 class="text-center project-name">"{{ $projectName }}"</h3>
        <div class="footer">
            <table class="footer-table">
                <tr>
                    <td class="footer-cell">
                        <div class="signature-line"></div>
                        <strong>Date Issued</strong><br>{{ $date }}
                    </td>
                    <td class="footer-cell">
                        <div class="signature-line"></div>
                        <strong>Authorized Signature</strong><br>ABS Soft Pvt. Ltd
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>