<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionsController extends Controller
{
    //
    public function questionsIndex()
    {
        // ดึงข้อมูลคำถามทั้งหมดจากฐานข้อมูล
        $questions = Question::all();

        // ส่งข้อมูลคำถามไปยัง view
        return view('admin_questions.admin_questions', compact('questions'));
    }

    public function createQuestion(Request $request)
    {
        // ตรวจสอบข้อมูลที่รับมาจากฟอร์ม
        $validatedData = $request->validate([
            'question_text' => 'required|string|max:255',
        ]);

        // สร้างคำถามใหม่
        Question::create([
            'question_text' => $validatedData['question_text'],
            'is_active' => true, // ค่าเริ่มต้นคือ active
        ]);

        // กลับไปยังหน้าเดิมพร้อมกับแสดงข้อความสำเร็จ
        return redirect()->back()->with('success', 'เพิ่มคำถามสำเร็จแล้ว!');
    }

    public function updateQuestion(Request $request, $id)
    {
        // ตรวจสอบข้อมูลที่รับมาจากฟอร์ม
        $validatedData = $request->validate([
            'question_text' => 'required|string|max:255',
        ]);

        // ดึงคำถามที่ต้องการแก้ไขจากฐานข้อมูล
        $question = Question::findOrFail($id);

        // อัปเดตข้อมูลคำถาม
        $question->update([
            'question_text' => $validatedData['question_text'],
        ]);

        // กลับไปยังหน้าเดิมพร้อมกับแสดงข้อความสำเร็จ
        return redirect()->back()->with('success', 'แก้ไขคำถามสำเร็จแล้ว!');
    }

}
