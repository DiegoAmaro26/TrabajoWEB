<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;


class BillingController extends Controller
{
    public function index()
    {
        // Solo los clientes asociados al hospital del usuario logueado
        $clients = Client::where('hospital_id', Auth::id())->get();

        $products = Product::all();
        $services = Service::all();

        return view('billing.index', compact('clients', 'products', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'billing_date' => 'required|date',
            'total' => 'required|numeric|min:0',
            'payment_method' => 'required|in:efectivo,tarjeta',
            'products' => 'array',
            'products.*.id' => 'exists:products,id',
            'products.*.quantity' => 'integer|min:1',
            'services' => 'array',
            'services.*.id' => 'exists:services,id',
        ]);

        // Crear la factura
        $invoice = Invoice::create([
            'client_id' => $request->client_id,
            'billing_date' => $request->billing_date,
            'total' => $request->total,
            'payment_method' => $request->payment_method,
        ]);

        // Asociar productos con cantidad y precio
        if ($request->has('products')) {
            foreach ($request->products as $productInput) {
                $product = Product::find($productInput['id']);
                $invoice->products()->attach($product->id, [
                    'quantity' => $productInput['quantity'],
                    'price' => $product->price,
                ]);
            }
        }

        // Asociar servicios con precio
        if ($request->has('services')) {
            foreach ($request->services as $serviceInput) {
                $service = Service::find($serviceInput['id']);
                $invoice->services()->attach($service->id, [
                    'price' => $service->price,
                ]);
            }
        }

        // Cargar relaciones necesarias para la vista PDF
        $invoice->load(['client.hospital', 'products', 'services']);

        // Generar PDF desde la vista
        $pdf = Pdf::loadView('invoices.factura', compact('invoice'));

        // Descargar directamente
        return $pdf->download('factura_' . $invoice->id . '.pdf');
        
        // Alternativa: guardar en el servidor
        // $path = storage_path('app/public/facturas/factura_' . $invoice->id . '.pdf');
        // $pdf->save($path);

        return redirect()->route('invoices.index')->with('success', 'Factura generada correctamente.');
    }
}
