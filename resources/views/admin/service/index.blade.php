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
                    <div class="card-header">ผลงาน</div>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">ลำดับ</th>
                            <th scope="col">ไฟล์ผลงาน</th>
                            <th scope="col">ชื่อผลงาน</th>
                            <th scope="col">ระยะเวลาในการนำเข้าสู่ระบบ</th>
                            <th scope="col">แก้ไข</th>
                            <th scope="col">ลบ</th>
                        </tr>
                        </thead>

                        @foreach($services as $row)
                            <tbody>
                            <tr>
                                <th scope="row">{{$services -> firstItem()+$loop->index }}</th>{{-- ฟังชั่นเรียงลำดับหน้า--}}
                                <td>
                                    <a href="{{ asset($row->service_image) }}" target="_blank"  >
                                        <img src="{{asset($row->service_image)}}" alt="" width="70px" height="50px" target="_blank">

                                    </a>
                                </td>

                               <td>{{ $row->service_name}}</td>
                                <td>
                                    @if($row->created_at == NULL)
                                        -
                                    @else
                                        {{Carbon\Carbon::parse($row->created_at)->diffForHumans()}}
                                    @endif
                                </td>
                                <td> <a href=" {{url ('service/edit/'.$row->id) }}" class="btn btn-warning"> แก้ไข </a></td>
                                <td> <a href="{{url('/service/delete/'.$row->id)}}" class="btn btn-danger" onclick="return confirm('คุณต้องการลบข้อมูลนี้หรือไม่ ?')">ลบ</a>   </td>

                            </tr>
                            </tbody>
                        @endforeach
                    </table>
                    {{ $services->links('pagination::bootstrap-5') }}
                </div>
            </div>


            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">บันทึกข้อมูล</div>
                    <div class="card-body">
                        <form action="{{route('addService')}}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="service_name">ชื่อผลงาน</label>
                                <input type="text" class="form-control" name="service_name">
                            </div>
                            @error('service_name')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                            @enderror
                            <div class="form-group">
                                <label for="service_image">ภาพประกอบ</label>
                                <input type="file" class="form-control" name="service_image">
                            </div>
                            @error('service_image')
                                <div class="my-2">
                                    <span class="text-danger">{{$message}}</span>
                                </div>
                            @enderror
                            <br>
                            <input type="submit" value="บันทึก" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>


        </div>
      </div>
    </div>
  </x-app-layout>
