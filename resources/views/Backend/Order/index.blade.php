@extends('layouts.masterlayout')

@section('head')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropify/0.2.2/css/dropify.min.css"/>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<style>
    /* Force top bar in one line */
    .top {
        display: flex !important;
        justify-content: space-between;
        align-items: center;
        width: 100%;
    }

    /* Prevent wrapping */
    .dataTables_length,
    .dataTables_filter {
        display: flex !important;
        align-items: center;
        white-space: nowrap;
    }

    /* Remove extra margins */
    .dataTables_filter {
        margin: 0 !important;
    }

    .dataTables_length {
        margin: 0 !important;
    }

    /* Search input clean */
    .dataTables_filter input {
        margin-left: 8px;
    }

    #orderTable thead th {
        background-color: #0d6efd !important;
        color: #fff !important;
    }

    /* Order specific styles */
    .order-id {
        font-weight: 600;
        color: #0d6efd;
    }
    
    .customer-info {
        font-weight: 500;
    }
    
    .badge-order {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-pending {
        background-color: #ffc107;
        color: #212529;
    }
    
    .badge-confirmed {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-delivered {
        background-color: #28a745;
        color: white;
    }
    
    .amount-positive {
        color: #28a745;
        font-weight: bold;
    }
    
    .order-note {
        max-width: 200px;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    /* Filter Styles */
    .filter-card {
        border: 1px solid #dee2e6;
        border-radius: 8px;
        background: #f8f9fa;
        transition: all 0.3s ease;
        margin-bottom: 20px;
    }
    
    .filter-header {
        cursor: pointer;
        padding: 12px 15px;
        background-color: #0d6efd !important;
        color: #fff !important;
        border-radius: 8px 8px 0 0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    
    .filter-body {
        padding: 15px;
    }
    
    .filter-icon {
        transition: transform 0.3s ease;
    }
    
    .filter-icon.rotate {
        transform: rotate(180deg);
    }
    
    .export-section {
        background: #e8f4ff;
        padding: 12px;
        border-radius: 6px;
        border: 1px solid #cce5ff;
        margin-top: 15px;
    }
    
    .export-buttons .btn {
        margin-right: 5px;
        margin-bottom: 5px;
    }
    
    .date-hidden {
        display: none;
    }
    
    /* Total summary card */
    .summary-card {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 20px;
        color: white;
    }
    
    .summary-card h4 {
        margin: 0;
        font-size: 14px;
        opacity: 0.9;
    }
    
    .summary-card h2 {
        margin: 10px 0 0;
        font-size: 28px;
        font-weight: bold;
    }
    
    /* Toast notification styles */
    .toast-notification {
        position: fixed;
        top: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 300px;
        animation: slideIn 0.3s ease-out;
    }
    
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
</style>
@endsection

@section('title', 'Order Management')
@section('content')
<div class="container mt-4">

    {{-- Success/Error Messages --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i>
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- Total Summary Card --}}
    <div class="summary-card">
        <div class="row">
            <div class="col-md-4">
                <h4>Total Orders</h4>
                <h2 id="totalOrders">0</h2>
            </div>
            <div class="col-md-4">
                <h4>Total Revenue</h4>
                <h2 id="totalRevenue">$0.00</h2>
            </div>
            <div class="col-md-4">
                <h4>Delivered Orders</h4>
                <h2 id="deliveredOrders">0</h2>
            </div>
        </div>
    </div>

    {{-- Filters Section --}}
    <div class="card filter-card mb-4">
        <div class="filter-header" id="filterHeader">
            <h5 class="mb-0">
                <i class="bi bi-funnel me-2"></i>Filters & Export Options
            </h5>
            <span class="filter-icon">
                <i class="bi bi-chevron-down"></i>
            </span>
        </div>
        
        <div class="filter-body" id="filterBody">
            <form id="filterForm">
                <div class="row">
                    {{-- Date Range Filter --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">From Date</label>
                        <input type="date" id="fromDate" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">To Date</label>
                        <input type="date" id="toDate" class="form-control">
                    </div>
                    
                    {{-- Status Filter --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Order Status</label>
                        <select id="statusFilter" class="form-control">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="confirmed">Confirmed</option>
                            <option value="delivered">Delivered</option>
                        </select>
                    </div>
                    
                    {{-- Amount Range Filter --}}
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Min Amount</label>
                        <input type="number" id="minAmount" class="form-control" placeholder="Min">
                    </div>
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Max Amount</label>
                        <input type="number" id="maxAmount" class="form-control" placeholder="Max">
                    </div>
                    
                    {{-- Search Filter --}}
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" id="searchFilter" class="form-control" 
                               placeholder="Search by customer name or note...">
                    </div>
                </div>
                
                {{-- Action Buttons --}}
                <div class="row">
                    <div class="col-12 d-flex justify-content-between align-items-center">
                        <div>
                            <button type="button" class="btn btn-primary me-2" id="applyFilters">
                                <i class="bi bi-filter me-1"></i>Apply Filters
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="resetFilters">
                                <i class="bi bi-arrow-clockwise me-1"></i>Reset Filters
                            </button>
                        </div>
                    </div>
                </div>

                {{-- Export Buttons Section --}}
                <div class="export-section">
                    <h6 class="mb-2"><i class="bi bi-download me-1"></i>Export Data</h6>
                    <div class="d-flex flex-wrap">
                        <button type="button" class="btn btn-success btn-sm me-2 mb-2" id="exportExcel">
                            <i class="bi bi-file-earmark-excel me-1"></i>Excel
                        </button>
                        <button type="button" class="btn btn-danger btn-sm me-2 mb-2" id="exportPDF">
                            <i class="bi bi-file-earmark-pdf me-1"></i>PDF
                        </button>
                        <button type="button" class="btn btn-info btn-sm me-2 mb-2" id="printTable">
                            <i class="bi bi-printer me-1"></i>Print
                        </button>
                        <button type="button" class="btn btn-secondary btn-sm mb-2" id="copyTable">
                            <i class="bi bi-clipboard me-1"></i>Copy
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
  
    <div class="d-flex justify-content-between mb-3">
        <h2>Order Management</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addOrderModal">
            <i class="bi bi-plus-circle me-1"></i>Add Order
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="orderTable" class="table table-striped table-hover mb-0">
                <thead>
                    全
                        <th>#</th>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Created At</th>
                        <th width="100">Action</th>
                    </thead>
                <tbody>
                    @forelse($orders ?? [] as $order)
                    运转
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td><span class="order-id">{{ $order->formatted_id ?? '#ORD-' . str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></td>
                        <td><span class="customer-info">{{ $order->customer->name ?? 'N/A' }}</span></td>
                        <td class="text-center">{{ $order->quantity }}</td>
                        <td class="text-end">${{ number_format($order->price, 2) }}</td>
                        <td class="text-end"><span class="amount-positive">${{ number_format($order->total, 2) }}</span></td>
                        <td>
                            @php
                                $statusClass = '';
                                if($order->status == 'pending') $statusClass = 'badge-pending';
                                elseif($order->status == 'confirmed') $statusClass = 'badge-confirmed';
                                elseif($order->status == 'delivered') $statusClass = 'badge-delivered';
                            @endphp
                            <span class="badge-order {{ $statusClass }}">{{ ucfirst($order->status) }}</span>
                        </td>
                        <td class="order-note" title="{{ $order->note }}">
                            @if($order->note)
                                {{ Str::limit($order->note, 50) }}
                            @else
                                <em class="text-muted">No note</em>
                            @endif
                        </td>
                        <td data-order="{{ $order->created_at }}">
                            {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y') }}
                            <span class="date-hidden">{{ $order->created_at }}</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info view-btn"
                                    data-id="{{ $order->id }}"
                                    data-customer_name="{{ $order->customer->name ?? 'N/A' }}"
                                    data-customer_email="{{ $order->customer->email ?? 'N/A' }}"
                                    data-customer_phone="{{ $order->customer->phone ?? 'N/A' }}"
                                    data-quantity="{{ $order->quantity }}"
                                    data-price="{{ $order->price }}"
                                    data-total="{{ $order->total }}"
                                    data-status="{{ $order->status }}"
                                    data-note="{{ htmlspecialchars($order->note, ENT_QUOTES, 'UTF-8') }}"
                                    data-created_at="{{ $order->created_at }}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $order->id }}"
                                    data-customer_id="{{ $order->customer_id }}"
                                    data-quantity="{{ $order->quantity }}"
                                    data-price="{{ $order->price }}"
                                    data-total="{{ $order->total }}"
                                    data-status="{{ $order->status }}"
                                    data-note="{{ htmlspecialchars($order->note, ENT_QUOTES, 'UTF-8') }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-btn"  
                                    data-id="{{ $order->id }}">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="10" class="text-center">No Orders Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Order Modal -->
<div class="modal fade" id="addOrderModal" tabindex="-1" aria-labelledby="addOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('orders.store') }}" method="POST" id="addOrderForm">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add Order</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <!-- Customer -->
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Customer *</label>
                    <select name="customer_id" id="addCustomerId" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers ?? [] as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                        @endforeach
                    </select>
                    @error('customer_id')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Quantity -->
                <div class="col-lg-4 mb-3">
                    <label class="form-label">Quantity *</label>
                    <input type="number" name="quantity" id="addQuantity" class="form-control" value="{{ old('quantity') }}" required min="1"
                           placeholder="Enter quantity">
                    @error('quantity')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Price -->
                <div class="col-lg-4 mb-3">
                    <label class="form-label">Price per Unit *</label>
                    <input type="number" step="0.01" name="price" id="addPrice" class="form-control" value="{{ old('price') }}" required
                           placeholder="Enter price">
                    @error('price')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Total (Auto-calculated) -->
                <div class="col-lg-4 mb-3">
                    <label class="form-label">Total Amount</label>
                    <input type="text" id="addTotal" class="form-control" readonly style="background-color: #e9ecef; font-weight: bold;">
                    <input type="hidden" name="total" id="addTotalHidden">
                </div>

                <!-- Status -->
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Order Status</label>
                    <select name="status" id="addStatus" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="delivered">Delivered</option>
                    </select>
                    @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Note -->
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Note</label>
                    <textarea name="note" id="addNote" class="form-control" rows="3" placeholder="Enter any additional notes">{{ old('note') }}</textarea>
                    @error('note')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Order</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- View Order Modal -->
<div class="modal fade" id="viewOrderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Order Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Order ID:</label>
                        <p id="viewId" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Customer:</label>
                        <p id="viewCustomer" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Email:</label>
                        <p id="viewEmail" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Phone:</label>
                        <p id="viewPhone" class="mb-0"></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Quantity:</label>
                        <p id="viewQuantity" class="mb-0"></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Price per Unit:</label>
                        <p id="viewPrice" class="mb-0"></p>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="fw-bold">Total Amount:</label>
                        <p id="viewTotal" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Status:</label>
                        <p id="viewStatus" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Created Date:</label>
                        <p id="viewCreatedAt" class="mb-0"></p>
                    </div>
                    <div class="col-md-12 mb-3">
                        <label class="fw-bold">Note:</label>
                        <p id="viewNote" class="mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Order Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editOrderForm" action="" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit Order</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Customer *</label>
                    <select name="customer_id" id="editCustomerId" class="form-control" required>
                        <option value="">Select Customer</option>
                        @foreach($customers ?? [] as $customer)
                            <option value="{{ $customer->id }}">{{ $customer->name }} ({{ $customer->email }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-lg-4 mb-3">
                    <label class="form-label">Quantity *</label>
                    <input type="number" name="quantity" id="editQuantity" class="form-control" required min="1">
                </div>

                <div class="col-lg-4 mb-3">
                    <label class="form-label">Price per Unit *</label>
                    <input type="number" step="0.01" name="price" id="editPrice" class="form-control" required>
                </div>

                <div class="col-lg-4 mb-3">
                    <label class="form-label">Total Amount</label>
                    <input type="text" id="editTotal" class="form-control" readonly style="background-color: #e9ecef; font-weight: bold;">
                    <input type="hidden" name="total" id="editTotalHidden">
                </div>

                <div class="col-lg-6 mb-3">
                    <label class="form-label">Order Status</label>
                    <select name="status" id="editStatus" class="form-control">
                        <option value="pending">Pending</option>
                        <option value="confirmed">Confirmed</option>
                        <option value="delivered">Delivered</option>
                    </select>
                </div>

                <div class="col-lg-12 mb-3">
                    <label class="form-label">Note</label>
                    <textarea name="note" id="editNote" class="form-control" rows="3"></textarea>
                </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Order</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- Delete Confirmation Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this order? This action cannot be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    // Calculate total on quantity or price change
    function calculateTotal() {
        var quantity = parseFloat($('#addQuantity').val()) || 0;
        var price = parseFloat($('#addPrice').val()) || 0;
        var total = quantity * price;
        $('#addTotal').val('$' + total.toFixed(2));
        $('#addTotalHidden').val(total.toFixed(2));
    }
    
    $('#addQuantity, #addPrice').on('input', calculateTotal);
    
    // Edit form total calculation
    function calculateEditTotal() {
        var quantity = parseFloat($('#editQuantity').val()) || 0;
        var price = parseFloat($('#editPrice').val()) || 0;
        var total = quantity * price;
        $('#editTotal').val('$' + total.toFixed(2));
        $('#editTotalHidden').val(total.toFixed(2));
    }
    
    $(document).on('input', '#editQuantity, #editPrice', calculateEditTotal);
    
    // Initialize DataTable
    var table = initializeDataTable();
    
    // Handle view button clicks
    $(document).on('click', '.view-btn', function() {
        var id = $(this).data('id');
        var customer_name = $(this).data('customer_name');
        var customer_email = $(this).data('customer_email');
        var customer_phone = $(this).data('customer_phone');
        var quantity = $(this).data('quantity');
        var price = $(this).data('price');
        var total = $(this).data('total');
        var status = $(this).data('status');
        var note = $(this).data('note');
        var created_at = $(this).data('created_at');
        
        openViewModal(id, customer_name, customer_email, customer_phone, quantity, price, total, status, note, created_at);
    });
    
    // Handle edit button clicks
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var customer_id = $(this).data('customer_id');
        var quantity = $(this).data('quantity');
        var price = $(this).data('price');
        var total = $(this).data('total');
        var status = $(this).data('status');
        var note = $(this).data('note');
        
        openEditModal(id, customer_id, quantity, price, total, status, note);
    });
    
    // Handle delete button clicks
    $(document).on('click', '.delete-btn', function() {
        var id = $(this).data('id');
        confirmDelete(id);
    });
    
    // Initialize filters
    initializeFilters();
    
    // Update total summary when filters are applied
    $(document).on('click', '#applyFilters', function() {
        setTimeout(function() {
            updateTotalSummary();
        }, 100);
    });
    
    $(document).on('click', '#resetFilters', function() {
        setTimeout(function() {
            updateTotalSummary();
        }, 100);
    });
    
    // Update total summary on table draw
    $('#orderTable').on('draw.dt', function() {
        updateTotalSummary();
    });
    
    // Initial total summary
    setTimeout(function() {
        updateTotalSummary();
    }, 300);
});

// Function to initialize DataTable
function initializeDataTable() {
    var table = $('#orderTable').DataTable({
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100, "All"],
        dom: '<"top"lf>rt<"bottom"ip><"clear">',
        buttons: [
            {
                extend: 'excel',
                className: 'btn btn-success',
                text: '<i class="bi bi-file-earmark-excel me-1"></i>Excel',
                title: 'Order Management Data',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 4) { // Price column
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 5) { // Total column
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 8) { // Created At column
                                var dateCell = $(node);
                                var dateText = dateCell.find('.date-hidden').text();
                                return dateText || $(data).text().trim();
                            }
                            return $(data).text().trim();
                        }
                    }
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                title: 'Order Management Data',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 4) {
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 5) {
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 8) {
                                var dateCell = $(node);
                                var dateText = dateCell.find('.date-hidden').text();
                                return dateText || $(data).text().trim();
                            }
                            return $(data).text().trim();
                        }
                    }
                }
            },
            {
                extend: 'print',
                className: 'btn btn-info',
                text: '<i class="bi bi-printer me-1"></i>Print',
                title: 'Order Management Data',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 4) {
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 5) {
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 8) {
                                var dateCell = $(node);
                                var dateText = dateCell.find('.date-hidden').text();
                                return dateText || $(data).text().trim();
                            }
                            return $(data).text().trim();
                        }
                    }
                }
            },
            {
                extend: 'copy',
                className: 'btn btn-secondary',
                text: '<i class="bi bi-clipboard me-1"></i>Copy',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5, 6, 7, 8],
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 4) {
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 5) {
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 8) {
                                var dateCell = $(node);
                                var dateText = dateCell.find('.date-hidden').text();
                                return dateText || $(data).text().trim();
                            }
                            return $(data).text().trim();
                        }
                    }
                }
            }
        ],
        columnDefs: [
            { 
                targets: [9], // Action column
                orderable: false,
                searchable: false
            },
            {
                targets: [0], // Serial number column
                orderable: false
            },
            {
                targets: [4, 5], // Price and Total columns
                className: 'text-end'
            },
            {
                targets: [8], // Created At column
                orderData: [8],
                render: function(data, type, row) {
                    if (type === 'sort' || type === 'filter') {
                        var $td = $(row[8]);
                        var dateValue = $td.find('.date-hidden').text();
                        return dateValue || data;
                    }
                    return data;
                }
            }
        ],
        order: [[8, 'desc']],
        language: {
            search: "Search:",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "Showing 0 to 0 of 0 entries",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            }
        }
    });
    
    // Hide default DataTable buttons
    $('.dt-buttons').hide();
    
    // Export Buttons
    $('#exportExcel').click(function() {
        table.button('.buttons-excel').trigger();
    });

    $('#exportPDF').click(function() {
        table.button('.buttons-pdf').trigger();
    });

    $('#printTable').click(function() {
        table.button('.buttons-print').trigger();
    });

    $('#copyTable').click(function() {
        table.button('.buttons-copy').trigger();
    });
    
    return table;
}

