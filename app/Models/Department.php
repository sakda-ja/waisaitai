<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Department extends Model
{
    use HasFactory;

//ถึงขยะ
    use SoftDeletes;

//อนุญาตให้บันทึกข้อมูลอะไรบ้าง
    protected $fillable = [
        'user_id',
        'department_name'
    ];


    //สร้างการเชื่อมโยง ระหว่าง Users and Departments
    //Model Department ---> 1:1 <---- กับ Model User
    //โดยเชื่อมตาราง users -> id(PK)  --->กับ<---  ตาราง Departments user_id(PK)
    public function user()
    {
        return $this->hasOne(User::class,'id','user_id');
    }


}
