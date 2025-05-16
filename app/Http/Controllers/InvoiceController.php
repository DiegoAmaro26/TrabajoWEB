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

    /**
     * The function `store` creates an invoice, adds products and services to it, calculates the total
     * amount, generates a PDF for the invoice, and then downloads the PDF.
     * 
     * @param Request request The `store` function you provided is responsible for storing a new
     * invoice based on the data received in the request. Let's break down the process:
     * 
     * @return The code is returning a PDF file for download. The PDF is generated using the data from
     * the newly created invoice and a view file named 'billing.pdf'. The PDF file is named 'factura_'
     * followed by the invoice ID and has the content related to the invoice details.
     */
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

    /**
     * The function retrieves a list of invoices with optional filters based on client ID, from date,
     * and to date, and passes the data to the view.
     * 
     * @param Request request The `list` function you provided is used to retrieve a list of invoices
     * based on certain criteria provided in the request. Let's go through the parameters that can be
     * passed in the request:
     * 
     * @return The `list` function returns a view called 'invoices.index' with the variables
     * `` and `` compacted. The `` variable contains a collection of invoices
     * based on the query parameters provided in the request, and the `` variable contains a
     * list of all clients.
     */
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


    /**
     * The function `downloadPdf` generates a PDF invoice for a given Invoice object and downloads it.
     * 
     * @param Invoice invoice The `downloadPdf` function is a method that takes an `Invoice` object as
     * a parameter. The function loads related data such as the client, products, and services
     * associated with the invoice. It then generates a PDF using the `billing.pdf` view and the
     * invoice data. Finally, it downloads
     * 
     * @return The `downloadPdf` function is returning a PDF file for download. The PDF is generated
     * using the `billing.pdf` view with the data from the `` object. The PDF file is then
     * downloaded with the filename "factura_{invoice_id}.pdf".
     */
    public function downloadPdf(Invoice $invoice)
    {
        $invoice->load('client', 'products', 'services');
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('billing.pdf', compact('invoice'));
        return $pdf->download("factura_{$invoice->id}.pdf");
    }
}