// Function to update total summary
function updateTotalSummary() {
    var totalOrders = 0;
    var totalRevenue = 0;
    var deliveredOrders = 0;
    
    // Get all visible rows from the table body
    $('#orderTable tbody tr').each(function() {
        // Check if row is visible
        if ($(this).css('display') !== 'none') {
            totalOrders++;
            
            // Get total amount (6th column index 5)
            var totalCell = $(this).find('td:eq(5)');
            var totalText = totalCell.find('.amount-positive').text().trim();
            if (!totalText) {
                totalText = totalCell.text().trim();
            }
            var total = parseFloat(totalText.replace('$', '').replace(/,/g, ''));
            if (!isNaN(total)) {
                totalRevenue += total;
            }
            
            // Check status (7th column index 6)
            var statusCell = $(this).find('td:eq(6)');
            var statusText = statusCell.find('.badge-order').text().trim().toLowerCase();
            if (statusText === 'delivered') {
                deliveredOrders++;
            }
        }
    });
    
    // Update the summary cards with animation
    $('#totalOrders').fadeOut(200, function() {
        $(this).text(totalOrders).fadeIn(200);
    });
    $('#totalRevenue').fadeOut(200, function() {
        $(this).text('$' + totalRevenue.toFixed(2)).fadeIn(200);
    });
    $('#deliveredOrders').fadeOut(200, function() {
        $(this).text(deliveredOrders).fadeIn(200);
    });
}

