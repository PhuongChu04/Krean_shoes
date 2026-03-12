@extends('admin.layouts.layout')

@section('content')


     <!-- Start Container Fluid -->
     <div class="container-xxl">

           <div class="row">
                 <div class="col-lg-12">
                       <div class="card">
                              <div class="card-header">
                                    <h4 class="card-title">Sửa Màu</h4>
                              </div>
                              <div class="card-body">
                                    <div class="row">
                                             <form action="{{route('admin.color.updateColor', $color->id)}}" method="post">
                                                @csrf
                                          <div class="col-lg-6">
                                             <input type="hidden" name="id" value="{{$color->id}}">
                                                
                                                       <div class="mb-3">
                                                             <label for="value-name" class="form-label text-dark">Tên Màu
                                                                   </label>
                                                             <input type="text" id="value-name" name="name" class="form-control"
                                                                   placeholder="Enter Name" value="{{$color->name}}">
                                                                   
                                                       </div>
                                                       <div style="display: flex; align-items: center; gap: 8px;">
                                                            <div style="width: 20px; height: 20px; background-color: {{ $color->code }}; border: 1px solid #ccc; border-radius: 3px;"></div>
                                                            
                                                        </div>
                                               
                                          </div>
                                          <div class="col-lg-6 mt-3">
                                                
                                                       <div class="">
                                                             <label for="attribute-id" class="form-label text-dark">Mã Màu</label>
                                                             <input type="text" id="attribute-id" name="code" class="form-control"
                                                                   placeholder="Enter ID" value="{{$color->code}}">
                                                       </div>
                                                
                                          </div>
                                          
                                         
                                    </div>
                              </div>
                              <div class="card-footer border-top">
                                    <button type="submit" name="submit" class="btn btn-primary" onclick="return confirm('Add Color?')">Lưu</button>
                              </div>
                              </form>
                       </div>
                 </div>
           </div>

     </div>
     <!-- End Container Fluid -->

    

@endsection