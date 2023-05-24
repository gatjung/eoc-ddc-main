<div class="sidebar">
  <!-- Sidebar user (optional) -->
  <div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
      <img src="{{ asset('bower_components/admin-lte/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
      <a href="#" class="d-block">Alexander Pierce</a>
    </div>
  </div>

  <!-- Sidebar Menu -->
  <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <!-- Add icons to the links using the .nav-icon class
           with font-awesome or any other icon font library -->
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
        <i class="fas fa-tasks"></i>
          <p>
            Task
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
          <li class="nav-item">
            <a href="{{ route('dash') }}" class="nav-link">
              <i class="fas fa-clipboard-check nav-icon"></i>
              <p>แดชบอร์ด</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('timeline') }}" class="nav-link">
              <i class="fas fa-clipboard-check nav-icon"></i>
              <p>timeline</p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{ route('view') }}" class="nav-link">
              <i class="fas fa-clipboard-check nav-icon"></i>
              <p>มอบหมายงาน</p>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              <i class="fas fa-clipboard-check nav-icon"></i>
              {{ __('Logout') }}
            </a>

            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
              @csrf
            </form>
          </li>
          
                                        
          </form>
        </ul>
      </li>
      
    </ul>
  </nav>
  <!-- /.sidebar-menu -->
</div>
