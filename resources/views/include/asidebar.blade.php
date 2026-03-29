<!-- Sidebar -->
<style>
    .logo-text{
    font-size: 20px;
    font-weight: 700;
    color: #0d6efd;            /* apni theme color */
    letter-spacing: 1px;
    margin: 0;
}

/* Add margin-top auto to push logout to bottom */
.nav-section {
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: calc(100vh - 120px);
}

.nav-section .nav-links-wrapper {
    flex: 1;
}

.logout-wrapper {
    margin-top: auto;
    padding-top: 20px;
    border-top: 1px solid #e5e7eb;
}

/* Logout Button Styling */
.logout-btn {
    background: linear-gradient(135deg, #dc2626, #b91c1c);
    color: white !important;
    border-radius: 8px;
    margin: 0 10px;
    transition: all 0.3s ease;
}

.logout-btn:hover {
    background: linear-gradient(135deg, #b91c1c, #991b1b);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
}

.logout-btn i {
    color: white !important;
}

.logout-btn .spanp {
    color: white !important;
}
</style>
{{-- @php
    $setting = \App\Models\HeaderSetting::first();
@endphp --}}
<aside class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ url('/') }}" class="logo d-inline align-items-center justify-content-center text-decoration-none">
    <span class="logo-text">Baraka Atta </span>
