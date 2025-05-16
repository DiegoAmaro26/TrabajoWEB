<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Client;
use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function index()
    {
        $clients = Client::all();
        $products = Product::all();
        $services = Service::all();
        return view('billing.index', compact('clients', 'products', 'services'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'billing_date' => 'required|date',
            'payment_method' => 'required|in:efectivo,tarjeta',
        ]);

        $invoice = Invoice::create([
            'client_id' => $request->client_id,
            'billing_date' => $request->billing_date,
            'payment_method' => $request->payment_method,
            'total' => 0,
        ]);

        $total = 0;

        // Agregar productos
        foreach ($request->products ?? [] as $productData) {
            $product = Product::find($productData['id']);
            $quantity = $productData['quantity'];
            $price = $product->price;

            $invoice->products()->attach($product->id, [
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $product->decrement('stock', $quantity); // descontar del stock
            $total += $price * $quantity;
        }

        // Agregar servicios
        foreach ($request->services ?? [] as $serviceData) {
            $service = Service::find($serviceData['id']);
            $price = $service->price;

            $invoice->services()->attach($service->id, [
                'price' => $price,
            ]);

            $total += $price;
        }

        $invoice->update(['total' => $total]);

        // Generar PDF
        $pdf = Pdf::loadView('billing.pdf', compact('invoice'));
        return $pdf->download('factura_' . $invoice->id . '.pdf');
    }

    public function list(Request $request)
    {
        $clients = \App\Models\Client::all();

        $query = \App\Models\Invoice::with('client');

        if ($request->filled('client_id')) {
            $query->where('client_id', $request->client_id);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('billing_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('billing_date', '<=', $request->to_date);
        }

        $invoices = $query->latest()->get();

        return view('invoices.index', compact('invoices', 'clients'));
    }


    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('client', 'products', 'services');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('billing.pdf', compact('invoice'));
        return $pdf->download("factura_{$invoice->id}.pdf");
    }
}

