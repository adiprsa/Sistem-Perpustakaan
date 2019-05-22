<nav class="navbar navbar-expand-lg navbar-light">
    <a class="d-xl-none d-lg-none" href="#">Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav flex-column">
            <li class="nav-item ">
                <a class="nav-link" href="#"><i class="fa fa-fw fa-user-circle"></i>Dashboard <span class="badge badge-success">6</span></a>
            </li>
            <li class="nav-divider">
                Menu
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-1" aria-controls="submenu-1"><i class="fas fa-fw fa-rocket"></i>Master Data</a>
                <div id="submenu-1" class="collapse submenu" style="">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('pengaturan/pengarang');?>">Pengarang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('pengaturan/penerbit');?>">Penerbit</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('pengaturan/supplier');?>">Supplier</a>
                        </li>
						<!--
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('#');?>">Lokasi Buku</a>
                        </li>
						-->
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('pengaturan/lokasi');?>">Lokasi</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('#');?>">Member</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('#');?>">Tipe Member</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('pengaturan/frekuensi');?>">Frekuensi Terbit</a>
                        </li>
						<!--
                        <li class="nav-item">
                            <a class="nav-link" href="<?=base_url('#');?>">Karyawan</a>
                        </li>
						-->
                    </ul>
                </div>
            </li>
            <li class="nav-item ">
                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-2" aria-controls="submenu-2"><i class="fab fa-fw fa-wpforms"></i>Bibliografi</a>
                <div id="submenu-2" class="collapse submenu" style="">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Bibliografi</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Eksemplar</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('pengaturan/kolasi');?>">Tipe Kolasi</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('pengaturan/tipe_media');?>">Tipe Media</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Serial</a>
                      </li>
                  </ul>
              </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-fw fa-table"></i>Sirkulasi</a>
                    <div id="submenu-3" class="collapse submenu" style="">
                        <ul class="nav flex-column">
                          <li class="nav-item">
                              <a class="nav-link" href="<?=base_url('peminjaman');?>">Peminjaman</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="<?=base_url('pengembalian');?>">Pengembalian</a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="<?=base_url('denda');?>">Pembayaran Denda</a>
                          </li>
                      </ul>
                  </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-4" aria-controls="submenu-4"><i class="fas fa-fw fa-table"></i>Stok Opname</a>
                <div id="submenu-4" class="collapse submenu" style="">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Waktu Stok Opname</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Stok Take</a>
                      </li>
                  </ul>
              </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-5" aria-controls="submenu-5"><i class="fa fa-fw fa-book"></i>Laporan</a>
                <div id="submenu-5" class="collapse submenu" style="">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('laporan/c_laporan_buku/tampil_laporan_buku') ?>">Laporan Koleksi Buku</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('laporan/c_laporan_anggota/tampil_laporan_anggota') ?>">Laporan Member</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('laporan/c_laporan_stok_opname/tampil_laporan_stok_opname') ?>">Laporan Stok Opname</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('laporan/c_laporan_peminjaman/tampil_laporan_peminjaman') ?>">Laporan Peminjaman</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo base_url('laporan/c_laporan_denda/tampil_laporan_denda') ?>">Laporan Denda</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-6" aria-controls="submenu-6"><i class="fas fa-f fa-user"></i>User Management</a>
                <div id="submenu-6" class="collapse submenu" style="">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('user');?>">Pengguna</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Member</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Tipe Member</a>
                      </li>
					  <!--
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Module</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Hak Akses</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Grup Pengguna</a>
                      </li>
					  -->
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('user/log_usernya');?>">Log Pengguna</a>
                      </li>
                    </ul>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-toggle="collapse" aria-expanded="false" data-target="#submenu-7" aria-controls="submenu-7"><i class="fas fa-f fa-cog"></i>Pengaturan</a>
                <div id="submenu-7" class="collapse submenu" style="">
                    <ul class="nav flex-column">
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('pengaturan/fakultas');?>">Fakultas</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('pengaturan/prodi');?>">Prodi</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('pengaturan/bahasa');?>">Bahasa</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Aturan Pinjam</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('pengaturan/libur');?>">Hari Libur</a>
                      </li>
                      <li class="nav-item">
                          <a class="nav-link" href="<?=base_url('#');?>">Berita</a>
                      </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</nav>
