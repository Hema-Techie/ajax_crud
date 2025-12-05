@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Product List</h2>
        <button id="addProductBtn" style="padding: 8px 16px; background-color: #ca2654; color: white; border: none; border-radius: 4px;">Create Product</button>
    </div>
    <div id="formCard" style="background-color: #f8f9fa; padding: 20px; border: 1px solid #ccc; border-radius: 8px; margin-bottom: 30px; display: none;">
        <form id="productForm">
            @csrf
            <input type="hidden" name="id" id="product_id">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">

                <input class="input_style" type="text" name="product_name" id="product_name" placeholder="Product Name" required>

                <input class="input_style" type="number" name="quantity" id="quantity" placeholder="Quantity" required>

                <div style="margin-top:20px">
                    <label><input type="radio" name="status" value="active" id="status_active"> Active</label>
                    <label><input type="radio" name="status" value="inactive" id="status_inactive"> Inactive</label>
                </div>

                <select name="category_id" id="category_id" required class="input_style">
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <input class="input_style" type="file"  name="image" id="image">



                <button type="submit" id="formSubmitBtn" style="padding: 8px 20px;background-color: #007bff;color: white;border: none;border-radius: 4px;">Save</button>
            </div>
        </form>
    </div>



<div style="margin-bottom: 15px; display: flex; align-items: center; gap: 700px;">
    <input type="text" id="searchInput" placeholder="Search ..." style="padding: 8px; width: 300px; border-radius: 4px; border: 1px solid #ccc;">
   <a href="{{ route('products.pdf') }}" target="_blank" title="Download PDF">
        <i class="fas fa-file-pdf" style="font-size: 24px; color: #d32f2f;"></i>
    </a>
</div>



   <table id="productTable" style="width: 100%; border-collapse: separate; border-spacing: 0; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden;">
    <thead>
        <tr style="background-color: #007bff; color: white;">
            <th style="padding: 10px; border: 1px solid #ccc;">Name</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Qty</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Status</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Category</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Image</th>
            <th style="padding: 10px; border: 1px solid #ccc;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($products as $p)
        <tr data-id="{{ $p->id }}" data-name="{{ $p->product_name }}" data-qty="{{ $p->quantity }}" data-status="{{ $p->status }}" data-category="{{ $p->category_id }}">
            <td style="padding: 10px; border: 1px solid #ccc;text-align:center">{{ $p->product_name }}</td>
            <td style="padding: 10px; border: 1px solid #ccc;text-align:center">{{ $p->quantity }}</td>
            <td style="padding: 10px; border: 1px solid #ccc;text-align:center">{{ $p->status }}</td>
            <td style="padding: 10px; border: 1px solid #ccc;text-align:center">{{ $p->category->name }}</td>
            <td style="padding: 10px; border: 1px solid #ccc;text-align:center">
                @if($p->image)
                    <img src="{{ asset('storage/' . $p->image) }}" alt="Product Image" width="80">
                @else
                    <span>No Image</span>
                @endif
            </td>
            <td style="padding: 10px; border: 1px solid #ccc; text-align: center;">
                <button class="editBtn" style="background: none; border: none; cursor: pointer;">
                    <i class="fas fa-edit" style="font-size: 20px; color: green;"></i>
                </button>
                <button class="deleteBtn" style="background: none; border: none; cursor: pointer;">
                    <i class="fas fa-trash-alt" style="font-size: 20px; color: #ea1414;"></i>
                </button>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

    <div style="margin-top: 20px; text-align: center;">
        <button style="padding: 6px 12px; margin-right: 5px;">Previous</button>
        <button style="padding: 6px 12px;">1</button>
        <button style="padding: 6px 12px; margin-left: 5px;">Next</button>
    </div>
</div>

  <script>
$(document).ready(function(){
    let isEdit = false;

    toastr.options = {
        "positionClass": "toast-top-right",
        "timeOut": "2000"
    };

    $('#addProductBtn').on('click', function(){
        isEdit = false;
        $('#productForm')[0].reset();
        $('#product_id').val('');
        $('#formSubmitBtn').text('Save');
        $('#formCard').slideDown();
    });

    $('#productForm').on('submit', function(e){
        e.preventDefault();
        let id = $('#product_id').val();
        let url = isEdit ? '/products/' + id : '/products';

        let formData = new FormData(this);
        if (isEdit) {
            formData.append('_method', 'PUT');
        }

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(data){
                toastr.success(isEdit ? 'Product Updated' : 'Product Added');
                  setTimeout(() => location.reload(), 1000);
            },
            error: function(){
                toastr.error('Something went wrong');
            }
        });
    });

    $('.deleteBtn').on('click', function(){
        var id = $(this).closest('tr').data('id');

        $.ajax({
            url: '/products/' + id,
            type: "POST",
            data: {
                _token: '{{ csrf_token() }}',
                _method: 'DELETE'
            },
            success: function(){
                toastr.success('Product Deleted');
                setTimeout(() => location.reload(), 1000);
            },
            error: function(){
                toastr.error('Delete failed');
            }
        });
    });

    $('.editBtn').on('click', function(){
        isEdit = true;

        var row = $(this).closest('tr');
        $('#product_id').val(row.data('id'));
        $('#product_name').val(row.data('name'));
        $('#quantity').val(row.data('qty'));

        if(row.data('status') === 'active'){
            $('#status_active').prop('checked', true);
        } else {
            $('#status_inactive').prop('checked', true);
        }

        $('#category_id').val(row.data('category'));

        $('#formSubmitBtn').text('Update');
        $('#formCard').slideDown();
    });

    $('#searchInput').on('keyup', function(){
        var value = $(this).val().toLowerCase();
        $('#productTable tbody tr').filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>


@endsection