// Function to initialize filters
function initializeFilters() {
    // Toggle filter section
    $('#filterHeader').click(function() {
        $('#filterBody').slideToggle();
        $('.filter-icon i').toggleClass('rotate');
    });
    
    // Set default dates (Last 30 days to today)
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $('#toDate').val(today);
    
    var monthAgo = new Date();
    monthAgo.setDate(monthAgo.getDate() - 30);
    var dd2 = String(monthAgo.getDate()).padStart(2, '0');
    var mm2 = String(monthAgo.getMonth() + 1).padStart(2, '0');
    var yyyy2 = monthAgo.getFullYear();
    monthAgo = yyyy2 + '-' + mm2 + '-' + dd2;
    $('#fromDate').val(monthAgo);
    
    // Apply Filters
    $('#applyFilters').click(function() {
        applyFilters();
    });
    
    // Reset Filters
    $('#resetFilters').click(function() {
        resetFilters();
    });
}

// Function to apply filters
function applyFilters() {
    var table = $('#orderTable').DataTable();
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var status = $('#statusFilter').val();
    var minAmount = $('#minAmount').val();
    var maxAmount = $('#maxAmount').val();
    var search = $('#searchFilter').val();
    
    // Clear previous filters
    $.fn.dataTable.ext.search = [];
    
    // Date filter
    if (fromDate || toDate) {
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var row = table.row(dataIndex).node();
                var dateCell = $(row).find('td:eq(8)');
                var dateText = dateCell.find('.date-hidden').text();
                
                if (!dateText) return true;
                
                var rowDate = new Date(dateText);
                
                if (fromDate && toDate) {
                    var from = new Date(fromDate);
                    var to = new Date(toDate);
                    to.setDate(to.getDate() + 1);
                    
                    return rowDate >= from && rowDate <= to;
                } else if (fromDate && !toDate) {
                    var from = new Date(fromDate);
                    return rowDate >= from;
                } else if (!fromDate && toDate) {
                    var to = new Date(toDate);
                    to.setDate(to.getDate() + 1);
                    return rowDate <= to;
                }
                return true;
            }
        );
    }
    
    // Status filter
    if (status) {
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var statusText = data[6].toLowerCase();
                return statusText.includes(status);
            }
        );
    }
    
    // Amount filter
    if (minAmount || maxAmount) {
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var totalText = data[5];
                var total = parseFloat(totalText.replace('$', '').replace(',', ''));
                
                if (isNaN(total)) return true;
                
                var min = minAmount ? parseFloat(minAmount) : null;
                var max = maxAmount ? parseFloat(maxAmount) : null;
                
                if (min !== null && max !== null) {
                    return total >= min && total <= max;
                } else if (min !== null) {
                    return total >= min;
                } else if (max !== null) {
                    return total <= max;
                }
                return true;
            }
        );
    }
    
    // Search filter
    if (search) {
        table.search(search).draw();
    } else {
        table.search('').draw();
    }
    
    table.draw();
    
    // Update total after filters
    setTimeout(function() {
        updateTotalSummary();
    }, 100);
}

