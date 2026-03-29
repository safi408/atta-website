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

    #customerTable thead th {
        background-color: #0d6efd !important;
        color: #fff !important;
    }

    /* Customer specific styles */
    .customer-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background-color: #0d6efd;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 18px;
    }
    
    .customer-name {
        font-weight: 600;
        color: #333;
    }
    
    .badge-customer {
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: 500;
    }
    
    .badge-active {
        background-color: #28a745;
        color: white;
    }
    
    .badge-inactive {
        background-color: #dc3545;
        color: white;
    }
    
    .badge-pending {
        background-color: #ffc107;
        color: #212529;
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
</style>
@endsection

@section('title', 'Customer Management')
@section('content')
<div class="container mt-4">





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
                        <label class="form-label">From Date (Joined)</label>
                        <input type="date" id="fromDate" class="form-control">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">To Date (Joined)</label>
                        <input type="date" id="toDate" class="form-control">
                    </div>
                    
                    {{-- Status Filter --}}
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select id="statusFilter" class="form-control">
                            <option value="">All Status</option>
                            <option value="Active">Active</option>
                            <option value="Inactive">Inactive</option>
                            <option value="Pending">Pending</option>
                        </select>
                    </div>
                    
                    {{-- Search Filter --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" id="searchFilter" class="form-control" 
                               placeholder="Search by name, email or phone...">
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
        <h2>Customer Management</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addCustomerModal">
            <i class="bi bi-plus-circle me-1"></i>Add Customer
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="customerTable" class="table table-striped table-hover mb-0">
                <thead>
                    全
                        <th>#</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Joined Date</th>
                        <th>Status</th>
                        <th width="120">Action</th>
                    </thead>
                <tbody>
                    @forelse($customers ?? [] as $customer)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="customer-avatar me-2">
                                    {{ strtoupper(substr($customer->name, 0, 1)) }}
                                </div>
                                <div>
                                    <div class="customer-name">{{ $customer->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>{{ $customer->email }}</td>
                        <td>{{ $customer->phone }}</td>
                        <td data-order="{{ $customer->joined_date }}">
                            {{ \Carbon\Carbon::parse($customer->joined_date)->format('d M Y') }}
                            <span class="date-hidden">{{ $customer->joined_date }}</span>
                        </td>
                        <td>
                            @php
                                $statusClass = '';
                                if($customer->status == 'Active') $statusClass = 'badge-active';
                                elseif($customer->status == 'Inactive') $statusClass = 'badge-inactive';
                                elseif($customer->status == 'Pending') $statusClass = 'badge-pending';
                            @endphp
                            <span class="badge-customer {{ $statusClass }}">{{ $customer->status ?? 'Pending' }}</span>
                        </td>
                        <td>
                            <button class="btn btn-sm btn-info view-btn"
                                    data-id="{{ $customer->id }}"
                                    data-name="{{ htmlspecialchars($customer->name, ENT_QUOTES, 'UTF-8') }}"
                                    data-email="{{ $customer->email }}"
                                    data-phone="{{ $customer->phone }}"
                                    data-joined_date="{{ $customer->joined_date }}"
                                    data-status="{{ $customer->status }}">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning edit-btn"
                                    data-id="{{ $customer->id }}"
                                    data-name="{{ htmlspecialchars($customer->name, ENT_QUOTES, 'UTF-8') }}"
                                    data-email="{{ $customer->email }}"
                                    data-phone="{{ $customer->phone }}"
                                    data-joined_date="{{ $customer->joined_date }}"
                                    data-status="{{ $customer->status }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-btn"  
                                    data-id="{{ $customer->id }}">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No Customers Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Customer Modal -->
<div class="modal fade" id="addCustomerModal" tabindex="-1" aria-labelledby="addCustomerModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('customers.store') }}" method="POST" id="addCustomerForm">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add Customer</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <!-- Name -->
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" id="addName" class="form-control" value="{{ old('name') }}" required
                           placeholder="Enter customer full name">
                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Email -->
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" id="addEmail" class="form-control" value="{{ old('email') }}" required
                           placeholder="Enter email address">
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Phone -->
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" name="phone" id="addPhone" class="form-control" value="{{ old('phone') }}" required
                           placeholder="Enter phone number">
                    @error('phone')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Joined Date -->
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Joined Date *</label>
                    <input type="date" name="joined_date" id="addJoinedDate" class="form-control" value="{{ old('joined_date', date('Y-m-d')) }}" required>
                    @error('joined_date')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Status -->
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="addStatus" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Pending">Pending</option>
                    </select>
                    @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Customer</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- View Customer Modal -->
<div class="modal fade" id="viewCustomerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">Customer Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12 text-center mb-4">
                        <div class="customer-avatar" style="width: 80px; height: 80px; font-size: 32px; margin: 0 auto;">
                            {{-- Will be filled by JS --}}
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Customer ID:</label>
                        <p id="viewId" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Full Name:</label>
                        <p id="viewName" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Email Address:</label>
                        <p id="viewEmail" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Phone Number:</label>
                        <p id="viewPhone" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Joined Date:</label>
                        <p id="viewJoinedDate" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Status:</label>
                        <p id="viewStatus" class="mb-0"></p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="fw-bold">Member Since:</label>
                        <p id="viewMemberSince" class="mb-0"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit Customer Modal -->
<div class="modal fade" id="editCustomerModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editCustomerForm" action="" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit Customer</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Full Name *</label>
                    <input type="text" name="name" id="editName" class="form-control" required>
                </div>

                <div class="col-lg-6 mb-3">
                    <label class="form-label">Email Address *</label>
                    <input type="email" name="email" id="editEmail" class="form-control" required>
                </div>

                <div class="col-lg-6 mb-3">
                    <label class="form-label">Phone Number *</label>
                    <input type="text" name="phone" id="editPhone" class="form-control" required>
                </div>

                <div class="col-lg-6 mb-3">
                    <label class="form-label">Joined Date *</label>
                    <input type="date" name="joined_date" id="editJoinedDate" class="form-control" required>
                </div>

                <div class="col-lg-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="editStatus" class="form-control">
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>
                        <option value="Pending">Pending</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Customer</button>
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
                <p>Are you sure you want to delete this customer? This action cannot be undone.</p>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>

<script>
$(document).ready(function () {
    // Initialize DataTable with custom export options
    var table = initializeDataTable();
    
    // Set default joined date to today for add form
    $('#addJoinedDate').val(new Date().toISOString().split('T')[0]);
    
    // Handle view button clicks
    $(document).on('click', '.view-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var phone = $(this).data('phone');
        var joined_date = $(this).data('joined_date');
        var status = $(this).data('status');
        
        openViewModal(id, name, email, phone, joined_date, status);
    });
    
    // Handle edit button clicks
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var email = $(this).data('email');
        var phone = $(this).data('phone');
        var joined_date = $(this).data('joined_date');
        var status = $(this).data('status');
        
        openEditModal(id, name, email, phone, joined_date, status);
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
    $('#customerTable').on('draw.dt', function() {
        updateTotalSummary();
    });
    
    // Initial total summary
    setTimeout(function() {
        updateTotalSummary();
    }, 300);
});

// Function to initialize DataTable
function initializeDataTable() {
    // Prepare data for export
    var table = $('#customerTable').DataTable({
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
                title: 'Customer Management Data',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        body: function(data, row, column, node) {
                            // Clean the data to avoid jQuery selector errors
                            var cleanData = '';
                            if (column === 1) { // Customer column with avatar
                                var $row = $(row);
                                // Create a temporary div to safely parse HTML
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.find('.customer-name').text().trim();
                            } else if (column === 4) { // Joined Date column
                                // Safely extract date without jQuery selector issues
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.find('.date-hidden').text().trim() || tempDiv.text().trim();
                            } else {
                                // For other columns, just get the text content
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.text().trim();
                            }
                            // Ensure we return a string, not a jQuery object
                            return String(cleanData);
                        }
                    }
                },
                customize: function(xlsx) {
                    var sheet = xlsx.xl.worksheets['sheet1.xml'];
                    $('row c', sheet).attr('s', '25');
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                title: 'Customer Management Data',
                orientation: 'landscape',
                pageSize: 'A4',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        body: function(data, row, column, node) {
                            // Clean the data to avoid jQuery selector errors
                            var cleanData = '';
                            if (column === 1) { // Customer column with avatar
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.find('.customer-name').text().trim();
                            } else if (column === 4) { // Joined Date column
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.find('.date-hidden').text().trim() || tempDiv.text().trim();
                            } else {
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.text().trim();
                            }
                            return String(cleanData);
                        }
                    }
                },
                customize: function(doc) {
                    // Center align content
                    doc.content[0].alignment = 'center';
                    doc.content[0].margin = [0, 0, 0, 10];
                    
                    // Center the table
                    if (doc.content[1]) {
                        doc.content[1].alignment = 'center';
                        doc.content[1].margin = [0, 10, 0, 20];
                        
                        // Style the table header
                        if (doc.content[1].table) {
                            doc.content[1].table.widths = ['auto', 'auto', 'auto', 'auto', 'auto', 'auto'];
                            doc.content[1].layout = {
                                hLineWidth: function(i, node) {
                                    return 0.5;
                                },
                                vLineWidth: function(i, node) {
                                    return 0.5;
                                },
                                hLineColor: function(i, node) {
                                    return '#ddd';
                                },
                                vLineColor: function(i, node) {
                                    return '#ddd';
                                },
                                paddingLeft: function(i, node) {
                                    return 5;
                                },
                                paddingRight: function(i, node) {
                                    return 5;
                                },
                                paddingTop: function(i, node) {
                                    return 5;
                                },
                                paddingBottom: function(i, node) {
                                    return 5;
                                }
                            };
                        }
                    }
                    
                    // Style the title
                    doc.defaultStyle.fontSize = 10;
                    doc.styles.tableHeader.fontSize = 11;
                    doc.styles.tableHeader.fillColor = '#0d6efd';
                    doc.styles.tableHeader.color = '#ffffff';
                    doc.styles.tableHeader.alignment = 'center';
                    doc.styles.title.alignment = 'center';
                    doc.styles.title.fontSize = 16;
                    doc.styles.title.bold = true;
                    doc.styles.title.margin = [0, 0, 0, 20];
                }
            },
            {
                extend: 'print',
                className: 'btn btn-info',
                text: '<i class="bi bi-printer me-1"></i>Print',
                title: 'Customer Management Data',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        body: function(data, row, column, node) {
                            // Clean the data to avoid jQuery selector errors
                            var cleanData = '';
                            if (column === 1) { // Customer column with avatar
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.find('.customer-name').text().trim();
                            } else if (column === 4) { // Joined Date column
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.find('.date-hidden').text().trim() || tempDiv.text().trim();
                            } else {
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.text().trim();
                            }
                            return String(cleanData);
                        }
                    }
                },
                customize: function(win) {
                    // Center the title
                    $(win.document.body).find('h1').css({
                        'text-align': 'center',
                        'margin-bottom': '20px',
                        'color': '#0d6efd'
                    });
                    
                    // Center the table
                    $(win.document.body).find('table').css({
                        'margin': '0 auto',
                        'width': '90%',
                        'border-collapse': 'collapse',
                        'font-size': '12px'
                    });
                    
                    // Style table cells
                    $(win.document.body).find('th, td').css({
                        'padding': '10px',
                        'border': '1px solid #ddd',
                        'text-align': 'center'
                    });
                    
                    // Style table header
                    $(win.document.body).find('th').css({
                        'background-color': '#0d6efd',
                        'color': 'white',
                        'font-weight': 'bold'
                    });
                    
                    // Style alternate rows
                    $(win.document.body).find('tr:nth-child(even)').css('background-color', '#f2f2f2');
                    
                    // Add margin to body
                    $(win.document.body).css({
                        'margin': '40px',
                        'font-family': 'Arial, sans-serif'
                    });
                }
            },
            {
                extend: 'copy',
                className: 'btn btn-secondary',
                text: '<i class="bi bi-clipboard me-1"></i>Copy',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        body: function(data, row, column, node) {
                            // Clean the data to avoid jQuery selector errors
                            var cleanData = '';
                            if (column === 1) { // Customer column with avatar
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.find('.customer-name').text().trim();
                            } else if (column === 4) { // Joined Date column
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.find('.date-hidden').text().trim() || tempDiv.text().trim();
                            } else {
                                var tempDiv = $('<div>').html(data);
                                cleanData = tempDiv.text().trim();
                            }
                            return String(cleanData);
                        }
                    }
                }
            }
        ],
        columnDefs: [
            { 
                targets: [6], // Action column
                orderable: false,
                searchable: false
            },
            {
                targets: [0], // Serial number column
                orderable: false
            },
            {
                targets: [4], // Joined Date column
                orderData: [4],
                render: function(data, type, row) {
                    if (type === 'sort' || type === 'filter') {
                        var $td = $(row[4]);
                        var dateValue = $td.find('.date-hidden').text();
                        return dateValue || data;
                    }
                    return data;
                }
            }
        ],
        order: [[4, 'desc']],
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
    
    // Export Buttons with error handling
    $('#exportExcel').off('click').on('click', function() {
        try {
            table.button('.buttons-excel').trigger();
        } catch(e) {
            console.error('Excel export error:', e);
            alert('Error exporting to Excel. Please try again.');
        }
    });

    $('#exportPDF').off('click').on('click', function() {
        try {
            table.button('.buttons-pdf').trigger();
        } catch(e) {
            console.error('PDF export error:', e);
            alert('Error exporting to PDF. Please try again.');
        }
    });

    $('#printTable').off('click').on('click', function() {
        try {
            table.button('.buttons-print').trigger();
        } catch(e) {
            console.error('Print error:', e);
            alert('Error printing. Please try again.');
        }
    });

    $('#copyTable').off('click').on('click', function() {
        try {
            table.button('.buttons-copy').trigger();
            // Removed the alert message as requested
        } catch(e) {
            console.error('Copy error:', e);
            alert('Error copying to clipboard. Please try again.');
        }
    });
    
    return table;
}

