<?php

namespace App\Http\Traits;

use App\Exports\ProductsExport;
use App\Models\Product;
use App\Models\ProductSupplier;
use Maatwebsite\Excel\Facades\Excel;

trait ProductTrait
{
    public function getProducts($search = null)
    {
        $product = Product::query();
        if ($search) {
            $searchTerm = $this->normalizeString($search);
            $product->whereRaw('LOWER(name) LIKE ?', ['%' . $searchTerm . '%']);
        }
        return $product;
    }
    public function getProductsFromExport()
    {
        return Product::select(
            'products.id', 'products.code', 'products.name', 'products.description',
            'categories.name as categories_name' ,'units.description as unit_name')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->join('units', 'products.unit_id', '=', 'units.id')
            ->get();
    }
    public function getProduct($product_id)
    {
        return Product::find($product_id);
    }
    public function getSuppliersByProduct($product_id)
    {
        return ProductSupplier::where('product_id', $product_id)->get();
    }
    public function getProductSupplier($product_supplier_id)
    {
        return ProductSupplier::find($product_supplier_id);
    }
    private function normalizeString($string)
    {
        // Convertir a minúsculas
        $string = mb_strtolower($string, 'UTF-8');

        // Eliminar acentos y caracteres especiales
        $string = str_replace(
            ['á', 'é', 'í', 'ó', 'ú', 'ü', 'ñ', 'à', 'è', 'ì', 'ò', 'ù'],
            ['a', 'e', 'i', 'o', 'u', 'u', 'n', 'a', 'e', 'i', 'o', 'u'],
            $string
        );

        return trim($string);
    }
    public function exportFileProducts()
    {
        return Excel::download(new ProductsExport, 'productos.xlsx');
    }

}
