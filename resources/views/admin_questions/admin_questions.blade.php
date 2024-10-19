@extends('layout.admin_layout')
@section('admin_layout')

<div class="container">
    <h2 class="text-center">จัดการคำถามแบบประเมิน</h2><br>

    @if ($message = Session::get('success'))
    <script>
        Swal.fire({
            icon: 'success'
            , title: '{{ $message }}'
        , })

    </script>
    @endif


    <button type="button" class="btn btn-primary mb-3 btn-sm" data-bs-toggle="modal" data-bs-target="#createUserModal">
        เพิ่มข้อมูล
    </button>
    <br>

    <!-- ตรวจสอบว่ามีคำถามหรือไม่ -->
    @if($questions->isEmpty())
        <p class="text-center">ยังไม่มีคำถามในขณะนี้</p>
    @else
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>คำถาม</th>
                    <th>สถานะ</th>
                    <th>วันที่สร้าง</th>
                    <th>จัดการ</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $index => $question)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $question->question_text }}</td>
                        <td>
                            @if($question->is_active)
                                <span class="badge bg-success">Active</span>
                            @else
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>{{ $question->created_at->format('d/m/Y') }}</td>
                        <td>
                            <!-- ปุ่มแก้ไขและลบ -->
                            <a class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal {{ $question->id }}">แก้ไข</a>
                            <form action="{{ route('questions.delete', $question->id) }}" method="post" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('คุณแน่ใจหรือว่าต้องการลบคำถามนี้?')">ลบ</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

        <!-- Modal สร้างผู้ใช้ -->
        <div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="{{ route('questions.create') }}" method="post">
                        @csrf
                        <div class="modal-header">
                            <h5 class="modal-title">เพิ่มหัวข้อการประเมิน</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="question_text" class="form-label">ข้อความของคำถาม</label>
                                <input type="text" class="form-control" id="question_text" name="question_text" required>
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

        @foreach ($questions as $index => $question)
            <!-- Modal แก้ไขผู้ใช้ -->
            <div class="modal fade" id="editUserModal{{ $question->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('questions.update', $question->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="modal-header">
                                <h5 class="modal-title">แก้ไขหัวข้อการประเมิน</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="question_text" class="form-label">พิมพ์ข้อความของคำถาม :</label>
                                    <input type="text" class="form-control" id="question_text" name="question_text" value="{{ $question->question_text }}" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                <button type="submit" class="btn btn-primary">บันทึกการแก้ไข</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

</div>

@endsection
