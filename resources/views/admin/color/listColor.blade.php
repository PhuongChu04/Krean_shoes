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
                                        
                                   </div>
                                   <div>
                                        <div class="table-responsive">
                                             <table class="table align-middle mb-0 table-hover table-centered">
                                                  <thead class="bg-light-subtle">
                                                       <tr>
                                                            
                                                            <th>STT</th>
                                                            
                                                            <th>Tên Màu</th>
                                                            <th>Mã Màu</th>
                                                            <th>Màu</th>
                                                            <th>Tạo Ngày</th>
                                                            
                                                            <th>Hành động</th>
                                                       </tr>
                                                  </thead>
                                               
                                                  <tbody >
                                   
                                                       
                                                      @foreach($colors as $color)
                                                       <tr>
                                                            
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
                                                                 </div>
                                                            </td>
                                                       </tr>
                                                       @endforeach
                                                
                                                       
                                                  </tbody>
                                             </table>
                                        </div>
                                        <!-- end table-responsive -->
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