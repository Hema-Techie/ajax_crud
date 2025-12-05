<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: DejaVu Sans; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
        th { background-color: #007bff; color: white; }
        h2 { text-align: center; margin-bottom: 20px; }
    </style>
</head>
<body>
    <h2>Product List</h2>
    <table>
         <thead>
            <tr style="background-color: #007bff; color: white;">
                <th style="padding: 10px; border: 1px solid #ccc; ">Name</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Qty</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Status</th>
                <th style="padding: 10px; border: 1px solid #ccc;">Category</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $p)
            <tr data-id="{{ $p->id }}" data-name="{{ $p->product_name }}" data-qty="{{ $p->quantity }}" data-status="{{ $p->status }}" data-category="{{ $p->category_id }}">
                <td style="padding: 10px; border: 1px solid #ccc;text-align:center">{{ $p->product_name }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;text-align:center">{{ $p->quantity }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;text-align:center">{{ $p->status }}</td>
                <td style="padding: 10px; border: 1px solid #ccc;text-align:center">{{ $p->category->name }}</td>

            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
