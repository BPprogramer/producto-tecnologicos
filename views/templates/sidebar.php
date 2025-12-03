<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->

  <a href="/inicio" class="brand-link">
    <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">PRODUCTOSTECN</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Buscar" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>


    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="/inicio" class="nav-link <?php echo pagina_actual('/inicio') ? 'active' : '' ?>">
            <i class="nav-icon fas fa-home"></i>
            <p>
              Inicio

            </p>
          </a>
        </li>


        <!--  ventas-->


        <li class="nav-item">
          <a href="" class="nav-link <?php echo pagina_actual('venta') ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-cart-shopping"></i>
            <p>
              Ventas
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/crear-venta" class="nav-link <?php echo pagina_actual('crear-venta') ? 'active' : '' ?>" style="<?php echo pagina_actual('crear-venta') ? 'background-color:white !important;' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Crear Venta</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/ventas" class="nav-link <?php echo $_SERVER['REQUEST_URI'] == "/ventas" ? 'active' : '' ?>" style="<?php echo  $_SERVER['REQUEST_URI'] == "/ventas"  ? 'background-color:white !important;' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Administrar Ventas</p>
              </a>
            </li>

            <?php if ($_SESSION['roll'] == 1) { ?>
              <li class="nav-item">
                <a href="/reporte-ventas" class="nav-link <?php echo $_SERVER['REQUEST_URI'] == "/reporte-ventas" ? 'active' : '' ?>" style="<?php echo  $_SERVER['REQUEST_URI'] == "/reporte-ventas"  ? 'background-color:white !important;' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Reporte de Ventas</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="/productos-ventas" class="nav-link <?php echo $_SERVER['REQUEST_URI'] == "/productos-ventas" ? 'active' : '' ?>" style="<?php echo  $_SERVER['REQUEST_URI'] == "/productos-ventas"  ? 'background-color:white !important;' : '' ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Productos Vendidos</p>
                </a>
              </li>

            <?php  } ?>

          </ul>
        </li>
  

        <li class="nav-item">
          <a href="" class="nav-link <?php echo (pagina_actual('fiados') || pagina_actual('fiados')) ? 'active' : ''; ?>
">
            <i class="nav-icon fas fa-hand-holding-usd"></i>
            <p>
              Fiados
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>

          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/fiados" class="nav-link <?php echo pagina_actual('/fiados') ? 'active' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>
                  Fiados
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/pagos" class="nav-link <?php echo pagina_actual('pagos') ? 'active' : '' ?>" style="<?php echo pagina_actual('pagos') ? 'background-color:white !important;' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Pagos</p>
              </a>
            </li>


          </ul>
        </li>


        <li class="nav-item">
          <a href="/cajas" class="nav-link <?php echo pagina_actual('/cajas') ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-cash-register"></i>
            <p>
              Cajas

            </p>
          </a>
        </li>
        <?php if ($_SESSION['roll'] == 1) { ?>
          <li class="nav-item">
            <a href="/productos" class="nav-link <?php echo $_SERVER['REQUEST_URI'] == "/productos" ? 'active' : '' ?>">
              <i class="nav-icon fa-brands fa-product-hunt"></i>
              <p>
                Productos

              </p>
            </a>
          </li>
        <?php } ?>
        <li class="nav-item">
          <a href="/compras" class="nav-link <?php echo pagina_actual('/compras') ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-bag-shopping"></i>
            <p>
              Avastesimiento

            </p>
          </a>
        </li>



        <li class="nav-item">
          <a href="" class="nav-link <?php echo (pagina_actual('ingreso') || pagina_actual('egreso')) ? 'active' : ''; ?>
">
            <i class="nav-icon fa-solid fa-exchange-alt"></i>
            <p>
              Transacciones
              <i class="fas fa-angle-left right"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="/ingresos" class="nav-link <?php echo pagina_actual('ingreso') ? 'active' : '' ?>" style="<?php echo pagina_actual('ingreso') ? 'background-color:white !important;' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Ingresos</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="/egresos" class="nav-link <?php echo pagina_actual('egreso') ? 'active' : '' ?>" style="<?php echo pagina_actual('egreso') ? 'background-color:white !important;' : '' ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Egresos</p>
              </a>
            </li>


          </ul>
        </li>

        <li class="nav-item">
          <a href="/clientes" class="nav-link <?php echo pagina_actual('/clientes') ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-people-arrows"></i>
            <p>
              Clientes

            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="/proveedores" class="nav-link <?php echo pagina_actual('/proveedores') ? 'active' : '' ?>">
            <i class="nav-icon fa-solid fa-truck"></i>
            <p>
              Proveedores

            </p>
          </a>
        </li>


        <?php if ($_SESSION['roll'] == 1) { ?>
          <li class="nav-item">
            <a href="/usuarios" class="nav-link <?php echo pagina_actual('/usuarios') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Usuarios

              </p>
            </a>
          </li>


          <li class="nav-item">
            <a href="/categorias" class="nav-link <?php echo pagina_actual('/categorias') ? 'active' : '' ?>">
              <i class="nav-icon fas fa-th"></i>
              <p>
                Categorias

              </p>
            </a>
          </li>
        <?php } ?>


      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>