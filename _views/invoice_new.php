<!DOCTYPE html>
<html>
<head>
    { include("_views/include/head.php") }
    { include("_views/include/script.php") }
    <link rel="stylesheet" type="text/css" href="src/plugins/jquery-steps/build/jquery.steps.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(function () {
            var availableTags = { :customers };
            $(".customers").autocomplete({
                source: availableTags
            });
        });
    </script>
</head>
<body>
{ include("_views/include/header.php") }
{ include("_views/include/sidebar.php") }
<div class="main-container">
    <div class="pd-ltr-20 customscroll customscroll-10-p height-100-p xs-pd-20-10">
        <div class="min-height-200px">
            <div class="page-header">
                <div class="row">
                    <div class="col-md-6 col-sm-12">
                        <div class="title">
                            <h4>Neue Rechnung</h4>
                        </div>
                        <nav aria-label="breadcrumb" role="navigation">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{ :app_url }">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Neue Rechnung</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>

            <div class="pd-20 bg-white border-radius-4 box-shadow mb-30">
                <div class="clearfix">
                    <h4 class="text-blue">Neue Rechnung erstellen</h4>
                </div>
                <div class="wizard-content">
                    <form class="tab-wizard wizard-circle wizard">
                        <h5>Rechnungsinformationen</h5>
                        <section>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="ui-widget">
                                            <label for="tags">Kunde :</label>
                                            <input id="customer_id" type="text" class="customers form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Datum :</label>
                                        <input id="date" type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Beschreibung :</label>
                                        <input id="description" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Netto Preis: </label>
                                        <input id="netto" type="number" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </section>
                    </form>
                </div>
            </div>

            <!-- success Popup html Start -->
            <div class="modal fade" id="success-modal" tabindex="-1" role="dialog"
                 aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-body text-center font-18">
                            <h3 class="mb-20">Rechnung erstellt!</h3>
                            <div class="mb-30 text-center"><img src="{ :app_url }vendors/images/success.png"></div>
                            Die Rechnung wurde erstellt.
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
            customer_id = $("#customer_id").val();
            date = $("#date").val();
            invoice_id = $("#invoice_id").val();
            netto = $("#netto").val();
            desc = $("#description").val();
            $.post("{ :app_url }rechnungen/new", {
                customer_id: customer_id,
                date: date,
                invoice_id: invoice_id,
                netto: netto,
                desc: desc
            }, function (data, status) {
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