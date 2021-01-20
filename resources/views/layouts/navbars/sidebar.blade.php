<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{ asset('material') }}/img/sidebar-1.jpg">
	<div class="logo">
		<div class="site-changer-container">
			<img src="storage/form/assets/img/logo.png" style="width:100%;">
		</div>
	</div>
	<div class="sidebar-wrapper">
		<ul class="nav">
			<li class="nav-item">
				<a class="nav-link" href="admin/home">
					<i class="material-icons">dashboard</i>
					<p>Panel Anasayfa</p>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" data-toggle="collapse" href="#kullanicilar" aria-expanded="false">
					<i class="fas fa-users"></i>
					<p>
						Kullanıcılar
						<b class="caret"></b>
					</p>
				</a>
				<div class="collapse" id="kullanicilar">
					<ul class="nav">
						<li class="nav-item">
							<a class="nav-link" href="admin/profile">
								<span class="sidebar-mini">
									<i class="fas fa-arrow-alt-circle-right"></i>
								</span>
								<span class="sidebar-normal"> Profilim </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="admin/user">
								<span class="sidebar-mini">
									<i class="fas fa-arrow-alt-circle-right"></i>
								</span>
								<span class="sidebar-normal"> Tüm Kullanıcılar </span>
							</a>
						</li>
					</ul>
				</div>
			</li>

			<li class="nav-item">
				<a class="nav-link" data-toggle="collapse" href="#merkezlerimiz" aria-expanded="false">
					<i class="fab fa-wpforms"></i>
					<p>
						Formlar
						<b class="caret"></b>
					</p>
				</a>
				<div class="collapse" id="merkezlerimiz">
					<ul class="nav">
						<li class="nav-item">
							<a class="nav-link" href="admin/forms/list">
								<span class="sidebar-mini">
									<i class="fas fa-arrow-alt-circle-right"></i>
								</span>
								<span class="sidebar-normal"> Listele </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="admin/forms/add">
								<span class="sidebar-mini">
									<i class="fas fa-arrow-alt-circle-right"></i>
								</span>
								<span class="sidebar-normal"> Yeni Ekle </span>
							</a>
						</li>
					</ul>
				</div>
			</li>

			<li class="nav-item">
				<a class="nav-link" data-toggle="collapse" href="#contractedProviders" aria-expanded="false">
					<i class="fas fa-chart-pie"></i>
					<p>
						Raporlar
						<b class="caret"></b>
					</p>
				</a>
				<div class="collapse" id="contractedProviders">
					<ul class="nav">
						<li class="nav-item">
							<a class="nav-link" href="contracted-providers/list">
								<span class="sidebar-mini">
									<i class="fas fa-arrow-alt-circle-right"></i>
								</span>
								<span class="sidebar-normal"> Listele </span>
							</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" href="contracted-providers/add">
								<span class="sidebar-mini">
									<i class="fas fa-arrow-alt-circle-right"></i>
								</span>
								<span class="sidebar-normal"> Yeni Ekle </span>
							</a>
						</li>
					</ul>
				</div>
			</li>
		</ul>
	</div>
</div>
