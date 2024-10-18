@extends('layout.admin_layout')
@section('admin_layout')

<div class="container">
    <h2 class="text-center">สรุปการทำแบบประเมิน</h2>

    @if($responses->isEmpty())
        <p class="text-center">ยังไม่มีการทำแบบประเมิน</p>
    @else
        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr>
                    <th>#</th>
                    <th>คำถาม</th>
                    <th>คะแนนที่ได้รับ</th>
                    <th>ชื่อผู้ประเมิน</th>
                    <th>เบอร์โทรติดต่อ</th>
                    <th>วันที่ทำแบบประเมิน</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($responses as $index => $response)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $response->question->question_text }}</td>
                        <td>{{ $response->rating }}</td>
                        <td>{{ $response->name ?? 'ไม่ระบุ' }}</td>
                        <td>{{ $response->phone ?? 'ไม่ระบุ' }}</td>
                        <td>{{ $response->created_at->format('d/m/Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>

@endsection
