<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class CustomerController extends Controller
{
    //

        /**
     * Display a listing of the customers.
     */
    public function index()
    {
        $customers = Customer::orderBy('joined_date', 'desc')->get();
        return view('Backend.Customer.index', compact('customers'));
    }

    /**
     * Store a newly created customer in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone',
            'joined_date' => 'required|date',
            'status' => 'required|in:Active,Inactive,Pending',
        ], [
            'name.required' => 'Customer name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Phone number is required.',
            'phone.unique' => 'This phone number is already registered.',
            'type.required' => 'Customer type is required.',
            'type.in' => 'Please select a valid customer type.',
            'joined_date.required' => 'Joined date is required.',
            'joined_date.date' => 'Please provide a valid date.',
            'status.required' => 'Status is required.',
            'status.in' => 'Please select a valid status.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Create the customer
        Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type,
            'joined_date' => $request->joined_date,
            'status' => $request->status,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer added successfully!');
    }

    /**
     * Display the specified customer.
     */
    public function show($id)
    {
        $customer = Customer::findOrFail($id);
        
        // Calculate member since
        $joinedDate = \Carbon\Carbon::parse($customer->joined_date);
        $now = \Carbon\Carbon::now();
        $memberSince = $joinedDate->diffForHumans($now, true);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'type' => $customer->type,
                'joined_date' => $customer->joined_date,
                'status' => $customer->status,
                'member_since' => $memberSince,
                'created_at' => $customer->created_at->format('d M Y'),
            ]
        ]);
    }

    /**
     * Update the specified customer in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the customer
        $customer = Customer::findOrFail($id);

        // Validate the request
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email,' . $id . '|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,' . $id,
            'type' => 'required|in:Regular,Premium,VIP',
            'joined_date' => 'required|date',
            'status' => 'required|in:Active,Inactive,Pending',
        ], [
            'name.required' => 'Customer name is required.',
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Phone number is required.',
            'phone.unique' => 'This phone number is already registered.',
            'type.required' => 'Customer type is required.',
            'type.in' => 'Please select a valid customer type.',
            'joined_date.required' => 'Joined date is required.',
            'joined_date.date' => 'Please provide a valid date.',
            'status.required' => 'Status is required.',
            'status.in' => 'Please select a valid status.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Update the customer
        $customer->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->type,
            'joined_date' => $request->joined_date,
            'status' => $request->status,
        ]);

        return redirect()->route('customers.index')
            ->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified customer from storage.
     */
    public function destroy($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->delete();

            return redirect()->route('customers.index')
                ->with('success', 'Customer deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('customers.index')
                ->with('error', 'Failed to delete customer. Please try again.');
        }
    }

    /**
     * Get customers summary (API endpoint for charts/reports)
     */
    public function getSummary(Request $request)
    {
        $query = Customer::query();

        // Apply filters if provided
        if ($request->has('from_date') && $request->from_date) {
            $query->whereDate('joined_date', '>=', $request->from_date);
        }

        if ($request->has('to_date') && $request->to_date) {
            $query->whereDate('joined_date', '<=', $request->to_date);
        }

        if ($request->has('type') && $request->type) {
            $query->where('type', $request->type);
        }

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $total = $query->count();
        $active = $query->where('status', 'Active')->count();
        $premium = $query->whereIn('type', ['Premium', 'VIP'])->count();
        $regular = $query->where('type', 'Regular')->count();
        
        // Get customer growth by month (last 12 months)
        $growth = Customer::selectRaw('DATE_FORMAT(joined_date, "%Y-%m") as month, COUNT(*) as count')
            ->where('joined_date', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'data' => [
                'total' => $total,
                'active' => $active,
                'premium' => $premium,
                'regular' => $regular,
                'growth' => $growth,
            ]
        ]);
    }

    /**
     * Export customers to CSV
     */
    public function export(Request $request)
    {
        $customers = Customer::orderBy('joined_date', 'desc')->get();

        $filename = 'customers_' . date('Y-m-d_H-i-s') . '.csv';
        $handle = fopen('php://output', 'w');

        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Add CSV headers
        fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Type', 'Joined Date', 'Status', 'Created At', 'Updated At']);

        // Add data rows
        foreach ($customers as $customer) {
            fputcsv($handle, [
                $customer->id,
                $customer->name,
                $customer->email,
                $customer->phone,
                $customer->type,
                $customer->joined_date,
                $customer->status,
                $customer->created_at,
                $customer->updated_at,
            ]);
        }

        fclose($handle);
        exit;
    }

    /**
     * Bulk import customers (optional)
     */
    public function import(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|mimes:csv,xlsx,xls',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Process CSV file
        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');
        
        $header = fgetcsv($handle);
        $imported = 0;
        $errors = [];

        while (($data = fgetcsv($handle)) !== FALSE) {
            $row = array_combine($header, $data);
            
            try {
                Customer::create([
                    'name' => $row['name'] ?? '',
                    'email' => $row['email'] ?? '',
                    'phone' => $row['phone'] ?? '',
                    'type' => $row['type'] ?? 'Regular',
                    'joined_date' => $row['joined_date'] ?? date('Y-m-d'),
                    'status' => $row['status'] ?? 'Pending',
                ]);
                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row " . ($imported + 1) . ": " . $e->getMessage();
            }
        }
        
        fclose($handle);

        if (count($errors) > 0) {
            return redirect()->route('customers.index')
                ->with('warning', "Imported $imported customers. " . count($errors) . " errors occurred.")
                ->with('import_errors', $errors);
        }

        return redirect()->route('customers.index')
            ->with('success', "Successfully imported $imported customers!");
    }

}
