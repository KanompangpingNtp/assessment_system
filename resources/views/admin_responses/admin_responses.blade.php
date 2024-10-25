@extends('layout.admin_layout')
@section('admin_layout')

<div class="container">
    <h2 class="text-center">สรุปการทำแบบประเมิน</h2>

    @if($responses->isEmpty())
        <p class="text-center">ยังไม่มีการทำแบบประเมิน</p>
    @else
    <table class="table table-bordered table-striped mt-4">
        <thead>
            <tr class="text-center">
                <th>#</th>
                <th>คำถาม</th>
                <th>ชื่อหน่วยงาน</th>
                <th>คะแนนที่ได้รับ</th>
                <th>ชื่อผู้ประเมิน</th>
                <th>เบอร์โทรติดต่อ</th>
                <th>วันที่ทำแบบประเมิน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($responses as $index => $response)
            <tr>
                <td class="text-center">{{ $index + 1 + ($responses->currentPage() - 1) * $responses->perPage() }}</td>
                <td>{{ $response->question->question_text }}</td>
                <td>{{ $response->agency->name ?? 'ไม่ระบุ' }}</td>
                <td class="text-center">{{ $response->score }}</td>
                <td class="text-center">{{ $response->name ?? 'ไม่ระบุ' }}</td>
                <td class="text-center">{{ $response->phone ?? 'ไม่ระบุ' }}</td>
                <td class="text-center">{{ $response->created_at->format('d/m/Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- แสดง pagination -->
    <nav aria-label="...">
        <ul class="pagination">
            <li class="page-item {{ $responses->onFirstPage() ? 'disabled' : '' }}">
                <a class="page-link" href="{{ $responses->previousPageUrl() }}">Previous</a>
            </li>
            @foreach ($responses->getUrlRange(1, $responses->lastPage()) as $page => $url)
                <li class="page-item {{ $page == $responses->currentPage() ? 'active' : '' }}">
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                </li>
            @endforeach
            <li class="page-item {{ $responses->hasMorePages() ? '' : 'disabled' }}">
                <a class="page-link" href="{{ $responses->nextPageUrl() }}">Next</a>
            </li>
        </ul>
    </nav>
    @endif
</div>

@endsection
