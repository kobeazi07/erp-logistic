  <div class="quixnav">
      <div class="quixnav-scroll">
          <ul class="metismenu" id="menu">
              <li class="nav-label first">Main Menu</li>

              <li><a href="widget-basic.html" aria-expanded="false"><i class="icon icon-globe-2"></i><span
                          class="nav-text">Dashboard</span></a></li>
              <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                          class="icon icon-app-store"></i><span class="nav-text">Master Data</span></a>
                  <ul aria-expanded="false">
                      <li><a href="./app-profile.html">Akun</a></li>
                      <li><a href="{{ Route('HalamanCabang') }}">Cabang</a></li>
                      <li><a href="{{ Route('HalamanVendor') }}">Supplier</a></li>
                      <li><a href="{{ Route('HalamanBrand') }}">Brand</a></li>
                      <li><a href="{{ Route('HalamanUnit') }}">Unit</a></li>
                      <li><a href="{{ Route('HalamanKategori') }} ">Kategori</a></li>
                      <li><a href="{{ Route('HalamanJabatan') }}">Jabatan</a></li>
                      <li><a href="">Item Supplier</a></li>
                      <li><a href="{{ Route('HalamanItem') }}">Item</a></li>
                      <li><a href="{{ Route('HalamanWarehouse') }}">Warehouse</a></li>
                  </ul>
              </li>
              <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                          class="icon icon-chart-bar-33"></i><span class="nav-text">Setting</span></a>
                  <ul aria-expanded="false">
                      <li><a href="{{ Route('HalamanPrefix') }}">Prefix</a></li>
                      <li><a href="{{ Route('HalamanMinStock') }}"> Minimum Stok</a></li>
                      <li><a href="{{ Route('HalamanStockOpname') }}">Stok Opname</a></li>
                      {{-- <li><a href="./chart-chartist.html">Chartist</a></li>
                      <li><a href="./chart-sparkline.html">Sparkline</a></li>
                      <li><a href="./chart-peity.html">Peity</a></li> --}}
                  </ul>
              </li>
              <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                          class="icon icon-chart-bar-33"></i><span class="nav-text">Logistic</span></a>
                  <ul aria-expanded="false">
                      <li><a href="{{ Route('HalamanInternalDelivery') }}">Internal Delivery Note</a></li>

                  </ul>
              </li>
              <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                          class="icon icon-chart-bar-33"></i><span class="nav-text">Charts</span></a>
                  <ul aria-expanded="false">
                      <li><a href="./chart-flot.html">Flot</a></li>
                      <li><a href="./chart-morris.html">Morris</a></li>
                      <li><a href="./chart-chartjs.html">Chartjs</a></li>
                      <li><a href="./chart-chartist.html">Chartist</a></li>
                      <li><a href="./chart-sparkline.html">Sparkline</a></li>
                      <li><a href="./chart-peity.html">Peity</a></li>
                  </ul>
              </li>

          </ul>
      </div>


  </div>