// Function to reset filters
function resetFilters() {
    var table = $('#orderTable').DataTable();
    $.fn.dataTable.ext.search = [];
    table.search('').draw();
    table.columns().search('').draw();
    $('#fromDate').val('');
    $('#toDate').val('');
    $('#statusFilter').val('');
    $('#minAmount').val('');
    $('#maxAmount').val('');
    $('#searchFilter').val('');
    
    // Reset to default dates
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0');
    var yyyy = today.getFullYear();
    today = yyyy + '-' + mm + '-' + dd;
    $('#toDate').val(today);
    
    var monthAgo = new Date();
    monthAgo.setDate(monthAgo.getDate() - 30);
    var dd2 = String(monthAgo.getDate()).padStart(2, '0');
    var mm2 = String(monthAgo.getMonth() + 1).padStart(2, '0');
    var yyyy2 = monthAgo.getFullYear();
    monthAgo = yyyy2 + '-' + mm2 + '-' + dd2;
    $('#fromDate').val(monthAgo);
    
    // Update total after reset
    setTimeout(function() {
        updateTotalSummary();
    }, 100);
}

// Open View Modal
function openViewModal(id, customer_name, customer_email, customer_phone, quantity, price, total, status, note, created_at) {
    $('#viewId').text('#ORD-' + String(id).padStart(5, '0'));
    $('#viewCustomer').text(customer_name);
    $('#viewEmail').text(customer_email);
    $('#viewPhone').text(customer_phone);
    $('#viewQuantity').text(quantity);
    $('#viewPrice').text('$' + parseFloat(price).toFixed(2));
    $('#viewTotal').text('$' + parseFloat(total).toFixed(2));
    
    var statusClass = '';
    var statusText = '';
    if(status == 'pending') {
        statusClass = 'badge-pending';
        statusText = 'Pending';
    } else if(status == 'confirmed') {
        statusClass = 'badge-confirmed';
        statusText = 'Confirmed';
    } else if(status == 'delivered') {
        statusClass = 'badge-delivered';
        statusText = 'Delivered';
    }
    $('#viewStatus').html('<span class="badge-order ' + statusClass + '">' + statusText + '</span>');
    
    $('#viewCreatedAt').text(new Date(created_at).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }));
    $('#viewNote').text(note || 'No note provided');
    
    var viewModal = new bootstrap.Modal(document.getElementById('viewOrderModal'));
    viewModal.show();
}

// Open Edit Modal
function openEditModal(id, customer_id, quantity, price, total, status, note) {
    var url = '{{ route("orders.update", ":id") }}';
    url = url.replace(':id', id);
    $('#editOrderForm').attr('action', url);
    
    $('#editCustomerId').val(customer_id);
    $('#editQuantity').val(quantity);
    $('#editPrice').val(price);
    $('#editTotal').val('$' + parseFloat(total).toFixed(2));
    $('#editTotalHidden').val(total);
    $('#editStatus').val(status);
    $('#editNote').val(note);
    
    var editModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
    editModal.show();
}

// Confirm delete
function confirmDelete(id) {
    $('#deleteForm').attr('action', '{{ route("orders.destroy", ":id") }}'.replace(':id', id));
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endsection