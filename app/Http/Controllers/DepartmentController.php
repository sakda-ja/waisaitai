<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department; //ORM ผ่าน Model
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; //query builder

class DepartmentController extends Controller
{
    public function index()
        {
            //ดึงข้อมูลมาแสดงใน view
          $departments = Department::paginate(5); //ORM
            //$departments = DB::table('departments')->paginate(5);
            return view('admin.department.index',compact('departments'));
        }



    public function store(Request $request )
        {
            //ตรวจสอบข้อมูลไม่ให้เป็นค่าว่าง และห้ามซ้ำกัน
            $request->validate
            (
                [
                    'department_name'=>'required|unique:departments|max:50'
                ],
                [
                    'department_name.required'=>"กรุณาป้อนข้อมูลให้ครบถ้วน",
                    'department_name.max'=>"ห้ามป้อนเกิน 50 ตัวอักษร",
                    'department_name.unique'=>"มีข้อมูลนี้ในฐานข้อมูลแล้ว"
                ]
            );


            //บันทึกแบบ ORM ผ่าน Model
    //        $department = new Department;
    //        $department->department_name =  $request->department_name;
    //        $department->user_id = Auth::user()->id;
    //        $department->save();

                //บันทึกข้อมูลแบบ query builder ไม่ผ่าน Model
                $data = array();
                $data["department_name"] = $request->department_name;
                $data["user_id"] = Auth::user()->id;

                //query builder
                DB::table('departments')->insert($data);
                return redirect()->back()->with('success' , "บันทึกข้อมูลเรียบร้อย");
        }


//ดึงข้อมูลมาแก้ไข
    public function edit($id)
        {
            $finddepartment =  Department::find($id); //ค้นหา ID
            return view('admin.department.edit' , compact('finddepartment')); //นำข้อมูลออกมาแสดง
        }


 //บันทึกเมื่อแก้ไข
    public function update(Request $request,$id)
        {
            //ตรวจสอบข้อมูลไม่ให้เป็นค่าว่าง และห้ามซ้ำกัน
            $request->validate
            (
                [
                    'department_name'=>'required|unique:departments|max:50'
                ],
                [
                    'department_name.required'=>"กรุณาป้อนข้อมูลให้ครบถ้วน",
                    'department_name.max'=>"ห้ามป้อนเกิน 50 ตัวอักษร",
                    'department_name.unique'=>"มีข้อมูลนี้ในฐานข้อมูลแล้ว"
                ]
            );

            //ผ่าน Model
          $update = Department::find($id)->update([
              'department_name' => $request->department_name,     //ค้นหา ID
              'user_id' =>Auth::user()->id  //เก็บ Log คนแก้ไขด้วย
          ]);
            return redirect()->route('department')->with('success' , "อัปเดทข้อมูลสำเร็จ");

        }


//ลบข้อมูลถาวร
    public function delete($id)
    {
        DB::table('departments')->where('id',  $id)->delete();
        return redirect()->back()->with('success' , "ลบข้อมูลสำเร็จ!");
    }






    
}


