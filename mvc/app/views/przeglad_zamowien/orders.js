$(document).ready(function () {
    refresh();
    refresh2();
    $(".edits").on("click", ".click", function () {
        var id = $(this).children("#id").first().text();
        window.location.assign("/magiste/mgr/mvc/public/przeglad_zamowien/orders/" + id);
    });
    $(".edits2").on("click", ".click", function () {
        var id = $(this).children("#id").first().text();
        window.location.assign("/magiste/mgr/mvc/public/przeglad_zamowien/setOfDishes/" + id);
    });
    $('#table-items')."click", ".click", function () {
        var id = $(this).children("#id").first().text();
        console.log(id);

        function refresh() {
            $.ajax({
                type: "POST",
                url: "/magiste/mgr/mvc/public/przeglad_zamowien/refreshOrdersAjax",
                dataType: "json",
                success: function (data) {
                    var string = '';
                    $.each(data, function () {
                        string += '<div class="row hover click table-row">' +
                            '<div id="id" class="col-xs-2">' + this.id + '</div>' +
                            '<div class="col-xs-4">' + this.imie + '</div>' +
                            '<div class="col-xs-3">' + this.nazwisko + '</div>' +
                            '<div class="col-xs-3">' + this.telefon + '</div>' +
                            '</div>';
                    });
                    $("#table").html(string);
                }
            });
        }

        function refresh2() {
            $.ajax({
                type: "POST",
                url: "/magiste/mgr/mvc/public/przeglad_zamowien/refreshSetOfDishesOrdersAjax",
                dataType: "json",
                success: function (data) {
                    var string = '';
                    $.each(data, function () {
                        string += '<div class="row hover click table-row">' +
                            '<div id="id" class="col-xs-2">' + this.id + '</div>' +
                            '<div class="col-xs-4">' + this.imie + '</div>' +
                            '<div class="col-xs-3">' + this.nazwisko + '</div>' +
                            '<div class="col-xs-3">' + this.telefon + '</div>' +
                            '</div>';
                    });
                    $("#table2").html(string);
                }
            });
        }

        window.setInterval(refresh, 2000);
        window.setInterval(refresh2, 2000);
    }
);