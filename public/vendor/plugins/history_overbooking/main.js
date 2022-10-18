const mainComponent = $("#overbooking-component");
function showData(e = "") {
    console.log(e);
    if (
        (mainComponent.find("#form-filter").fadeOut(),
        "none" == mainComponent.find("#list-data").css("display") &&
            mainComponent.find("#list-data").fadeIn(),
        "none" != mainComponent.find("#form-filter").css("display") &&
            (mainComponent.find("#form-filter").fadeOut(),
            mainComponent.find("#filter").find("#setFilter").fadeOut()),
        "" == e)
    ) {
        const e = `${$('meta[name="baseurl"]').attr(
            "content"
        )}history-overbooking`;
        $(".t-overbooking").DataTable().destroy(), n(e);
    } else if ("" != e) {
        const t = `${$('meta[name="baseurl"]').attr(
            "content"
        )}history-overbooking?filter=${e}`;
        $(".t-overbooking").DataTable().destroy(), n(t);
    }
    function n(e) {
        $(".t-overbooking").DataTable({
            processing: !0,
            serverSide: !0,
            ajax: e,
            columns: [
                { data: "status", name: "status" },
                { data: "tbk_partnerid", name: "tbk_partnerid" },
                { data: "sender_bank_name", name: "sender_bank_name" },
                { data: "tbk_sender_account", name: "tbk_sender_account" },
                { data: "sender_amount", name: "sender_amount" },
                { data: "tbk_notes", name: "tbk_notes" },
                { data: "recipient_bank_name", name: "recipient_bank_name" },
                {
                    data: "tbk_recipient_account",
                    name: "tbk_recipient_account",
                },
                { data: "recipient_amount", name: "recipient_amount" },
                { data: "tbk_execution_time", name: "tbk_execution_time" },
                { data: "tbk_sp2d_desc", name: "tbk_sp2d_desc" },
                { data: "status_message", name: "status_message" },
            ],
            columnDefs: [
                { className: "text-center align-middle", targets: "_all" },
                { searchable: !1, orderable: !1, targets: 0 },
            ],
            order: [[9, "desc"]],
        });
    }
}
function addFilter(e) {
    if (
        (mainComponent.find("#form-filter").fadeIn(),
        mainComponent.find("#filter").find("#setFilter").fadeIn(),
        "add" == e)
    )
        apiCall(
            "history-overbooking/render-filter",
            "",
            "GET",
            () => {
                swal({
                    title: "Loading...",
                    content: {
                        element: "i",
                        attributes: {
                            className: "fas fa-spinner fa-spin text-large",
                        },
                    },
                    buttons: !1,
                    closeOnClickOutside: !1,
                    closeOnEsc: !1,
                });
            },
            null,
            () => {},
            (e) => {
                swal.close(), mainComponent.find("#form-filter").append(e.html);
                let n = mainComponent
                        .find("#form-filter")
                        .find(".form-container"),
                    t = n.length;
                if (t > 1)
                    for (let e = 1; e < t; e++)
                        $(n[e]).find(".remove-filter").fadeIn(),
                            $(n[e]).find(".separator").fadeIn();
            },
            !0
        );
    else {
        0 ==
            mainComponent.find("#form-filter").find(".form-container").length &&
            addFilter("add");
    }
}
function removeFilter(e) {
    swal({ title: "Are you sure want to remove filter?", buttons: !0 }).then(
        (n) => {
            n && $(e).parent().parent().remove();
        }
    );
}
function getValueColumn(e) {
    const n = $(e)
        .parentsUntil(".form-container")
        .parent()
        .find(".select-value");
    if ("" != $(e).val()) {
        var t = window.btoa($(e).val());
        apiCall(
            `history-overbooking/column-data/${t}`,
            "GET",
            "",
            null,
            null,
            () => {},
            (e) => {
                swal.close(), (t = t.toLowerCase());
                var a = "<option><option>";
                $.each(e.data, (e, n) => {
                    a += `<option value="${Object.values(n)[0]}">${
                        Object.values(n)[0]
                    }</option>`;
                }),
                    n.html(a);
            },
            !0
        );
    } else n.html("<option></option>");
}
function setFilter() {
    const e = mainComponent.find("#form-filter").find(".form-container");
    var n = mainComponent.find(e).find(".required");
    n.removeClass("is-invalid");
    for (var t = 0; t < n.length; t++)
        if ("" == n[t].value) {
            !1,
                mainComponent
                    .find(e)
                    .find(`input[name="${n[t].name}"]`)
                    .addClass("is-invalid");
            var a = n[t].name.replace("_", " ").toUpperCase();
            $.toast({
                heading: "Warning",
                text: `Form ${a} is Required`,
                icon: "warning",
                loader: !0,
                loaderBg: "#9EC600",
                position: "top-right",
            });
        }
    if (n) {
        var o = "";
        e.find(".form-control").each((e, n) => {
            "none" != $(n).css("display") &&
                (o +=
                    "value" != $(n).attr("name")
                        ? `${$(n).val()} `
                        : `'${$(n).val()}' `);
        }),
            showData((o = window.btoa(o)));
    }
}
$(document).ready(function () {
    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    }),
        showData();
});
