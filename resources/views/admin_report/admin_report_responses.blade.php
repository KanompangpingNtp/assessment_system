@extends('layout.admin_layout')
@section('admin_layout')

<div class="container">
    <div class="container d-flex justify-content-center align-items-center min-vh-50">
        <form action="{{ route('report.responses') }}" method="GET" class="row g-3 w-50">
            <div class="col-md-12">
                <h2 class="text-center">เลือกข้อมูลเพื่อแสดงผลการประเมิน</h2>
            </div>

            <div class="col-md-12">
                <label for="agency_id" class="form-label">เลือกหน่วยงาน:</label>
                <select class="form-select" id="agency_id" name="agency_id" required>
                    <option value="">เลือกหน่วยงาน</option>
                    @foreach ($agencies as $agency)
                        <option value="{{ $agency->id }}">{{ $agency->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <label for="month" class="form-label">เลือกเดือน:</label>
                <select id="month" name="month" class="form-select">
                    <option value="">เลือกเดือน</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 10)) }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-6">
                <label for="year" class="form-label">เลือกปี:</label>
                <select id="year" name="year" class="form-select">
                    <option value="">เลือกปี</option>
                    @for ($i = date('Y'); $i >= date('Y') - 5; $i--)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>

            <div class="col-md-12 d-flex justify-content-center">
                <button type="submit" class="btn btn-primary">แสดงผล</button>
            </div>
        </form>
    </div>
</div>


@endsection
