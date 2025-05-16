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
    /**
     * The index function retrieves clients associated with the logged-in user's hospital, along with
     * all products and services, and passes them to the billing index view.
     * 
     * @return The `index` function is returning a view called 'billing.index' and passing three
     * variables to the view: 'clients', 'products', and 'services'. The 'clients' variable contains a
     * collection of Client models filtered by the hospital_id of the currently authenticated user. The
     * 'products' variable contains all Product models, and the 'services' variable contains all
     * Service models.
     */
    public function index()
    {
        // Solo los clientes asociados al hospital del usuario logueado
        $clients = Client::where('hospital_id', Auth::id())->get();

        $products = Product::all();
        $services = Service::all();

        return view('billing.index', compact('clients', 'products', 'services'));
    }

    /**
     * The function `store` validates and stores invoice data, associates products and services,
     * generates a PDF invoice, and then downloads it.
     * 
     * @param Request request The `store` function you provided is responsible for storing a new
     * invoice based on the data received in the request. Let's break down the process:
     * 
     * @return A PDF file containing the invoice details is being returned for download. The PDF is
     * generated from the 'invoices.factura' view using the data of the created invoice. After the PDF
     * is generated and downloaded, the function does not reach the redirect statement due to the
     * previous return statement.
     */
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
        

        return redirect()->route('invoices.index')->with('success', 'Factura generada correctamente.');
    }
}
