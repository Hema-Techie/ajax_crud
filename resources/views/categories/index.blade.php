@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Category List</h2>
        <button id="addCategoryBtn" style="padding: 8px 16px; background-color: #ca2654; color: white; border: none; border-radius: 4px;">Create Category</button>
    </div>

    <!-- Form -->
    <div id="formCard" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: none;">
        <form id="categoryForm">
            @csrf
            <input type="hidden" name="id" id="category_id">
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 15px;">
                <input class="input_style" type="text" name="name" id="category_name" placeholder="Category Name" required>
                <button type="submit" id="formSubmitBtn" style="padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px;">Save</button>
            </div>
        </form>
    </div>

     <!-- Search + PDF Export -->
<div style="margin-bottom: 15px; display: flex; align-items: center; gap: 700px;">

    <!-- Search Input -->
    <input type="text" id="searchInput" placeholder="Search categories..." style="padding: 8px; width: 300px; border-radius: 4px; border: 1px solid #ccc;">
  <!-- PDF Icon -->
   <a href="{{ route('categories.pdf') }}" target="_blank" title="Download PDF">
        <i class="fas fa-file-pdf" style="font-size: 24px; color: #d32f2f;"></i>
    </a>


</div>

    <!-- Table -->
    <table id="categoryTable" style="width: 100%; border-collapse: separate; border-spacing: 0; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); overflow: hidden;">
        <thead>
            <tr style="background-color: #007bff; color: white;">
                <th style="padding: 10px;">Name</th>
                <th style="padding: 10px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $c)
            <tr data-id="{{ $c->id }}" data-name="{{ $c->name }}">
                <td style="padding: 10px; border: 1px solid #ccc;text-align:center;">{{ $c->name }}</td>
                <td style="padding: 10px; border: 1px solid #ccc; text-align: center;">
                    <button class="editBtn" style="background: none; border: none; cursor: pointer;">
                        <i class="fas fa-edit" style="font-size: 20px; color: green;"></i>
                    </button>
                    <button class="deleteBtn" style="background: none; border: none; cursor: pointer;">
                        <i class="fas fa-trash-alt" style="font-size: 20px;   color: #ea1414;"></i>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Pagination -->
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

    $('#addCategoryBtn').on('click', function(){
        isEdit = false;
        $('#categoryForm')[0].reset();
        $('#category_id').val('');
        $('#formSubmitBtn').text('Save');
        $('#formCard').slideDown();
    });

    $('#categoryForm').on('submit', function(e){
        e.preventDefault();
        let id = $('#category_id').val();
        let url = isEdit ? '/categories/' + id : '/categories';
        let type = isEdit ? 'PUT' : 'POST';

        $.ajax({
            url: url,
            type: type,
            data: $(this).serialize(),
            success: function(data){
                toastr.success(isEdit ? 'Category Updated' : 'Category Added');
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
            url: '/categories/' + id,
            type: 'DELETE',
            data: {_token: '{{ csrf_token() }}'},
            success: function(){
                toastr.success('Category Deleted');
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
        var id = row.data('id');
        var name = row.data('name');

        $('#category_id').val(id);
        $('#category_name').val(name);
        $('#formSubmitBtn').text('Update');
        $('#formCard').slideDown();
    });

    $('#searchInput').on('keyup', function(){
        var value = $(this).val().toLowerCase();
        $('#categoryTable tbody tr').filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
@endsection
