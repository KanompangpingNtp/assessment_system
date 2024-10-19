<!-- resources/views/user_index.blade.php -->

<!DOCTYPE html>
<html>

<head>
    <title>หน้าหลัก</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body style="background-color: #566573;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mt-5">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>
                            <h4>แบบประเมิน</h4>
                        </span>
                    </div>

                    <div class="card-body">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                    </div>

                    @yield('user_layout')

                    <br>

                </div>
            </div>
        </div>
        {{-- <a href="{{route('login')}}">login</a> --}}
    </div>

    <br>
    <br>

    <footer style="background-color: #1c2833; color: white; padding: 20px; text-align: center;">
        <div>
            <p>&copy; 2024 ชื่อบริษัท | สงวนลิขสิทธิ์</p>
            <p><a href="{{route('login')}}" style="color: white; text-decoration: none;">สำหรับผู้ดูแลระบบ</a> | <a href="#" style="color: white; text-decoration: none;">คู่มือการใช้งาน</a></p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
