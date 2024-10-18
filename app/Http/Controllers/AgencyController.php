<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Agency;

class AgencyController extends Controller
{
    //
    public function indexAgency()
    {
        $agencies = Agency::all(); // ดึงข้อมูลทั้งหมดจากตาราง agencies
        return view('admin_agency.admin_agency', compact('agencies'));
    }

    public function store(Request $request)
    {
        // ตรวจสอบข้อมูลที่ส่งมาจากฟอร์ม
        $request->validate([
            'agencies_name' => 'required|string|max:255',
        ]);

        // สร้างหน่วยงานใหม่
        $agency = new Agency();
        $agency->name = $request->agencies_name; // เก็บชื่อหน่วยงาน
        $agency->save(); // บันทึกลงฐานข้อมูล

        // Redirect กลับไปที่หน้าเดิมพร้อมข้อความสำเร็จ
        return redirect()->back()->with('success', 'สร้างหน่วยงานใหม่เรียบร้อยแล้ว!');
    }
}
