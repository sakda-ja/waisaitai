<x-app-layout>
    <x-slot name="header">
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Department
        <b class="float-end"> ยินดีต้อนรับคุณ : {{ Auth::user()->name }}: status  <span style="color: green;">Online</span></b>
      </h2>
    </x-slot>

    <div class="py-12">
      <div class="container">
        <div class="row">

            <div class="col-md-8">
                <div class="card">
                    @if(session("success"))
                        {{--                             <div class="alert alert-success my-3"> {{session ('success')}}</div>--}}
                        <div x-data="{isShow:true}" x-show="isShow"x-init="setTimeout( ()=>isShow = false, 1000 )" class="alert alert-success my-3"> {{ session('success') }} </div>
                    @endif
                    <div class="card-header">ตารางข้อมูลชื่อ/ตำแหน่ง/กลุ่มสาระ</div>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">กลุ่มสาระการเรียนรู้</th>
                            <th scope="col">ผู้บันทึกข้อมูล</th>
                            <th scope="col">ระยะเวลาเข้าสู่ระบบ</th>
                            <th scope="col">แก้ไข</th>
                            <th scope="col">ลบ</th>
                        </tr>
                        </thead>

                        @foreach($departments as $row)
                            <tbody>
                            <tr>
                                <th scope="row">{{$departments -> firstItem()+$loop->index }}</th>{{-- ฟังชั่นเรียงลำดับหน้า--}}
                                <td>{{ $row->department_name }}</td>
                               <td>{{ $row->user->name}}</td>
                                <td>
                                    @if($row->created_at == NULL)
                                        -
                                    @else
                                        {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                    @endif
                                </td>
                                <td> <a href="{{url ('/department/edit/'.$row->id)}}" class="btn btn-warning">แก้ไข</a></td>
{{--                                <td> <a href="{{url ('/department/delete/'.$row->id)}}" class="btn btn-danger">ลบ</a></td>--}}
                                <td> <a href="{{ route ('delete', $row->id) }}" class="btn btn-danger" onclick="return confirm('คุณต้องการลบบทความ {{$row->department_name}} หรือไม่?')">ลบ</a></td>

                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                    {{ $departments->links('pagination::bootstrap-5') }}
                </div>
            </div>


            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">บันทึกข้อมูล</div>
                    <div class="card-body">
                        <form action="{{ route ('addDepartment') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="department_name">เลือกกลุ่มสาระการเรียนรู้</label>
                                <input type="text" class="form-control" name="department_name">
                            </div>
                            @error('department_name')
                                <div class="my-2"><span class="text-danger my-3">{{$message}}</span></div>
                            @enderror
                            <br>
                            <input type="submit" class="btn btn-success" value="บันทึก">

                        </form>
                    </div>
                </div>
            </div>


        </div>
      </div>
    </div>
  </x-app-layout>
