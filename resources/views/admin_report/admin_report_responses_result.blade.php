@extends('layout.admin_layout')
@section('admin_layout')

<div class="container">
    <a href="{{route('report.responses.index')}}" class="btn btn-primary btn-sm" >กลับหน้าเดิม</a><br><br>
    <h2>ผลการประเมินคะแนน สำหรับหน่วยงาน: {{ $agencyName }}</h2>
    <p>จำนวนครั้งที่ทำแบบประเมิน: {{ $submissionCount }} (เดือน : {{ $month }}, ปี : {{ $year }})</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>คำถาม</th>
                <th>คะแนนรวม</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($questions as $question)
            <tr>
                <td>{{ $question->question_text }}</td>
                <td>{{ $question->responses_sum_score ?? 0 }} คะแนน</td> <!-- แสดงคะแนนรวม -->
            </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('exportResponses') }}" method="POST" class="mb-3">
        @csrf
        <input type="hidden" name="month" value="{{ $month }}">
        <input type="hidden" name="year" value="{{ $year }}">
        <input type="hidden" name="agency_id" value="{{ $agencyId }}">
        <button type="submit" class="btn btn-primary">Export to Excel</button>
    </form>


</div>
@endsection
