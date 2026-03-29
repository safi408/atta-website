<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
    :root {
        --primary: #4f46e5;
        --primary-dark: #4338ca;
        --success: #10b981;
        --warning: #f59e0b;
        --info: #3b82f6;
        --danger: #ef4444;
        --light: #f9fafb;
        --dark: #111827;
        --gray: #6b7280;
        --border: #e5e7eb;
        --card-bg: #ffffff;
    }
    
    .dashboard-container {
        padding: 0px;
        max-width: 1400px;
        margin: 0 auto;
    }
    
    /* Page Header */
    .page-header {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 25px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
    }
    
    .page-title {
        font-size: 24px;
        font-weight: 600;
        color: #111827;
        margin-bottom: 5px;
    }
    
    .page-subtitle {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 0;
    }
    
    /* Stats Cards */
    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 20px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
        height: 100%;
        display: flex;
        align-items: center;
        gap: 15px;
    }
    
    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }
    
    .stat-icon {
        width: 60px;
        height: 60px;
        min-width: 60px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }
    
    .stat-info {
        flex: 1;
    }
    
    .stat-number {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 5px;
        color: #111827;
        line-height: 1;
    }
    
    .stat-label {
        color: #6b7280;
        font-size: 14px;
        margin-bottom: 0;
    }
    
    /* Color variants */
    .stat-card.blue .stat-icon {
        background-color: rgba(59, 130, 246, 0.1);
        color: var(--info);
    }
    
    .stat-card.purple .stat-icon {
        background-color: rgba(139, 92, 246, 0.1);
        color: #8b5cf6;
    }
    
    .stat-card.green .stat-icon {
        background-color: rgba(16, 185, 129, 0.1);
        color: var(--success);
    }
    
    .stat-card.orange .stat-icon {
        background-color: rgba(245, 158, 11, 0.1);
        color: var(--warning);
    }
    
    /* Section Cards */
    .section-card {
        background: white;
        border-radius: 10px;
        padding: 0;
        border: 1px solid #e5e7eb;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 30px;
    }
    
    .section-header {
        padding: 20px 20px;
        background: white;
        border-bottom: 1px solid #e5e7eb;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #111827;
        margin: 0;
    }
    
    .section-title i {
        margin-right: 10px;
        color: var(--primary);
    }
    
    .btn-action {
        background: var(--primary);
        color: white;
        border: none;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-action:hover {
        background: var(--primary-dark);
        transform: translateY(-1px);
    }
    
    .btn-outline-action {
        background: transparent;
        border: 1px solid #d1d5db;
        color: #374151;
        padding: 8px 16px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.2s;
    }
    
    .btn-outline-action:hover {
        border-color: var(--primary);
        color: var(--primary);
    }
    
    /* Chart Container - Fixed Height */
    .chart-wrapper {
        position: relative;
        height: 280px;
        width: 100%;
    }
    
    /* Table Styles */
    .table-custom {
        margin: 0;
    }
    
    .table-custom thead {
        background: #f9fafb;
    }
    
    .table-custom th {
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
        padding: 12px 16px;
        font-size: 14px;
    }
    
    .table-custom td {
        padding: 12px 16px;
        vertical-align: middle;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .table-custom tbody tr:hover {
        background-color: #f9fafb;
    }
    
    /* Status Badges */
    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }
    
    .badge-success {
        background-color: rgba(16, 185, 129, 0.1);
        color: #065f46;
    }
    
    .badge-warning {
        background-color: rgba(245, 158, 11, 0.1);
        color: #92400e;
    }
    
    .badge-danger {
        background-color: rgba(239, 68, 68, 0.1);
        color: #991b1b;
    }
    
    .badge-info {
        background-color: rgba(59, 130, 246, 0.1);
        color: #1e40af;
    }
    
    .avatar-sm {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        object-fit: cover;
        border: 1px solid #e5e7eb;
    }
    
    .view-link {
        color: var(--primary);
        text-decoration: none;
        font-size: 13px;
        font-weight: 500;
    }
    
    .view-link:hover {
        text-decoration: underline;
    }
    
    /* Animation */
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    .fade-in {
        animation: fadeIn 0.5s ease;
    }
    
    /* Responsive */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 15px;
        }
        
        .page-header {
            padding: 15px;
        }
        
        .stat-card {
            padding: 15px;
        }
        
        .stat-icon {
            width: 50px;
            height: 50px;
            min-width: 50px;
            font-size: 20px;
        }
        
        .stat-number {
            font-size: 24px;
        }
        
        .section-header {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .table-responsive {
            font-size: 14px;
        }
        
        .table-custom th,
        .table-custom td {
            padding: 8px 12px;
        }
        
        .chart-wrapper {
            height: 220px;
        }
    }
</style>

