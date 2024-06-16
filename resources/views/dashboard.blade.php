<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
      ยินดีต้อนรับ คุณ : {{ Auth::user()->name }}
      <b class="float-end"><span style="color: green;">Online</span> : {{count($users)  }} คน</b>
    </h2>
  </x-slot>

  <div class="py-12">
    <div class="container">
      <div class="row">
        <table class="table table-bordered-">
          <thead>
            <tr>
              <th scope="col">ลำดับ</th>
              <th scope="col">ชื่อ</th>
              <th scope="col">อีเมลล์</th>
              <th scope="col">ระยะเวลาเข้าสู่ระบบ</th>
            </tr>
          </thead>
@php($i=1)
@foreach($users as $row)
        <tbody>
            <tr>
              <th scope="row">{{ $row->id }}</th>
              <td>{{ $row->name }}</td>
              <td>{{ $row->email }}</td>
              {{-- <td>{{ $row->created_at->diffForHumans() }}</td> --}} <!--E-ORM -->
              <td>{{ Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</td> <!--Query Builder  -->
            </tr>
          </tbody>
@endforeach
        </table>
      </div>
    </div>
  </div>
</x-app-layout>
