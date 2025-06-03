<!-- need to remove -->
@role('admin', true)
<li class="nav-item">
	<a href="{{ route('home') }}" class="nav-link {{ Request::is('admin/home') ? 'active' : '' }}">
		<i class="nav-icon fas fa-home"></i>
		<p>Dashboard</p>
	</a>
</li>
@endrole
@role('psikolog', true)
<li class="nav-item">
	<a href="{{ url('/admin/home-psikolog') }}" class="nav-link {{ Request::is('admin/home-psikolog*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-home"></i>
		<p>Dashboard Psikolog</p>
	</a>
</li>
@endrole

@role('admin', true)
	<li class="nav-item {{ request()->is('admin/master/*') ? 'menu-open' : '' }}">
		<a href="#" class="nav-link {{ request()->is('admin/master/*') ? 'active' : '' }}">
			<i class="nav-icon fas fa-table"></i>
			<p>
			Master Data
			<i class="fas fa-angle-left right"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<li class="nav-item">
				<a href="{{ route('psikologs.index') }}" class="nav-link {{ Request::is('admin/master/psikologs*') ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Psikolog</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('masyarakats.index') }}" class="nav-link {{ Request::is('admin/master/masyarakats*') ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Masyarakat</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('masalahs.index') }}" class="nav-link {{ Request::is('admin/master/masalahs*') ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Masalah</p>
				</a>
			</li>
			<!-- <li class="nav-item">
				<a href="{{ route('keluhans.index') }}" class="nav-link {{ Request::is('admin/master/keluhans*') ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Keluhan</p>
				</a>
			</li> -->
			<!-- <li class="nav-item">
				<a href="{{ route('konselings.index') }}" class="nav-link {{ Request::is('admin/master/konselings*') ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Konseling</p>
				</a>
			</li> -->
		</ul>
	</li>
@endrole
<li class="nav-header">PENGATURAN</li>
@role('psikolog', true)
	<li class="nav-item">
		<a href="{{ route('jadwals.index') }}" class="nav-link {{ Request::is('admin/jadwals*') ? 'active' : '' }}">
			<i class="nav-icon fas fa-clock"></i>
			<p>Jadwal Psikolog</p>
		</a>
	</li>
@endrole

@role('admin', true)
<li class="nav-item {{ request()->is('admin/data/*') ? 'menu-open' : '' }}">
		<a href="#" class="nav-link {{ request()->is('admin/data/*') ? 'active' : '' }}">
			<i class="nav-icon fas fa-table"></i>
			<p>
			Edukasi & Saran
			<i class="fas fa-angle-left right"></i>
			</p>
		</a>
		<ul class="nav nav-treeview">
			<li class="nav-item">
				<a href="{{ route('blog-kategoris.index') }}" class="nav-link {{ Request::is('admin/data/blog-kategoris*') ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Kategori</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ route('blogs.index') }}" class="nav-link {{ Request::is('admin/data/blogs*') ? 'active' : '' }}">
					<i class="far fa-circle nav-icon"></i>
					<p>Data</p>
				</a>
			</li>
		</ul>
	</li>

<li class="nav-item">
    <a href="{{ route('pengaturans.index') }}" class="nav-link {{ Request::is('admin/pengaturans*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-wrench"></i>
        <p>Konfigurasi & Narasi</p>
    </a>
</li>
<li class="nav-item">
    <a href="{{ route('logs.index') }}" class="nav-link {{ Request::is('admin/logs*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-history"></i>
        <p>Log Aktivitas</p>
    </a>
</li>
@endrole


<!-- <li class="nav-item">
	<a href="{{ route('dassPertanyaans.index') }}" class="nav-link {{ Request::is('dassPertanyaans*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-home"></i>
		<p>Dass Pertanyaans</p>
	</a>
</li>

<li class="nav-item">
	<a href="{{ route('konseling-masalahs.index') }}" class="nav-link {{ Request::is('konseling-masalahs*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-home"></i>
		<p>Konseling Masalahs</p>
	</a>
</li>

<li class="nav-item">
	<a href="{{ route('dasshasils.index') }}" class="nav-link {{ Request::is('dasshasils*') ? 'active' : '' }}">
		<i class="nav-icon fas fa-home"></i>
		<p>Dasshasils</p>
	</a>
</li> -->

<!-- <li class="nav-item">
    <a href="{{ route('evaluasis.index') }}" class="nav-link {{ Request::is('evaluasis*') ? 'active' : '' }}">
        <i class="nav-icon fas fa-home"></i>
        <p>Evaluasis</p>
    </a>
</li> -->