</a>

        <button class="sidebar-close" id="sidebarClose">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>
    
    <div class="sidebar-content" id="sidebarContent">
        <nav class="nav-menu" id="navMenu">
            <div class="nav-section">
                <div class="nav-links-wrapper">
                    <!-- Admin Dashboard -->
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                         <i class="bi bi-house-door-fill"></i>
                        <span class="spanp">Dashboard</span>
                    </a>

                    <!-- CMS Management -->
                    {{-- <div class="dropdown {{ request()->routeIs('cms.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-gear"></i>
                            <span>CMS Management</span>
                        </a>
                        <div class="submenu">
                            <!-- Home Page -->
                            <div class="dropdown nested-dropdown {{ request()->routeIs('cms.home.*') ? 'open' : '' }}">
                                <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                    <i class="bi bi-house-door"></i>
                                    <span>Home Page</span>
                                </a>
                                <div class="submenu nested-submenu">
                                    <a href="" class="nav-link {{ request()->routeIs('cms.hero.index') ? 'active' : '' }}">
                                        <i class="bi bi-circle me-2"></i> Hero
                                    </a>
                                     <a href="" class="nav-link {{ request()->routeIs('cms.slider.index') ? 'active' : '' }}">
                                        <i class="bi bi-circle me-2"></i> Sliders
                                    </a>
                                         <a href="" class="nav-link {{ request()->routeIs('cms.achievement.index') ? 'active' : '' }}">
                                        <i class="bi bi-circle me-2"></i> Achievements
                                    </a>
                                    </a>
                                    <a href="" class="nav-link {{ request()->routeIs('cms.faq.index') ? 'active' : '' }}">
                                        <i class="bi bi-circle me-2"></i> Faq
                                    </a>
                                    <a href="" class="nav-link {{ request()->routeIs('cms.testimonial.index') ? 'active' : '' }}">
                                        <i class="bi bi-circle me-2"></i> Testimonials
                                    </a> 
                                 </div>
                            </div> --}}


                               {{-- <a href="{{ route('cms.meta.index') }}" class="nav-link {{ request()->routeIs('cms.meta.index') ? 'active' : '' }}">
                               <i class="bi bi-facebook"></i>
                                <span class="spanp">Meta</span>
                                </a> --}}


                                  <!-- Home Page -->
                            {{-- <div class="dropdown nested-dropdown {{ request()->routeIs('cms.blog.*') ? 'open' : '' }}">
                                <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                    <i class="bi bi-house-door"></i>
                                    <span>Blog page</span>
                                </a>
                                <div class="submenu nested-submenu"> --}}
                                     {{-- <a href="{{route('cms.blog.index')}}" class="nav-link {{ request()->routeIs('cms.blog.index') ? 'active' : '' }}">
                                        <i class="bi bi-circle me-2"></i> Blogs
                                    </a> --}}
                                {{-- </div>
                            </div> --}}


                                     <!-- Home Page -->
                            {{-- <div class="dropdown nested-dropdown {{ request()->routeIs('cms.about.*') ? 'open' : '' }}">
                                <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                                    <i class="bi bi-house-door"></i>
                                    <span>About page</span>
                                </a>
                                <div class="submenu nested-submenu"> --}}
                                     {{-- <a href="{{route('cms.about.edit')}}" class="nav-link {{ request()->routeIs('cms.about.edit') ? 'active' : '' }}">
                                        <i class="bi bi-circle me-2"></i> Banner
                                    </a> --}}
                                {{-- </div>
                            </div> --}}

                          
                        {{-- </div>
                    </div> --}}

                    <!-- Categories -->
                    {{-- <div class="dropdown {{ request()->routeIs('category.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-tags"></i>
                            <span>Categories</span>
                        </a>
                        <div class="submenu nested-submenu">
                            <a href="{{route('category.index')}}" class="nav-link {{ request()->routeIs('category.index') ? 'active' : '' }}">
                                <i class="bi bi-circle me-2"></i> All Categories
                            </a> --}}
                            {{-- Future nested items can be added here --}}
                        {{-- </div>
                    </div> --}}

                    <!-- Courses -->
                    {{-- <div class="dropdown {{ request()->routeIs('subcategory.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-journal-bookmark-fill"></i>
                            <span>Courses</span>
                        </a>
                        <div class="submenu nested-submenu">
                            <a href="" class="nav-link {{ request()->routeIs('subcategory.index') ? 'active' : '' }}">
                                <i class="bi bi-circle me-2"></i> All Courses
                            </a> --}}
                            {{-- Future nested items: Featured Courses, Popular Courses, Pending Courses etc. --}}
                        {{-- </div>
                    </div> --}}


                    <!-- Courses Management -->
    {{-- <div class="dropdown {{ request()->routeIs('category.*') ||  request()->routeIs('subcategory.*') || request()->routeIs('course.*') ? 'open' : '' }} ">
        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
            <i class="bi bi-journal-richtext"></i>
            <span>Course Management</span>
        </a>     --}}
    {{-- 
        <div class="submenu"> --}}
            <!-- Categories -->
            {{-- <a href="{{ route('category.index') }}" class="nav-link  {{ request()->routeIs('category.*') ? 'active' : '' }}">
                 <i class="fa-solid fa-circle" style="font-size: 8px;"></i> Categories
            </a> --}}
            
            <!-- Subcategories -->
            {{-- <a href="{{route('subcategory.index')}}" class="nav-link {{ request()->routeIs('subcategory.*') ? 'active' : '' }}">
                   <i class="fa-solid fa-circle" style="font-size: 8px;"></i> SubCategories
            </a> --}}

            <!-- Courses -->
            {{-- <a href="{{route('course.index')}}" class="nav-link {{ request()->routeIs('course.*') ? 'active' : '' }}">
                 <i class="fa-solid fa-circle" style="font-size: 8px;"></i> Courses
            </a> --}}
        {{-- </div>
    </div> --}}





                    <!-- Students -->
                    {{-- <div class="dropdown {{ request()->routeIs('students.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-people-fill"></i>
                            <span>Students</span>
                        </a>
                        <div class="submenu"> --}}
                        
                           
    {{-- <a href="{{route('cms.hero.edit')}}" class="nav-link {{ request()->routeIs('cms.hero.edit') ? 'active' : '' }}">
        <i class="bi bi-image-fill"></i>
        <span class="spanp">Hero Section</span>
    </a> --}}

    {{-- <a href="{{route('cms.slider.index')}}" class="nav-link {{ request()->routeIs('cms.slider.index') ? 'active' : '' }}">
        <i class="bi bi-sliders"></i>
        <span class="spanp">Slide Section</span>
    </a> --}}

    {{-- <a href="{{route('cms.truth.edit')}}" class="nav-link {{ request()->routeIs('cms.truth.edit') ? 'active' : '' }}">
        <i class="bi bi-patch-check-fill"></i>
        <span class="spanp">Truth Section</span>
    </a> --}}

    {{-- <a href="{{route('cms.problem.index')}}" class="nav-link {{ request()->routeIs('cms.problem.index') ? 'active' : '' }}">
        <i class="bi bi-exclamation-triangle-fill"></i>
        <span class="spanp">Multiples Sections</span>
    </a>

    <a href="{{route('cms.shift.edit')}}" class="nav-link {{ request()->routeIs('cms.shift.edit') ? 'active' : '' }}">
        <i class="bi bi-arrow-left-right"></i>
        <span class="spanp">Shift Section</span>
    </a>

    <a href="{{route('cms.mentorship.edit')}}" class="nav-link {{ request()->routeIs('cms.mentorship.edit') ? 'active' : '' }}">
        <i class="bi bi-person-video3"></i>
        <span class="spanp">MentorShip Section</span>
    </a>

    <a href="{{route('cms.about.edit')}}" class="nav-link {{ request()->routeIs('cms.about.edit') ? 'active' : '' }}">
        <i class="bi bi-person-badge-fill"></i>
        <span class="spanp">About Section</span>
    </a>

    <a href="{{route('cms.learn.index')}}" class="nav-link {{ request()->routeIs('cms.learn.index') ? 'active' : '' }}">
        <i class="bi bi-journal-bookmark-fill"></i>
        <span class="spanp">Learn Cards Section</span>
    </a>

    <a href="{{route('cms.compare.index')}}" class="nav-link {{ request()->routeIs('cms.compare.index') ? 'active' : '' }}">
        <i class="bi bi-bar-chart-fill"></i>
        <span class="spanp">Compare Section</span>
    </a>

    <a href="{{route('cms.timeline.index')}}" class="nav-link {{ request()->routeIs('cms.timeline.index') ? 'active' : '' }}">
        <i class="bi bi-clock-history"></i>
        <span class="spanp">Time line Section</span>
    </a>

    <a href="{{route('cms.next.edit')}}" class="nav-link {{ request()->routeIs('cms.next.edit') ? 'active' : '' }}">
        <i class="bi bi-arrow-right-circle-fill"></i>
        <span class="spanp">Next Step Section</span>
    </a>

    <a href="{{route('cms.testimonial.index')}}" class="nav-link {{ request()->routeIs('cms.testimonial.index') ? 'active' : '' }}">
        <i class="bi bi-chat-left-quote-fill"></i>
        <span class="spanp">Testimonial</span>
    </a>

    <a href="{{route('cms.faq.index')}}" class="nav-link {{ request()->routeIs('cms.faq.index') ? 'active' : '' }}">
        <i class="bi bi-question-circle-fill"></i>
        <span class="spanp">FAQ's</span>
    </a>

    <a href="{{route('cms.setting.index')}}" class="nav-link {{ request()->routeIs('cms.setting.index') ? 'active' : '' }}">
        <i class="bi bi-gear-fill"></i>
        <span class="spanp">Settings</span>
    </a> --}}





                        {{-- </div>
                    </div> --}}

                    <!-- Instructors -->
                    {{-- <div class="dropdown {{ request()->routeIs('instructor.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-person-badge-fill"></i>
                            <span>Instructors</span>
                        </a>
                        <div class="submenu">
                            <a href="" class="{{ request()->routeIs('instructor.index') ? 'active' : '' }}">
                                 <span class="spanp">Instructors</span>
                            </a>
                        </div>
                    </div> --}}


                    <!-- Customers, Orders, Expenses -->
    <div class="dropdown {{ request()->routeIs('customers.*') ? 'open' : '' }}">
        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
            <i class="bi bi-people-fill"></i>
            <span>Customers</span>
        </a>
        <div class="submenu">
            <a href="{{route('customers.index')}}" class="nav-link {{ request()->routeIs('customers.index') ? 'active' : '' }}">
                <i class="bi bi-circle me-2"></i>
                <span class="spanp">All Customers</span>
            </a>
        </div>
    </div>

    <div class="dropdown {{ request()->routeIs('orders.*') ? 'open' : '' }}">
        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
            <i class="bi bi-cart-fill"></i>
            <span>Orders</span>
        </a>
        <div class="submenu">
            <a href="{{route('orders.index')}}" class="nav-link {{ request()->routeIs('orders.index') ? 'active' : '' }}">
                <i class="bi bi-circle me-2"></i>
                <span class="spanp">All Orders</span>
            </a>

       
            <a href="" class="nav-link {{ request()->routeIs('orders.pending') ? 'active' : '' }}">
                <i class="bi bi-circle me-2"></i>
                <span class="spanp">Pending Orders</span>
            </a>
            <a href="" class="nav-link {{ request()->routeIs('orders.completed') ? 'active' : '' }}">
                <i class="bi bi-circle me-2"></i>
                <span class="spanp">Completed Orders</span>
            </a>
        </div>
    </div>

    <div class="dropdown {{ request()->routeIs('expenses.*') ? 'open' : '' }}">
        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
            <i class="bi bi-wallet2"></i>
            <span>Expenses</span>
        </a>
        <div class="submenu">
            <a href="{{route('expenses.index')}}" class="nav-link {{ request()->routeIs('expenses.index') ? 'active' : '' }}">
                <i class="bi bi-circle me-2"></i>
                <span class="spanp">All Expenses</span>
            </a>
        </div>
    </div>

                    <!-- User Management -->
                    {{-- <div class="dropdown {{ request()->routeIs('user.*') || request()->routeIs('role.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-person-gear"></i>
                            <span>User Management</span>
                        </a>
                        <div class="submenu"> 
                            <a href="" class="nav-link {{ request()->routeIs('role.index') ? 'active' : '' }}">
                                <i class="bi bi-circle me-2"></i> Roles
                            </a>
                            <a href="" class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">
                                <i class="bi bi-circle me-2"></i> Users
                            </a> 
                        </div>
                    </div> --}}

                    <!-- Enrollments -->
                    {{-- <div class="dropdown {{ request()->routeIs('enrollments.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-person-plus-fill"></i>
                            <span>Enrollments</span>
                        </a>
                        <div class="submenu">
                            <a href="" class="nav-link {{ request()->routeIs('enrollments.index') ? 'active' : '' }}">
                                <i class="bi bi-circle me-2"></i> All Enrollments
                            </a>
                           
                        </div>
                    </div> --}}

                    <!-- Assignments -->
                    {{-- <div class="dropdown {{ request()->routeIs('assignments.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-file-earmark-text-fill"></i>
                            <span>Assignments</span>
                        </a>
                        <div class="submenu">
                            <a href="" class="{{ request()->routeIs('assignments.index') ? 'active' : '' }}">
                                All Assignments
                            </a>
                        </div>
                    </div> --}}

                    <!-- Exams -->
                    {{-- <div class="dropdown {{ request()->routeIs('exams.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-pencil-square"></i>
                            <span>Exams</span>
                        </a>
                        <div class="submenu">
                            <a href="" class="{{ request()->routeIs('exams.index') ? 'active' : '' }}">
                                All Exams
                            </a>
                        </div>
                    </div> --}}

                    <!-- Reports -->
                    {{-- <div class="dropdown {{ request()->routeIs('reports.*') ? 'open' : '' }}">
                        <a href="javascript:void(0)" class="nav-link dropdown-toggle">
                            <i class="bi bi-bar-chart-fill"></i>
                            <span>Reports</span>
                        </a>
                        <div class="submenu">
                            <a href="" class="nav-link {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                                <i class="bi bi-circle me-2"></i> All Reports
                            </a>
                        </div>
                    </div> --}}

                    <!-- Settings -->
                    {{-- <a href="" class="nav-link {{ request()->routeIs('website.setting') ? 'active' : '' }}">
                        <i class="bi bi-gear-fill"></i>
                        <span class="spanp">Setting</span>
                    </a> --}}
                </div>

                <!-- Logout Button at Bottom with Red Color -->
                <div class="logout-wrapper">
                    <a href="#" class="nav-link logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span class="spanp">Logout</span>
                    </a>
                </div>

                <!-- Hidden Logout Form -->
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

            </div>
        </nav>
    </div>
</aside>