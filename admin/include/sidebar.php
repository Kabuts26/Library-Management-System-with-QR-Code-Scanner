 <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="home.php">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Admin</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Nav Item - Users -->

            <!-- Nav Item - Borrowed Books -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="library.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Library</span>
                </a>
            </li>

            <!-- Nav Item - Books -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="book.php" >
                    <i class="fas fa-fw fa-book"></i>
                    <span>Manage Books</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="#"><i class="fas fa-fw fa-book"></i><span> Borrow/Pending Books</span>  </a>
                <ul class="submenu collapse navbar-nav accordion" id="accordionSidebar">
                    <li class="nav-item"><a class="nav-link nav-link collapsed" href="pending.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Pending Books</span></a></li>
                    
                    <li class="nav-item"><a class="nav-link nav-link collapsed" href="borrowed_book.php">
                    <i class="fas fa-fw fa-book"></i>
                    <span>Borrowed Books</span></a></li>
                </ul>
            </li>


            <!-- Nav Item - Books -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="category.php" >
                    <i class="fas fa-fw fa-list"></i>
                    <span>Book Categories</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">


            <li class="nav-item">
                <a class="nav-link collapsed" href="report.php" >
                    <i class="fas fa-fw fa-clipboard"></i>
                    <span>Report</span>
                </a>
            </li>

            <!-- Nav Item - Returned Books -->
            <li class="nav-item">
                <a class="nav-link" href="user.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Users</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="setting.php" >
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <script>
            document.addEventListener("DOMContentLoaded", function(){
  document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
    
    element.addEventListener('click', function (e) {

      let nextEl = element.nextElementSibling;
      let parentEl  = element.parentElement;    

        if(nextEl) {
            e.preventDefault(); 
            let mycollapse = new bootstrap.Collapse(nextEl);
            
            if(nextEl.classList.contains('show')){
              mycollapse.hide();
            } else {
                mycollapse.show();
                // find other submenus with class=show
                var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                // if it exists, then close all of them
                if(opened_submenu){
                  new bootstrap.Collapse(opened_submenu);
                }
            }
        }
    }); // addEventListener
  }) // forEach
}); 
// DOMContentLoaded  end
        </script>