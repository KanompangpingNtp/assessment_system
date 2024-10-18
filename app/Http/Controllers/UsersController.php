<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Agency;

class UsersController extends Controller
{
    //
    public function usersIndex()
    {
        // ดึงข้อมูลคำถามทั้งหมดจากฐานข้อมูล
        $questions = Question::where('is_active', true)->get(); // ดึงเฉพาะคำถามที่เปิดใช้งาน
        // ดึงข้อมูลหน่วยงานทั้งหมด
        $agencies = Agency::all(); // หรือสามารถเพิ่มเงื่อนไขตามต้องการ

        // ส่งข้อมูลคำถามและหน่วยงานไปยัง view
        return view('users_form.users_form', compact('questions', 'agencies'));
    }

}
