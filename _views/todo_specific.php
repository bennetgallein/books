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
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 mb-30">
                <div class="bg-white pd-20 box-shadow border-radius-5">
                    <h4 class="mb-30">{ :list.title }</h4>
                    <p>{ :list.description }</p>
                    <div class="to-do-list">
                        <ul>
                            { foreach :item in :elements }
                            <li data-id="{ :item.id }" onclick="remove(this)">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="check{ :item.id }">
                                    <label class="custom-control-label" for="check{ :item.id }">{ :item.text }</label>
                                </div>
                            </li>
                            { endforeach }
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12 mb-30">
            <div class="form-group row">
                <label class="col-sm-12 col-md-2 col-form-label">Besch. </label>
                <div class="col-sm-12 col-md-10">
                    <input id="description" class="form-control" placeholder="Beschreibung" type="search">
                </div>
            </div>
            <button onclick="submit()" type="button" class="btn btn-primary">Hinzufügen</button>
        </div>
        { include("_views/include/footer.php") }
    </div>
</div>
{ include("_views/include/script.php") }
<script>

    function submit() {
        $.post("{ :app_url }api/todo/createtask/{ :list.id }", {
            description: $("#description").val()
        }, function(data, status) {
            window.location.reload();
        });
    }

    function remove(id) {
        $.get("{ :app_url }api/todo/remove/" + id.dataset.id, function(data, status) {
            console.log(data);
        });
        $(id).fadeOut("slow");
    }
</script>
</body>
</html>