<!-- ============================================================== -->
<!-- wrapper  -->
<!-- ============================================================== -->
<div class="dashboard-wrapper">
	<div class="dashboard-ecommerce">
		<div class="container-fluid dashboard-content ">
			<!-- ============================================================== -->
			<!-- pageheader  -->
			<!-- ============================================================== -->
			<div class="row">
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
					<div class="page-header">
						<h2 class="pageheader-title"><?=$title?> </h2>
						<div class="page-breadcrumb">
							<nav aria-label="breadcrumb">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="<?=base_url()?>" class="breadcrumb-link">Dashboard</a></li>
									<li class="breadcrumb-item"><a href="<?=base_url($title)?>" class="breadcrumb-link"><?=$title?></a></li>
									<li class="breadcrumb-item active" aria-current="page"><?=$action.' '.$title?></li>
								</ol>
							</nav>
						</div>
					</div>
				</div>
			</div>
			<!-- ============================================================== -->
			<!-- end pageheader  -->
			<!-- ============================================================== -->
			<div class="row">
                    <!-- ============================================================== -->
                    <!-- data table  -->
                    <!-- ============================================================== -->
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4><?=strtoupper($action." ".$title);?></h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <form method="post" enctype="multipart/form-data">
								    	<table class="table">
								    		<tr>
								    			<td></td>
								    			<td>
								    				<div class="fileinput fileinput-new" data-provides="fileinput">
													  <div class="fileinput-preview thumbnail" data-trigger="fileinput" style="width: 200px; height: 150px;">
													  	<?php if(isset($buku)){?><img style="max-width: 200px; max-height: 150px" src="data:image/png;base64,<?php echo base64_encode($buku['gambar']);?>"><?php } ?>
													  </div>
													  <div>
													    <span class="btn btn-default btn-file"><span class="fileinput-new">Select image</span><span class="fileinput-exists">Change</span><input type="file" name="gambar"></span>
													    <a href="#" class="btn btn-default fileinput-exists" data-dismiss="fileinput">Remove</a>
													  </div>
													</div>
								    			</td>
								    		</tr>								    		
								    		<tr>
								    			<td>Kategori</td>
								    			<td>
								    				<select name="kategori_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($kategori as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['kategori_id']==$value['kategori_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['kategori_id']."'>".$value['nama_kategori']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Judul Buku</td>
								    			<td><input type="text" name="judul" class="form-control" value="<?=isset($buku)?$buku['judul']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Edisi</td>
								    			<td><input type="text" name="edisi" class="form-control" value="<?=isset($buku)?$buku['edisi']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>ISBN ISSN</td>
								    			<td><input type="text" name="isbn_issn" class="form-control" value="<?=isset($buku)?$buku['isbn_issn']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Pengarang</td>
								    			<td id="fromPengarang"><?php if(isset($pengarang)&&$pengarang){foreach ($pengarang as $keyPengarang => $valuePengarang) { 
								    					$keyPengarang++;
								    				?>
								    				<div id="pengarangRow<?=$keyPengarang?>">
									    				<select name="pengarang_id[]" class="form-control" id="optPengarang<?=$keyPengarang?>">
									    					<option value="<?=$valuePengarang['pengarang_id']?>"><?=$valuePengarang['nama_pengarang']?></option>
									    					
									    				</select>
									    				<div id="actPengarang<?=$keyPengarang?>">
									    					<?php if (count($pengarang)!=$keyPengarang) { ?>
										    				<a href="javascript:void(0)" onclick="pengarang_hapus(<?=$keyPengarang?>);"> [Hapus pengarang] </a>
									    					<?php }else{ ?>
										    				<a href="javascript:void(0)" onclick="pengarang_tambah(<?=$keyPengarang?>);"> [Tambah pengarang] </a>
										    				<a href="javascript:void(0)" onclick="pengarang_baru(<?=$keyPengarang?>);"> [Pengarang Baru] </a>
										    				<?php } ?>
									    				</div>
								    				</div>
								    				<?php } }else{ ?>
													<div id="pengarangRow1">
									    				<select name="pengarang_id[]" class="form-control" id="optPengarang1">
									    					<option value=""></option>
									    				</select>
									    				<div id="actPengarang1">
										    				<a href="javascript:void(0)" onclick="pengarang_tambah(1);"> [Tambah pengarang] </a>
										    				<a href="javascript:void(0)" onclick="pengarang_baru(1);"> [Pengarang Baru] </a>
									    				</div>
								    				</div>
								    				<?php } ?>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Penerbit</td>
								    			<td>
								    				<select name="penerbit_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($penerbit as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['penerbit_id']==$value['penerbit_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['penerbit_id']."'>".$value['nama_penerbit']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Tahun Terbit</td>
								    			<td><input type="text" name="tahun_terbit" class="form-control" value="<?=isset($buku)?$buku['tahun_terbit']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Kolasi</td>
								    			<td><input type="text" name="kolasi" class="form-control" value="<?=isset($buku)?$buku['kolasi']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Judul Seri</td>
								    			<td><input type="text" name="judul_seri" class="form-control" value="<?=isset($buku)?$buku['judul_seri']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Nomor Panggil</td>
								    			<td><input type="text" name="call_number" class="form-control" value="<?=isset($buku)?$buku['call_number']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Bahasa</td>
								    			<td>
								    				<select name="bahasa_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($bahasa as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['bahasa_id']==$value['bahasa_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['bahasa_id']."'>".$value['nama_bahasa']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Asal</td>
								    			<td><input type="text" name="asal" class="form-control" value="<?=isset($buku)?$buku['asal']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Tempat Terbit</td>
								    			<td><input type="text" name="tempat_terbit_id" class="form-control" value="<?=isset($buku)?$buku['tempat_terbit_id']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Catatan</td>
								    			<td><input type="text" name="notes" class="form-control" value="<?=isset($buku)?$buku['notes']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Labels</td>
								    			<td><input type="text" name="labels" class="form-control" value="<?=isset($buku)?$buku['labels']:'';?>"></td>
								    		</tr>
								    		<tr>
								    			<td>Frekuensi</td>
								    			<td>
								    				<select name="frekuensi_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($frekuensi as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['frekuensi_id']==$value['frekuensi_id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['frekuensi_id']."'>".$value['frekuensi']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Tipe Konten</td>
								    			<td>
								    				<select name="tipe_konten_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($tipe_konten as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['tipe_konten_id']==$value['id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['id']."'>".$value['tipe_konten']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    		<tr>
								    			<td>Tipe Media</td>
								    			<td>
								    				<select name="tipe_media_id" class="form-control">
								    					<option value=""></option>
								    					<?php foreach ($tipe_media as $key => $value) {
											                $selected = "";
											                if (isset($buku)&&$buku['tipe_media_id']==$value['id']) {
											                  $selected='selected';
											                }
											                echo "<option ".$selected." value='".$value['id']."'>".$value['tipe_media']."</option>";
											              } ?>
								    				</select>
								    			</td>
								    		</tr>
								    	</table>
								    	<input type="submit" value="SIMPAN" class="btn btn-primary" >
								    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- ============================================================== -->
                    <!-- end data table  -->
                    <!-- ============================================================== -->
                </div>
		</div>
	</div>

