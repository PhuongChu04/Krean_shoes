@extends('admin.layouts.layout')

@section('content')

               <!-- Start Container Fluid -->
               <div class="container-xxl">
               <form action="{{route('admin.color.bulkRestoreColor')}}">
                    <div class="row">
                         <div class="col-xl-12">
                              <div class="card">
                                   <div class="card-header d-flex justify-content-between align-items-center gap-1">
                                        <h4 class="card-title flex-grow-1">Danh Sách Đã Xóa</h4>

                                        <a href="product-add.html" class="btn btn-sm btn-primary">
                                             Add Product
                                        </a>

                                        <div class="dropdown">
                                             <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light" data-bs-toggle="dropdown" aria-expanded="false">
                                                  This Month
                                             </a>
                                             <div class="dropdown-menu dropdown-menu-end">
                                                  <!-- item-->
                                                  <a href="#!" class="dropdown-item">Download</a>
                                                  <!-- item-->
                                                  <a href="#!" class="dropdown-item">Export</a>
                                                  <!-- item-->
                                                  <a href="#!" class="dropdown-item">Import</a>
                                             </div>
                                        </div>
                                   </div>
                                   <div>
                                        <div class="table-responsive">
                                             <table class="table align-middle mb-0 table-hover table-centered">
                                                  <thead class="bg-light-subtle">
                                                       <tr>
                                                            <th style="width: 20px;">
                                                                 <div class="form-check">
                                                                      <input type="checkbox" class="form-check-input" id="checkAll">
                                                                      <label class="form-check-label" for="checkAll"></label>
                                                                 </div>
                                                            </th>
                                                            <th>ID</th>
                                                            <th>Tên Màu</th>
                                                            <th>Mã Màu</th>
                                                          
                                                            <th>Màu</th>
                                                            <th></th>
                                                       </tr>
                                                  </thead>
                                                  <tbody>
                                                       @foreach ($trashedColors as $color)
                                                            
                                                      
                                                       <tr>
                                                            <td>
                                                                 <div class="form-check">
                                                                      <input type="checkbox" class="form-check-input checkbox-item" name="ids[]" value="{{ $color->id }}">
                                                                      <label class="form-check-label" for="customCheck2"></label>
                                                                 </div>
                                                            </td>
                                                            <td>
                                                                 <div class="d-flex align-items-center gap-2">
                                                                      {{$color->id}}
                                                                 </div>

                                                            </td>
                                                            <td>{{$color->name}}</td>
                                                            <td>{{$color->code}}</td>
                                                            <td> <div style="display: flex; align-items: center; gap: 8px;">
                                                                 <div style="width: 20px; height: 20px; background-color: {{ $color->code }}; border: 1px solid #ccc; border-radius: 3px;"></div>
                                                                 {{ $color->code }}
                                                             </div>
                                                            </td>
                                                          
                                                            <td>
                                                                 <div class="d-flex gap-2">
                                                                      <a href="{{route('admin.color.restoreColor', $color->id)}}" class="btn btn-sm btn-primary" onclick="return confirm('bạn có muốn khôi phục màu này không?')">
                                                                           Khôi Phục
                                                                      </a>
                                                                      <form action="{{ route('admin.color.forceDeleteColor', $color->id) }}" method="POST" style="display:inline;">
                                                                           @csrf
                                                                           @method('DELETE')
                                                                           <button type="submit" class="btn btn-sm btn-primary" onclick="return confirm('bạn có muốn xóa vĩnh viễn màu này?')">Xóa</button>
                                                                      </form>
                                                                 </div>
                                                            </td>
                                                       </tr>
                                                       @endforeach

                                                      
                                                  </tbody>
                                             </table>
                                        </div>
                                        <!-- end table-responsive -->
                                   </div>
                                   <div class="card-footer border-top">
                                        <nav aria-label="Page navigation example">
                                             <ul class="pagination justify-content-end mb-0">
                                                  <button type="submit" class="btn btn-primary me-4" onclick="return confirm('bạn có muốn xóa các mục đã chọn?')">Khôi Phục các mục đã chọn</button>
                                                  <li class="page-item"><a class="page-link" href="javascript:void(0);">Previous</a></li>
                                                  <li class="page-item active"><a class="page-link" href="javascript:void(0);">1</a></li>
                                                  <li class="page-item"><a class="page-link" href="javascript:void(0);">2</a></li>
                                                  <li class="page-item"><a class="page-link" href="javascript:void(0);">3</a></li>
                                                  <li class="page-item"><a class="page-link" href="javascript:void(0);">Next</a></li>
                                             </ul>
                                        </nav>
                                   </div>
                              </div>
                         </div>
                    </div>

               </div>
          </form>
               <!-- End Container Fluid -->

               <script>
                    document.addEventListener('DOMContentLoaded', function () {
                    const checkAll = document.getElementById('checkAll');
                    const checkboxes = document.querySelectorAll('.checkbox-item');
            
                    // Khi bấm "Chọn tất cả"
                    checkAll.addEventListener('change', function () {
                        checkboxes.forEach(cb => {
                            cb.checked = checkAll.checked;
                        });
                    });
            
                    // Nếu thay đổi checkbox con → kiểm tra lại checkbox tổng
                    checkboxes.forEach(cb => {
                        cb.addEventListener('change', function () {
                            const allChecked = [...checkboxes].every(input => input.checked);
                            checkAll.checked = allChecked;
                        });
                    });
                });
                </script>


               
@endsection

        