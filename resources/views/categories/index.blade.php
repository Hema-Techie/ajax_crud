@extends('layouts.app')

@section('content')
<div class="container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
        <h2 style="margin: 0;">Category List</h2>
        <button id="addCategoryBtn" style="padding: 8px 16px; background-color: #28a745; color: white; border: none; border-radius: 4px;">create Category</button>
    </div>

    <!-- Form -->
    <div id="formCard" style="background-color: #f8f9fa; padding: 20px; border-radius: 8px; margin-bottom: 30px; display: none;">
        <form id="categoryForm">
            @csrf
            <div style="display: grid; grid-template-columns: 1fr auto; gap: 15px;">
                <input class="input_style" type="text" name="name" placeholder="Category Name" required>
                <button type="submit" style="padding: 10px; background-color: #007bff; color: white; border: none; border-radius: 4px;">Save</button>
            </div>
        </form>
    </div>

    <!-- Search -->
    <div style="margin-bottom: 15px;">
        <input type="text" id="searchInput" placeholder="Search categories..." style="padding: 8px; width: 300px; border-radius: 4px; border: 1px solid #ccc;">
    </div>

    <!-- Table -->
    <table id="categoryTable" style="width: 100%; border-collapse: collapse; background-color: white;">
        <thead>
            <tr style="background-color: #007bff; color: white;">
                <th style="padding: 10px;">Name</th>
                <th style="padding: 10px;">Actions</th>
            </tr>
        </thead>
        <tbody>

             @foreach($categories as $c)
            <tr data-id="{{ $c->id }}">
                <td style="padding: 10px; border: 1px solid #ccc;">{{ $c->name }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;">
                    <button class="editBtn" style="background-color: #ffc107; color: black; border: none; padding: 5px 10px; border-radius: 4px;">Edit</button>
                    <button class="deleteBtn" style="background-color: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px;">Delete</button>
                </td>
            </tr>
            @endforeach

        </tbody>
    </table>

    <!-- Pagination Placeholder -->
    <div style="margin-top: 20px; text-align: center;">
        <button style="padding: 6px 12px; margin-right: 5px;">Previous</button>
        <button style="padding: 6px 12px;">1</button>
        <button style="padding: 6px 12px; margin-left: 5px;">Next</button>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#addCategoryBtn').on('click', function(){
        $('#formCard').slideToggle();
    });

    $('#categoryForm').on('submit', function(e){
        e.preventDefault();
        $.ajax({
            url: '/categories',
            type: 'POST',
            data: $(this).serialize(),
            success: function(data){
                alert('Category Added');
                location.reload();
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
                alert('Deleted');
                location.reload();
            }
        });
    });

    // Edit
    $('.editBtn').on('click', function(){
        var id = $(this).closest('tr').data('id');
        var newName = prompt("Enter new name:");
        if(newName){
            $.ajax({
                url: '/categories/' + id,
                type: 'PUT',
                data: {_token: '{{ csrf_token() }}', name: newName},
                success: function(){
                    alert('Updated');
                    location.reload();
                }
            });
        }
    });

    // Search
    $('#searchInput').on('keyup', function(){
        var value = $(this).val().toLowerCase();
        $('#categoryTable tbody tr').filter(function(){
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
</script>
@endsection
