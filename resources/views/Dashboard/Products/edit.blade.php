@extends('Dashboard.layouts.master')
@section('css')
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('Dashboard/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link href="{{URL::asset('dashboard/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>

    <!-- Internal Select2 css -->
    <link href="{{URL::asset('Dashboard/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{URL::asset('Dashboard/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('Dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css')}}"
          rel="stylesheet">
    <link href="{{URL::asset('Dashboard/plugins/pickerjs/picker.min.css')}}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{URL::asset('Dashboard/plugins/spectrum-colorpicker/spectrum.css')}}" rel="stylesheet">

@section('title')
    {{trans('doctors.add_doctor')}}
@stop
@endsection
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"> {{trans('main-sidebar_trans.doctors')}}</h4><span
                    class="text-muted mt-1 tx-13 mr-2 mb-0">/
               {{trans('doctors.add_doctor')}}</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

    {{-- @include('Dashboard.messages_alert') --}}

    <!-- row -->
    <div class="row">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('products.update', $item->id) }}" method="post" autocomplete="on"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="modal-body">
                            <div class="form-group">
                                <label for="name">Product Name:</label>
                                <input type="text" name="name" class="form-control" id="name"
                                    value="{{ $item->name }}" required>
                            </div>
        
                            <div class="form-group">
                                <label for="section_id">Section:</label>
                                <select name="section_id" class="form-control" id="section_id" required>
                                    <option value="">Select Section</option>
                                    @foreach ($sections as $section)
                                        <option value="{{ $section->id }}" @if ($item->section_id == $section->id) selected @endif>
                                            {{ $section->name }}</option>
                                    @endforeach
                                </select>
                            </div>
        
                            <div class="form-group">
                                <label for="price">Price:</label>
                                <input type="number" name="price" class="form-control" id="price" step="0.01"
                                    value="{{ $item->price }}" required>
                            </div>
        
                            <div class="form-group">
                                <label for="discount">Discount (%):</label>
                                <input type="number" name="discount" class="form-control" id="discount" min="0"
                                    max="100" value="{{ $item->discount }}">
                            </div>
        
                            <div class="form-group">
                                <label for="delivery_price">Delivery Price:</label>
                                <input type="number" name="delivery_price" class="form-control" id="delivery_price"
                                    step="0.01" value="{{ $item->delivery_price }}">
                            </div>
        
                            <div class="form-group">
                                <label for="delivery_time">Delivery Time:</label>
                                <input type="text" name="delivery_time" class="form-control" id="delivery_time"
                                    value="{{ $item->delivery_time }}">
                            </div>
        
                            <div class="form-group form-check">
                                <input type="checkbox" name="status" class="form-check-input" id="status" value="1"
                                    @if ($item->status) checked @endif>
                                <label for="status" class="form-check-label">Active</label>
                            </div>
        
                            <div class="form-group row">
                                <label for="rating" class="col-sm-2 col-form-label">Rating:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="rating" class="form-control" id="rating"
                                        value="{{ $item->rating }}" readonly>
                                    <small class="text-muted">This field is automatically generated.</small>
                                </div>
                            </div>
        
                            <div class="form-group row">
                                <label for="number_of_ratings" class="col-sm-2 col-form-label">Number of Ratings:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="number_of_ratings" class="form-control" id="number_of_ratings"
                                        value="{{ $item->number_of_ratings }}" readonly>
                                    <small class="text-muted">This field is automatically generated.</small>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <label for="quantity" class="col-sm-2 col-form-label">Quantity:</label>
                                <div class="col-sm-10">
                                    <input type="text" name="quantity" class="form-control" id="quantity"
                                        value="{{ $item->quantity }}" >
                                    
                                </div>
                            </div>
        
        
                            <div class="form-group row">
                                <label for="specifications" class="col-sm-2 col-form-label">specifications:</label>
                                <div class="col-sm-10">
                                    <textarea type="texterea" name="specifications" class="form-control" id="specifications" 
                                        >{{ $item->specifications }}</textarea>
                                    
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="details" class="col-sm-2 col-form-label">details:</label>
                                <div class="col-sm-10">
                                    <textarea type="texterea" name="details" class="form-control" id="details"
                                        >{{ $item->details }}</textarea>
                                    
                                </div>
                            </div>
        
        
                            <div class="row row-xs align-items-center mg-b-20">
                                <div class="col-md-1">
                                    <label for="exampleInputEmail1">
                                        Product photo</label>
                                </div>
                                <div class="col-md-11 mg-t-5 mg-md-t-0">
                                    <input type="file" accept="image/*" name="photo" onchange="loadFile(event)">
                                    @if ($item->image)
                                    <img src="{{ URL::asset('Dashboard/img/products/' . $item->image->filename) }}" alt="" id="output">
                                    @endif
                                </div>
                            </div>
        
                            <button type="submit"
                            class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">{{ trans('Doctors.submit') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /row -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')

    <script>
        var loadFile = function (event) {
            var output = document.getElementById('output');
            output.src = URL.createObjectURL(event.target.files[0]);
            output.onload = function () {
                URL.revokeObjectURL(output.src) // free memory
            }
        };
    </script>

    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('Dashboard/js/select2.js') }}"></script>
    <script src="{{ URL::asset('Dashboard/js/advanced-form-elements.js') }}"></script>

    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('Dashboard/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Notify js -->
    <script src="{{URL::asset('dashboard/plugins/notify/js/notifIt.js')}}"></script>
    <script src="{{URL::asset('/plugins/notify/js/notifit-custom.js')}}"></script>


    <!--Internal  Datepicker js -->
    <script src="{{URL::asset('dashboard/plugins/jquery-ui/ui/widgets/datepicker.js')}}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{URL::asset('dashboard/plugins/jquery.maskedinput/jquery.maskedinput.js')}}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{URL::asset('dashboard/plugins/spectrum-colorpicker/spectrum.js')}}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{URL::asset('dashboard/plugins/select2/js/select2.min.js')}}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{URL::asset('dashboard/plugins/ion-rangeslider/js/ion.rangeSlider.min.js')}}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{URL::asset('dashboard/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js')}}"></script>
    <!-- Ionicons js -->
    <script src="{{URL::asset('dashboard/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js')}}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{URL::asset('dashboard/plugins/pickerjs/picker.min.js')}}"></script>
    <!-- Internal form-elements js -->
    <script src="{{URL::asset('dashboard/js/form-elements.js')}}"></script>


@endsection