<div id="modal_form" class="modal" data-width="600">
	<div id="tampil_form"></div>
</div>
<script type="text/javascript" src="<?=base_url('assets/vendor/upload.js')?>"></script>
<script type="text/javascript">
	function pengarang_tambah(ke) {
		last=ke-1;next=ke+1;
		var form = "<div id=\"pengarangRow"+next+"\">"+
					"<select name=\"pengarang_id[]\" class=\"form-control\" id=\"optPengarang"+next+"\">"+
						"<option value=\"\"></option>"+
					"</select>"+
					"<div id=\"actPengarang"+next+"\">"+
						"<a href=\"javascript:void(0)\" onclick=\"pengarang_tambah("+next+");\"> [Tambah pengarang] </a>"+
						"<a href=\"javascript:void(0)\" onclick=\"pengarang_baru("+next+");\"> [Pengarang Baru] </a>"+
					"</div></div>";
		$("#fromPengarang").append(form);
		opsiPengarang(next);
		var act = "<a href=\"javascript:void(0)\" onclick=\"pengarang_hapus("+ke+");\"> [Hapus pengarang] </a>";
		$("#actPengarang"+ke).html(act);
	}
	function pengarang_hapus(ke) {
		$('#pengarangRow'+ke).remove();
	}
	function pengarang_baru(){
		$('#tampil_form').load("<?=site_url()?>pengaturan/pengarang/modal_form_pengarang/",
			function(){
				$('#modal_form').modal('show');
		});
	}
	function opsiPengarang(ke) {
		$.get('<?=site_url('buku/ajax/pengarang')?>',
			function(data){
				$('#optPengarang'+ke).html(data);
			})
	}
