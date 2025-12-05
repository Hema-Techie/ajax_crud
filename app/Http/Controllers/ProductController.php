<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
    use App\Models\Product;
    use App\Models\Category;
    use Mpdf\Mpdf;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->get();

        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function store(Request $request)
{
    $data = $request->all();

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('products', $filename, 'public');
        $data['image'] = 'products/' . $filename;
    }

    $product = Product::create($data);
    return response()->json($product);
}
   public function update(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $data = $request->all();

    if ($request->hasFile('image')) {
        $file = $request->file('image');
        $filename = time() . '_' . $file->getClientOriginalName();
        $file->storeAs('products', $filename, 'public');
        $data['image'] = 'products/' . $filename;
    }

    $product->update($data);
    return response()->json($product);
}

    public function destroy($id)
    {
        Product::destroy($id);
        return response()->json(['success' => true]);
    }
    public function productexportPdf()
    {
        $products=Product::all();
        $html = view('products.pdf', compact('products'))->render();
        $mpdf = new Mpdf([
        'default_font' => 'dejavusans',
        'format' => 'A4',
        'margin_top' => 10,
        'margin_bottom' => 10,
    ]);

    $mpdf->SetCompression(true);

    $mpdf->useSubstitutions = false;
    $mpdf->simpleTables = true;
    $mpdf->packTableData = true;
    $mpdf->WriteHTML($html);

    return response($mpdf->Output('', 'S'), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="Products.pdf"');

    }
}
