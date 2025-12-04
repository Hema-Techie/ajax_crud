@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Product List</h2>
        <button id="addProductBtn" style="padding: 8px 16px; background-color: #28a745; color: white; border: none; border-radius: 4px;">Create Product</button>
    </div>

    <!-- Form -->
    <div id="formCard" style="background-color: #f8f9fa; padding: 20px; border: 1px solid #ccc; border-radius: 8px; margin-bottom: 30px; display: none;">
        <form id="productForm">
    @csrf
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">

        <input class="input_style" type="text" name="product_name" placeholder="Product Name" required>

        <input class="input_style" type="number" name="quantity" placeholder="Quantity" required>

        <div style="margin-top:20px">
            <label><input type="radio" name="status" value="active" checked> Active</label>
            <label><input type="radio" name="status" value="inactive"> Inactive</label>
        </div>

        <select name="category_id" required class="input_style">
            <option value="">Select Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>
        <button type="submit" style="justify-self: right;padding: 8px 20px;background-color: #007bff;color: white;border: none;border-radius: 4px;
            ">Save</button>

    </div>
</form>

    </div>

    <div style="margin-bottom: 15px;">
        <input type="text" id="searchInput" placeholder="Search..." style="padding: 8px; width: 300px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <table id="productTable" style="width: 100%; border-collapse: collapse; background-color: white; border: 1px solid #ccc;">
        <thead>
            <tr style="background-color: #007bff; color: white;">
                <th style="padding: 10px; border: 1px solid #ccc;">Name</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Qty</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Status</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Category</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr data-id="{{ $p->id }}">
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $p->product_name }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $p->quantity }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $p->status }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $p->category->name }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">
                    <button class="editBtn" style="background-color: #ffc107; color: black; border: none; padding: 5px 10px; border-radius: 4px;">Edit</button>
                    <button class="deleteBtn" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px;">Delete</button>
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
    $('#addProductBtn').on('click', function(){
        $('#formCard').slideToggle();
    });

    $('#productForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '/products',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                alert('Product Added');
                location.reload();
            }
        });
    });

    $('.deleteBtn').on('click', function(){
        var id = $(this).closest('tr').data('id');
        $.ajax({
            url: '/products/' + id,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: function(){
                alert('Deleted');
                location.reload();
            }
        });
    });

    $('.editBtn').on('click', function(){
        var id = $(this).closest('tr').data('id');
        var newName = prompt("Enter new name:");
        if(newName){
            $.ajax({
                url: '/products/' + id,
                type: 'PUT',
                data: {_token: '{{ csrf_token() }}', product_name: newName},
                success: function(){
                    alert('Updated');
                    location.reload();
                }
            });
        }
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