</script>


<style type="text/css">
a{
	color: #0056b3;
}			
.btn-file {
  overflow: hidden;
  position: relative;
  vertical-align: middle;
}
.btn-file > input {
  position: absolute;
  top: 0;
  right: 0;
  margin: 0;
  opacity: 0;
  filter: alpha(opacity=0);
  font-size: 23px;
  height: 100%;
  width: 100%;
  direction: ltr;
  cursor: pointer;
}
.fileinput {
  margin-bottom: 9px;
  display: inline-block;
}
.fileinput .form-control {
  padding-top: 7px;
  padding-bottom: 5px;
  display: inline-block;
  margin-bottom: 0px;
  vertical-align: middle;
  cursor: text;
}
.fileinput .thumbnail {
  overflow: hidden;
  display: inline-block;
  margin-bottom: 5px;
  vertical-align: middle;
  text-align: center;
}
.fileinput .thumbnail > img {
  max-height: 100%;
}
.fileinput .btn {
  vertical-align: middle;
}
.fileinput-exists .fileinput-new,
.fileinput-new .fileinput-exists {
  display: none;
}
.fileinput-inline .fileinput-controls {
  display: inline;
}
.fileinput-filename {
  vertical-align: middle;
  display: inline-block;
  overflow: hidden;
}
.form-control .fileinput-filename {
  vertical-align: bottom;
}
.fileinput.input-group {
  display: table;
}
.fileinput.input-group > * {
  position: relative;
  z-index: 2;
}
.fileinput.input-group > .btn-file {
  z-index: 1;
}
.fileinput-new.input-group .btn-file,
.fileinput-new .input-group .btn-file {
  border-radius: 0 4px 4px 0;
}
.fileinput-new.input-group .btn-file.btn-xs,
.fileinput-new .input-group .btn-file.btn-xs,
.fileinput-new.input-group .btn-file.btn-sm,
.fileinput-new .input-group .btn-file.btn-sm {
  border-radius: 0 3px 3px 0;
}
.fileinput-new.input-group .btn-file.btn-lg,
.fileinput-new .input-group .btn-file.btn-lg {
  border-radius: 0 6px 6px 0;
}
.form-group.has-warning .fileinput .fileinput-preview {
  color: #8a6d3b;
}
.form-group.has-warning .fileinput .thumbnail {
  border-color: #faebcc;
}
.form-group.has-error .fileinput .fileinput-preview {
  color: #a94442;
}
.form-group.has-error .fileinput .thumbnail {
  border-color: #ebccd1;
}
.form-group.has-success .fileinput .fileinput-preview {
  color: #3c763d;
}
.form-group.has-success .fileinput .thumbnail {
  border-color: #d6e9c6;
}
.input-group-addon:not(:first-child) {
  border-left: 0;
}


	</style>