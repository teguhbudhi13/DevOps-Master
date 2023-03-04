				<div class="tab-pane <?= jecho($act_tab, 1, 'active') ?>">
					<div class="row">
						<div class="col-md-12">
							<div class="box-header with-border">
								<h3 class="box-title"><strong>Backup Database SID</strong></h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-sm-8">
										<form class="form-horizontal">
											<table class="table table-bordered">
												<tbody>
													<?php
                                                        $sizeFolder = byte_format(dirSize(DESAPATH));
                                                        $sizeSql    = byte_format(getSizeDB()->size);
                                                    ?>
													<tr>
														<td class="col-sm-10"><b>Backup Seluruh Database SID (.sql)</b></td>
														<td class="col-sm-2">
															<a href="<?= site_url('database/exec_backup')?>" class="btn btn-social btn-flat btn-block btn-info btn-sm" title="Perkiraan ukuran file backup sql berdasarkan jumlah tabel dan baris data adalah <?= $sizeSql ?>"><i class="fa fa-download"></i> Unduh Database <b><code><?= $sizeSql ?></code></b></a>
														</td>
													</tr>
													<tr>
														<td class="col-sm-10"><b>Backup Seluruh Folder Desa SID (.zip)</b> </td>
														<td class="col-sm-2">
															<a href="<?= site_url('database/desa_backup'); ?>" class="btn btn-social btn-flat btn-block btn-info btn-sm" title="Perkiraan ukuran folder desa sebelum di compress adalah <?= $sizeFolder ?>"><i class="fa fa-download"></i> Unduh Folder Desa <b><code><?= $sizeFolder ?></code></b></a>
														</td>
													</tr>
												</tbody>
											</table>
										</form>
										<p>Proses Unduh akan mengunduh keseluruhan database SID anda.</p>
										<div class="row">
											<ul>
												<li> Usahakan untuk melakukan backup secara rutin dan terjadwal. </li>
												<li> Backup yang dihasilkan sebaiknya disimpan di komputer terpisah dari server SID. </li>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
						<?php if ($this->CI->cek_hak_akses('u') && ! config_item('demo_mode')): ?>
							<div class="col-md-12">
							<div class="box-header with-border">
								<h3 class="box-title"><strong>Restore Database SID</strong></h3>
							</div>
							<div class="box-body">
								<div class="row">
									<div class="col-sm-12">
										<p>Backup yang dibuat dapat dipergunakan untuk mengembalikan database SID anda apabila ada masalah. Klik tombol Restore di bawah untuk menggantikan keseluruhan database SID dengan data hasil backup terdahulu.</p>
										<form action="<?= $form_action?>" method="post" enctype="multipart/form-data" class="form-horizontal">
											<p>Batas maksimal pengunggahan berkas <strong><?= max_upload() ?> MB.</strong></p>
											<p>Proses ini akan membutuhkan waktu beberapa menit, menyesuaikan dengan spesifikasi komputer server SID dan sambungan internet yang tersedia.</p>
											<p></p>
											<table class="table table-bordered table-hover" >
												<tbody>
													<tr>
														<td style="padding-top:20px;padding-bottom:10px;">
															<div class="form-group">
																<label for="file"class="col-md-2 col-lg-3 control-label">Pilih File .Sql:</label>
																<div class="col-sm-12 col-md-5 col-lg-5">
																	<div class="input-group input-group-sm">
																		<input type="text" class="form-control" id="file_path" name="userfile">
																		<input type="file" class="hidden" id="file" name="userfile" data-submit="restore" accept="application/sql">
																		<span class="input-group-btn">
																			<button type="button" class="btn btn-info btn-flat" id="file_browser"><i class="fa fa-search"></i> Browse</button>
																		</span>
																	</div>
																</div>
																<div class="col-sm-12 col-md-3 col-lg-2">
																	<button type="submit" id="restore" class="btn btn-block btn-success btn-sm" disabled="disabled"><i class="fa fa-spin fa-refresh"></i>Restore</button>
																</div>
															</div>
														</td>
													</tr>
												</tbody>
											</table>
										</form>
									</div>
								</div>
							</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>
</div>
