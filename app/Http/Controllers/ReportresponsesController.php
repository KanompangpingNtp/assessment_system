<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Agency;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use App\Models\FormSubmission;
use App\Models\Response;

class ReportresponsesController extends Controller
{
    //

    public function index()
    {
        $agencies = Agency::all();

        return view('admin_report.admin_report_responses', compact('agencies'));
    }

    // public function report(Request $request)
    // {
    //     $month = $request->input('month');
    //     $year = $request->input('year');
    //     $agencyId = $request->input('agency_id');

    //     // Query ข้อมูลคำถามทั้งหมด
    //     $questions = Question::query();

    //     // ถ้ามีการเลือกหน่วยงาน จะกรองคำถามตามหน่วยงานนั้น
    //     if ($agencyId) {
    //         $questions->withSum(['responses' => function ($query) use ($agencyId, $month, $year) {
    //             if ($month) {
    //                 $query->whereMonth('created_at', $month);
    //             }
    //             if ($year) {
    //                 $query->whereYear('created_at', $year);
    //             }
    //             $query->where('agency_id', $agencyId);
    //         }], 'score');
    //     } else {
    //         $questions->withSum('responses', 'score');
    //     }

    //     // ดึงข้อมูลคำถามทั้งหมดพร้อมคะแนนรวม
    //     $questions = $questions->get();

    //     // ดึงชื่อหน่วยงาน
    //     $agencyName = $agencyId ? Agency::find($agencyId)->name : 'ทั้งหมด';

    //     return view('admin_report.admin_report_responses_result', compact('questions', 'month', 'year', 'agencyId', 'agencyName'));
    // }

    public function report(Request $request)
{
    $month = $request->input('month');
    $year = $request->input('year');
    $agencyId = $request->input('agency_id');

    // Query ข้อมูลคำถามทั้งหมด
    $questions = Question::query();

    // ถ้ามีการเลือกหน่วยงาน จะกรองคำถามตามหน่วยงานนั้น
    if ($agencyId) {
        $questions->withSum(['responses' => function ($query) use ($agencyId, $month, $year) {
            if ($month) {
                $query->whereMonth('created_at', $month);
            }
            if ($year) {
                $query->whereYear('created_at', $year);
            }
            $query->where('agency_id', $agencyId);
        }], 'score');
    } else {
        $questions->withSum('responses', 'score');
    }

    // ดึงข้อมูลคำถามทั้งหมดพร้อมคะแนนรวม
    $questions = $questions->get();

    // ดึงชื่อหน่วยงาน
    $agencyName = $agencyId ? Agency::find($agencyId)->name : 'ทั้งหมด';

    // ดึงจำนวนครั้งที่ทำแบบประเมินตามเดือนและปี
    $submissionCount = FormSubmission::where('agency_id', $agencyId)
        ->when($month, function ($query) use ($month) {
            return $query->whereMonth('created_at', $month);
        })
        ->when($year, function ($query) use ($year) {
            return $query->whereYear('created_at', $year);
        })
        ->count();

    return view('admin_report.admin_report_responses_result', compact('questions', 'month', 'year', 'agencyId', 'agencyName', 'submissionCount'));
}



public function exportResponses(Request $request)
{
    // ดึงข้อมูลตามตัวเลือกที่ผู้ใช้เลือก
    $month = $request->input('month');
    $year = $request->input('year');
    $agencyId = $request->input('agency_id');

    // Query ข้อมูลคำถามโดยกรองตามเดือน ปี และหน่วยงานที่เลือก
    $query = Question::with(['responses' => function ($q) use ($agencyId, $month, $year) {
        if ($agencyId) {
            $q->where('agency_id', $agencyId); // กรองตามหน่วยงาน
        }
        if ($month && $year) {
            $q->whereYear('created_at', $year)
              ->whereMonth('created_at', $month); // กรองตามเดือนและปี
        }
    }]);

    // ดึงข้อมูลคำถาม
    $questions = $query->get();

    // คำนวณจำนวนครั้งที่ทำแบบประเมิน
    $submissionCount = FormSubmission::where('agency_id', $agencyId)
        ->when($month, function ($query) use ($month) {
            return $query->whereMonth('created_at', $month);
        })
        ->when($year, function ($query) use ($year) {
            return $query->whereYear('created_at', $year);
        })
        ->count();

    // สร้าง Writer สำหรับ Excel
    $writer = WriterEntityFactory::createXLSXWriter();
    $writer->openToBrowser('responses_summary.xlsx');

    // เขียนข้อมูล header
    $headerRow = WriterEntityFactory::createRowFromArray(['จำนวนครั้งที่ทำแบบประเมิน: ' . $submissionCount . ' คน']);
    $writer->addRow($headerRow);

    // เพิ่มแถวสำหรับจำนวนครั้งที่ทำแบบประเมิน
    $headerRow3 = $headerRow = WriterEntityFactory::createRowFromArray(['หัวข้อการประเมิน', 'คะแนนรวม', 'เวลาที่อัพเดทล่าสุด']);
    $writer->addRow($headerRow3);

    // เขียนข้อมูลของแต่ละคำถาม
    foreach ($questions as $question) {
        // คำนวณคะแนนรวมของคำถามเฉพาะหน่วยงานที่เลือก
        $totalScore = $question->responses->where('agency_id', $agencyId)->sum('score');
        $updatedAt = $question->responses->where('agency_id', $agencyId)->max('updated_at') ?
        $question->responses->where('agency_id', $agencyId)->max('updated_at')->format('d/m/Y H:i:s') : 'N/A';

        // เขียนข้อมูลเฉพาะถ้ามีคะแนนจากหน่วยงานที่เลือก
        if ($totalScore > 0) {
            $row = WriterEntityFactory::createRowFromArray([
                $question->question_text,
                $totalScore, // คะแนนรวม
                $updatedAt // เวลาที่อัพเดทล่าสุด
            ]);
            $writer->addRow($row);
        }
    }

    $writer->close();
}




}
