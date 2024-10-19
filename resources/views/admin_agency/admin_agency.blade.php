@extends('layout.admin_layout')
@section('admin_layout')

@if ($message = Session::get('success'))
<script>
    Swal.fire({
        icon: 'success'
        , title: '{{ $message }}'
    , })

</script>
@endif

<div class="container">
    <h2 class="text-center">ข้อมูลหน่วยงาน</h2>

    <br>

    <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
        เพิ่มข้อมูล
    </button>
    <br>

    <!-- ตารางแสดงผลข้อมูลหน่วยงาน -->
    <table class="table  table-bordered table-striped">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>ชื่อหน่วยงาน</th>
                <th>เวลาที่เพิ่ม</th>
                {{-- <th>เวลาที่อัพเดทล่าสุด</th> --}}
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            @if($agencies->isEmpty())
                <tr>
                    <td colspan="5" class="text-center">ไม่พบข้อมูลหน่วยงาน</td>
                </tr>
            @else
                @foreach($agencies as $index => $agency)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $agency->name }}</td>
                        <td class="text-center">{{ $agency->created_at->format('d/m/Y') }}</td>
                        {{-- <td class="text-center">{{ $agency->updated_at->format('d/m/Y H:i:s') }}</td> --}}
                        <td class="text-center">
                            {{-- <a href="{{ route('agencies.edit', $agency->id) }}" class="btn btn-warning btn-sm">แก้ไข</a>
                            <form action="{{ route('agencies.destroy', $agency->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจที่จะลบหน่วยงานนี้?');">ลบ</button>
                            </form> --}}
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>

  <!-- Modal สร้างผู้ใช้ -->
  <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{route('agencies.store')}}" method="post">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">เพิ่มชื่อหน่วยงาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="agencies_name" class="form-label">ชื่อหน่วยงาน :</label>
                        <input type="text" class="form-control" id="agencies_name" name="agencies_name" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-primary">สร้าง</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
