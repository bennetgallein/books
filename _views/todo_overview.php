<!DOCTYPE html>
<html>
<head>
    { include("_views/include/head.php") }
</head>
<body>
{ include("_views/include/header.php") }
{ include("_views/include/sidebar.php") }
<div class="main-container">
    <div class="pd-ltr-20 height-100-p xs-pd-20-10">
        <div class="row clearfix">
            { foreach :list in :lists }
            <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
                <div class="card box-shadow">
                    <img class="card-img-top" src="https://loremflickr.com/1920/1080?random={ :list.id }" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title weight-500">{ :list.title }</h5>
                        <p class="card-text">{ :list.description }</p>
                        <a href="{ :app_url }todo/{ :list.id }" class="btn btn-primary">Öffnen</a>
                    </div>
                </div>
            </div>
            { endforeach }
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Titel</label>
                <div class="col-sm-12 col-md-10">
                    <input id="title" class="form-control" type="text" placeholder="Titel">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Besch.</label>
                <div class="col-sm-12 col-md-10">
                    <input id="description" class="form-control" placeholder="Beschreibung" type="search">
                </div>
            </div>
            <button onclick="submit()" type="button" class="btn btn-primary">Erstellen</button>
        </div>
        { include("_views/include/footer.php") }
    </div>
</div>
{ include("_views/include/script.php") }
<script>
    function submit() {
        $.post("{ :app_url }api/todo/createlist", {
            title: $("#title").val(),
            description: $("#description").val()
        }, function(data, status) {
            window.location.reload();
        });
    }
</script>
</body>
</html>