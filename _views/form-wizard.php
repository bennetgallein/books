<!DOCTYPE html>
<html>
<head>
	{ include("_views/include/head.php") }
	<link rel="stylesheet" type="text/css" href="src/plugins/jquery-steps/build/jquery.steps.css">
</head>
<body>
	{ include("_views/include/header.php") }
	{ include("_views/include/sidebar.php") }
	<div class="main-container">
		<div class="pd-ltr-20 height-100-p xs-pd-20-10">
			<div class="min-height-200px">
				<div class="page-header">
					<div class="row">
						<div class="col-md-6 col-sm-12">
							<div class="title">
								<h4>Neuer Kunde</h4>
							</div>
							<nav aria-label="breadcrumb" role="navigation">
								<ol class="breadcrumb">
									<li class="breadcrumb-item"><a href="{ :app_url }">Home</a></li>
									<li class="breadcrumb-item active" aria-current="page">Neuer Kunde</li>
								</ol>
							</nav>
						</div>
					</div>
				</div>

				<div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
					<div class="clearfix">
						<h4 class="text-blue">Neuen Kunden anlegen</h4>
					</div>
					<div class="wizard-content">
						<form class="tab-wizard wizard-circle wizard">
							<h5>Persönliche Informationen</h5>
							<section>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label >Erster Name :</label>
											<input id="first_name" type="text" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label >Nachname :</label>
											<input id="last_name" type="text" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Email Addresse :</label>
											<input id="email" type="email" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Telefon Nummer :</label>
											<input id="telefon" type="text" class="form-control">
										</div>
									</div>
								</div>
								<div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Land :</label>
                                            <input id="country" type="text" class="form-control">
                                        </div>
                                    </div>
									<div class="col-md-6">
										<div class="form-group">
											<label >Geburtsdatum :</label>
											<input id="birthday" type="text" class="form-control date-picker" placeholder="Datum auswählen">
										</div>
									</div>
								</div>
							</section>
							<!-- Step 2 -->
							<h5>Adresse</h5>
							<section>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Straße :</label>
											<input id="street" type="text" class="form-control">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Postleitzahl :</label>
											<input id="zip_code" type="number" class="form-control">
										</div>
									</div>
                                </div>
                                <div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>Stadt :</label>
											<input id="city" type="text" class="form-control">
										</div>
									</div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Firma :</label>
                                            <input id="company" type="text" class="form-control">
                                        </div>
                                    </div>
								</div>
							</section>
						</form>
					</div>
				</div>

				<!-- success Popup html Start -->
				<div class="modal fade" id="success-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered" role="document">
						<div class="modal-content">
							<div class="modal-body text-center font-18">
								<h3 class="mb-20">Kunde angelegt</h3>
								<div class="mb-30 text-center"><img src="{ :app_url }vendors/images/success.png"></div>
								Der Kunde wurde im System angelegt und kann ab jetzt verwendet werden.
							</div>
							<div class="modal-footer justify-content-center">
								<button type="button" class="btn btn-primary" data-dismiss="modal">Fertig</button>
							</div>
						</div>
					</div>
				</div>
				<!-- success Popup html End -->
			</div>
			{ include("_views/include/footer.php") }
		</div>
	</div>
	{ include("_views/include/script.php") }
	{ js src/plugins/jquery-steps/build/jquery.steps.js }
	<script>
		$(".tab-wizard").steps({
			headerTag: "h5",
			bodyTag: "section",
			transitionEffect: "fade",
			titleTemplate: '<span class="step">#index#</span> #title#',
			labels: {
				finish: "Submit"
			},
			onStepChanged: function (event, currentIndex, priorIndex) {
				$('.steps .current').prevAll().addClass('disabled');
			},
			onFinished: function (event, currentIndex) {
			    first_name = $("#first_name").val();
			    last_name = $("#last_name").val();
			    email = $("#email").val();
			    telefon = $("#telefon").val();
			    country = $("#country").val();
			    birthday = $("#birthday").val();
			    street = $("#street").val();
			    zip_code = $("#zip_code").val();
			    city = $("#city").val();
			    company = $("#company").val();
			    $.post("{ :app_url }kunden/new", {
			        first_name: first_name,
                    last_name: last_name,
                    email: email,
                    telefon: telefon,
                    country: country,
                    birthday: birthday,
                    street: street,
                    zip_code: zip_code,
                    city: city,
                    company: company
                }, function(data, status) {
                    if (status === "success") {
                        $('#success-modal').modal('show');
                    } else {
                        alert("Something went wrong!");
                    }
                });
			}
		});
	</script>
</body>
</html>