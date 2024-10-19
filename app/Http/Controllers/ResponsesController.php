<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Response;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use App\Models\Question;
use App\Models\FormSubmission;

class ResponsesController extends Controller
{
    //
    // ฟังก์ชันแสดงผลข้อมูล Responses
    public function responsesIndex()
    {
        // ดึงข้อมูล Responses ทั้งหมดจากฐานข้อมูล พร้อมกับข้อมูลคำถามและหน่วยงาน โดยแบ่งหน้าแสดงครั้งละ 20 แถว
        $responses = Response::with(['question', 'agency'])->paginate(20); // เปลี่ยนจาก get() เป็น paginate(20)

        return view('admin_responses.admin_responses', compact('responses'));
    }


    public function store(Request $request)
    {
        // dd($request->all());

        // ตรวจสอบว่า responses มีค่า
        $responses = $request->input('responses');

        // วนลูปเพื่อบันทึกคะแนนแต่ละคำถาม
        foreach ($responses as $questionId => $rating) {
            Response::create([
                'question_id' => $questionId,
                'score' => $rating,
                'user_name' => $request->input('name') ?? null,
                'user_phone' => $request->input('phone') ?? null,
                'agency_id' => $request->input('agency_id'),
            ]);
        }

        // นับจำนวนครั้งการทำแบบประเมินของแต่ละหน่วยงาน
        FormSubmission::create([
            'agency_id' => $request->input('agency_id'),
            'submission_count' => 1, // เพิ่มบันทึกการทำแบบประเมิน
            'submitted_at' => now(),
        ]);

        // ส่งกลับหน้าหลักพร้อมข้อความสำเร็จ
        return redirect()->back()->with('success', 'บันทึกผลการประเมินเรียบร้อยแล้ว!');
    }
}
