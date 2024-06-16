
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
                @if(session("success"))
                    {{--                             <div class="alert alert-success my-3"> {{session ('success')}}</div>--}}
                    <div x-data="{isShow:true}" x-show="isShow"x-init="setTimeout( ()=>isShow = false, 1200 )" class="alert alert-success my-3"> {{ session('success') }} </div>
                @endif
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">ระบุข้อมูลที่ต้องการแก้ไขและกดบันทึก</div>
                        <div class="card-body">

                        <form action="{{url ('department/update/'.$finddepartment->id )}}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="department_name"></label>
                                <input type="text" class="form-control" name="department_name" value="{{$finddepartment->department_name}}">

                            </div>

                            <br>
                            <input type="submit" value="อัปเดต" class="btn btn-primary">


                        </form>

                    </div>

                    </div>
                </div>


            </div>
        </div>
    </div>
</x-app-layout>
