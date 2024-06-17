<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use Carbon\Carbon;


class ServiceController extends Controller
{
    //

public function index()

    {
        $services = Service::paginate(5); //ดึงข้อมูลมาแสดง แบบ Eloquen

        return view('admin.service.index' ,compact('services') );
    }





    //Upload image--------------------------------------------------------------------------------
    public function store( Request $request)
    {


        //-----------ตรวจสอบ ดักแจ้งเตือนฟอร์ม------
        $request->validate
        (
            [
                'service_name'=>'required|unique:services|max:255',
                'service_image'=>'required|mimes:jpg,jpeg,png,pdf,PDF' //ระบบนามสกุลที่สามารถอัปโหลดได้


            ],

            [
                'service_name.required' => "กรุณากรอกชื่อบริการด้วยครับ" ,
                'service_name.max' => "ห้ามป้อนข้อความเกิน 255 ตัวอักษร",
                'service_name.unique' => "มีข้อมูลนี้แล้วในฐานข้อมูล",
                'service_image.required' => "กรุณาใส่ภาพประกอบด้วยครับ",
                'service_image.mimes' => 'กรุณาอัปโหลดไฟล์รูปภาพประเภท .jpg,.jpeg,.png,.pdf,.PDF เท่านั้น'

            ]
        );

        //-----------------------เข้ารหัส----------------------
        // $service_image = $request->file('service_image'); //เข้ารหัส
        // $name_gen = hexdec(uniqid()); //เปลี่ยนชื่อรูปภาพสุ่มแปลงเป็นตัวเลขที่ไม่ซ้ำ
        // $img_ext = strtolower($service_image->getClientOriginalExtension()); //หั่นเอาเฉพาะนามสกุลมาเก็บ**เป็นตัวพิมพ์เล็ก
        // $img_name = $name_gen .   '.'    .$img_ext; //รวมชื่อภาพที่สุ่มได้เป็นตัวเลข+นามสกุลไฟล์เช่น 10101010.jpg

        // //--------------------อัปโหลดลงฐานข้อมูล---------------
        // $upload_location = 'image/services/'; //ที่เก็บ
        // $full_path = $upload_location.$img_name; //เริ่มเก็บประมวลผลที่เซิร์ฟเวอร์

        // //สั่งบันทึกเก็บลงในคอลัม
        // Service::insert([
        //     'service_name' => $request->service_name,
        //     'service_image' =>$full_path,
        //     'created_at' =>Carbon::now() // ต้อง import Class ด้วย
        // ]);
        // $service_image->move($upload_location , $img_name); //อัปโหลดย้ายไฟล์เก็บ









//-----------------------เข้ารหัสแบบกำหนดตัวแปรใหม่เอง-------------------------------------
        //เข้ารหัส
        $service_image = $request->file('service_image');

        //เปลี่ยนชื่อรูปภาพสุ่มแปลงเป็นตัวเลขที่ไม่ซ้ำ
        $name_picture_change = hexdec(uniqid());

        //ดึงนามสกุลไฟล์ภาพ หั่นเอาเฉพาะนามสกุลมาเก็บ**เป็นตัวพิมพ์เล็ก
        $lastname_cut_save = strtolower($service_image->getClientOriginalExtension());

        //รวมชื่อภาพที่สุ่มได้เป็นตัวเลข+นามสกุลไฟล์เช่น 10101010.jpg
        $namepic_and_lastname = $name_picture_change .   '.'    .$lastname_cut_save;


    //--------------------อัปโหลดลงฐานข้อมูล--------------------------------------------
        //ที่เก็บ
        $upload_location = 'image/services/';

        //เริ่มเก็บประมวลผลที่เซิร์ฟเวอร์
        $full_path = $upload_location.$namepic_and_lastname;

        //บันทึก
        Service::insert([
            'service_name'  =>  $request->service_name,
            'service_image' =>  $full_path,
            'created_at' =>Carbon::now() // ต้อง import Class ด้วย
        ]);

        //สั่งอัปโหลดย้ายไฟล์เก็บ
        $service_image->move($upload_location , $namepic_and_lastname);



        return redirect()->back()->with('success' , "บันทึกข้อมูลเรียบร้อย");
    }











//Delete ลบถาวร แต่ต้องมีไฟล์--------------------------------------------------------------------------------
public function delete($id)
        {
            // ลบภาพในโฟลเดอร์
            $img = Service::find($id)->service_image; //ไปค้นจาก Models/Service.php เพื่อหา PATH ไปลบใน Folder
            @unlink($img); //สั่งลบ

            //ลบข้อมูลชื่อภาพจากฐานข้อมูล
            $delete=Service::find($id)->delete();
            return redirect()->back()->with('success',"ลบข้อมูลเรียบร้อย");
        }


}
