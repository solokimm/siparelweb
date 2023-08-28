<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8" />
	<meta property="og:locale" content="en_US" />
	<meta property="og:type" content="article" />
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
	<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
</head>

<body id="kt_body" class="app-blank">
	<div class="d-flex flex-column flex-root" id="kt_app_root">
		<div class="d-flex flex-column flex-column-fluid">
			<div class="scroll-y flex-column-fluid px-10 py-10" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_header_nav" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true" style="background-color: #d5d9e2; --kt-scrollbar-color: #d9d0cc; --kt-scrollbar-hover-color: #d9d0cc">
				<style>
					html,
					body {
						padding: 0;
						margin: 0;
						font-family: Inter, Helvetica, 'sans-serif';
					}

					a:hover {
						color: #009ef7;
					}
				</style>
				<div id="#kt_app_body_content" style="background-color: #d5d9e2; font-family: Arial, Helvetica, sans-serif; line-height: 1.5; min-height: 100%; font-weight: normal; font-size: 15px; color: #2f3044; margin: 0; padding: 0; width: 100%">
					<div style="background-color: #ffffff; padding: 45px 0 34px 0; margin: 40px auto; max-width: 600px">
						<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="auto" style="border-collapse: collapse">
							<tbody>
								<tr>
									<td align="center" valign="center" style="text-align: center; padding-bottom: 10px">
										<div style="text-align: center; margin: 0 15px 34px 15px">
											<div style="margin-bottom: 10px"> <img alt="Logo" src="<?= base_url('assets/media/logos/new-bnn.png') ?>" style="height: 35px" /> </div>
											<div style="margin-bottom: 15px"> <img alt="Logo" src="<?= base_url('assets/media/logos/siparel-02.png') ?>" style="height: 150px" /> </div>
											<div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family: Arial, Helvetica, sans-serif">
												<p style="margin-bottom: 9px; color: #181c32; font-size: 22px; font-weight: 700">Hai <?= $name ?>!,</p>
												<p style="margin-bottom: 2px; color: #7e8299">Gunakan kode OTP berikut untuk mengverifikasi akun Anda</p>
											</div>
											<a href="javascript:void(0);" style="background-color: #50cd89; border-radius: 6px; display: inline-block; padding: 11px 19px; color: #ffffff; font-size: 14px; font-weight: 500; text-decoration: none"><?= $otp_code ?></a>
										</div>
									</td>
								</tr>
								<tr>
									<td align="center" valign="center" style="font-size: 13px; padding: 0 15px; text-align: center; font-weight: 500; color: #a1a5b7; font-family: Arial, Helvetica, sans-serif">
										<p>&copy; SIPARLNEW 2023</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		var hostUrl = 'assets/';
	</script>
	<script src="assets/plugins/global/plugins.bundle.js"></script>
	<script src="assets/js/scripts.bundle.js"></script>
</body>

</html>