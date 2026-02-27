<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="d-flex">
    <div style="width:250px; background:#222; color:white; min-height:100vh; padding:20px;">
        <h4>ADMIN</h4>
        <a href="{{ route('admin.categories.index') }}" class="text-white d-block mb-2">Categories</a>
    </div>
    <div class="p-4 w-100">
        @yield('content')
    </div>
</div>
</body>
</html>