// Function to update total summary
function updateTotalSummary() {
    var totalCustomers = 0;
    var activeCustomers = 0;
    
    // Get all visible rows from the table body
    $('#customerTable tbody tr').each(function() {
        if ($(this).css('display') !== 'none') {
            totalCustomers++;
            
            // Check status
            var statusCell = $(this).find('td:eq(5)');
            var statusText = statusCell.find('.badge-customer').text().trim();
            if (statusText === 'Active') {
                activeCustomers++;
            }
        }
    });
    
    // Update the summary cards with animation
    $('#totalCustomers').fadeOut(200, function() {
        $(this).text(totalCustomers).fadeIn(200);
    });
    $('#activeCustomers').fadeOut(200, function() {
        $(this).text(activeCustomers).fadeIn(200);
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
    var table = $('#customerTable').DataTable();
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
    var status = $('#statusFilter').val();
    var search = $('#searchFilter').val();
    
    // Clear previous filters
    $.fn.dataTable.ext.search = [];
    
    // Date filter
    if (fromDate || toDate) {
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var row = table.row(dataIndex).node();
                var dateCell = $(row).find('td:eq(4)');
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
                var statusText = data[5];
                return statusText.includes(status);
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
    var table = $('#customerTable').DataTable();
    $.fn.dataTable.ext.search = [];
    table.search('').draw();
    table.columns().search('').draw();
    $('#fromDate').val('');
    $('#toDate').val('');
    $('#statusFilter').val('');
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
function openViewModal(id, name, email, phone, joined_date, status) {
    $('#viewId').text('#CUST-' + String(id).padStart(4, '0'));
    $('#viewName').text(name);
    $('#viewEmail').text(email);
    $('#viewPhone').text(phone);
    $('#viewJoinedDate').text(new Date(joined_date).toLocaleDateString('en-GB', { day: 'numeric', month: 'short', year: 'numeric' }));
    
    // Set status with badge
    var statusClass = '';
    if(status == 'Active') statusClass = 'badge-active';
    else if(status == 'Inactive') statusClass = 'badge-inactive';
    else if(status == 'Pending') statusClass = 'badge-pending';
    $('#viewStatus').html('<span class="badge-customer ' + statusClass + '">' + status + '</span>');
    
    // Calculate member since
    var joined = new Date(joined_date);
    var today = new Date();
    var years = today.getFullYear() - joined.getFullYear();
    var months = today.getMonth() - joined.getMonth();
    if (months < 0) {
        years--;
        months += 12;
    }
    var memberSince = years + ' years, ' + months + ' months';
    $('#viewMemberSince').text(memberSince);
    
    // Update avatar
    $('.customer-avatar').text(name.charAt(0).toUpperCase());
    
    var viewModal = new bootstrap.Modal(document.getElementById('viewCustomerModal'));
    viewModal.show();
}

// Open Edit Modal
function openEditModal(id, name, email, phone, joined_date, status) {
    var url = '{{ route("customers.update", ":id") }}';
    url = url.replace(':id', id);
    $('#editCustomerForm').attr('action', url);
    
    $('#editName').val(name);
    $('#editEmail').val(email);
    $('#editPhone').val(phone);
    $('#editJoinedDate').val(joined_date);
    $('#editStatus').val(status);
    
    var editModal = new bootstrap.Modal(document.getElementById('editCustomerModal'));
    editModal.show();
}

// Confirm delete
function confirmDelete(id) {
    $('#deleteForm').attr('action', '{{ route("customers.destroy", ":id") }}'.replace(':id', id));
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endsection