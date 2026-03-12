@extends('admin.layouts.layout')

@section('content')


               <!-- Start Container Fluid -->
               <div class="container-xxl">
                    <form action="{{route('admin.color.bulkDeleteColor')}}">
                         @csrf
                         @method('DELETE')
                    <div class="row">
                         <div class="col-xl-12">
                              <div class="card">
                                   <div class="d-flex card-header justify-content-between align-items-center">
                                        <div>
                                             
                                             <a href="{{route('admin.color.addColor')}}" type="button" class="btn btn-secondary mb-3">Thêm màu</a>
                                             <h4 class="card-title">Danh Sách Màu</h4>
                                        </div>
                                        <div class="dropdown">
                                             <a href="{{route('admin.color.trashColor')}}" class="btn btn-soft-danger btn-sm" aria-expanded="false">
                                                  Đã Xóa
                                             </a>
                                             <a href="#" class="dropdown-toggle btn btn-sm btn-outline-light rounded" data-bs-toggle="dropdown" aria-expanded="false">
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
                                                            <th>STT</th>
                                                            
                                                            <th>Tên Màu</th>
                                                            <th>Mã Màu</th>
                                                            <th>Màu</th>
                                                            <th>Tạo Ngày</th>
                                                            
                                                            <th></th>
                                                       </tr>
                                                  </thead>
                                               
                                                  <tbody >
                                   
                                                       
                                                      @foreach($colors as $color)
                                                       <tr>
                                                            <td>
                                                                 <div class="form-check">
                                                                      <input type="checkbox" name="ids[]" value="{{$color->id}}" class="form-check-input checkbox-item" >
                                                                      <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                                 </div>
                                                            </td>
                                                            <td>
                                                                 {{ $loop->iteration }}
                                                            </td>
                                                          
                                                            
                                                            <td>{{$color->name}}</td>
                                                            <td>{{$color->code}}</td>
                                                            <td>
                                                                 <div style="display: flex; align-items: center; gap: 8px;">
                                                                      <div style="width: 20px; height: 20px; background-color: {{ $color->code }}; border: 1px solid #ccc; border-radius: 3px;"></div>
                                                                      {{ $color->code }}
                                                                  </div>
                                                            </td>
                                                            <td>{{$color->updated_at}}</td>
                                                           
                                                            <td>
                                                                 <div class="d-flex gap-2">
                                                                      {{-- <a href="#!" class="btn btn-light btn-sm"><iconify-icon icon="solar:eye-broken" class="align-middle fs-18"></iconify-icon></a> --}}
                                                                      <a href="{{route('admin.color.editColor', $color->id)}}" class="btn btn-soft-primary btn-sm"><iconify-icon icon="solar:pen-2-broken" class="align-middle fs-18"></iconify-icon></a>
                                                                      <a href="{{route('admin.color.deleteColor', $color->id)}}" class="btn btn-soft-danger btn-sm" onclick="return confirm('Bạn có muốn xóa màu này không?')"><iconify-icon icon="solar:trash-bin-minimalistic-2-broken" class="align-middle fs-18"></iconify-icon></a>
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
                                                  <button type="submit" class="btn btn-primary me-4" onclick="return confirm('bạn có muốn xóa các mục đã chọn?')">Xóa các mục đã chọn</button>
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

               <!-- ========== Footer Start ========== -->
               <footer class="footer">
                   <div class="container-fluid">
                       <div class="row">
                           <div class="col-12 text-center">
                               <script>document.write(new Date().getFullYear())</script> &copy; Larkon. Crafted by <iconify-icon icon="iconamoon:heart-duotone" class="fs-18 align-middle text-danger"></iconify-icon> <a
                                   href="https://1.envato.market/techzaa" class="fw-bold footer-text" target="_blank">Techzaa</a>
                           </div>
                       </div>
                   </div>
               </footer>
               <!-- ========== Footer End ========== -->
               
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