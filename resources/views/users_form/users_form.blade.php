@extends('layout.users_layout')
@section('user_layout')

<div class="container">
    {{-- <h2 class="text-center">แบบประเมิน</h2> --}}

    <form action="{{ route('responses.store') }}" method="POST">
        @csrf
        <div class="row mb-3">
            <div class="col-md-6">
                <label for="name" class="form-label">ชื่อ:</label>
                <input type="text" class="form-control" id="name" name="name">
            </div>

            <div class="col-md-6">
                <label for="phone" class="form-label">เบอร์ติดต่อ:</label>
                <input type="text" class="form-control" id="phone" name="phone">
            </div>
        </div>

        <div class="mb-3">
            <label for="agency_id" class="form-label">เลือกหน่วยงาน:</label>
            <select id="agency_id" name="agency_id" class="form-select" required>
                <option value="">เลือกหน่วยงาน</option>
                @foreach ($agencies as $agency)
                    <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                @endforeach
            </select>
        </div>

        <table class="table table-bordered table-striped mt-4">
            <thead>
                <tr class="text-center">
                    <th>#</th>
                    <th>คำถาม</th>
                    <th>คะแนนความพึงพอใจ 1-5</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($questions as $index => $question)
                    <tr>
                        <td class="text-center">{{ $index + 1 }}</td>
                        <td>{{ $question->question_text }}</td>
                        <td class="text-center">
                            @for ($i = 1; $i <= 5; $i++)
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="responses[{{ $question->id }}]" id="question_{{ $question->id }}_{{ $i }}" value="{{ $i }}" required>
                                    <label class="form-check-label" for="question_{{ $question->id }}_{{ $i }}">{{ $i }}</label>
                                </div>
                            @endfor
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-primary"><i class="bi bi-save"></i> ส่งการประเมิน</button>
    </form>

</div>

@endsection
