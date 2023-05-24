<style type="text/css">
	.ba-we-love-subscribers {
		width: 350px;
		height: 50px;
		background-color: #fff;
		border-radius: 15px;
		box-shadow: 0px 12px 45px rgba(0, 0, 0, .15);
		text-align: center;
		margin: 0 0 10px 0;
		overflow: hidden;
		opacity: 0;
	}
	.ba-we-love-subscribers.open {
		height: 400px;
		opacity: 1;
	}
	.ba-we-love-subscribers.popup-ani {
		-webkit-transition: all .8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
		transition: all .8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
	}
	.ba-we-love-subscribers h1 {
		font-size: 20px;
		color: #757575;
		padding: 25px 0;
		margin: 0;
	  	font-weight:400;

	}
	.ba-we-love-subscribers .love {
		width: 20px;
		height: 20px;
		background-position: 35px 84px;
		display: inline-block;
		margin: 0 6px;
		background-size: 62px;
	}
	.ba-we-love-subscribers .ba-logo {
		width: 65px;
		height: 25px;
		background-position: 0px;
		margin: 0 auto;
		opacity: .5;
		cursor: pointer;
	}
	.ba-we-love-subscribers .ba-logo:hover {
		opacity: 1;
	}
	.logo-ani {
		transition: 0.5s linear;
		-webkit-transition: 0.5s linear;
	}
	.ba-we-love-subscribers input {
		font-size: 14px;
		padding: 12px 15px;
		border-radius: 15px;
		border: 3;
		outline: none;
		margin: 8px 0;
		width: 100%;
		box-sizing: border-box;
		line-height: normal;
		/*Bootstrap Overide*/
		font-family: sans-serif;
		/*Bootstrap Overide*/
	}
	.ba-we-love-subscribers form {
		padding: 5px 30px 0;
		margin-bottom: 15px;
	}
	.ba-we-love-subscribers input[name="email"] {
		background-color: #eee;
	}
	.ba-we-love-subscribers input[name="submit"] {
		background-color: #00aeef;
		cursor: pointer;
		color: #fff;
	}
	.ba-we-love-subscribers input[name="submit"]:hover {
		background-color: #26baf1;
	}
	.ba-we-love-subscribers .img {
		background-image: url("https://4.bp.blogspot.com/-1J75Et4_5vc/WAYhWRVuMiI/AAAAAAAAArE/gwa-mdtq0NIqOrlVvpLAqdPTV4VAahMsQCPcB/s1600/barrel-we-love-subscribers-img.png");
	}
	.ba-we-love-subscribers-fab {
		width: 50px;
		height: 50px;
		background-color: #00aeef;
		border-radius: 30px;
		float: right;
		box-shadow: 0px 12px 45px rgba(0, 0, 0, .3);
		z-index: 5;
		position: relative;
	}
	.ba-we-love-subscribers-fab .img-fab {
		height: 30px;
		/*width: 40px;*/
		margin: 11px 11px auto;
		background-image: url("https://4.bp.blogspot.com/-1J75Et4_5vc/WAYhWRVuMiI/AAAAAAAAArE/gwa-mdtq0NIqOrlVvpLAqdPTV4VAahMsQCPcB/s1600/barrel-we-love-subscribers-img.png");
		background-position: -1px -53px;
	}
	.ba-we-love-subscribers-fab .wrap {
		transform: rotate(0deg);
		-webkit-transition: all .15s cubic-bezier(0.15, 0.87, 0.45, 1.23);
		transition: all .15s cubic-bezier(0.15, 0.87, 0.45, 1.23);
	}
	.ba-we-love-subscribers-fab .ani {
		transform: rotate(45deg);
		-webkit-transition: all .15s cubic-bezier(0.15, 0.87, 0.45, 1.23);
		transition: all .15s cubic-bezier(0.15, 0.87, 0.45, 1.23);
	}
	.ba-we-love-subscribers-fab .close {
		background-position: -2px 1px;
		transform: rotate(-45deg);
		float: none;
		/*Bootstrap Overide*/
		opacity: 1;
		/*Bootstrap Overide*/
	}
	.ba-we-love-subscribers-wrap {
		position: fixed;
		right: 25px;
		bottom: 25px;
		z-index: 1000;
	}
	.ba-settings {
		position: absolute;
		top: -25px;
		right: 0px;
		padding: 10px 20px;
		background-color: #555;
		border-radius: 5px;
		color: #fff;
	}

</style>

<div class="ba-we-love-subscribers-wrap">
	<div class="ba-we-love-subscribers popup-ani">
		<header>
			<h1>ข้อเสนอแนะ</h1>
		</header>
		<form method="post" action="{{ route('feedback.store') }}" enctype="multipart/form-data">
			@csrf
			<textarea  class="form-control" style="width: 100%;" rows="5" name="description" required=""></textarea>
			<div class="form-group">
				<label for="InputFile" style="padding-top: 10px;">อัพโหลดไฟล์แนบ</label>
				<div class="input-group">
	            	<div class="custom-file">
						<input type="file" class="custom-file-input" id="InputFile" name="file_name">
						<label class="custom-file-label" for="InputFile" style="text-align: left;">แนบไฟล์</label>
						<input type="hidden" name="page" value="afterlogin">
					</div>
				</div>
			</div>

			<input name="submit" class="btn btn-primary" type="submit" value="ส่ง">
		</form>
		
	</div>
	<div class="ba-we-love-subscribers-fab">
		<div class="wrap">
			<div class="img-fab img"></div>
		</div>
	</div>
</div>
<!-- partial -->
<script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
<script>
	$(".ba-we-love-subscribers-fab").click(function() {
		$('.ba-we-love-subscribers-fab .wrap').toggleClass("ani");
		$('.ba-we-love-subscribers').toggleClass("open");
		$('.img-fab.img').toggleClass("close");
	});
</script>

<script src="{{ asset('js/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
      bsCustomFileInput.init();
    });
</script>