@extends('layouts.masterlayout')
@section('title', 'Dashboard | Barakah Atta')
@section('content')
<div class="dashboard-container">
    <!-- Page Header -->
    <div class="page-header fade-in">
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">
            Welcome back, {{ auth()->user()->name ?? 'Admin' }}! Here's your business overview.
        </p>
    </div>

    <!-- Stats Cards -->
    <div class="row g-3 mb-4">
        <!-- Total Customers -->
        <div class="col-md-6 col-lg-3 fade-in">
            <div class="stat-card blue">
                <div class="stat-icon">
                    <i class="bi bi-people-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">1,284</div>
                    <p class="stat-label">Total Customers</p>
                </div>
            </div>
        </div>
        
        <!-- Total Orders -->
        <div class="col-md-6 col-lg-3 fade-in" style="animation-delay: 0.1s">
            <div class="stat-card purple">
                <div class="stat-icon">
                    <i class="bi bi-cart-fill"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">856</div>
                    <p class="stat-label">Total Orders</p>
                </div>
            </div>
        </div>
        
        <!-- Total Revenue -->
        <div class="col-md-6 col-lg-3 fade-in" style="animation-delay: 0.2s">
            <div class="stat-card green">
                <div class="stat-icon">
                    <i class="bi bi-currency-rupee"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">₨ 342,500</div>
                    <p class="stat-label">Total Revenue</p>
                </div>
            </div>
        </div>
        
        <!-- Total Expenses -->
        <div class="col-md-6 col-lg-3 fade-in" style="animation-delay: 0.3s">
            <div class="stat-card orange">
                <div class="stat-icon">
                    <i class="bi bi-wallet2"></i>
                </div>
                <div class="stat-info">
                    <div class="stat-number">₨ 87,700</div>
                    <p class="stat-label">Total Expenses</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row - Fixed Height -->
    <div class="row g-3 mb-4">
        <div class="col-lg-8 fade-in">
            <div class="section-card" style="padding: 20px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="section-title" style="margin: 0;">Order Trends (Last 6 Months)</h3>
                </div>
                <div class="chart-wrapper">
                    <canvas id="orderChart"></canvas>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 fade-in" style="animation-delay: 0.1s">
            <div class="section-card" style="padding: 20px;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h3 class="section-title" style="margin: 0;">Revenue Distribution</h3>
                </div>
                <div class="chart-wrapper">
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- CUSTOMERS SECTION -->
    <div class="section-card fade-in" style="animation-delay: 0.2s">
        <div class="section-header">
            <h4 class="section-title">
                <i class="bi bi-people-fill"></i> Customers Management
            </h4>
            <div>
                <button class="btn-outline-action me-2"><i class="bi bi-download"></i> Export</button>
                <button class="btn-action"><i class="bi bi-plus-lg"></i> Add New Customer</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Total Orders</th>
                        <th>Total Spent</th>
                        <th>Joined Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </thead>
                <tbody>
                    68d
                        <td>#CUST-001</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://randomuser.me/api/portraits/women/68.jpg" class="avatar-sm">
                                <div>
                                    <strong>Ayesha Khan</strong>
                                    <div class="small text-muted">Lahore</div>
                                </div>
                            </div>
                        </td>
                        <td>ayesha.khan@email.com</td>
                        <td>+92 300 1234567</td>
                        <td>12</td>
                        <td>₨ 28,500</td>
                        <td>Jan 15, 2025</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td><a href="#" class="view-link">View <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                    <tr>
                        <td>#CUST-002</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://randomuser.me/api/portraits/men/32.jpg" class="avatar-sm">
                                <div>
                                    <strong>Imran Ali</strong>
                                    <div class="small text-muted">Karachi</div>
                                </div>
                            </div>
                        </td>
                        <td>imran.ali@email.com</td>
                        <td>+92 321 9876543</td>
                        <td>8</td>
                        <td>₨ 18,200</td>
                        <td>Feb 03, 2025</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td><a href="#" class="view-link">View <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                    <tr>
                        <td>#CUST-003</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://randomuser.me/api/portraits/women/45.jpg" class="avatar-sm">
                                <div>
                                    <strong>Fatima Rizvi</strong>
                                    <div class="small text-muted">Islamabad</div>
                                </div>
                            </div>
                        </td>
                        <td>fatima.rizvi@email.com</td>
                        <td>+92 334 5566778</td>
                        <td>15</td>
                        <td>₨ 32,800</td>
                        <td>Dec 20, 2024</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td><a href="#" class="view-link">View <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                    <tr>
                        <td>#CUST-004</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="https://randomuser.me/api/portraits/men/45.jpg" class="avatar-sm">
                                <div>
                                    <strong>Bilal Ahmed</strong>
                                    <div class="small text-muted">Rawalpindi</div>
                                </div>
                            </div>
                        </td>
                        <td>bilal.ahmed@email.com</td>
                        <td>+92 312 4455667</td>
                        <td>5</td>
                        <td>₨ 9,500</td>
                        <td>Mar 10, 2025</td>
                        <td><span class="badge badge-success">Active</span></td>
                        <td><a href="#" class="view-link">View <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top text-center">
            <a href="#" class="view-link">View All Customers <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>

    <!-- ORDERS SECTION -->
    <div class="section-card fade-in" style="animation-delay: 0.3s">
        <div class="section-header">
            <h4 class="section-title">
                <i class="bi bi-cart-fill"></i> Orders Management
            </h4>
            <div>
                <button class="btn-outline-action me-2"><i class="bi bi-funnel"></i> Filter</button>
                <button class="btn-action"><i class="bi bi-plus-lg"></i> New Order</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Products</th>
                        <th>Quantity</th>
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Order Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>#ORD-001</strong></td>
                        <td>Ayesha Khan</td>
                        <td>Gluten-Free Atta (5kg)</td>
                        <td>2</td>
                        <td>₨ 4,000</td>
                        <td>Cash on Delivery</td>
                        <td><span class="badge badge-success">Delivered</span></td>
                        <td>2025-03-28</td>
                        <td><a href="#" class="view-link">Details <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                    <tr>
                        <td><strong>#ORD-002</strong></td>
                        <td>Imran Ali</td>
                        <td>Multigrain Atta (2kg)</td>
                        <td>3</td>
                        <td>₨ 2,550</td>
                        <td>Cash on Delivery</td>
                        <td><span class="badge badge-success">Delivered</span></td>
                        <td>2025-03-27</td>
                        <td><a href="#" class="view-link">Details <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                    <tr>
                        <td><strong>#ORD-003</strong></td>
                        <td>Fatima Rizvi</td>
                        <td>Gluten-Free Atta (1kg)</td>
                        <td>5</td>
                        <td>₨ 2,250</td>
                        <td>Online Payment</td>
                        <td><span class="badge badge-warning">Processing</span></td>
                        <td>2025-03-27</td>
                        <td><a href="#" class="view-link">Details <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                    <tr>
                        <td><strong>#ORD-004</strong></td>
                        <td>Bilal Ahmed</td>
                        <td>Family Pack (5kg)</td>
                        <td>1</td>
                        <td>₨ 2,000</td>
                        <td>Cash on Delivery</td>
                        <td><span class="badge badge-success">Delivered</span></td>
                        <td>2025-03-26</td>
                        <td><a href="#" class="view-link">Details <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                    <tr>
                        <td><strong>#ORD-005</strong></td>
                        <td>Sana Malik</td>
                        <td>Multigrain Atta (1kg)</td>
                        <td>2</td>
                        <td>₨ 900</td>
                        <td>Cash on Delivery</td>
                        <td><span class="badge badge-danger">Cancelled</span></td>
                        <td>2025-03-25</td>
                        <td><a href="#" class="view-link">Details <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top text-center">
            <a href="#" class="view-link">View All Orders <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>

    <!-- EXPENSES SECTION -->
    <div class="section-card fade-in" style="animation-delay: 0.4s">
        <div class="section-header">
            <h4 class="section-title">
                <i class="bi bi-wallet2"></i> Expenses Management
            </h4>
            <div>
                <button class="btn-outline-action me-2"><i class="bi bi-calendar3"></i> Filter by Date</button>
                <button class="btn-action"><i class="bi bi-plus-lg"></i> Add Expense</button>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table table-custom">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Category</th>
                        <th>Payment Method</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                         $expenses = \App\Models\Expense::orderBy('date', 'desc')->get();
                    @endphp
                    @foreach ($expenses as $key => $expense)
                        <tr>
                        <td>#EXP-{{$key+1}}</td>
                        <td>2025-03-28</td>
                        <td>Flour Packaging Material</td>
                        <td><span class="badge badge-info">Supplies</span></td>
                        <td>Bank Transfer</td>
                        <td><strong>₨ {{$expense->amount}}</strong></td>
                        <td><span class="badge badge-success">Paid</span></td>
                        <td><a href="#" class="view-link">View <i class="bi bi-chevron-right"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-3 border-top text-center">
            <a href="#" class="view-link">View All Expenses <i class="bi bi-arrow-right"></i></a>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Order Chart
    const orderCtx = document.getElementById('orderChart').getContext('2d');
    new Chart(orderCtx, {
        type: 'line',
        data: {
            labels: ['Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Mar'],
            datasets: [{
                label: 'Orders',
                data: [120, 145, 168, 210, 245, 286],
                borderColor: '#4f46e5',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#4f46e5',
                pointBorderColor: '#fff',
                pointRadius: 4,
                pointHoverRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10
                    }
                },
                tooltip: {
                    backgroundColor: 'white',
                    titleColor: '#111827',
                    bodyColor: '#374151',
                    borderColor: '#e5e7eb',
                    borderWidth: 1
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e5e7eb',
                        drawBorder: false
                    },
                    ticks: {
                        color: '#6b7280',
                        stepSize: 50
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6b7280'
                    }
                }
            }
        }
    });
    
    // Revenue Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'doughnut',
        data: {
            labels: ['Online Orders', 'Cash on Delivery', 'Wholesale'],
            datasets: [{
                data: [45, 35, 20],
                backgroundColor: ['#4f46e5', '#10b981', '#f59e0b'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '65%',
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        boxWidth: 10,
                        padding: 15
                    }
                },
                tooltip: {
                    backgroundColor: 'white',
                    titleColor: '#111827',
                    bodyColor: '#374151',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    callbacks: {
                        label: function(context) {
                            let label = context.label || '';
                            let value = context.raw || 0;
                            return `${label}: ${value}%`;
                        }
                    }
                }
            }
        }
    });
});
</script>

@endsection