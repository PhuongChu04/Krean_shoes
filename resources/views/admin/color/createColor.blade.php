@extends('admin.layouts.layout')

@section('content')
    <!-- Start Container Fluid -->
    <div class="container-xxl">

        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thêm Màu</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.color.storeColor') }}" method="post">
                            @csrf

                            <div class="row g-3 align-items-end">

                                <div class="col-lg-6">
                                    <label for="value-name" class="form-label text-dark">
                                        Tên Màu
                                    </label>

                                    <input type="text" id="value-name" name="name" class="form-control"
                                        placeholder="Enter Name">
                                </div>

                                <div class="col-lg-6">
                                    <label for="attribute-id" class="form-label text-dark">
                                        Mã màu
                                    </label>

                                    <input type="text" id="attribute-id" name="code" class="form-control"
                                        placeholder="Enter ID">
                                </div>

                            </div>
                        </form>
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <button type="submit" name="submit" onclick="return confirm('Bạn có muốn tạo màu không?')"
                                class="btn btn-primary">Thêm</button>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- End Container Fluid -->
@endsection
