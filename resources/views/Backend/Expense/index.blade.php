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

    #expenseTable thead th {
        background-color: #0d6efd !important;
        color: #fff !important;
    }

    /* Expense specific styles */
    .amount-column {
        min-width: 150px;
        font-weight: bold;
    }
    
    .amount-positive {
        color: #28a745;
    }
    
    .amount-negative {
        color: #dc3545;
    }
    
    .note-column {
        min-width: 250px;
    }
    
    .note-preview {
        max-height: 80px;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        line-height: 1.4;
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

@section('title', 'Expenses Management')
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
            <div class="col-md-6">
                <h4>Total Expenses</h4>
                <h2 id="totalExpenses">$0.00</h2>
            </div>
            <div class="col-md-6">
                <h4>Number of Transactions</h4>
                <h2 id="transactionCount">0</h2>
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
                    
                    {{-- Amount Range Filter --}}
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Min Amount</label>
                        <input type="number" id="minAmount" class="form-control" placeholder="Min">
                    </div>
                    <div class="col-md-2 mb-3">
                        <label class="form-label">Max Amount</label>
                        <input type="number" id="maxAmount" class="form-control" placeholder="Max">
                    </div>
                    
                    {{-- Search Filter --}}
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Search</label>
                        <input type="text" id="searchFilter" class="form-control" 
                               placeholder="Search in title or note...">
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
        <h2>Expense Management</h2>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addExpenseModal">
            <i class="bi bi-plus-circle me-1"></i>Add Expense
        </button>
    </div>

    <div class="card">
        <div class="card-body">
            <table id="expenseTable" class="table table-striped table-hover mb-0">
                <thead>
                    老了
                        <th>#</th>
                        <th>Title</th>
                        <th>Amount</th>
                        <th>Date</th>
                        <th>Note</th>
                        <th>Created At</th>
                        <th width="100">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expenses ?? [] as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $expense->title }}</td>
                        <td class="amount-column">
                            <span class="amount-positive">${{ number_format($expense->amount, 2) }}</span>
                        </td>
                        <td data-order="{{ $expense->date }}">
                            {{ \Carbon\Carbon::parse($expense->date)->format('d M Y') }}
                            <span class="date-hidden">{{ $expense->date }}</span>
                        </td>
                        <td class="note-column">
                            @if($expense->note)
                                <div class="note-preview" title="{{ strip_tags($expense->note) }}">
                                    {{ Str::limit(strip_tags($expense->note), 100) }}
                                </div>
                            @else
                                <em class="text-muted">No note</em>
                            @endif
                        </td>
                        <td>{{ $expense->created_at->format('d M Y') }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning edit-btn"
                                data-id="{{ $expense->id }}"
                                data-title="{{ htmlspecialchars($expense->title, ENT_QUOTES, 'UTF-8') }}"
                                data-amount="{{ $expense->amount }}"
                                data-date="{{ $expense->date }}"
                                data-note="{{ htmlspecialchars($expense->note, ENT_QUOTES, 'UTF-8') }}">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button type="button" class="btn btn-sm btn-danger delete-btn"  
                                    data-id="{{ $expense->id }}">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No Expenses Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Expense Modal -->
<div class="modal fade" id="addExpenseModal" tabindex="-1" aria-labelledby="addExpenseModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form action="{{ route('expenses.store') }}" method="POST" id="addExpenseForm">
        @csrf
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Add Expense</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <!-- Title -->
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" id="addTitle" class="form-control" value="{{ old('title') }}" required
                           placeholder="Enter expense title">
                    @error('title')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Amount -->
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Amount *</label>
                    <input type="number" step="0.01" name="amount" id="addAmount" class="form-control" value="{{ old('amount') }}" required
                           placeholder="Enter amount">
                    @error('amount')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Date -->
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Date *</label>
                    <input type="date" name="date" id="addDate" class="form-control" value="{{ old('date', date('Y-m-d')) }}" required>
                    @error('date')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <!-- Note -->
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Note</label>
                    <textarea name="note" id="addNote" class="form-control" rows="4" placeholder="Enter any additional notes">{{ old('note') }}</textarea>
                    @error('note')<small class="text-danger">{{ $message }}</small>@enderror
                </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Save Expense</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Edit Expense Modal -->
<div class="modal fade" id="editExpenseModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <form id="editExpenseForm" action="" method="POST">
        @csrf
        @method('PUT')

        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title">Edit Expense</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
            <div class="row">
                <!-- Title -->
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Title *</label>
                    <input type="text" name="title" id="editTitle" class="form-control" required>
                </div>

                <!-- Amount -->
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Amount *</label>
                    <input type="number" step="0.01" name="amount" id="editAmount" class="form-control" required>
                </div>

                <!-- Date -->
                <div class="col-lg-6 mb-3">
                    <label class="form-label">Date *</label>
                    <input type="date" name="date" id="editDate" class="form-control" required>
                </div>

                <!-- Note -->
                <div class="col-lg-12 mb-3">
                    <label class="form-label">Note</label>
                    <textarea name="note" id="editNote" class="form-control" rows="4"></textarea>
                </div>
            </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Update Expense</button>
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
                <p>Are you sure you want to delete this expense? This action cannot be undone.</p>
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
    // Initialize DataTable
    var table = initializeDataTable();
    
    // Set default date to today for add form
    $('#addDate').val(new Date().toISOString().split('T')[0]);
    
    // Handle edit button clicks
    $(document).on('click', '.edit-btn', function() {
        var id = $(this).data('id');
        var title = $(this).data('title');
        var amount = $(this).data('amount');
        var date = $(this).data('date');
        var note = $(this).data('note');
        
        openEditModal(id, title, amount, date, note);
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
    $('#expenseTable').on('draw.dt', function() {
        updateTotalSummary();
    });
    
    // Initial total summary
    setTimeout(function() {
        updateTotalSummary();
    }, 300);
});

// Function to initialize DataTable
function initializeDataTable() {
    var table = $('#expenseTable').DataTable({
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
                title: 'Expenses Management Data',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 2) { // Amount column
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 3) { // Date column
                                var dateCell = $(node);
                                var dateText = dateCell.find('.date-hidden').text();
                                return dateText || $(data).text().trim();
                            }
                            if (column === 4) { // Note column
                                return $(data).text().trim();
                            }
                            return data;
                        }
                    }
                }
            },
            {
                extend: 'pdf',
                className: 'btn btn-danger',
                text: '<i class="bi bi-file-earmark-pdf me-1"></i>PDF',
                title: 'Expenses Management Data',
                orientation: 'landscape',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 2) {
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 3) {
                                var dateCell = $(node);
                                var dateText = dateCell.find('.date-hidden').text();
                                return dateText || $(data).text().trim();
                            }
                            if (column === 4) {
                                return $(data).text().trim();
                            }
                            return data;
                        }
                    }
                }
            },
            {
                extend: 'print',
                className: 'btn btn-info',
                text: '<i class="bi bi-printer me-1"></i>Print',
                title: 'Expenses Management Data',
                exportOptions: {
                    columns: [0, 1, 2, 3, 4, 5],
                    format: {
                        body: function(data, row, column, node) {
                            if (column === 2) {
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 3) {
                                var dateCell = $(node);
                                var dateText = dateCell.find('.date-hidden').text();
                                return dateText || $(data).text().trim();
                            }
                            if (column === 4) {
                                return $(data).text().trim();
                            }
                            return data;
                        }
                    }
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
                            if (column === 2) {
                                return $(data).text().replace('$', '').trim();
                            }
                            if (column === 3) {
                                var dateCell = $(node);
                                var dateText = dateCell.find('.date-hidden').text();
                                return dateText || $(data).text().trim();
                            }
                            if (column === 4) {
                                return $(data).text().trim();
                            }
                            return data;
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
                targets: [2], // Amount column
                className: 'text-end'
            },
            {
                targets: [3], // Date column
                orderData: [3], // Use this column for sorting
                render: function(data, type, row) {
                    if (type === 'sort' || type === 'filter') {
                        var $td = $(row[3]);
                        var dateValue = $td.find('.date-hidden').text();
                        return dateValue || data;
                    }
                    return data;
                }
            }
        ],
        order: [[3, 'desc']],
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
    var total = 0;
    var count = 0;
    
    // Get all visible rows from the table body
    $('#expenseTable tbody tr').each(function() {
        // Check if row is visible
        if ($(this).css('display') !== 'none') {
            var amountCell = $(this).find('td:eq(2)');
            var amountText = amountCell.find('.amount-positive').text().trim();
            
            if (!amountText) {
                amountText = amountCell.text().trim();
            }
            
            var cleanAmount = amountText.replace('$', '').replace(/,/g, '').trim();
            var amount = parseFloat(cleanAmount);
            
            if (!isNaN(amount) && amount > 0) {
                total += amount;
                count++;
            }
        }
    });
    
    // Update the summary cards with animation
    $('#totalExpenses').fadeOut(200, function() {
        $(this).text('$' + total.toFixed(2)).fadeIn(200);
    });
    $('#transactionCount').fadeOut(200, function() {
        $(this).text(count).fadeIn(200);
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
    var table = $('#expenseTable').DataTable();
    var fromDate = $('#fromDate').val();
    var toDate = $('#toDate').val();
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
                var dateCell = $(row).find('td:eq(3)');
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
    
    // Amount filter
    if (minAmount || maxAmount) {
        $.fn.dataTable.ext.search.push(
            function(settings, data, dataIndex) {
                var amountText = data[2];
                var amount = parseFloat(amountText.replace('$', '').replace(',', ''));
                
                if (isNaN(amount)) return true;
                
                var min = minAmount ? parseFloat(minAmount) : null;
                var max = maxAmount ? parseFloat(maxAmount) : null;
                
                if (min !== null && max !== null) {
                    return amount >= min && amount <= max;
                } else if (min !== null) {
                    return amount >= min;
                } else if (max !== null) {
                    return amount <= max;
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
    var table = $('#expenseTable').DataTable();
    $.fn.dataTable.ext.search = [];
    table.search('').draw();
    table.columns().search('').draw();
    $('#fromDate').val('');
    $('#toDate').val('');
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

// Open Edit Modal
function openEditModal(id, title, amount, date, note) {
    var url = '{{ route("expenses.update", ":id") }}';
    url = url.replace(':id', id);
    $('#editExpenseForm').attr('action', url);
    
    $('#editTitle').val(title);
    $('#editAmount').val(amount);
    $('#editDate').val(date);
    $('#editNote').val(note);
    
    var editModal = new bootstrap.Modal(document.getElementById('editExpenseModal'));
    editModal.show();
}

// Confirm delete
function confirmDelete(id) {
    $('#deleteForm').attr('action', '{{ route("expenses.destroy", ":id") }}'.replace(':id', id));
    var deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
@endsection