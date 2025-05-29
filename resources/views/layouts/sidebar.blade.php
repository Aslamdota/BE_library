<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ asset('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
        </div>
        <div>
            <h4 class="logo-text">Admin Dashboard</h4>
        </div>
        <div class="toggle-icon ms-auto"><i class='bx bx-arrow-back'></i>
        </div>
     </div>
    <!--navigation-->
    <ul class="metismenu" id="menu">
        
        <li>
            <a href="{{ route('dashboard.admin') }}">
                <div class="parent-icon"><i class='bx bx-home-alt'></i>
                </div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>
       
        <li class="menu-label">Pages</li>
        @if(auth()->user()->role == 'karyawan' || auth()->user()->role == 'admin')
        <li>
            <a href="{{ route('view.peminjaman') }}">
                <div class="parent-icon"><i class='bx bx-bookmark-alt'></i>
                </div>
                <div class="menu-title">Peminjaman</div>
            </a>
        </li>
        <li>
            <a href="{{ url('returns') }}">
                <div class="parent-icon"><i class='bx bx-bookmark-alt'></i>
                </div>
                <div class="menu-title">Pengembalian</div>
            </a>
        </li>
        @endif

        <li>
            <a href="{{ route('view.books') }}">
                <div class="parent-icon"><i class='bx bx-book'></i>
                </div>
                <div class="menu-title">Buku</div>
            </a>
        </li>

        <li>
            <a href="{{ route('view.member') }}">
                <div class="parent-icon"><i class='bx bx-user'></i>
                </div>
                <div class="menu-title">Member</div>
            </a>
        </li>

        <li>
            <a href="{{ route('view.user') }}">
                <div class="parent-icon"><i class='bx bx-user-circle'></i>
                </div>
                <div class="menu-title">User</div>
            </a>
        </li>

        <li class="">
			<a href="javascript:;" class="has-arrow" aria-expanded="false">
						<div class="parent-icon"><i class="bx bx-cart"></i>
						</div>
						<div class="menu-title">Laporan</div>
					</a>
					<ul class="mm-collapse" style="height: 0px;">
						<li> <a href=""><i class="bx bx-radio-circle"></i>Peminjaman</a>
						</li>
						<li> <a href=""><i class="bx bx-radio-circle"></i>Pengembalian</a>
						</li>
						<li> <a href="{{ route('report.fine') }}"><i class="bx bx-radio-circle"></i>Denda</a>
						</li>
					</ul>
		</li>

        
    </ul>
    <!--end navigation-->
</div>
<!--end sidebar wrapper -->