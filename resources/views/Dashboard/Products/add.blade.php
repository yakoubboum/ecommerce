<!-- Modal -->
<div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('Dashboard/sections_trans.add_sections') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('products.store') }}" method="post" autocomplete="on"
                enctype="multipart/form-data">
                @csrf

                <div class="modal-body">
                    <div class="form-group">
                        <label for="name">Product Name:</label>
                        <input type="text" name="name" class="form-control" id="name" required>
                    </div>

                    <div class="form-group">
                        <label for="section_id">Section:</label>
                        <select name="section_id" class="form-control" id="section_id" required>
                            <option value="">Select Section</option>
                            @foreach ($sections as $section)
                                <option value="{{ $section->id }}">{{ $section->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="price">Price:</label>
                        <input type="number" name="price" class="form-control" id="price" step="0.01"
                            required>
                    </div>

                    <div class="form-group">
                        <label for="discount">Discount (%):</label>
                        <input type="number" name="discount" class="form-control" id="discount" min="0"
                            max="100">
                    </div>

                    <div class="form-group">
                        <label for="delivery_price">Delivery Price:</label>
                        <input type="number" name="delivery_price" class="form-control" id="delivery_price"
                            step="0.01">
                    </div>

                    <div class="form-group">
                        <label for="delivery_time">Delivery Time:</label>
                        <input type="text" name="delivery_time" class="form-control" id="delivery_time">
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" name="status" class="form-check-input" id="status" checked value=1>
                        <label for="status" class="form-check-label">Active</label>
                    </div>

                    <div class="form-group row">
                        <label for="rating" class="col-sm-2 col-form-label">Rating:</label>
                        <div class="col-sm-10">
                            <input type="text" name="rating" class="form-control" id="rating" readonly>
                            <small class="text-muted">This field is automatically generated.</small>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="number_of_ratings" class="col-sm-2 col-form-label">Number of Ratings:</label>
                        <div class="col-sm-10">
                            <input type="text" name="number_of_ratings" class="form-control" id="number_of_ratings"
                                readonly>
                            <small class="text-muted">This field is automatically generated.</small>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="number_of_sales">Number of Sales:</label>
                        <input type="text" name="number_of_sales" class="form-control" id="number_of_sales" readonly>
                        <small class="text-muted">This field is automatically generated.</small>
                    </div>

                    <div class="form-group">
                        <label for="quantity">Quantity:</label>
                        <input type="number" name="quantity" class="form-control" id="quantity">
                    </div>

                    <div class="form-group">
                        <label for="specifications">Specifications:</label>
                        <textarea name="specifications" class="form-control" id="specifications" rows="3"></textarea>
                    </div>

                    <div class="form-group">
                        <label for="details">details:</label>
                        <textarea name="details" class="form-control" id="details" rows="3"></textarea>
                    </div>

                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-1">
                            <label for="exampleInputEmail1">
                                Product photo</label>
                        </div>
                        <div class="col-md-11 mg-t-5 mg-md-t-0">
                            <input type="file" accept="image/*" name="photo" onchange="loadFile(event)">
                            <img style="border-radius:50%" width="150px" height="150px" id="output"/>
                        </div>
                    </div>



                    <button type="submit"
                            class="btn btn-main-primary pd-x-30 mg-r-5 mg-t-5">{{ trans('Doctors.submit') }}</button>
                </div>
            </form>    
        </div>
    </div>
